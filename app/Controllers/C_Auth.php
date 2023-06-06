<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;

class C_Auth extends BaseController
{

    protected $model_admin;

    public function __construct()
    {
        $this->model_admin = new AuthModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        return view('v_login', $data);
    }

    public function login()
    {
        $session = session();
        $model = new AuthModel();
        $idadmin = $this->request->getVar('idadmin');
        $username = $this->request->getVar('username');
        $password = md5($this->request->getVar('password'));
        $data = $model->where('idadmin', $idadmin)->first();
        $data = $model->where('username', $username)->first();
        if($data){
            $pass = $data['password'];
            // $verify_pass = password_verify($password, $pass);
            if($pass == $password){
                $ses_data = [
                    'idadmin'           => $data['idadmin'],
                    'username'      => $data['username'],
                    'password'      => $data['password'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/admin/dashboard');
            }else{
                $session->setFlashdata('msg', 'Password salah');
                return redirect()->to('/login');
            }
        }else{
            $session->setFlashdata('msg', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
