<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryPosts extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'category_posts';
    protected $fillable=[
        'name',
        'publish',
        'slug',
    ];
    public function posts()
    {
        return $this->hasMany(Posts::class,'category_id','id');
    }
}
