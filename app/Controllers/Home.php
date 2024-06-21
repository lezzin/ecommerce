<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ConfigModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    protected $categoryModel;
    protected $productModel;
    protected $configModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->configModel = new ConfigModel();
    }

    public function index(): string
    {
        $categories = $this->getCategories();
        $products = $this->getFeaturedProducts(4);
        $config = $this->getConfig();

        $headerData =  [
            "title" => "Início - " . PAGE_TITLE,
            "config" => $config
        ];

        $categoriesData = [
            "categories" => $categories
        ];

        $homeData = [
            "products"    => $products,
            "categories"  => $categories,
            "banner_url"  => $config ? $config->banner_url : null
        ];

        return view('templates/header', $headerData)
            .  view('templates/categories', $categoriesData)
            .  view('home/home', $homeData)
            .  view('templates/footer', $categoriesData);
    }

    public function politica_privacidade()
    {
        $categories = $this->getCategories();
        $headerData =  [
            "title" => "Política de Privacidade - " . PAGE_TITLE,
            "config" => null
        ];

        return view('templates/header', $headerData)
            .  view("home/politica_privacidade")
            .  view('templates/footer', ["categories" => $categories]);
    }

    protected function getCategories()
    {
        return $this->categoryModel
            ->select("category.name, category.image")
            ->join('product', 'product.category_id = category.category_id')
            ->join('product_stock', 'product_stock.product_id = product.product_id')
            ->where('product_stock.quantity >', 0)
            ->orderBy("category.name")
            ->groupBy("category.category_id")
            ->asObject()
            ->findAll();
    }

    protected function getFeaturedProducts($limit)
    {
        return $this->productModel
            ->select('product.name, product.price, product_image.url AS image, category.name AS category')
            ->join('product_image', 'product_image.product_id = product.product_id')
            ->join('category', 'category.category_id = product.category_id')
            ->join('product_stock', 'product_stock.product_id = product.product_id')
            ->where('product_stock.quantity >', 0)
            ->groupBy('product.product_id')
            // ->orderBy("product.created_at")
            ->asObject()
            ->findAll($limit);
    }

    protected function getConfig()
    {
        return $this->configModel->asObject()->first() ?? null;
    }

    public function set_redirect()
    {
        $session_redirect = urldecode($this->request->getVar("session_redirect"));
        $redirect = urldecode($this->request->getVar("redirect"));

        session()->set("redirect", $session_redirect);
        return redirect()->to($redirect);
    }
}
