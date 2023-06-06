<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiPenjualanModel extends Model
{
    protected $table            = 'penjualan';
    protected $primaryKey       = 'nopjl';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nopjl', 'nama', 'alamat', 'kodepostujuan', 'kota', 'total','ongkirtotal', 'tgl'];

    // Dates
    protected $useTimestamps = false;
}
