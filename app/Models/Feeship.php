<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;

class Feeship extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'feeships';
    protected $fillable=[
        'province_id',
        'district_id',
        'ward_id',
        'cost',
        'updated_at',
    ];
    public function province(){
        return $this->belongsTo(Province::class,'province_id','code');
    }
    public function district(){
        return $this->belongsTo(District::class,'district_id','code');
    }
    public function ward(){
        return $this->belongsTo(Ward::class,'ward_id','code');
    }
}
