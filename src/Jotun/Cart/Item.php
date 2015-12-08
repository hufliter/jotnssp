<?php namespace Jotun\Cart;
class Item
{
    /**
     * @var int
     */
    protected $product_id;

    /**
     * @var \Entity\Product
     */
    protected $product;

    /**
     * @var string
     */
    protected $product_name;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var float
     */
    protected $price;

    public function __construct($productId, $productName, $price, $quantity, $product = null)
    {
        $this->product_id = $productId;
        $this->product_name = $productName;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->product = $product;
    }

    /**
     * @param \Entity\Product $product
     * @param $quantity
     * @return static
     */
    public static function make($product, $quantity)
    {
        $instance = new static($product->getId(), $product->getName(), $product->getPrice(), $quantity, $product);
        return $instance;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @return null|\Entity\Product
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getProduct()
    {
        if ($this->product) {
            return $this->product;
        }

        return \Doctrine::getEntityManager()->find('Entity\Product', $this->product_id);
    }

    public function getName()
    {
        return $this->product_name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function modifyQuantity($offset)
    {
        $this->quantity += $offset;

        return $this;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function toArray()
    {
        return [
            $this->product_id,
            $this->product_name,
            $this->price,
            $this->quantity
        ];
    }

    public static function fromArray($array)
    {
        $instance = new static($array[0], $array[1], $array[2], $array[3]);

        return $instance;
    }
}