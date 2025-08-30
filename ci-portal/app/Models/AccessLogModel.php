<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessLogModel extends Model
{
    protected $table            = 'access_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'email', 'action', 'target_type', 'target_id', 'status', 'ip_address', 'user_agent', 'metadata', 'created_at'
    ];

    protected $useTimestamps = false;
}

