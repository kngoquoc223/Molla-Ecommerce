@include('backend.dashboard.component.breadcrumb',['title'=> $config['seo']['index']['title']])
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{$config['seo']['index']['tableHeading']}}</h6>
            <div class="ibox-tools">
                <a class="collapse-link" href="#collapseCardExample" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <i class="setfa fa fa-chevron-down"></i>
                </a>
            </div>
            <script>
                  $('.collapse-link').on('click', function () {
                    $('.setfa').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up')
                });
            </script>
        </div>
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <div id="dataTable_wrapper" class="dataTable_wrapper dt-bootstrap4">
                    @include('backend.users.catalogue.component.filter')
                    <div class="row">
                        <div class="col-sm-12">
                    @include('backend.users.catalogue.component.table')
                        </div>
                    </div>
                </div>
                </div>
        </div>
        </div>
    </div>
