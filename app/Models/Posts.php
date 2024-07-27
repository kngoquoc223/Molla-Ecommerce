<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Posts extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $table = 'posts';
    protected $fillable=[
        'title',
        'desc',
        'content',
        'meta_desc',
        'meta_keywords',
        'image',
        'publish',
        'user_id',
        'category_id',
        'slug',
    ];
    public function category(){
        return $this->belongsTo(CategoryPosts::class, 'category_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function comment()
    {
        return $this->hasMany(PostsComment::class,'posts_id','id');
    }
}
