<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'id_category';

    protected $fillable =['title','position'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $lastCategory = static::orderBy('position', 'desc')->first();
            $category->position = $lastCategory ? $lastCategory->position + 1 : 1;
        });
    }

    public function verbatim(){
        return $this->hasMany('App\Models\Verbatim');
    }

}
