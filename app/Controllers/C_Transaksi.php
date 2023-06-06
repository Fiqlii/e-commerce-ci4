<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class C_Transaksi extends BaseController
{

    protected $model_barang;
    protected $model_transaksi_penjualan;
    protected $model_detail_penjualan;
    protected $model_ongkir;

    public function __construct()
    {
        $this->model_barang = new \App\Models\Barang();
        $this->model_detail_penjualan = new \App\Models\Detailjual();
        $this->model_transaksi_penjualan = new \App\Models\Transaksipjl();
        $this->model_ongkir = new \App\Models\Ongkir();
    }

    public function add_to_cart()
    {
        // Ambil data produk dari database atau sumber data lainnya
        $product_data = $this->model_barang->getBarang($this->request->getPost('idbrg'));


        // Buat array untuk disimpan ke dalam session
        $product = [
            'idbrg' => $product_data['idbrg'],
            'nama' => $product_data['nama'],
            'harga' => $product_data['harga'],
            'qty' => 1,
            'namafilesparepart' => $product_data['namafilesparepart'],
            'beratdlmgram' => $product_data['beratdlmgram'],
        ];

        // Jika session cart belum ada maka buat cart baru
        if (!session()->has('cart')) {
            session()->set('cart', []);
        }

        // Cek apakah produk sudah ada di dalam cart, jika sudah maka tambahkan qty nya saja, jika belum maka tambahkan produk baru ke cart session
        $cart = session()->get('cart');
        if (array_key_exists($product['idbrg'], $cart)) {
            $cart[$product['idbrg']]['qty'] += 1;
        } else {
            $cart[$product['idbrg']] = $product;
        }
        session()->set('cart', $cart);

        // Redirect ke halaman cart
        return redirect()->to('/cart');
    }

    public function delete_product_in_cart()
    {
        $cart = session()->get('cart');
        unset($cart[$this->request->getPost('idbrg')]);
        session()->set('cart', $cart);

        // jika cart kosong maka hapus session cart
        if (count($cart) == 0) {
            session()->remove('cart');
        }

        return redirect()->to('/cart');
    }

    public function checkout()
    {
        $data_checkout = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'kodepostujuan' => $this->request->getPost('kodepostujuan'),
            'kota' => $this->request->getPost('kota'),
            'tgl' => date('Y-m-d H:i:s'),
            'ongkirtotal' =>  $this->request->getPost('ongkirtotal'),
            'total' =>  $this->request->getPost('total'),
            'kode_post' => $this->request->getPost('kode_post'),
        ];

        $ongkir = $this->model_ongkir->getOngkir($data_checkout['kodepostujuan']);

        // cek ongkir berdasarkan kode pos
        $harga_ongkir = intval($ongkir['ongkirperkg']);

        // get data cart pada session cart
        $cart = session()->get('cart');
        $idbrg = [];
        foreach ($cart as $key => $value) {
            $idbrg[] = $key;
        }

        // get data berat_pergram product berdasarkan idkemeja kemudian dijadikan array
        $beratdlmgram = $this->model_barang->whereIn('idbrg', $idbrg)->findAll();
        $berat_gram = [];
        foreach ($beratdlmgram as $b) {
            $jumlah_berat_gram = $b['beratdlmgram'] * $cart[$b['idbrg']]['qty'];
            $berat_gram[] = $jumlah_berat_gram;
        }

        // hitung total berat dan convert dari gram ke kg array_sum($berat_gram)
        $berat_baru_kg = floatval(array_sum($berat_gram)) / 1000;
        $angka_belakang_koma = substr(strrchr($berat_baru_kg, "."), 1, 1);

        // ternary untuk pembulatan berat ongkir dalam kg
        $pembulatan_berat_ongkir_kg = $angka_belakang_koma <= 3  ? substr($berat_baru_kg, 0, 1) : substr($berat_baru_kg, 0, 1) + 1;

        // jika angka sebelum koma 0 maka ubah nilai jadi 1
        if (substr($berat_baru_kg, 0, 1) == 0) {
            $pembulatan_berat_ongkir_kg = 1;
        }

        // hitung total ongkir
        $harga_total_ongkir_berdasarkan_produk = $pembulatan_berat_ongkir_kg > 0  ? ($harga_ongkir * $pembulatan_berat_ongkir_kg)  : $harga_ongkir;
        
        $data_checkout['ongkirtotal'] += $harga_total_ongkir_berdasarkan_produk;
        $data_checkout['total'] += $harga_total_ongkir_berdasarkan_produk + $data_checkout['total'];
        // insert data transaksi_penjualan
        $transaksi = $this->model_transaksi_penjualan->insert($data_checkout);

        // insert data ke tabel jual
        $data_jual = [];
        foreach ($cart as $key => $value) {
            $data_jual[] = [
                'nopjl' => $transaksi,
                'idbrg' => $key,
                'jmljual' => $value['qty'],
                'hargajual' => $value['harga'],
            ];
        }

        $produk = $this->model_barang->whereIn('idbrg', $idbrg)->findAll();

        // update stok barang
        foreach ($produk as $p) {
            $cart_qty = $cart[$p['idbrg']]['qty'];
            $new_stock = $p['stok'] - $cart_qty;
            $this->model_barang->update($p['idbrg'], ['stok' => $new_stock]);
        }

        // insert kameja berdasakan idbrg
        $this->model_detail_penjualan->insert_data_jual($data_jual);

        session()->remove('cart');
        session()->setFlashdata('success', 'Checkout berhasil');

        $data = [
            'title' => 'Checkout Success',
            'harga_ongkir' => $harga_total_ongkir_berdasarkan_produk,
            'data_transaksi' => $this->model_transaksi_penjualan->getTransaksiPenjualan($transaksi),
            'detail_ongkir' => $ongkir

        ];

        return view('v_success', $data);
    }
}
