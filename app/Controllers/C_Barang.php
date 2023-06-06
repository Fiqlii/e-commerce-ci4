<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class C_Barang extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\Barang();
    }

    public function index()
    {
        return $this->render('barang/index', [
            'title' => 'Barang',
            'barang' => $this->model->getAllBarang()
        ]);
    }

    public function show()
    {
        return $this->render('barang/create', [
            'title' => 'Tambah Barang'
        ]);
    }

    public function create()
    {

        $nama_barang = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $stok = $this->request->getPost('stok');
        $berat = floatval($this->request->getPost('berat'));
        $gambar = $this->request->getFile('namafilesprarepart');


        $fileName = $gambar->getRandomName();

        $gambar->move(ROOTPATH . 'public/gambar', $fileName);


        $this->model->insert([
            'nama' => $nama_barang,
            'stok' => $stok,
            'harga' => $harga,
            'namafilesparepart' => $fileName,
            'beratdlmgram' => $berat
        ]);

        return redirect()->to(base_url('admin/barang'));
    }

    public function getBarang()
    {
        $uri = service('uri');
        $id = $uri->getSegment(3);

        try {
            $barang = $this->model->getBarang($id);

            if ($barang) {
                return response()->setJSON($barang);
            } else {
                return response()->setJSON([
                    'status' => 404,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->setJSON([
                'status' => 500,
                'message' => 'Terjadi kesalahan'
            ]);
        }
    }

    public function tampil($id)
    {
        $model_transaksi_penjualan = new \App\Models\Transaksipjl();

        $data = [
            'title' => 'Checkout Success',
            'data_transaksi' => $model_transaksi_penjualan->getTransaksiPenjualan($id),
        ];
        return view('v_success', $data);
    }
}
