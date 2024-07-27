<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'comments';
    protected $fillable=[
        'comment',
        'user_id',
        'user_name',
        'product_id',
        'publish',
        'parent_id',
        'rating',
    ];
    public function parent(){
        return $this->belongsTo(Comment::class,'parent_id');
    }
    public function child(){
        return $this->hasMany(Comment::class,'parent_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
}
