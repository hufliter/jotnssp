<?php

class Cart extends AppController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['productId'];
            $name = $_POST['name'];
            $quantity = intval($_POST['quantity']);
            $price = $_POST['price'];
            $data['cart'] = array();
            if ($this->session->userdata('cart')) {
                $data['cart'] = $this->session->userdata('cart');
                if (is_array($data['cart'])) {
                    foreach ($data['cart'] as $key => $item) {
                        if ($item['productId'] == $productId) {
                            $quantity += $item['quantity'];
                            unset($data['cart'][$key]);
                        }
                    }
                }
            }
            $data['cart'][] = array(
                'productId' => $productId,
                'name'      => $name,
                'quantity'  => $quantity,
                'price'     => $price
            );
            $this->session->set_userdata($data);
            echo 'true';
        } else {
            //$this->session->unset_userdata('cart');
            var_dump($this->session->userdata('cart'));
            exit;
        }
    }

    public function api_add()
    {
        $response['code'] = 0;
        try {
            $product = \Entity\Product::getProduct($this->getInput('product_id'));
            \Jotun\Cart\Cart::getInstance()->add($product, intval($this->getInput('quantity')));
        } catch (\Exception $e) {
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
        } finally {
            $this->jsonResponse($response);
        }
    }

    public function api_get_add($id)
    {
        try {
            $product = \Entity\Product::getProduct($id);
            $this->load->view('cart/add_item', ['product' => $product]);
        } catch (\Exception $e) {
            // no response
        }
    }
}
