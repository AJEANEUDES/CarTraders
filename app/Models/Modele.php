<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    use HasFactory;

    protected $table = 'modeles';
    protected $primaryKey = 'id_modele';
    protected $guarded = ['created_at', 'updated_at'];

    public function marques()
    {
        return $this->belongsTo(Marque::class, 'marque_id');
    }
}
