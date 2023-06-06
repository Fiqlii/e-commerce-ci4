<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenjualanModel extends Model
{
    protected $table            = 'jual';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nopjl', 'idbrg', 'hargajual', 'jmljual'];

    public function insert_data_jual($data)
    {
        $this->db->table($this->table)->insertBatch($data);
    }

    public function insertData($data)
    {
        // $sql = "INSERT INTO detailjual (idtrans, idkemeja, jmljual, hargajual) VALUES (?, ?, ?, ?)";
        // $this->db->query($sql, $data);

        $this->db->table($this->table)->insert($data);
    }
}