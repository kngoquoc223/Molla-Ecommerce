<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Feeship;

class Shipping extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'shippings';
    protected $fillable=[
        'name',
        'email',
        'phone',
        'address',
        'note',
        'method_payment',
        'method_delivery',
        'ward_id',
        'province_id',
        'district_id',
    ];
    public function provinces(){
        return $this->belongsTo(Province::class, 'province_id','code');
    }
    public function districts(){
        return $this->belongsTo(District::class, 'district_id','code');
    }
    public function wards(){
        return $this->belongsTo(Ward::class, 'ward_id','code');
    }
    public function getCost($province_id,$district_id,$ward_id){
        return Feeship::where('province_id',$province_id)->where('district_id',$district_id)->where('ward_id',$ward_id)->first('cost');
    }
}
