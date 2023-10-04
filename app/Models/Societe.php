<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    use HasFactory;

    protected $table = 'societes';
    protected $primaryKey = 'id_societe';
    protected $guarded = ['created_at', 'updated_at'];

    public function parkings()
    {
        return $this->belongsTo(Parking::class, 'parking_id');
    }
}
