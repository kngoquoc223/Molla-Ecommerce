<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    public function __construct(

    ){

    }
    public function changeStatus(Request $request){
        $post=$request->input();
        $serviceInterfaceNamespace='\App\Services\\'. ucfirst($post['model']).'Service';     //$post['model'] = model User
        if(class_exists($serviceInterfaceNamespace)){
            $serviceInstance=app($serviceInterfaceNamespace);
        }
       $flag =$serviceInstance->updateStatus($post);
       return response()->json(['flag'=>$flag]);
    }
    public function changeStatusAll(Request $request){
        $post=$request->input();
        $serviceInterfaceNamespace='\App\Services\\'. ucfirst($post['model']).'Service';     //$post['model'] = model User
        if(class_exists($serviceInterfaceNamespace)){
            $serviceInstance=app($serviceInterfaceNamespace);
        }
        $flag =$serviceInstance->updateStatusAll($post);
        return response()->json(['flag'=>$flag]);
    }
}
