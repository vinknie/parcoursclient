<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;
    protected $table = 'historiques';
    protected $primaryKey = 'id_historique';

    // protected $fillable = ['id_category', 'verbatim', 'positif', 'neutre', 'negatif'];
}
