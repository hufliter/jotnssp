<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Tests\ORM\Functional\Ticket\DateTime2;
use Jotun\Exceptions\AlreadyPaymentException;

/**
 * User
 *
 * @ORM\Table(name="user",indexes={@ORM\Index(name="index_reseller_code",columns={"reseller_code"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`user`", type="string", length=50, nullable=false, unique=true)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="`pass`", type="string", length=32, nullable=false)
     */
    private $pass;

    /**
     * @var string
     *
     * @ORM\Column(name="`email`", type="string", length=50, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="`name`", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="`delete`", type="boolean", nullable=false)
     */
    private $delete;

    /**
     * @var boolean
     *
     * @ORM\Column(name="`admin`", type="boolean", nullable=false)
     */
    private $admin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="`date`", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="`roles`", type="integer", nullable=false)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="Entity\ResellerPayment", mappedBy="reseller")
     */
    private $reseller_payments;

    /**
     * @var string
     *
     * @ORM\Column(name="fb_user_id", type="string", nullable=true)
     */
    public $fb_user_id;

    /**
     * @var string
     *
     * @ORM\Column(name="reseller_code", type="string", nullable=true)
     */
    public $reseller_code;

    /**
     * @var string
     * @ORM\Column(name="note", type="string", nullable=true)
     */
    private $note;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="Entity\Order", mappedBy="user")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="Entity\Order", mappedBy="reseller")
     */
    private $reseller_orders;

    public function __construct()
    {
        $this->reseller_payments = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->reseller_orders = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return User
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set pass
     *
     * @param string $pass
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set delete
     *
     * @param boolean $delete
     * @return User
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;

        return $this;
    }

    /**
     * Get delete
     *
     * @return boolean 
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     * @return User
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return User
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set roles
     *
     * @param integer $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return integer 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function getResellerOrders()
    {
        return $this->reseller_orders;
    }

    public function getRolesString()
    {
        $map = [
            ROLE_USER => 'User',
            ROLE_RESELLER => 'Reseller',
            ROLE_ADMIN => 'Admin',
        ];

        if (array_key_exists($this->getRoles(), $map)) {
            return $map[$this->getRoles()];
        }

        if ($this->getAdmin()) {
            return $map[ROLE_ADMIN];
        }

        return $map[ROLE_USER];
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Check user has role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return (bool)($this->getRoles() & $role);
    }

    public function getResellerCode()
    {
        if (strlen($this->reseller_code) == 0) {
            $this->reseller_code = 'JTS' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
            \Doctrine::getEntityManager()->persist($this);
            \Doctrine::getEntityManager()->flush($this);
        }

        return $this->reseller_code;
    }

    public function getRoleDropdown($name, $attributes = [])
    {
        $attributes['name'] = $name;
        $html = '<select ';
        foreach ($attributes as $key => $val) {
            $html .= $key . '="' . $val . '" ';
        }
        $html .= ">";

        $roles = [
            ROLE_USER => 'User',
            ROLE_RESELLER => 'Reseller',
            ROLE_ADMIN => 'Admin',
        ];
        foreach ($roles as $id => $text) {
            $selected = $this->getRoles() == $id ? ' selected' : '';
            $option = "<option value=\"{$id}\"{$selected}>{$text}</option>";
            $html .= $option;
        }

        $html .= '</select>';

        return $html;

    }

    /**
     * @return ArrayCollection|ResellerPayment[]
     */
    public function getResellerPayments()
    {
        return $this->reseller_payments;
    }

    /**
     * @param int|User $reseller
     * @param int $maxMonth
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Exception
     */
    public static function getResellerSalary($reseller, $maxMonth = 3)
    {
        if ( ! $reseller instanceof User) {
            /** @var User $reseller */
            $reseller = \Doctrine::getEntityManager()->find('Entity\User', $reseller);
        }

        if (!$reseller || !$reseller->hasRole(ROLE_RESELLER)) {
            throw new \Exception('Invalid reseller');
        }

        // calc this month
        $now = new \DateTime();
        $salaries[] = [
            'time' => $now->format('m/Y'),
            'value' => $reseller->getSalaryByMonthOrTimeCode($now),
            'paid' => -1,
        ];

        $maxMonth--;
        for ($i = $maxMonth; $i > 0; $i--) {
            $now->modify('-1 month');
            $salaries[] = [
                'time' => $now->format('m/Y'),
                'value' => $reseller->getSalaryByMonthOrTimeCode($now),
                'paid' => $reseller->isPaid($now->format('m/Y')),
            ];
        }

        return $salaries;
    }

    public function getLifetimeSalary()
    {
        $query = \Doctrine::getEntityManager()->createQueryBuilder()
            ->select('sum(o.total)')
            ->from('Entity\Order', 'o')
            ->where('o.reseller = ?1')
            ->setParameter(1, $this);

        $value = $query->getQuery()->getSingleScalarResult();

        return $value ?: 0;
    }

    /**
     * @param \DateTime $time
     * @return float
     */
    public function getSalaryByMonthOrTimeCode($time)
    {
        if (!$time instanceof \DateTime) {
            $time = \DateTime::createFromFormat('m/Y', $time);
        }
        $start = \DateTime::createFromFormat('d-m-Y H:i:s', $time->format('01-m-Y 00:00:00'));
        $end = \DateTime::createFromFormat('d-m-Y H:i:s', $time->format('t-m-Y 23:59:59'));

        $query = \Doctrine::getEntityManager()->createQueryBuilder()
            ->select('sum(r.total)')
            ->from('Entity\Order', 'r')
            ->where('r.reseller = :reseller')
            ->andWhere('r.updated_at >= :start')
            ->andWhere('r.updated_at <= :end');

        $query->setParameters([
            'reseller' => $this,
            'start' => $start,
            'end' => $end
        ]);

        $value = $query->getQuery()->getSingleScalarResult();

        return $value ?: 0;
    }

    /**
     * @param $timeCode
     * @return bool
     */
    public function isPaid($timeCode)
    {
        if ($this->getSalaryByMonthOrTimeCode($timeCode) == 0) {
            return true;
        }

        $query = \Doctrine::getEntityManager()->createQueryBuilder()
            ->select('count(p.id)')
            ->from('Entity\ResellerPayment', 'p')
            ->where('p.reseller = :reseller')
            ->andWhere('p.time_code = :code');
        $query->setParameter('reseller', $this);
        $query->setParameter('code', $timeCode);

        return $query->getQuery()->getSingleScalarResult() > 0;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return Order[]
     */
    public function collectOrdersByTime($start, $end)
    {
        $query = \Doctrine::getEntityManager()->createQueryBuilder()
            ->select('o')
            ->from('Entity\Order','o')
            ->where('o.reseller = :reseller')
            ->andWhere('o.updated_at >= :start')
            ->andWhere('o.updated_at <= :end');

        $query->setParameter('reseller', $this);
        $query->setParameter('start', $start);
        $query->setParameter('end', $end);

        return $query->getQuery()->getResult();
    }

    public function makePayment($timeCode)
    {
        if ($this->isPaid($timeCode)) {
            throw new AlreadyPaymentException($this, $timeCode);
        }

        // Collect orders
        $start = \JotunUtils::getStartOfMonth($timeCode);
        $end = \JotunUtils::getEndOfMonth($timeCode);
        $orders = $this->collectOrdersByTime($start, $end);
        $total = 0;

        $payment = new ResellerPayment();
        $payment->setReseller($this);
        $payment->setTimeCode($timeCode);

        // make payment details
        foreach ($orders as $order) {
            $paymentDetail = new ResellerPaymentDetail();
            $paymentDetail->setResellerPayment($payment);
            $paymentDetail->setOrder($order);
            $paymentDetail->setAmount($order->getTotal());

            $total += $order->getTotal();

            \Doctrine::getEntityManager()->persist($paymentDetail);
        }
        $payment->setAmount($total);
        \Doctrine::getEntityManager()->persist($payment);
        \Doctrine::getEntityManager()->flush();
    }
}
