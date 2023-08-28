<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryEvent extends Model
{
    use HasFactory;

    protected $table = 'category-event';
    protected $primaryKey = 'id_category-event';

    protected $fillable =['id_category','id_event'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }
    

}