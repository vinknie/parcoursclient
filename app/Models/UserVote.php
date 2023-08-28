<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVote extends Model
{
    use HasFactory;
    
    protected $table = 'user_votes';
    protected $primaryKey = 'id';
    
    protected $fillable = ['user_id','verbatim_id','vote_type'];
    
    // Relationships
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function verbatim()
    {
        return $this->belongsTo(Verbatim::class);
    }
}