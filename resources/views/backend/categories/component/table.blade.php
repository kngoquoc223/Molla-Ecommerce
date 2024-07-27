<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center" >Tên danh mục</th>
            <th class="text-center">Slug</th>
            <th  class="text-center">Tình trạng</th>
            <th class="text-center">Update</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>

    <tbody> 

        @if(isset($categoryProducts) && is_object($categoryProducts))
        {!! \App\Helpers\Helper::menu($categoryProducts) !!}
        {{-- @foreach($categoryProducts as $key => $categoryProduct)
        @if($categoryProduct->parent_id != 0) 
        <tr>
            <td><input type="checkbox" value="{{$categoryProduct->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">{{$categoryProduct->name}}</td>
            <td class="text-center">{{$categoryProduct->slug}}</td>
            <td class="text-center">{{$categoryProduct->parent->name}}</td>
            <td class="text-center js-switch-'.$categoryProduct->id.'">
            <input type="checkbox" class="js-switch status" data-field="publish" data-model="CategoryProduct" 
            type="checkbox" value="{{$categoryProduct->publish}}"  {{(($categoryProduct->publish==2) ? 'checked' : '')}}
            data-modelId="{{$categoryProduct->id}}">
            </td>
            <td class="text-center">{{$categoryProduct->updated_at}}</td>
            <td class="text-center">
            <a href="{{route('categoryProduct.edit', $categoryProduct->id)}}"  class="btn btn-primary btn-circle"><i class="fa fa-edit"></i></a>
            <a href="{{route('categoryProduct.delete', $categoryProduct->id)}}" class="btn btn-danger btn-circle"><i class="fa fa-trash"></i></a>
                </td>
             </td>
            </tr>
        @endif
        @endforeach --}}
        @endif
    </tbody>
</table>
{{
    $categoryProducts->links('pagination::bootstrap-4')
}}
