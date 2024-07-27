<div class="ibox-tools">
    <a class="collapse-link" href="#collapseCardExample" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <i class="setfa fa fa-chevron-down"></i>
    </a>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-wrench"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li><a href="#" class="dropdown-item changeStatusAll" data-value="2" 
            data-field="publish" data-model="{{$model}}">Xuất bản</a>
        </li>
        <li><a href="#" class="dropdown-item changeStatusAll" data-value="1" 
            data-field="publish" data-model="{{$model}}">Bỏ xuất bản</a>
        </li>
    </ul>
</div>
<script>
      $('.collapse-link').on('click', function () {
        $('.setfa').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up')
    });
</script>