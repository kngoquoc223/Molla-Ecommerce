<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PostsComment extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $table = 'posts_comments';
    protected $fillable=[
        'comment',
        'user_id',
        'user_name',
        'posts_id',
        'publish',
        'parent_id',
    ];
    public function parent(){
        return $this->belongsTo(PostsComment::class,'parent_id');
    }
    public function child(){
        return $this->hasMany(PostsComment::class,'parent_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
