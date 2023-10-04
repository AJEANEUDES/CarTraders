<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysLog extends Model
{
    use HasFactory;

    protected $table = 'syslogs';
    protected $primaryKey = 'id_syslog';
    protected $guarded = ['created_at', 'updated_at'];
}
