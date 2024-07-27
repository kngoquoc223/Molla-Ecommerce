<form action="{{route('user.index')}}">
    <div class="d-flex">
        <div class="mr-auto p-2">
            @php 
            $perpage=request('perpage') ?: old('perpage')
            @endphp
            <select name="perpage" aria-controls="dataTable" class="custom-select custom-select-m form-control form-control-m">
                @for ($i = 20; $i <= 200; $i+=20)
                <option {{($perpage==$i)? 'selected' : ''}} value="{{$i}}">{{$i}} bản ghi </option>
                @endfor
            </select>
        </div>
        <div class="p-2">
            @php 
            $publish=request('publish') ?: old('publish');
            @endphp
                <select name="publish" aria-controls="dataTable" class="form-control form-control-m setupSelect2">
                    @foreach(config('apps.general.publish') as $key => $val)
                    <option {{($publish==$key)? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
                    @endforeach
                    </select>                        
         </div>
         <div class="p-2">
            <select name="user_catologue_id" aria-controls="dataTable" class="form-control form-control-m setupSelect2 ">
                <option value="0" selected="selected">--Chọn nhóm thành viên--</option>
                @if(@isset($userCatalogues))
                @foreach ($userCatalogues as $v)
                <option value="{{$v->id}}">{{$v->name}}</option>
                @endforeach
                @endif
            </select>
         </div>
        <div class="p-2">
            <div class="input-group">
                <input 
                        name="keyword"
                        type="text" 
                        class="form-control form-control-m" 
                        value="{{request('keyword') ?: old('keyword')}}"
                        placeholder="Nhập từ khóa tìm kiếm"
                >
                <span class="input-group-btn">
                    <button name="search" class="btn btn-success mb0 btn-m" type="submit"> Tìm kiếm</button>
                </span>
            </div>                               
        </div>
        <div class="p-2">
            <span class="input-group-btn">
                <a href="{{route('user.index')}}" class="btn btn-primary mb0 btn-m">Refresh<span class="fas fa-sync-alt"></span></a>
            </span>    
        </div>
        <div class="p-2">
            <a href="{{route('user.create')}}" class="btn btn-danger mb0 btn-m" ><i class="fa fa-plus mr3">Thêm mới thành viên</i></a>
        </div>
      </div>
</form>