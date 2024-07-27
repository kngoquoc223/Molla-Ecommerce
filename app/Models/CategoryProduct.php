<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'category_products';
    protected $fillable=[
        'name',
        'parent_id',
        'description',
        'slug',
        'publish',
        'banner',
        'update_at',
    ];
    public static function recursive($categories, $parents=0, $level=1, &$listCategory)
    {
        if(count($categories) > 0){
            foreach($categories as $key =>$val){
                if($val->parent_id == $parents ){
                    $val->level=$level;
                    $listCategory[]=$val;
                    unset($categories[$key]);
                    $parent=$val->id;
                    self::recursive($categories, $parent, $level+1, $listCategory);
                }
            }
        }
    }
    public function parent(){
        return $this->belongsTo(CategoryProduct::class,'parent_id');
    }
    public function child(){
        return $this->hasMany(CategoryProduct::class,'parent_id')->orderBy('order');
    }
    public function products ()
    {
        return $this->hasMany(Product::class, 'category_id','id');

    }
}
