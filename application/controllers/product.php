<?php

use Jotun\Cart\Cart;
use Repositories\OrderRepository;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends AppController
{
    protected $orderRepository;
    protected $cart;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');

        $this->orderRepository = new OrderRepository();
        $this->cart = Cart::getInstance();
    }

    public function index()
    {
        $field = 'product.id,product.name,product.thumb,product.price,product.sale,product.start,product.end, product.available';
        $link = '/product/index/';

        $this->paginate('product', $field, 3, $link);
        $this->paginate['total_rows'] = $this->pagination_model->total_rows('status', '1');

        $this->pagination->initialize($this->paginate);
        $this->data['pagination_link'] = $this->pagination->create_links();

        $this->pagination_model->sortList = array(
            'date' => 'date'
        );
        $this->data['pagination'] = $this->pagination_model->fetch(
            $this->uri->segment(3), $this->paginate['per_page'], 'status', '1', 'date', 'desc'
        );

        $this->data['description'] = 'sản phẩm mới cập nhật, mỹ phẩm mới update, mỹ phẩm mới, new product in jotunshop';
        $this->render('product/index', null, array('board'));
    }

    public function search($q = null)
    {
        $get = $this->input->get('q');
        if (empty($q) && empty($get))
            redirect('/');
        elseif (empty($q))
            $q = $get;

        $q = str_replace('/', '', urldecode(trim($q)));
        $this->data['q'] = html_escape($q);

        $field = 'product.id,product.name,product.thumb,product.price,product.sale,product.start,product.end,product.available';
        $link = '/product/search/' . $q . '/';

        $this->paginate('product', $field, 4, $link);

        $this->product_search($q);

        $this->paginate['total_rows'] = $this->pagination_model->db->get('product')->num_rows;

        $this->pagination->initialize($this->paginate);

        $this->data['pagination_link'] = $this->pagination->create_links();

        $this->product_search($q);

        $this->data['pagination'] = $this->pagination_model->fetch(
            $this->uri->segment(4), $this->paginate['per_page']
        );

        $this->data['description'] = 'sản phẩm ' . $this->data['q'] . ', các loại sản phẩm ' . $this->data['q'];
        $this->render('product/search', null, array('board'));
    }

    public function detail($id = null, $name = null)
    {
        if (empty($id) || empty($name))
            redirect('/');

        $this->product_model->db->where('status', '1');
        $this->product_model->db->join('category', 'product.cid = category.id', 'inner');

        $field = 'product.id, category.id as cid, category.link, category.name as category, product.name, product.thumb, product.image, product.seo,' .
            'product.advantage, product.price, product.sale, product.start, product.end, product.available';
        $this->product_model->view = get_cookie('product_' . $id);
        $this->data['detail_product'] = $this->product_model->select('product', $id, 'product.id', $field);

        if (empty($this->data['detail_product']))
            redirect('/');

        $this->data['detail_relative'] = $this->product_model->relative(
            $this->data['detail_product']->cid, $id
        );
        $this->data['slide_relative'] = $this->load->view('product/slide_relative', $this->data, true);

        if (!empty($this->data['detail_product'])):
            $this->data['fb_thumb'] = $this->data['detail_product']->thumb;
            $this->data['fb_title'] = html_escape($this->data['detail_product']->name);
            $this->data['fb_url'] = '/product/detail/' . $this->data['detail_product']->id . '/' .
                url_title(convert_accented_characters($this->data['detail_product']->name), '-', TRUE);
        endif;

        if (empty($this->data['detail_product']->seo))
            $this->data['description'] = html_escape($this->data['detail_product']->name) . ', sản phẩm của ' . html_escape($this->data['detail_product']->category);
        else
            $this->data['description'] = html_escape($this->data['detail_product']->seo);

        $this->data['ads'] = $this->dashboard_model->ads_find('under_product_detail', false);
        $this->render('product/detail', array('elevatezoom'), array('board', 'carousel3'));
    }

    public function sale()
    {
        $field = 'product.id,product.name,product.thumb,product.price,product.sale,product.start,product.end';
        $link = '/product/sale/';

        $this->paginate('product', $field, 3, $link);

        $rule = array(
            'status' => '1',
            'start <=' => date('Y-m-d'),
            'end >=' => date('Y-m-d')
        );
        $this->paginate['total_rows'] = $this->pagination_model->total_rows($rule);

        $this->pagination->initialize($this->paginate);
        $this->data['pagination_link'] = $this->pagination->create_links();

        $this->data['pagination'] = $this->pagination_model->fetch(
            $this->uri->segment(3), $this->paginate['per_page'], $rule
        );

        $this->data['description'] = ' các sản phẩm khuyến mãi, jotunshop hot, jotunshop sale, giảm giá, hàng tốt';
        $this->render('product/sale', null, array('board'));
    }

    public function admin_index($sortBy = 'stt', $sortOrder = 'desc')
    {
        $field = 'product.id,product.cid,category.name as category,product.name,product.thumb,product.price,product.status,product.view, product.date,product.available';
        $link = '/admincp/product/index';

        $this->paginate('product', $field, 6, $link . '/' . $sortBy . '/' . $sortOrder);

        $this->pagination_model->sortList = array(
            'stt' => 'id', 'category' => 'cid', 'ten' => 'name', 'gia' => 'price',
            'tinhtrang' => 'status', 'view' => 'view', 'ngay' => 'date',
            'available' => 'available'
        );
        $this->paginate['total_rows'] = $this->pagination_model->total_rows();
        $this->pagination->initialize($this->paginate);
        $this->data['pagination_link'] = $this->pagination->create_links();

        $this->pagination_model->db->join('category', 'category.id = product.cid');
        $this->data['pagination'] = $this->pagination_model->fetch(
            $this->uri->segment(6), $this->paginate['per_page'], null, null,
            $sortBy, $sortOrder
        );

        $this->data['sort_link'] = $link;
        $this->data['pagination_sortBy'] = $sortBy;
        $this->data['pagination_sortOrder'] = $this->pagination_model->sortOrder;
        $this->render('product/admin_index',
            array('jquery.sceditor.bbcode.min', 'jquery-ui', 'tag-it.min', 'admin/product'),
            array('back', 'default.min', 'jquery.tagit', 'tagit.ui-zendesk'));
    }

    public function admin_search($q = null, $sortBy = 'stt', $sortOrder = 'desc')
    {
        $get = $this->input->get('q');
        if (empty($q) && empty($get))
            redirect('/admincp/product');
        elseif (empty($q))
            $q = $get;

        $q = str_replace('/', '', urldecode(trim($q)));
        $this->data['q'] = html_escape($q);

        $field = 'product.id,product.cid,category.name as category,product.name,product.thumb,product.price,product.status,product.view,product.date,product.available';
        $link = '/admincp/product/search/' . $q;

        $this->paginate('product', $field, 7, $link . '/' . $sortBy . '/' . $sortOrder);
        $this->pagination_model->sortList = array(
            'stt' => 'id', 'category' => 'cid', 'ten' => 'name', 'gia' => 'price',
            'tinhtrang' => 'status', 'view' => 'view'
        );

        $this->product_search($q);

        $this->paginate['total_rows'] = $this->pagination_model->db->get('product')->num_rows;

        $this->pagination->initialize($this->paginate);

        $this->data['pagination_link'] = $this->pagination->create_links();

        $this->product_search($q);
        $this->pagination_model->db->join('category', 'category.id = product.cid');
        $this->pagination_model->sortList = array(
            'stt' => 'id', 'category' => 'cid', 'ten' => 'name', 'gia' => 'price',
            'tinhtrang' => 'status', 'view' => 'view'
        );
        $this->data['pagination'] = $this->pagination_model->fetch(
            $this->uri->segment(7), $this->paginate['per_page'], null, null,
            $sortBy, $sortOrder
        );


        $this->data['sort_link'] = $link;
        $this->data['pagination_sortBy'] = $sortBy;
        $this->data['pagination_sortOrder'] = $this->pagination_model->sortOrder;
        $this->render('product/admin_index',
            array('jquery.sceditor.bbcode.min', 'jquery-ui', 'tag-it.min', 'admin/product'),
            array('back', 'default.min', 'jquery.tagit'));
    }

    private function product_search($q)
    {
        $this->pagination_model->db->select('product.id');
        //$alternate = $q;
        //if(strlen(utf8_decode($alternate)) <=5 )
        $this->pagination_model->db->like('product.name', $q);
        /*
        else
            $this->pagination_model->db->where('MATCH (product.name) AGAINST ('.
                $this->pagination_model->db->escape($q).
            ' IN BOOLEAN MODE)', null, false);
        */
    }

    public function admin_neighbour($id = null, $sortBy = 'stt', $sortOrder = 'desc')
    {
        if (empty($id))
            redirect('/admincp/product');

        $field = 'product.id,product.cid,category.name as category,product.name,product.thumb,product.price,product.status,product.view,product.date, product.available';
        $link = '/admincp/product/neighbour/' . $id;

        $this->paginate('product', $field, 7, $link . '/' . $sortBy . '/' . $sortOrder);

        $this->pagination_model->sortList = array(
            'stt' => 'id', 'category' => 'cid', 'ten' => 'name', 'gia' => 'price',
            'tinhtrang' => 'status', 'view' => 'view'
        );
        $this->paginate['total_rows'] = $this->pagination_model->total_rows('cid', $id);
        $this->pagination->initialize($this->paginate);
        $this->data['pagination_link'] = $this->pagination->create_links();

        if (empty($this->paginate['total_rows']))
            redirect('/admincp/product');

        $this->pagination_model->db->join('category', 'category.id = product.cid');
        $this->data['pagination'] = $this->pagination_model->fetch(
            $this->uri->segment(7), $this->paginate['per_page'], 'cid', $id,
            $sortBy, $sortOrder
        );

        $this->data['sort_link'] = $link;
        $this->data['pagination_sortBy'] = $sortBy;
        $this->data['pagination_sortOrder'] = $this->pagination_model->sortOrder;
        $this->render('product/admin_index',
            array('jquery.sceditor.bbcode.min', 'jquery-ui', 'tag-it.min', 'admin/product'),
            array('back', 'default.min', 'jquery.tagit'));
    }

    public function admin_add()
    {
        $this->data = array_merge($this->data, $this->site->back('category'));
        $this->validation();
        $this->isAjax();

        if ($this->input->post() && $this->form_validation->run('productAdd')):
            if ($this->product_model->add()):
                $this->session->set_flashdata('success', 'Thêm sản phẩm thành công');
                $this->site->back_erase(array('lastProduct', 'hotProduct'));
            else:
                $this->session->set_flashdata('error', 'Lỗi sql, thử lại');
            endif;
            redirect('/admincp/product');
        endif;

        $this->data['captTime'] = $this->captcha();
        $this->render('product/admin_add',
            array('jquery.sceditor.bbcode.min', 'jquery-ui', 'tag-it.min'),
            array('back', 'default.min', 'jquery-ui', 'jquery.tagit'));
    }

    public function admin_edit($id = null)
    {
        if (empty($id))
            redirect('/admincp/product/category');
        $this->data = array_merge($this->data, $this->site->back('category'));

        $this->validation();
        $this->isAjax();

        if ($this->input->post() && $this->form_validation->run('productEdit')):
            if ($this->product_model->edit()):
                $this->site->back_erase(array('lastProduct', 'hotProduct'));
                $this->session->set_flashdata('success', 'Sửa sản phẩm thành công');
            else:
                $this->session->set_flashdata('error', 'Lỗi sql, thử lại');
            endif;
            redirect('/admincp/product');
        endif;

        $this->data['product'] = $this->product_model->select('product', $id, 'id');
        if (empty($this->data['product'])):
            $this->session->set_flashdata('error', 'Không có sản phẩm này');
            redirect('/admincp/product');
        endif;

        $this->data['captTime'] = $this->captcha();
        $this->render(
            'product/admin_edit',
            array('jquery.sceditor.bbcode.min', 'jquery-ui', 'tag-it.min'),
            array('back', 'default.min', 'jquery.tagit')
        );
    }

    public function admin_delete($id = null)
    {
        if (empty($id))
            redirect('/admincp/product');

        $this->validation();
        $this->isAjax();
        if ($this->input->post() && $this->form_validation->run('delete')):
            if ($this->product_model->delete()):
                $this->site->back_erase(array('lastProduct', 'hotProduct'));
                $this->session->set_flashdata('success', 'Xóa sản phẩm thành công');
            else:
                $this->session->set_flashdata('error', 'Lỗi sql, thử lại');
            endif;
            redirect('/admincp/product');
        endif;

        $this->data['captTime'] = $this->captcha();
        $this->data['id'] = $id;
        $this->render('product/admin_delete', null, array('back'));
    }

    public function order()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->input->post() && $this->form_validation->run('productOrder')) {
                $user = $this->auth->getUser();
                $flag = false;

                if ($user->getAddress() == '') {
                    $user->setAddress($this->getInput('address'));
                    $flag = true;
                }

                if ($user->getPhone() == '') {
                    $user->setPhone($this->getInput('phone'));
                    $flag = true;
                }

                if ($flag) {
                    $this->entityManager->flush($user);
                }

                /**
                 * @var \Entity\Ward $ward
                 */
                $this->data['name'] = $this->getInput('name');
                $this->data['phone'] = $this->getInput('phone');
                $this->data['address'] = $this->getInput('address');
                $this->data['ward'] = $ward = $this->entityManager->find('Entity\Ward', $this->getInput('ward_id'));
                $this->data['note'] = $this->getInput('note');
                $quantity = $this->getInput('quantity');
                $i = 0;
                $total = 0;
                $items = [];
                foreach ($this->getInput('product_id') as $productId) {
                    $product = $this->entityManager->find('Entity\Product', $productId);
                    $items[] = [
                        'quantity' => $quantity[$i],
                        'product' => $product,
                    ];

                    $total += $product->getPrice() * $quantity[$i];

                    $i++;
                }
                $this->data['items'] = $items;
                $this->data['total'] = $total;

                $final = $total;

                $reseller = null;
                $off = 0;
                if ($this->getInput('reseller_code') != '') {
                    $reseller = $this->entityManager->getRepository('Entity\User')
                        ->findOneBy(['reseller_code' => $this->getInput('reseller_code')]);
                    $off = intval(\Entity\SiteConfig::getConfig(CONF_COUPON_OFF)) * $total / 100;
                    $final -= $off;
                }
                $final += $ward->getShipFee();

                $this->data['reseller'] = $reseller;
                $this->data['final'] = $final;
                $this->data['off'] = $off;

                $this->render('product/confirm');
            } else {
                echo 'hi';
                exit;
            }
        } elseif (!\Jotun\JotunAuth::instance()->check()) {
            $this->session->set_userdata('redirect_after_login', 'dat-hang');
            $this->render('login_required');
        } else {
            $this->data['user'] = $this->auth->getUser();
            $this->data['wards'] = $this->entityManager->getRepository('Entity\Ward')->findAll();
            $this->render('product/order');
        }
    }

    public function confirm()
    {
        if ($this->cart->getTotal() > 0) {
            $orderInfo = [
                'name' => $this->getInput('name'),
                'address' => $this->getInput('address'),
                'phone' => $this->getInput('phone'),
                'note' => $this->getInput('note'),
            ];
            $reseller = null;
            if (!is_null($this->getInput('reseller_id'))) {
                /** @var \Entity\User $reseller */
                $reseller = $this->entityManager->find('Entity\User', $this->getInput('reseller_id'));
            }

            /** @var \Entity\Ward $ward */
            $ward = $this->entityManager->find('Entity\Ward', $this->getInput('ward_id'));

            $this->orderRepository->makeOrder(
                $orderInfo,
                $ward,
                $this->auth->getUser(),
                $this->cart->getItems(),
                $reseller);

            $this->cart->clean();
            $this->render('product/order_success');
        } else {
            redirect('/');
        }
    }

    public function list_order()
    {
        $this->render('product/list_order');
    }

    public function api_list_order()
    {
        $offset = $this->getInput('start');
        $quantity = $this->getInput('length');
        $sortableColumns = [
            'o.id',
            'o.created_at',
            'o.total',
            'o.status'
        ];

        $cOrders = $this->getInput('order');
        $search = $this->getInput('search');

        $ordersQuery = $this->entityManager->createQueryBuilder()
            ->from('Entity\Order', 'o')
            ->setFirstResult($offset)
            ->setMaxResults($quantity);

        foreach ($cOrders as $o) {
            $ordersQuery->orderBy($sortableColumns[$o['column']], $o['dir']);
        }

        $ordersQuery->where('o.user = :user')
            ->setParameter('user', $this->auth->getUser());

        $countQuery = clone $ordersQuery;
        $countQuery->select('count(o.id)');
        $count = $countQuery->getQuery()->getSingleScalarResult();

        $jsonResponse = [
            'data' => [],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ];

        $orders = $ordersQuery
            ->select('o')
            ->getQuery()->getResult();
        /** @var \Entity\Order $o */
        foreach ($orders as $o) {
            $jsonData = [
                'code' => sprintf('<a class="order_code" href="%s">%s</a>',
                    base_url() . 'product/list-order-detail/' . $o->getId(), $o->getId()),
                'created_at' => $o->getCreatedAt()->format('H:i:s d/m/Y'),
                'total' => JotunUtils::currencyFormat($o->getTotal() + $o->getShipFee() - $o->getSaleOff()),
                'status' => $o->getStatus() == ORDER_STATUS_NEW ?
                    '<i class="fa fa-times unavailable"></i>' :
                    '<i class="fa fa-check available"></i>',
                'actions' => sprintf('<a class="btn btn-info" href="%s">%s</a>',
                    base_url() . 'product/list-order-detail/' . $o->getId(),
                    '<i class="fa fa-info-circle"></i>')
            ];

            $jsonResponse['data'][] = $jsonData;
        }

        $this->jsonResponse($jsonResponse);

    }

    public function list_order_detail($id)
    {
        /** @var \Entity\Order $order */
        $order = $this->entityManager->getRepository('Entity\Order')
            ->findOneBy([
                'id' => $id,
                'user' => $this->auth->getUser()
            ]);
        if (!$order) {
            redirect('product/list-order');
        } else {
            $this->data['order'] = $order;
            $i = 0;
            $rows = '';
            /** @var \Entity\OrderDetail[] $details */
            $details = $order->getDetails();
            foreach ($details as $detail) {
                $rowData = [
                    'i' => ++$i,
                    'name' => sprintf('<a href="%s" target="_blank">%s</a>',
                        base_url() . 'product/detail/' . $detail->getProduct()->getId() . '/' .
                            url_title(convert_accented_characters($detail->getProduct()->getName()),'-', true),
                        $detail->getProduct()->getName()),
                    'price' => JotunUtils::currencyFormat($detail->getPrice()),
                    'quantity' => $detail->getQuantity(),
                    'total' => JotunUtils::currencyFormat($detail->getPrice() * $detail->getQuantity())
                ];

                $rows .= $this->load->view('product/partials/list_order_detail_row', $rowData, true);
            }

            $this->data['rows'] = $rows;
            $this->render('product/list_order_detail');
        }
    }
    public function list_order_ctv()
    {
        $this->render('product/list_order_ctv');
    }

    public function api_list_order_ctv()
    {
        $offset = $this->getInput('start');
        $quantity = $this->getInput('length');
        $sortableColumns = [
            'o.id',
            'o.user',
            'o.total',
            'o.created_at',
            'o.status',
        ];

        $cOrders = $this->getInput('order');
        $search = $this->getInput('search');

        $ordersQuery = $this->entityManager->createQueryBuilder()
            ->from('Entity\Order', 'o')
            ->join('o.user', 'u')
            ->setFirstResult($offset)
            ->setMaxResults($quantity);

        foreach ($cOrders as $o) {
            $ordersQuery->orderBy($sortableColumns[$o['column']], $o['dir']);
        }

        $ordersQuery->where('o.reseller = :user')
            ->andWhere('u.name LIKE :a')
            ->setParameters([
                'user' => $this->auth->getUser(),
                'a' => '%' . $search['value'] . '%'
            ]);

        $countQuery = clone $ordersQuery;
        $countQuery->select('count(o.id)');
        $count = $countQuery->getQuery()->getSingleScalarResult();

        $jsonResponse = [
            'data' => [],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ];

        $orders = $ordersQuery
            ->select('o')
            ->getQuery()->getResult();
        /** @var \Entity\Order $o */
        foreach ($orders as $o) {
            $detailEp = base_url() . 'order/api-detail/' . $o->getId();
            $jsonData = [
                'code' => $o->getBeautyId(),
                'created_at' => $o->getCreatedAt()->format('H:i:s d/m/Y'),
                'total' => JotunUtils::currencyFormat($o->getTotal() + $o->getShipFee()),
                'name' => sprintf('<a href="%s" target="_blank">%s</a>',
                    'http://fb.com/' . $o->getUser()->fb_user_id, $o->getUser()->getName()),
                'status' => $o->getStatus() == ORDER_STATUS_NEW ?
                    '<i class="fa fa-times unavailable"></i>' :
                    '<i class="fa fa-check available"></i>',
                'actions' => sprintf('<button class="btn btn-info" data-ep="%s"><i class="fa fa-info"></i></button>', $detailEp)
            ];

            $jsonResponse['data'][] = $jsonData;
        }

        $this->jsonResponse($jsonResponse);
    }

    public function admin_api_available_swap($id)
    {
        /** @var \Entity\Product $product */
        $product = $this->entityManager->find('Entity\Product', $id);
        if (!$product) {
            $this->jsonResponse([
                'code' => -1,
                'message' => 'Sản phẩm không hợp lệ.',
            ]);
        } else {
            $product->setAvailable(!$product->getAvailable());
            $this->entityManager->flush($product);
            $this->jsonResponse([
                'code' => 0,
                'result' => $product->getAvailable() ? 'fa-check available' : 'fa-times unavailable',
            ]);
        }
    }

    public function api_check_reseller_code($code = null)
    {
        $code = strtoupper($code);
        $reseller = Doctrine::getEntityManager()->getRepository('Entity\User')
            ->findOneBy(['reseller_code' => $code]);
        if ($reseller) {
            $response = [
                'code' => 0,
                'reseller' => $reseller->getName(),
                'off' => (int)\Entity\SiteConfig::getConfig(CONF_COUPON_OFF),
            ];
        } else {
            $response['code'] = -1;
        }

        $this->jsonResponse($response);
    }

    public function api_cart_remove()
    {
        Cart::getInstance()->remove($this->getInput('product_id'));
        $this->jsonResponse(['code' => 0]);
    }

    public function api_cart_change_quantity()
    {
        Cart::getInstance()->updateQuantity($this->getInput('product_id'), $this->getInput('quantity'));
        $this->jsonResponse(['code' => 0]);
    }
}