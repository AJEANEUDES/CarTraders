<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionnaireSociete extends Model
{
    use HasFactory;

    protected $table = 'gestionnaires_societes';
    protected $primaryKey = 'id_gestionnaire';
    protected $guarded = ['created_at', 'updated_at'];

    
}
