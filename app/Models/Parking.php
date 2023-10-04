<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parking extends Model
{
    use HasFactory;

    protected $table = 'parkings';
    protected $primaryKey = 'id_parking';
    protected $guarded = ['created_at', 'updated_at'];
}
