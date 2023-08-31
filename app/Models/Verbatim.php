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

    public function votes()
    {
        return $this->hasMany(UserVote::class, 'verbatim_id');
    }

    public function userVote($userId)
    {
        return $this->votes()->where('user_id', $userId)->first();
    }
}
