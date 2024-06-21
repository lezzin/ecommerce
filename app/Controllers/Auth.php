<?php

namespace App\Controllers;

use App\Models\UserModel;
use Exception;

class Auth extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function login()
    {
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return view("login", ["title" => "Login - " . PAGE_TITLE]);
        }

        $email = $this->request->getPost("email");
        $user = $this->model->where("email", $email)->first();

        if (!$user || !password_verify($this->request->getPost("password") ?? "", $user->password_hash)) {
            $response = [
                "status" => "error",
                "message" => "Credenciais inválidas"
            ];
            return $this->response->setJSON($response);
        }

        session()->set("user", $user);

        $redirect = session("redirect") ?? null;
        session()->remove("redirect");

        $response = [
            "status" => "redirect",
            "message" => $user->user_type == "admin" ? base_url("/admin") : ($redirect ? base_url($redirect) : base_url()),
        ];

        return $this->response->setJSON($response);
    }

    public function register()
    {
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return view("user/register", ["title" => "Registro - " . PAGE_TITLE]);
        }

        $completeAddress = "{$this->request->getPost("address")}, {$this->request->getPost("district")}, {$this->request->getPost("house_number")}";
        $data = [
            "username" => $this->request->getPost("username"),
            "password_hash" => password_hash(strval($this->request->getPost("password")), PASSWORD_BCRYPT),
            "email" => $this->request->getPost("email"),
            "full_name" => $this->request->getPost("full_name"),
            "phone_number" => $this->request->getPost("phone_number"),
            "address" => $completeAddress,
        ];

        if ($this->model->where("email", $data["email"])->first()) {
            $response = [
                "status" => "error",
                "message" => "O email inserido já está cadastrado"
            ];
            return $this->response->setJSON($response);
        }

        try {
            $this->model->insert($data);
            $response = [
                "status" => "success",
                "message" => "Cadastrado com sucesso"
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Erro ao cadastrar: " . $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to("/");
    }
}
