<?php

namespace App\Helpers;
use Illuminate\Support\Str;



class Helper
{       
        public static function menu($categoryProducts, $parent_id=0,$char='')
        {   
            $html ='' ;
            foreach($categoryProducts as $key => $categoryProduct)
            if($categoryProduct->parent_id == $parent_id){
                $html.= '
                <tr>
                <td><input type="checkbox" value="'.$categoryProduct->id.'" class="input-checkbox checkBoxItem">
                </td>
                <td >'.$char.$categoryProduct->name.'</td>
                <td class="text-center">'.$categoryProduct->slug.'</td>
                <td class="text-center '.($parent_id!=0?'js-switch-child-'.$categoryProduct->parent_id.'':'js-switch-parent-'.$categoryProduct->id.'').'">
                <input type="checkbox" class="js-switch '.($parent_id!=0?'status-child-cat':'status-cat').'" data-field="publish" data-model="CategoryProduct" 
                value="'.$categoryProduct->publish.'"  '.(($categoryProduct->publish==2) ? 'checked' : '').' 
                data-parentId="'.$categoryProduct->parent_id.'"
                data-modelId="'.$categoryProduct->id.'">
                </td>
                <td class="text-center">'.$categoryProduct->updated_at.'</td>
                <td class="text-center">
                <a href="'.route('categoryProduct.edit', $categoryProduct->id).'"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <a href="'.route('categoryProduct.delete', $categoryProduct->id).'" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </td>
                </tr>
                ';
                unset($categoryProducts[$key]);
                $html.=self::menu($categoryProducts,$categoryProduct->id,$char.'--');
            }
            return $html;
        }
        // public static function isChild($categories,$id){
        //     foreach($categories as $category){
        //         if($category->parent_id == $id){
        //             return true;
        //         }
        //     }
        //     return false;
        // }
        // public static function menus($categories,$parent_id=0){
        //     $html ='' ;
        //     foreach($categories as $key => $category){
        //         if($category->parent_id == $parent_id){
        //             $html.= '<li><a href="/collections/'.Str::slug($category->name,'-').'.html">'.$category->name;
        //             if(self::isChild($categories,$category->id)){
        //                 $html.='<i class="ti-angle-down"></i></a><ul class="dropdown">' ;
        //                 $html.= self::menus($categories,$category->id);
        //                 $html.= '</ul>';
        //             }
        //             $html.='</a></li>';
        //         }
        //     }
        //     return $html;
        // }
}