<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'order_details';
    protected $fillable=[
        'product_id',
        'product_name',
        'product_price',
        'product_sales_qty',
        'order_code',
        'product_size',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
