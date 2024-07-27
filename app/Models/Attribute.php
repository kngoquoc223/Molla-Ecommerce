<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attributes';
    protected $fillable=[
        'name',
        'publish',
    ];
    public function attrs_values(){
       return $this->hasMany(AttributeValue::class,'id_attribute','id');
    }
}
