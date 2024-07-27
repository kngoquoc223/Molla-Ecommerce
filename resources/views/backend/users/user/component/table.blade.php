<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th >Họ Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            {{-- <th>Địa chỉ</th> --}}
            <th class="text-center">Nhóm thành viên</th>
            <th  class="text-center">Tình trạng</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($users) && is_object($users) )
        @foreach ($users as $user)
        <tr>
            <td>
            <input type="checkbox" value="{{$user->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->phone}}</td>
            {{-- <td>{{$user->address}}</td> --}}
            <td class="text-center">{{$user->user_catalogues->name}}</td>
            <td class="text-center js-switch-{{$user->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="User" 
                type="checkbox" value="{{$user->publish}}" {{($user->publish==2) ? 'checked' :''}} 
                data-modelId="{{$user->id}}">
            </td>
            <td class="text-center">
                <a href="{{route('user.edit', $user->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <a href="{{route('user.delete', $user->id)}}" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
    {{$users->links('pagination::bootstrap-4')}}