<?php
class Test extends AppController
{
    public function hello()
    {
        echo JotunUtils::passwordHash('hello');
    }

    public function addUser()
    {
        $user = new \Entity\User();
        $user->setUser('phuong');
        $user->setName('phuong');
        $user->setPass(JotunUtils::passwordHash('123'));
        $user->setEmail('phuong@gmail.com');
        $user->setRoles(ROLE_ADMIN);
        $user->setAdmin(true);
        $user->setDelete(false);
        $user->setDate(new DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        echo 'Add user: ', $user->getId();
    }

    public function allUser()
    {
        $users = $this->entityManager->getRepository('Entity\User')->findAll();
        foreach ($users as $u) {
            echo $u->getName() . '<br>';
        }

    }

    public function login()
    {
        var_dump($this->session->userdata);
        if ($this->auth->check()) {
            $user = $this->auth->getUser();

            echo 'Xin chao ban ' . $user->getName();
        } else {
            echo 'You are not logged in.';
        }
    }

    public function order()
    {
        /** @var \Entity\User $user */
        $user = $this->entityManager->getRepository('Entity\User')
            ->findOneBy(['roles' => ROLE_RESELLER]);

        $order = new \Entity\Order();
        $order->setUser($user);
        $order->setAddress('115 Vo Van Tan');
        $order->setCoupon($user->getResellerCode());
        $order->setDate(new \DateTime());
        $order->setFullName('Test Order');
        $order->setReseller($user);
        $order->setStatus(ORDER_STATUS_NEW)
            ->setPhone('0979474581')
            ->setTotal(1000);

        $total = 0;
        $orderDetail = new \Entity\OrderDetail();
        /** @var \Entity\Product $product */
        $product = $this->entityManager->getRepository('Entity\Product')
            ->findOneBy(['cid' => 44]);

        $orderDetail->setProduct($product);
        $orderDetail->setPrice($product->getPrice());
        $orderDetail->setQuantity(1);
        $orderDetail->setOrder($order);
        $this->entityManager->persist($orderDetail);

        $total += $product->getPrice();

        $order->getDetails()->add($orderDetail);
        $order->setTotal($total);


        $this->entityManager->persist($order);
        $this->entityManager->flush();

        echo 'Order generated: ', $order->getId();
    }
}