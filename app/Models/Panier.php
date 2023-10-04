<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'paniers';
    protected $primaryKey = 'id_panier';
    protected $guarded = ['created_at', 'updated_at'];
}
