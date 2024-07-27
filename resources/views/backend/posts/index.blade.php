@include('backend.dashboard.component.breadcrumb',['title'=> $config['seo']['index']['title']])
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{$config['seo']['index']['tableHeading']}}</h6>
            @include('backend.dashboard.component.toolbox', ['model' => 'Posts'])
        </div>
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <div id="dataTable_wrapper" class="dataTable_wrapper dt-bootstrap4">
                    @include('backend.posts.component.filter')
                    <div class="row">
                        <div class="col-sm-12">
                    @include('backend.posts.component.table')
                        </div>
                    </div>
                </div>
                </div>
        </div>
        </div>
    </div>
