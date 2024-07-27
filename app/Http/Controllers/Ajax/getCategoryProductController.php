<?php

namespace App\Http\Controllers\Ajax;
use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CategoryProductRepositoryInterface as CategoryProductRepository;


class getCategoryProductController extends Controller
{
    protected $categoryProductRepository;

    public function __construct(
        CategoryProductRepository $categoryProductRepository,

    ){
        $this->categoryProductRepository=$categoryProductRepository;

    }
    public function getCategory(Request $request){
       $get=$request->input();
       $html='';
       if($get['target'] == 'categories' && $get['data']['parent_id'] != 0){
        $categories=$this->categoryProductRepository->findChildCategory($get['data']['parent_id']);
        $html=$this->renderHtml($categories);
       }
        $reponse = [
                'html' => $html
        ];
        return response()->json($reponse);
        }
        
        public function renderHtml($categories, $root='--[Chọn Danh Mục Sản Phẩm]--'){
        $html='<option value="0">'.$root.'</option>';
        foreach($categories as $category){
            $html .= '<option value="'.$category->id.'">'.$category->name.'</option>';
        }
        return $html;
        }
}
