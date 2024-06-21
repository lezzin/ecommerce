<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductImageModel;
use Exception;

class Product extends BaseController
{
    protected $productModel;
    protected $imageModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->imageModel = new ProductImageModel();
    }

    public function save()
    {
        $response = [];

        $id = $this->request->getPost("id");
        $data = [
            'category_id'  => $this->request->getPost("category"),
            'name'         => trim($this->request->getPost("name") ?? ""),
            'description'  => $this->request->getPost("description"),
            'price'        => $this->request->getPost("price"),
        ];

        try {
            if ($id) {
                $this->productModel->update($id, $data);
                $response = [
                    "status"  => "success",
                    "message" => "Produto atualizado com sucesso!"
                ];
            } else {
                if ($this->productModel->insert($data)) {
                    $id = $this->productModel->getInsertID();
                    $this->handleImagesUpload($id);
                    $response = [
                        "status"  => "success",
                        "message" => "Produto cadastrado com sucesso!"
                    ];
                }
            }
        } catch (Exception $e) {
            $response = [
                "status"  => "error",
                "message" => "Erro ao salvar produto: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    public function all()
    {
        $products = [];
        $productsWithoutImages = $this->productModel
            ->select("product.*, category.category_id AS category_id")
            ->join("category", "category.category_id = product.category_id")
            ->findAll();

        foreach ($productsWithoutImages as $product) {
            $products[] = $this->addProductImages($product);
        }

        return $this->response->setJSON($products);
    }

    public function get_last()
    {
        $productWihthoutImages = $this->productModel->asObject()->orderBy("product_id", "DESC")->first();
        $product = $this->addProductImages($productWihthoutImages);

        return $this->response->setJSON($product);
    }

    public function search($name)
    {
        $products = $this->productModel
            ->select("product.product_id, product.name, product.price, category.name AS category, product_image.url AS image")
            ->like("product.name", $name)
            ->join("product_image", "product_image.product_id = product.product_id")
            ->join("category", "category.category_id = product.category_id")
            ->join('product_stock', 'product_stock.product_id = product.product_id')
            ->where('product_stock.quantity >', 0)
            ->groupBy("product.product_id")
            ->findAll();

        return $this->response->setJSON($products);
    }

    public function delete($id)
    {
        try {
            $this->deleteProductImages($id);
            $this->productModel->delete($id);

            $response = [
                "status"  => "success",
                "message" => "Produto deletado com sucesso!"
            ];
        } catch (Exception $e) {
            $response = [
                "status"  => "error",
                "message" => "Erro ao deletar produto: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    protected function handleImagesUpload($productId)
    {
        $files = $this->request->getFiles('image')['image'] ?? null;
        $uploadPath = 'public/upload/';

        if ($files) {
            foreach ($files as $file) {
                $newName = $file->getRandomName();

                $file->move($uploadPath, $newName);
                $this->resizeImage($uploadPath . $newName, 720, 720);

                $imageData = [
                    'product_id' => $productId,
                    "url"        => $newName,
                ];

                $this->imageModel->save($imageData);
            }
        }
    }

    protected function resizeImage($path, $width, $height)
    {
        $imageService = \Config\Services::image();
        $imageService->withFile($path)->fit($width, $height, 'center')->save();
    }

    protected function addProductImages($product)
    {
        $productImages = $this->imageModel->asObject()->select("url")->where("product_id", $product->product_id)->findAll();
        $product->primaryImage = $productImages[0] ?? null;
        array_shift($productImages);
        $product->secondaryImages = $productImages;

        return $product;
    }

    public function deleteProductImages($productId)
    {
        $images = $this->imageModel->where("product_id", $productId);
        $deletePath = "public/upload/";

        if ($images->countAllResults()) {
            $imagesToDelete = $images->findAll();

            foreach ($imagesToDelete as $image) {
                $imageToDelete = $deletePath . $image->url;

                if (file_exists($imageToDelete)) {
                    unlink($imageToDelete);
                }
            }

            $this->imageModel->where("product_id", $productId)->delete();
        }
    }
}
