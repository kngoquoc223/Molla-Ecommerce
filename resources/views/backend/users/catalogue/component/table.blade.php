<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th >Tên nhóm thành viên</th>
            <th class="text-center">Số thành viên</th>
            <th>Mô tả</th>
            <th  class="text-center">Tình trạng</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($userCatalogues) && is_object($userCatalogues) )
        @foreach ($userCatalogues as $userCatalogue)
        <tr >
            <td>
            <input type="checkbox" value="{{$userCatalogue->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td>{{$userCatalogue->name}}</td>
            <td class="text-center">{{$userCatalogue->users_count}}</td>
            <td>{{$userCatalogue->description}}</td>
            <td class="text-center js-switch-{{$userCatalogue->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="UserCatalogue" 
                type="checkbox" value="{{$userCatalogue->publish}}" {{($userCatalogue->publish==2) ? 'checked' :''}} 
                data-modelId="{{$userCatalogue->id}}">
            </td>
            <td class="text-center">
                <a href="{{route('user.catalogue.edit', $userCatalogue->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <a href="{{route('user.catalogue.delete', $userCatalogue->id)}}" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $userCatalogues->links('pagination::bootstrap-4')
}}