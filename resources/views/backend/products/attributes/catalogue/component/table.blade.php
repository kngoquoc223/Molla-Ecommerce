<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tên</th>   
            <th  class="text-center">Tình trạng</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($attributes) && is_object($attributes) )
        @foreach ($attributes as $attribute)
        <tr >
            <td>
            <input type="checkbox" value="{{$attribute->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">
                {{$attribute->name}}
            </td>
            <td class="text-center js-switch-{{$attribute->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="Attribute" 
                type="checkbox" value="{{$attribute->publish}}" {{($attribute->publish==2) ? 'checked' :''}} 
                data-modelId="{{$attribute->id}}">
            </td>
            <td class="text-center">
                <a href="{{route('attribute.catalogue.edit', $attribute->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <a href="{{route('attribute.catalogue.delete', $attribute->id)}}" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
    {{$attributes->links('pagination::bootstrap-4')}}
