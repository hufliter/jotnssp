<?php
namespace Repositories;


use DateTime;
use Entity\Order;
use Entity\OrderDetail;
use Entity\SiteConfig;
use Entity\User;
use Entity\Ward;
use Jotun\Cart\Item;

class OrderRepository
{
    /**
     * @param array $orderInfo
     * @param Ward $ward
     * @param User $user
     * @param Item[] $items
     * @param User $reseller
     * @return Order
     */
    public function makeOrder(array $orderInfo, Ward $ward, User $user, $items, User $reseller = null)
    {
        $em = \Doctrine::getEntityManager();
        $order = new Order();
        $order->setFullName($orderInfo['name'])
            ->setAddress($orderInfo['address'])
            ->setPhone($orderInfo['phone'])
            ->setStatus(ORDER_STATUS_NEW)
            ->setDate(new DateTime())
            ->setUser($user);

        if (array_key_exists('note', $orderInfo)) {
            $order->setNote($orderInfo['note']);
        }

        $total = 0;

        // Add items
        foreach ($items as $item) {
            $detail = new OrderDetail();
            $detail->setOrder($order)
                ->setProduct($item->getProduct())
                ->setQuantity($item->getQuantity())
                ->setPrice($item->getPrice());

            $em->persist($detail);
            $total += $detail->getTotal();
        }

        $order->setWard($ward);
        $order->setShipFee($ward->getShipFee());

        if ($reseller) {
            $order->setReseller($reseller);
            $offPercent = (int) SiteConfig::getConfig(CONF_COUPON_OFF);
            $order->setSaleOff(round($offPercent * $total / 100));
            $order->setCoupon($reseller->getResellerCode());
        }

        $order->setTotal($total);
        $em->persist($order);
        $em->flush();

        return $order;
    }

    /**
     * @param $id
     * @return null|\Entity\Order
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Exception
     */
    public function getOrder($id)
    {
        $order = \Doctrine::getEntityManager()->find('Entity\Order', $id);
        if (!$order) {
            throw new \Exception('Invalid order with id: ' . $id);
        }

        return $order;
    }
}