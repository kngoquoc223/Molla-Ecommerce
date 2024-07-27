<?php

namespace App\Services;
use App\Services\Interfaces\FeeshipServiceInterface;
use App\Repositories\Interfaces\FeeshipRepositoryInterface as FeeshipRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * Class UserService.
 */
class FeeshipService implements FeeshipServiceInterface
{
    protected $feeshipRepository;
    public function __construct(
        FeeshipRepository $feeshipRepository,
        )
    {
        $this->feeshipRepository=$feeshipRepository;
    }
    public function paginate($request)
    {
        $condition['keyword']=addslashes($request->input('keyword'));
        $perPage=$request->integer('perpage');
        $feeships=$this->feeshipRepository->pagination(
            $this->paginateSelect(), $condition, [], ['path' => '/admin/feeship/index']
            , $perPage
        );
        return $feeships;
    }
    public function create($request){
        DB::beginTransaction();
        try{
            $payload=$request->except(['_token','send']);
            $payload['cost']=filter_var($payload['cost'],FILTER_SANITIZE_NUMBER_INT);
            $feeship=$this->feeshipRepository->create($payload);
            DB::commit();
            return $feeship;
        } catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function update($id, $request){
        DB::beginTransaction();
        try{
            $payload['cost']=$request['cost'];
            $payload['cost']=filter_var($payload['cost'],FILTER_SANITIZE_NUMBER_INT);
            $feeship=$this->feeshipRepository->update($id, $payload);
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
            $feeship=$this->feeshipRepository->forceDelete($id);
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
                'province_id',
                'district_id',
                'ward_id',
                'cost',
                'updated_at',
                'created_at'
            ];
    }

}
