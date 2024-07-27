<?php

namespace App\Services;
use App\Services\Interfaces\OrderServiceInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class OrderService implements OrderServiceInterface
{
    protected $orderRepository;
    public function __construct(
        OrderRepository $orderRepository,
        )
    {
        $this->orderRepository=$orderRepository;
    }
    public function paginate($request)
    {
        $condition['keyword']=addslashes($request->input('keyword'));
        $condition['order_status']=$request->integer('order_status');
        $perPage=$request->integer('perpage');
        $orders=$this->orderRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/order/index']
            , $perPage
        );
        return $orders;
    }
    public function update($id, $request){
        DB::beginTransaction();
        try{
            $payload['status']=$request['status'];
            $order=$this->orderRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function paginateSelect(){
            return [
                'id',
                'order_code',
                'shipping_id',
                'status',
                'user_id',
                'coupon',
                'created_at',
                'updated_at',
            ];
    }

}
