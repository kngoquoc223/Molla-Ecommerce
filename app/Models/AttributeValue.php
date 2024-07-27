<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attributes_values';
    protected $fillable=[
        'id_attribute',
        'value',
        'publish',
    ];
    public function attribute_catalogue(){
       return $this->belongsTo(Attribute::class,'id_attribute','id');
    }
}
