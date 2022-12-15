<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $validation = \Config\Services::validation();
        $aturan = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ];

        $validation->setRules($aturan);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $model = new AuthModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $model->getUsername($username);
        if ($data['password'] != $password) {
            return $this->fail("Password tidak sesuai");
        }

        helper('jwt');
        $response = [
            'message' => 'Otentikasi berhasil dilakukan.',
            'data' => $data,
            'access_token' => createJWT($username)
        ];

        return $this->respond($response);
    }
}
