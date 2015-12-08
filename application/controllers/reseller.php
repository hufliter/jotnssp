<?php
class Reseller extends AppController
{
    public function admin_show($id)
    {
        /** @var Entity\User $reseller */
        $reseller = $this->entityManager->getRepository('Entity\User')
            ->find($id);
        if (is_null($reseller) || !$reseller->hasRole(ROLE_RESELLER)) {
            redirect('admincp/dashboard');
            exit();
        }

        $this->data['salaries'] = \Entity\User::getResellerSalary($reseller, 6);
        $this->data['page_title'] = 'Reseller detail';
        $this->data['reseller'] = $reseller;
        $this->render('back/reseller/show', ['admin/reseller'], ['back']);
    }

    public function admin_api_get_orders()
    {
        $resellerId = $this->getInput('reseller_id');
        $reseller = Doctrine::getEntityManager()->find('Entity\User', $resellerId);
        $ordersQuery = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from('Entity\Order', 'o')
            ->where('o.reseller = ?1');

        $ordersQuery->setParameter('1', $reseller);
        $orders = $ordersQuery->getQuery()->getResult();

        // Count query
        $countOrdersQuery = Doctrine::getEntityManager()->createQueryBuilder()
            ->select('count(o.id)')
            ->from('Entity\Order', 'o')
            ->where('o.reseller = ?1');

        $countOrdersQuery->setParameter('1', $reseller);
        $count = $countOrdersQuery->getQuery()->getSingleScalarResult();

        $jsonResponse = [
            'data' => [],
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ];

        /** @var \Entity\Order $order */
        foreach ($orders as $order) {
            $jsonData = [
                $this->makeOrderDetailLink($order),
                $order->getUser()->getName(),
                $order->getCreatedAt()->format('H:i:s d/m/Y'),
                JotunUtils::currencyFormat($order->getTotal()),
                '<div class="control"></div>'
            ];

            $jsonResponse['data'][] = $jsonData;
        }

        $this->jsonResponse($jsonResponse);
    }

    public function admin_api_make_payment()
    {
        $id = $this->getInput('id');
        $timeCode = $this->getInput('time_code');
        /** @var \Entity\User $reseller */
        $reseller = \Doctrine::getEntityManager()->find('Entity\User', $id);
        $response = ['code' => 0];

        try {
            $reseller->makePayment($timeCode);
        } catch (\Exception $e) {
            $response['code'] = $e->getCode();
            $reseller['message'] = $e->getMessage();
        } finally {
            $this->jsonResponse($response);
        }
    }

    public function admin_api_get_payment_detail()
    {
        $id = $this->getInput('id');
        $time = $this->getInput('time');
        /** @var \Entity\User $reseller */
        $reseller = \Doctrine::getEntityManager()->find('Entity\User', $id);

        $orders = $reseller->collectOrdersByTime(JotunUtils::getStartOfMonth($time), JotunUtils::getEndOfMonth($time));
        $this->load->view('back/reseller/order_detail', ['orders' => $orders]);

    }

    /**
     * @param \Entity\Order $order
     * @return string
     */
    protected function makeOrderDetailLink($order)
    {
        return sprintf('<a href="%sadmincp/order/show/%d">%s</a>', base_url(), $order->getId(), $order->getBeautyId());
    }
}