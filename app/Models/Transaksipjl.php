<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaksipjl extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penjualan';
    protected $primaryKey       = 'nopjl';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nopjl', 'nama', 'alamat', 'kodepostujuan', 'kota', 'ongkirtotal', 'total', 'tgl'];

    public function getTransaksiPenjualan($id_param)
    {
        $sql = "SELECT tp.nopjl, tp.tgl, tp.nama, tp.alamat, tp.kodepostujuan, tp.kota, tp.ongkirtotal, tp.total,
               j.idbrg,
               j.jmljual,
               j.hargajual,
               b.nama AS nama_barang,
               b.beratdlmgram AS berat,
               SUM(j.jmljual) AS jumlah_barang_terjual
        FROM penjualan tp
        JOIN jual j ON tp.nopjl = j.nopjl
        JOIN sparepart b ON j.idbrg = b.idbrg
        WHERE tp.nopjl = ?
        GROUP BY tp.nopjl, j.idbrg";
        $query = $this->db->query($sql, [$id_param]);
        $data = $query->getResultArray();

        return $data;
    }
}
