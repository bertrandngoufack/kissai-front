<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table            = 'applications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'name', 'type', 'url', 'file_name', 'file_path', 'file_size', 'file_hash', 'description', 'tags', 'is_active', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
}

