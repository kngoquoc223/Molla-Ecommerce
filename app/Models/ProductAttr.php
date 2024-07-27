<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttr extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_attr';
    protected $fillable=[
        'product_id',
        'attr_value_id',
        'quantity',
    ];
    
}
