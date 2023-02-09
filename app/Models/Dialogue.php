<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialogue extends Model
{
    use HasFactory;

    protected $table = 'dialogue';
    protected $primaryKey = 'id_dialogue';

    protected $fillable =['id_category','id_verbatim','dialogue','positif','neutre','negatif'];
}
