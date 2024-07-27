<form action="{{route('order.index')}}">
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
            $order_status=request('order_status') ?: old('order_status');
            @endphp
                <select name="order_status" aria-controls="dataTable" class="form-control form-control-m setupSelect2">
                    @foreach(config('apps.general.order_status') as $key => $val)
                    <option {{($order_status==$key)? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
                    @endforeach
                </select>                        
         </div>
        <div class="p-2">
            <div class="input-group">
                <input 
                        name="keyword"
                        type="text" 
                        class="form-control form-control-m" 
                        value="{{request('keyword') ?: old('keyword')}}"
                        placeholder="Nhập mã đơn hàng"
                >
                <span class="input-group-btn">
                    <button name="search" class="btn btn-success mb0 btn-m" type="submit"> Tìm kiếm</button>
                </span>
            </div>                               
        </div>
        <div class="p-2">
            <span class="input-group-btn">
                <a href="{{route('order.index')}}" class="btn btn-primary mb0 btn-m">Refresh<span class="fas fa-sync-alt"></span></a>
            </span>    
        </div>
      </div>
</form>