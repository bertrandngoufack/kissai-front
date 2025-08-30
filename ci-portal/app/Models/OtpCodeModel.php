<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpCodeModel extends Model
{
    protected $table            = 'otp_codes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'email', 'code_hash', 'target_type', 'application_id', 'expires_at', 'used_at', 'ip_address', 'user_agent', 'created_at'
    ];

    protected $useTimestamps = false;
}

