<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Customer implements FilterInterface
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $user = session()->get('user'); 

        if (!$user or $user->user_type != "customer") {
            return redirect()->to('/');
        }

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // This method can be used for any post-processing after the response has been sent.
        // You may leave it blank if no post-processing is required.
    }
}
