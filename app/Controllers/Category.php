<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ConfigModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use App\Models\ProductStockModel;
use Exception;

class Category extends BaseController
{
    protected $categoryModel;
    protected $productModel;
    protected $productImageModel;
    protected $productStockModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->productImageModel = new ProductImageModel();
        $this->productStockModel = new ProductStockModel();
    }

    public function category($name)
    {
        $category = $this->getCategoryByName($name);

        if (!$category) {
            return redirect()->to('/');
        }

        $products = $this->getProductsByCategory($category);

        $headerData = $this->getHeaderData($category->name);
        $categoriesData = $this->getCategoriesData();
        $homeData = [
            "products" => $products,
            "pager" => $this->productModel->pager,
            "category" => $category
        ];

        $breadcrumbData = [
            "breadcrumbLinks" => [
                ['name' => $category->name, 'active' => true]
            ]
        ];

        return view("templates/header", $headerData)
            .  view('templates/categories', $categoriesData)
            .  view("templates/breadcrumb", $breadcrumbData)
            .  view("category/home", $homeData)
            .  view('templates/footer', $categoriesData);
    }

    public function product($category_name, $product_name)
    {
        $category = $this->getCategoryByName($category_name);

        if (!$category) {
            return redirect()->to('/');
        }

        $product = $this->productModel->where("name", get_original_url($product_name))->first();

        if (!$product || $product->category_id != $category->category_id) {
            return redirect()->to("category/{$category->name}");
        }

        $product = $this->enhanceProductData($product);

        $headerData = $this->getHeaderData($product->name);
        $categoriesData = $this->getCategoriesData();
        $productData = [
            "product" => $product,
            "category" => $category
        ];

        $breadcrumbData = [
            "breadcrumbLinks" => [
                ['name' => $category->name, 'active' => false, 'url' => "category/{$category->name}"],
                ['name' => $product->name, 'active' => true]
            ]
        ];

        return view("templates/header", $headerData)
            .  view('templates/categories', $categoriesData)
            .  view("templates/breadcrumb", $breadcrumbData)
            .  view("category/product", $productData)
            .  view('templates/footer', $categoriesData);
    }

    public function save()
    {
        try {
            $id = $this->request->getPost("id") ?? null;
            $currentCategory = $this->categoryModel->find($id);
            $fileName = $this->uploadCategoryImage();

            $deletePath = "public/upload/";

            if ($fileName && $id) {
                unlink($deletePath . $currentCategory->image);
            }

            $this->categoryModel->save([
                'category_id' => $id,
                'name'        => trim($this->request->getPost("name") ?? $currentCategory->name),
                'image'       => $fileName ?? $currentCategory->image,
            ]);

            $response = [
                "status" => "success",
                "message" => "Categoria " . ($id ? "atualizada" : "salva") . " com sucesso!"
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Erro ao " . ($id ? "atualizar" : "salvar") . " categoria: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    public function get($id)
    {
        $category = $this->categoryModel->asObject()->find($id);
        return $this->response->setJSON($category);
    }

    public function delete($id)
    {
        try {
            $deletePath = "public/upload/";
            $imageToDelete = $this->categoryModel->select("image")->where("category_id", $id)->first()->image;

            if ($imageToDelete && file_exists($deletePath . $imageToDelete)) {
                unlink($deletePath . $imageToDelete);
            }

            $productsToDelete = $this->productModel->where("category_id", $id)->findAll();

            foreach ($productsToDelete as $product) {
                (new Product)->deleteProductImages($product->product_id);
            }

            $this->categoryModel->delete($id);

            $response = [
                "status" => "success",
                "message" => "Categoria deletada com sucesso!"
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Erro ao deletar categoria: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    protected function getCategoryByName($name)
    {
        return $this->categoryModel->where("name", get_original_url($name))->first();
    }

    protected function getProductsByCategory($category)
    {
        return $this->productModel
            ->select('product.name, product.price, product_image.url AS image, category.name AS category')
            ->join('category', 'category.category_id = product.category_id')
            ->join('product_image', 'product_image.product_id = product.product_id')
            ->join('product_stock', 'product_stock.product_id = product.product_id')
            ->where('product.category_id', $category->category_id)
            ->where('product_stock.quantity >', 0)
            ->groupBy('product.product_id')
            ->orderBy('product.name')
            ->paginate(20);
    }

    protected function enhanceProductData($product)
    {
        $productImages = $this->productImageModel->asObject()->select("url")->where("product_id", $product->product_id)->findAll();

        $product->primaryImage = $productImages[0] ?? null;
        array_shift($productImages);
        $product->secondaryImages = $productImages;

        $product->stocks = $this->productStockModel->select("quantity, size")->asObject()->where("product_id", $product->product_id)->findAll();

        $product->category = $this->categoryModel->select("name")->asObject()->where("category_id", $product->category_id)->first()->name;

        return $product;
    }

    protected function uploadCategoryImage()
    {
        $fileName = null;

        if ($this->request->getFile("image") && $this->request->getFile("image")->isValid()) {
            $uploadPath = 'public/upload/';

            $image = $this->request->getFile("image");
            $fileName = $image->getRandomName();

            $image->move($uploadPath, $fileName);

            $imageService = \Config\Services::image();

            try {
                $imageService->withFile($uploadPath . $fileName)->fit(480, 480, 'center')->save();
            } catch (Exception $e) {
                unlink($uploadPath . $fileName);
                throw new Exception("Erro ao redimensionar imagem: " . $e->getMessage());
            }
        }

        return $fileName;
    }

    protected function getHeaderData($title = '')
    {
        return [
            "title" => ($title ? "{$title} - " : '') . PAGE_TITLE,
            "config" => (new ConfigModel)->asObject()->first() ?? null,
        ];
    }

    protected function getCategoriesData()
    {
        return [
            "categories" => $this->categoryModel->select("name")->orderBy("name")->asObject()->findAll()
        ];
    }

    public function all()
    {
        $categories = $this->categoryModel->asObject()->findAll();
        return $this->response->setJSON($categories);
    }
}
