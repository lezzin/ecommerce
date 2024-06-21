<?php

namespace App\Controllers;

use App\Models\ProductStockModel;
use Exception;

class ProductStock extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductStockModel();
    }

    public function save()
    {
        $response = [];

        $data = [
            'product_id'  => $this->request->getPost("product_id"),
            'size'        => $this->request->getPost("size"),
            'quantity'    => $this->request->getPost("quantity"),
        ];

        try {
            $existingStock = $this->verifyIfSizeExists($data["product_id"], $data['size']);

            if ($existingStock) {
                $id = $existingStock->product_stock_id;
                $data["quantity"] = intval($existingStock->quantity)  + intval($data["quantity"]);
                $this->model->update($id, $data);
                $response = [
                    "status"  => "success",
                    "message" => "Estoque atualizado com sucesso!"
                ];
            } else {
                if ($this->model->insert($data)) {
                    $response = [
                        "status"  => "success",
                        "message" => "Estoque cadastrado com sucesso!"
                    ];
                }
            }
        } catch (Exception $e) {
            $response = [
                "status"  => "error",
                "message" => "Erro ao salvar estoque: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    public function verifyIfSizeExists($productId, $size)
    {
        return $this->model->where("product_id", $productId)->where("size", $size)->first();
    }

    public function getByProduct($productId)
    {
        $productStocks = $this->model
            ->select("product_stock_id, size, quantity")
            ->where("product_id", $productId)
            ->findAll();

        return $this->response->setJSON($productStocks);
    }

    public function delete($id)
    {
        $response = [];

        try {
            $this->model->delete($id);
            $response = [
                "status" => "success",
                "message" => "Estoque deletado com sucesso!"
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Erro ao deletar estoque: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    public function all($id)
    {
        $stock = $this->model
            ->asObject()
            ->where("product_id", $id)
            ->findAll();

        return $this->response->setJSON($stock);
    }

    public function get_last()
    {
        $stock = $this->model->asObject()->orderBy("product_stock_id", "DESC")->first();
        return $this->response->setJSON($stock);
    }
}
