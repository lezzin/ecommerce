<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    private function getBaseData(string $title): array
    {
        return [
            "title" => "Administração - " . $title,
        ];
    }

    public function index(): string
    {
        $productsQuantity = (new ProductModel)->countAllResults();
        $usersQuantity = (new UserModel)->countAllResults();
        $categoriesQuantity = (new CategoryModel)->countAllResults();

        $homeData = $this->getBaseData(PAGE_TITLE);
        $homeData['products_quantity'] = $productsQuantity . ($productsQuantity != 1 ?  " produtos" : " produto");
        $homeData['users_quantity'] = $usersQuantity . ($usersQuantity != 1 ?  " usuários" : " usuário");
        $homeData['categories_quantity'] = $categoriesQuantity . ($categoriesQuantity != 1 ?  " categorias" : " categoria");

        return view('admin/home', $homeData);
    }

    public function category(): string
    {
        $homeData = $this->getBaseData(PAGE_TITLE);

        return view('admin/category', $homeData);
    }

    public function product(): string
    {
        $homeData = $this->getBaseData(PAGE_TITLE);

        return view('admin/product', $homeData);
    }

    public function customs(): string
    {
        $homeData = $this->getBaseData(PAGE_TITLE);

        return view('admin/customs', $homeData);
    }
}
