<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th> 
            <th class="text-center">Giá Trị</th>  
            <th class="text-center">Nhóm Thuộc Tính</th>  
            <th  class="text-center">Tình trạng</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($attributeValues) && is_object($attributeValues) )
        @foreach ($attributeValues as $attributeValue)
        <tr >
            <td>
            <input type="checkbox" value="{{$attributeValue->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">
                {{$attributeValue->value}}
            </td>
            <td class="text-center">
                {{$attributeValue->attribute_catalogue->name}}
            </td>
            <td class="text-center js-switch-{{$attributeValue->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="AttributeValue" 
                type="checkbox" value="{{$attributeValue->publish}}" {{($attributeValue->publish==2) ? 'checked' :''}} 
                data-modelId="{{$attributeValue->id}}">
            </td>
            <td class="text-center">
                <a href="{{route('attribute.edit', $attributeValue->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <a href="{{route('attribute.delete', $attributeValue->id)}}" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{$attributeValues->links('pagination::bootstrap-4')}}
    
