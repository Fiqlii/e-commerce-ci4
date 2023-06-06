<?php

namespace App\Controllers;

use App\Models\Barang;

class C_Home extends BaseController
{
    protected $model_barang;

    public function __construct()
    {
        $this->model_barang = new Barang();
    }

    public function index()
    {
        $data = [
            'title' => 'Barang',
            'barang' => $this->model_barang->getAllBarang()
        ];
        return view('v_home', $data);
    }

    public function cart()
    {
        return view('v_cart', [
            'title' => 'Cart'
        ]);
    }
}
