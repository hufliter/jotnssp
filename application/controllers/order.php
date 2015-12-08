<?php use Repositories\OrderRepository;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends AppController
{
    /** @var OrderRepository  */
    protected $orderRepository;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('order_model');
        $this->order_model->data =& $this->data;

        $this->load->library('user_agent');

        $this->orderRepository = new OrderRepository();
    }

    public function admin_ajax_view($id = null)
    {
        if ($this->input->is_ajax_request()):
            if (empty($id))
                show_404();

            $this->order_model->detail($id);

            $this->data['referrer'] = $this->agent->referrer();
            $this->layout = 'ajax';
            $this->render('order/admin_ajax_view');

        else:
            redirect('/admincp/dashboard');
        endif;
    }

    public function admin_ajax_do($id = null)
    {
        if ($this->input->is_ajax_request()):
            if (empty($id))
                show_404();

            $this->validation();
            if ($this->input->post() && $this->form_validation->run('ajaxDo')):
                if ($this->order_model->updateStatus()):
                    $this->site->back_erase(array('overview', 'lastOrder'));
                    exit('success');
                else:
                    exit('error on sql');
                endif;
            endif;

            $this->data['order'] = $this->order_model->status($id);
            $this->data['captTime'] = $this->captcha();
            $this->layout = 'ajax';
            $this->render('order/admin_ajax_do');
        else:
            redirect('/admincp/dashboard');
        endif;
    }

    public function checkCapt($str)
    {
        if (!$this->captValid($str)):
            $this->form_validation->set_message('checkCapt', 'Sai Captcha, nhập lại');
            return false;
        endif;
        return true;
    }

    public function admin_index()
    {
        $this->render('back/order/index', ['admin/order', 'admin/datatable-common'], ['back']);
    }

    public function admin_show($id)
    {
        $order = $this->entityManager->find('Entity\Order', $id);
        if (!$order) {
            redirect('admincp/order/index');
        } else {
            $this->data['order'] = $order;
            $this->render('back/order/show', ['admin/order_show'], ['back']);
        }
    }

    public function admin_api_index()
    {
        $offset = $this->getInput('start');
        $quantity = $this->getInput('length');
        $sortableColumns = [
            'o.full_name',
            'o.phone',
            'o.reseller_id',
            'o.created_at',
            'total',
            'o.status'
        ];

        $cOrders = $this->getInput('order');
        $search = $this->getInput('search');

        $ordersQuery = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from('Entity\Order', 'o')
            ->setFirstResult($offset)
            ->setMaxResults($quantity);

        foreach ($cOrders as $o) {
            $ordersQuery->orderBy($sortableColumns[$o['column']], $o['dir']);
        }

        $ordersQuery->where('o.full_name LIKE ?1')
                    ->orWhere('o.phone LIKE ?1');
        $ordersQuery->setParameter('1', '%' . $search['value'] . '%');

        $countQuery = $this->entityManager->createQueryBuilder()
            ->select('count(o.id)')
            ->from('Entity\Order', 'o')
            ->where('o.full_name LIKE ?1')
            ->orWhere('o.phone LIKE ?1');
        $countQuery->setParameter('1', '%' . $search['value'] . '%');
        $count = $countQuery->getQuery()->getSingleScalarResult();

        $jsonResponse = [
            'data' => [],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ];

        $orders = $ordersQuery->getQuery()->getResult();
        /** @var \Entity\Order $o */
        foreach ($orders as $o) {
            $jsonData = [
                $o->getFullName(),
                $o->getPhone(),
                $o->getReseller() ? $o->getReseller()->getName() : '',
                $o->getCreatedAt()->format('H:i:s d/m/Y'),
                JotunUtils::currencyFormat($o->getTotal() + $o->getShipFee() - $o->getSaleOff()),
                $o->getStatus() == ORDER_STATUS_NEW ?
                    '<i class="fa fa-times unavailable"></i>' :
                    '<i class="fa fa-check available"></i>',
                $this->orderBuildControls($o),
            ];

            $jsonResponse['data'][] = $jsonData;
        }

        $this->jsonResponse($jsonResponse);
    }

    /**
     * API đánh dấu đã chuyển hàng
     *
     * @param $id
     */
    public function admin_api_mark_shipped($id)
    {
        /** @var \Entity\Order $order */
        $order = $this->entityManager->find('Entity\Order', $id);
        if (!$order) {
            // non-exists order id
            $this->jsonResponse([
                'code' => -1,
                'message' => 'Đơn hàng không hợp lệ.'
            ]);
        } elseif ($order->getStatus() != ORDER_STATUS_NEW) {
            // Invalid state
            $this->jsonResponse([
                'code' => -2,
                'message' => 'Trạng thái đơn hàng không phải là mới đặt.'
            ]);
        } else {
            $order->setStatus(ORDER_STATUS_SHIPPED);
            $this->entityManager->flush($order);
            $this->jsonResponse(['code' => 0]);
        }
    }

    public function admin_api_destroy($id)
    {
        /** @var \Entity\Order $order */
        $order = $this->entityManager->find('Entity\Order', $id);
        if (!$order) {
            // non-exists order id
            $this->jsonResponse([
                'code' => -1,
                'message' => 'Đơn hàng không hợp lệ.'
            ]);
        } elseif ($order->getStatus() != ORDER_STATUS_NEW) {
            // Invalid state
            $this->jsonResponse([
                'code' => -2,
                'message' => 'Trạng thái đơn hàng không phải là mới đặt.'
            ]);
        } else {
            foreach ($order->getDetails() as $orderDetail) {
                $this->entityManager->remove($orderDetail);
            }

            $this->entityManager->remove($order);
            $this->entityManager->flush();
            $this->jsonResponse(['code' => 0]);
        }
    }

    protected function orderBuildControls(\Entity\Order $item)
    {
        $edit = sprintf('<button class="edit btn btn-warning control redirect" data-id="%s" data-href="%s"><i class="icon-edit  icon-white"></i></button>',
            $item->getId(),
            base_url() . 'admincp/order/show/' . $item->getId());

//        $del = sprintf('<button class="delete btn btn-danger control" data-id="%s" data-value=""><i class="icon-remove  icon-white"></i></button>',
//            $item->getId());
        $del = '';

        return $edit . $del;
    }

    public function admin_ship_fee()
    {
        $this->render('back/order/ship_fee', ['admin/ship_fee'], ['back']);
    }

    public function admin_api_get_ship_fee()
    {
        $offset = $this->getInput('start');
        $quantity = $this->getInput('length');
        $sortableColumns = [
            'w.name',
            'w.ship_fee'
        ];
        $cOrders = $this->getInput('order');
        $search = $this->getInput('search');

        $wardsQuery = $this->entityManager->createQueryBuilder()
            ->select('w')
            ->from('Entity\Ward', 'w')
            ->setFirstResult($offset)
            ->setMaxResults($quantity);
        // Set order by

        $wardsQuery->where('w.name LIKE ?1');

        $wardsQuery->setParameter('1', '%' . $search['value'] . '%');

        foreach ($cOrders as $o) {
            $wardsQuery->orderBy($sortableColumns[$o['column']], $o['dir']);
        }


        $countQuery = $this->entityManager->createQueryBuilder()
            ->select('count(w.id)')
            ->from('Entity\Ward', 'w')
            ->where('w.name LIKE ?1')
            ->setParameter('1', '%' . $search['value'] . '%');
        $count = $countQuery->getQuery()->getSingleScalarResult();

        $jsonResponse = [
            'data' => [],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ];

        $wards = $wardsQuery->getQuery()->getResult();
        /** @var \Entity\Ward $w */
        foreach ($wards as $w) {
            $data = [
                $w->getName(),
                $w->getShipFee(),
                $this->shipFeeBuildControls($w),
            ];

            $jsonResponse['data'][] = $data;
        }

        $this->jsonResponse($jsonResponse);
    }

    public function admin_api_get_ship_fee_edit($id)
    {
        /** @var \Entity\Ward $ward */
        $ward = $this->entityManager->find('Entity\Ward', $id);
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->data['ward'] = $ward;
            $this->load->view('back/order/ship_fee_form', compact('ward'));
        } else {
            $ward->setName($this->getInput('name'));
            $ward->setShipFee($this->getInput('fee'));
            $ward->setMessage($this->getInput('message'));
            $this->entityManager->flush($ward);

            $this->jsonResponse(['code' => 0]);
        }
    }

    public function admin_api_ship_fee_store()
    {
        $ward = new \Entity\Ward();
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $ward->setShipFee(10);
            $ward->setName('Quận ');
            $this->load->view('back/order/ship_fee_form', compact('ward'));
        } else {
            $ward->setName($this->getInput('name'));
            $ward->setShipFee($this->getInput('fee'));
            $ward->setMessage($this->getInput('message'));
            $this->entityManager->persist($ward);
            $this->entityManager->flush();
            $this->jsonResponse(['code' => 0]);
        }
    }

    public function admin_api_ship_fee_destroy($id)
    {
        $ward = $this->entityManager->find('Entity\Ward', $id);
        if (!$ward) {
            $this->jsonResponse(['code' => -1], 404);
        } else {
            $this->entityManager->remove($ward);
            $this->entityManager->flush();
            $this->jsonResponse(['code' => 0]);
        }
    }

    protected function shipFeeBuildControls(\Entity\Ward $ward)
    {
        $edit = '<button class="edit btn btn-warning control" data-id="'. $ward->getId() .'"><i class="icon-edit  icon-white"></i></button>';
        $del = '<button class="delete btn btn-danger control" data-id="'. $ward->getId() .'" data-value="' . $ward->getName() . '"><i class="icon-remove  icon-white"></i></button>';

        return $edit . $del;
    }

    public function print_only($id)
    {
        try {
            $order = $this->orderRepository->getOrder($id);

            $this->load->view('order/print_only', ['order' => $order]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function api_detail($id)
    {
        $order = $this->entityManager->find('Entity\Order', $id);

        $this->load->view('order/detail', ['order' => $order]);
    }
}