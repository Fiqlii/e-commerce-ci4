<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sparepart';
    protected $primaryKey       = 'idbrg';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'harga', 'stok', 'namafilesparepart', 'beratdlmgram'];

    public function getAllBarang()
    {
        $sql = "SELECT * FROM sparepart";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getBarang($id)
    {
        $sql = "SELECT * FROM sparepart WHERE idbrg = ?";
        $query = $this->db->query($sql, [$id]);
        return $query->getRowArray();
    }
}
