<?php

namespace App\Services;
use App\Services\Interfaces\CouponServiceInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface as CouponRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class CouponService implements CouponServiceInterface
{
    protected $couponRepository;
    public function __construct(
        CouponRepository $couponRepository,
        )
    {
        $this->couponRepository=$couponRepository;
    }
    public function updateStatus($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = (($post['value']==1)?2:1);
            $coupon=$this->couponRepository->update($post['modelId'], $payload);
         //   $this->changeUserStatus($post, $payload[$post['field']]);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function updateStatusAll($post=[]){
        DB::beginTransaction();
        try{
            $payload[$post['field']] = $post['value'];
            $flag=$this->couponRepository->updateByWhereIn('id',$post['id'],$payload);
          //  $this->changeUserStatus($post,$post['value']);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function paginate($request)
    {
        $condition['keyword']=addslashes($request->input('keyword'));
        $condition['publish']=$request->integer('publish');
        $condition['condition']=$request->integer('condition');
        $perPage=$request->integer('perpage');
        $coupons=$this->couponRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/coupon/index']
            , $perPage
        );
        return $coupons;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['coupon_number']=filter_var($payload['coupon_number'],FILTER_SANITIZE_NUMBER_INT);
            $coupon=$this->couponRepository->create($payload);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function update($id, $request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['coupon_number']=filter_var($payload['coupon_number'],FILTER_SANITIZE_NUMBER_INT);
            $coupon=$this->couponRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function delete($id){
        DB::beginTransaction();
        try{
            $coupon=$this->couponRepository->forceDelete($id);
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
                'coupon_name',
                'coupon_time',
                'publish',
                'coupon_number',
                'coupon_code',
                'coupon_condition',
            ];
    }

}
