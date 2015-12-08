<?php namespace Jotun\Cart;
use Entity\Product;
use Jotun\Exceptions\InvalidProductException;
use Jotun\SingletonTrait;
use Jotun\CodeIgniterTrait;

class Cart
{
    use SingletonTrait,
        CodeIgniterTrait;

    const SESSION_BASE = '_jts_cart_';

    /**
     * @var Item[]|\SplObjectStorage
     */
    protected $items;

    protected function init()
    {
        $raw = $this->getCI()->session->userdata(static::SESSION_BASE);
        $this->items = new \SplObjectStorage();
        if ($raw !== false) {
            $this->discoverItems(json_decode($raw, true));
        }
    }

    /**
     * @param Product|int $productId
     * @param $quantity
     * @throws InvalidProductException
     */
    public function add($productId, $quantity)
    {
        if ($quantity > 0) {
            if ($productId instanceof Product) {
                $product = $productId;
            } else {
                $product = Product::getProduct($productId);
            }

            $item = $this->getItemById($product->getId());
            if (!$item) {
                $item = Item::make($product, $quantity);
                $this->items->attach($item);
            } else {
                $item->modifyQuantity($quantity);
            }

            $this->storeSession();
        }
    }

    public function remove($productId)
    {
        $item = $this->getItemById($productId);
        if ($item) {
            $this->items->detach($item);
            $this->storeSession();
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        $item = $this->getItemById($productId);
        if ($item) {
            $item->setQuantity($quantity);
            $this->storeSession();
        }
    }

    public function getTotal()
    {
        return $this->items->count();
    }

    /**
     * @return Item[]|\SplObjectStorage
     */
    public function getItems()
    {
        return $this->items;
    }

    protected function storeSession()
    {
        $array = [];
        foreach ($this->items as $item) {
            if ($item->getQuantity() > 0) {
                $array[] = $item->toArray();
            }
        }

        $json = json_encode($array);

        $this->getCI()->session->set_userdata(static::SESSION_BASE, $json);
    }

    protected function discoverItems($data)
    {
        foreach ($data as $arr) {
            $item = Item::fromArray($arr);
            $this->items->attach($item);
        }
    }

    protected function getItemById($id)
    {
        foreach ($this->items as $item) {
            if ($item->getProductId() == $id) {
                return $item;
            }
        }

        return null;
    }

    public function clean()
    {
        $this->items = new \SplObjectStorage();
        $this->storeSession();
    }
}