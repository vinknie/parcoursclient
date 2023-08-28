<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUsers extends Model
{
    use HasFactory;

    protected $table = 'event-users';
    protected $primaryKey = 'id_event-users';

    protected $fillable =['id_user','id_event'];


    public function User(){
        return $this->hasMany('App\Models\User');
    }

    public function Event(){
        return $this->hasMany('App\Models\Event');
    }

}