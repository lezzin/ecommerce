<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfigModel;
use Exception;

class Config extends BaseController
{
    protected $configModel;

    public function __construct()
    {
        $this->configModel = new ConfigModel();
    }

    public function save()
    {
        $response = [];
        $currentConfig = $this->getCurrentConfig();
        $currentBanner = $currentConfig->banner_url;

        $message = $this->request->getPost("top_message") ?: $currentConfig->top_message;

        try {
            $banner_url = $this->updateBannerUrl($currentBanner);

            $this->configModel->save([
                "config_id"   => $currentConfig->config_id,
                "top_message" => $message,
                "banner_url"  => $banner_url,
            ]);

            $response = [
                "status"   => "success",
                "config"   => json_encode($this->configModel->asObject()->first()),
                "message"  => "Configurações atualizadas com sucesso"
            ];
        } catch (Exception $e) {
            $response = [
                "status"  => "error",
                "message" => "Erro ao atualizar configurações: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    public function get()
    {
        return $this->response->setJSON(["config" => $this->configModel->asObject()->first()]);
    }

    public function delete()
    {
        $column = $this->request->getPost("column");
        $id = $this->request->getPost("id");
        $response = [];

        try {
            $this->updateConfigColumn($id, $column);

            if ($column == "banner_url") {
                $this->deleteBannerImage($id);
            }

            $response = [
                "status"  => "success",
                "message" => "Configurações atualizadas com sucesso"
            ];
        } catch (Exception $e) {
            $response = [
                "status"  => "error",
                "message" => "Erro ao atualizar configurações: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    protected function getCurrentConfig()
    {
        return $this->configModel->asObject()->first();
    }

    protected function updateBannerUrl($currentBanner)
    {
        if ($this->request->getFiles('banner_url')) {
            if ($currentBanner) {
                unlink("public/upload/{$currentBanner}");
            }

            $bannerUrlFile = $this->request->getFiles('banner_url')["banner_url"];
            $bannerUrl = $bannerUrlFile->getRandomName();
            $bannerUrlFile->move('public/upload', $bannerUrl);
        } else {
            $bannerUrl = $currentBanner;
        }

        return $bannerUrl;
    }

    protected function updateConfigColumn($id, $column)
    {
        $this->configModel->update($id, [$column => NULL]);
    }

    protected function deleteBannerImage($id)
    {
        $currentImage = $this->configModel->find($id)->banner_url;
        if ($currentImage && file_exists("../public/upload/{$currentImage}")) {
            unlink("public/upload/{$currentImage}");
        }
    }
}
