<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marque extends Model
{
    use HasFactory;

    protected $table = 'marques';
    protected $primaryKey = 'id_marque';
    protected $guarded = ['created_at', 'updated_at'];
}
