<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable=[
        'name',
        'description',
        'content',
        'category_id',
        'price',
        'img',
        'publish',
        'discount',
        'thumb',
        'parent_category_id',
        'quantity',
    ];
    public function category_products(){
        return $this->belongsTo(CategoryProduct::class, 'category_id','id');
    }
    public function parentCategory_products(){
        return $this->belongsTo(CategoryProduct::class, 'parent_category_id','id');
    }
    public function attr()
    {
       return $this->belongsToMany(AttributeValue::class,'product_attr','product_id','attr_value_id')->withPivot('quantity')->orderBy('attr_value_id');
    }
    public function images() 
    {          
     return $this->hasMany(ProductImage::class, 'product_id', 'id');       
    }
    public function comment()
    {
        return $this->hasMany(Comment::class,'product_id','id');
    }
}
