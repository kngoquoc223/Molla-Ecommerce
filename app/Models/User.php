<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use function Laravel\Prompts\password;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $table = 'users';
    protected $fillable=[
        'name',
        'email',
        'password',
        'phone',
        'address',
        'user_catalogue_id',
        'province_id',
        'district_id',
        'ward_id',
        'birthday',
        'description',
        'publish',
        'avatar',
    ];
    public function user_catalogues(){
        return $this->belongsTo(UserCatalogue::class, 'user_catalogue_id','id');
    }
    public function comment_posts()
    {
        return $this->hasMany(PostsComment::class,'user_id','id');
    }
    public function comment_product()
    {
        return $this->hasMany(Comment::class,'user_id','id');
    }
}
