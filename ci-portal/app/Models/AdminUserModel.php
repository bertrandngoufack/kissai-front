<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table            = 'admin_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'email', 'password_hash', 'name', 'is_active', 'last_login_at', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
}

