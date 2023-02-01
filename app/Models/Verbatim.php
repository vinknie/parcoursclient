<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verbatim extends Model
{
    use HasFactory;

    protected $table = 'verbatim';
    protected $primaryKey = 'id_verbatim';

    protected $fillable =['id_category','verbatim','positif','neutre','negatif'];
}
