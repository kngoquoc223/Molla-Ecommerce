<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tên người vận chuyển</th>
            <th class="text-center">Địa chỉ</th>
            <th class="text-center">Số điện thoại</th>
            <th class="text-center">Ghi chú</th>
            <th class="text-center">Hình thức thanh toán</th>
            <th class="text-center">Hình thức vận chuyển</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($shipping) && is_object($shipping))
        @php
        $method_delivery='';
        if($shipping->method_delivery == 1){
            $method_delivery='Giao hàng nhanh';
        }else if($shipping->method_delivery == 2){
            $method_delivery='Giao hàng tiết kiệm';
        }else if($shipping->method_delivery == 3){
            $method_delivery='Hỏa tốc';
        }
        @endphp
        <tr >
            <td>
            <input type="checkbox" value="{{$shipping->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">{{$shipping->name}}</td>
            <td class="text-center">{{$shipping->address}} p.{{$shipping->wards->name}} Quận {{$shipping->districts->name}} Tp.{{$shipping->provinces->name}}</td>
            <td class="text-center">{{$shipping->phone}}</td>
            <td class="text-center">{{$shipping->note}}</td>
            <td class="text-center">{{($shipping->method_payment==1?'COD':'')}}</td>
            <td class="text-center">{{$method_delivery}}</td>
        </tr>
        @endif
    </tbody>
</table>