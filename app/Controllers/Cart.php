<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\ConfigModel;
use App\Models\ProductStockModel;
use Exception;

class Cart extends BaseController
{
    protected $cartModel;
    protected $productStockModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productStockModel = new ProductStockModel();
    }

    public function index()
    {
        $sessionUserId = session()->get("user")->user_id ?? null;

        $cartData = $this->getCartData($sessionUserId);

        $headerData = $this->getHeaderData();
        $categoriesData = $this->getCategoriesData();
        $homeData = [
            "cart" => $cartData,
            "total" => $this->calculateTotalCartPrice($cartData)
        ];

        return view("templates/header", $headerData)
            .  view("templates/categories", $categoriesData)
            .  view("cart/home", $homeData)
            .  view("templates/footer", $categoriesData);
    }

    public function get()
    {
        $sessionUserId = session()->get("user")->user_id ?? null;

        $response = $this->cartModel
            ->select("product.name, product.price, first_product_image.url as product_image_url, shopping_cart.size, category.name as category")
            ->where("customer_id", $sessionUserId)
            ->join("product", "product.product_id = shopping_cart.product_id")
            ->join("category", "product.category_id = category.category_id")
            ->join("(SELECT product_id, MIN(url) AS url FROM product_image GROUP BY product_id) AS first_product_image", "product.product_id = first_product_image.product_id")
            ->orderBy("product.name")
            ->asObject()
            ->findAll();

        return $this->response->setJSON($response);
    }

    public function save()
    {
        if (!session()->has("user")) {
            session()->setFlashdata("message", "Você deve estar logado para acessar o carrinho");
            return redirect("login");
        }

        $data = [
            "customer_id" => session()->get("user")->user_id,
            "product_id"  => $this->request->getPost("product_id"),
            "quantity"    => $this->request->getPost("quantity"),
            "size"        => $this->request->getPost("size"),
        ];

        $response = $this->saveOrUpdateCart($data);

        return $this->response->setJSON($response);
    }

    public function update_quantity()
    {
        $action = $this->request->getPost("action");
        $cart_id = $this->request->getPost("cart_id");

        $this->updateCartQuantity($action, $cart_id);

        return redirect()->to("cart");
    }

    public function delete($id)
    {
        $this->cartModel->delete($id);
        return redirect()->to("cart");
    }

    protected function getCartData($sessionUserId)
    {
        return $this->cartModel
            ->select("product.name, product.price, first_product_image.url as product_image_url, shopping_cart.size, shopping_cart.quantity, shopping_cart.cart_id")
            ->where("customer_id", $sessionUserId)
            ->join("product", "product.product_id = shopping_cart.product_id")
            ->join("(SELECT product_id, MIN(url) AS url FROM product_image GROUP BY product_id) AS first_product_image", "product.product_id = first_product_image.product_id")
            ->orderBy("product.name")
            ->asObject()
            ->findAll();
    }

    protected function getHeaderData()
    {
        return [
            "title" => "Seu Carrinho - " . PAGE_TITLE,
            "config" => (new ConfigModel)->asObject()->first() ?? null,
        ];
    }

    protected function getCategoriesData()
    {
        return [
            "categories" => (new CategoryModel)->select("name")->orderBy("name")->asObject()->findAll()
        ];
    }

    protected function calculateTotalCartPrice($cartData)
    {
        $totalCartPrice = 0;
        foreach ($cartData as $cartItem) {
            $totalCartPrice += intval($cartItem->quantity) * doubleval($cartItem->price);
        }
        return $totalCartPrice;
    }

    protected function saveOrUpdateCart($data)
    {
        $response = [];
        $cart = $this->cartModel->where("product_id", $data["product_id"])->where("size", $data["size"])->asObject()->first();


        try {
            if ($cart) {
                $currentCartQuantity = intval($cart->quantity);
                $productStockQuantity = intval($this->productStockModel
                    ->select("quantity")
                    ->where("size", $cart->size)
                    ->where("product_id", $cart->product_id)
                    ->first()->quantity);

                if ($currentCartQuantity == $productStockQuantity) {
                    $response = [
                        "status" => "success",
                        "message" => "Produto sem estoque!"
                    ];
                } else {
                    $newQuantity = intval($cart->quantity) + intval($data["quantity"]);
                    $this->cartModel->update($cart->cart_id, ["quantity" => $newQuantity]);
                    $response = [
                        "status" => "success",
                        "message" => "Carrinho atualizado com sucesso!"
                    ];
                }
            } else {
                $this->cartModel->insert($data);
                $response = [
                    "status" => "success",
                    "message" => "Produto adicionado ao carrinho com sucesso!"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Erro ao adicionar produto ao carrinho: " . $e->getMessage()
            ];
        }

        return $response;
    }

    protected function updateCartQuantity($action, $cart_id)
    {
        $selectedCart = $this->cartModel->find($cart_id);

        if (!$selectedCart) {
            return redirect()->to("cart");
        }

        $currentCartQuantity = intval($selectedCart->quantity);
        $productStockQuantity = intval($this->productStockModel
            ->select("quantity")
            ->where("size", $selectedCart->size)
            ->where("product_id", $selectedCart->product_id)
            ->first()->quantity);

        $newQuantity = ($action == "increase") ? $currentCartQuantity + 1 : $currentCartQuantity - 1;

        if ($productStockQuantity >= $newQuantity) {
            if ($newQuantity == 0) {
                $this->cartModel->delete($cart_id);
            } else {
                $this->cartModel->update($cart_id, ["quantity" => $newQuantity]);
            }
        }
    }
}
