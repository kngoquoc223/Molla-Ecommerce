<main class="main">
    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 style="font-family: Be VietNam" class="page-title">Danh mục sản phẩm<span>{{(isset($categoryProducts->parent)?$categoryProducts->parent->name.' - ':'')}}{{(isset($categoryProducts)?$categoryProducts->name:'')}}</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang Chủ</a></li>
                @if(@isset($categoryProducts->parent))
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{isset($categoryProducts->parent)?route('home.category.index',$categoryProducts->parent->slug):'#'}}">{{(isset($categoryProducts->parent)?$categoryProducts->parent->name:'')}}</a></li>
                @endif
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{isset($categoryProducts)?route('home.category.index',$categoryProducts->slug):'#'}}">{{(isset($categoryProducts)?$categoryProducts->name:'')}}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    {{-- <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{isset($categoryProducts)?route('home.category.index',$categoryProducts->slug):'#'}}">{{(isset($categoryProducts)?$categoryProducts->name:'')}}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav --> --}}
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                
                            </div><!-- End .toolbox-info -->
                        </div>
                        <div class="toolbox-right">
                            <div class="toolbox-sort">
                                <label>Sắp xếp theo:</label>
                                <div class="select-custom">
                                    <select name="order_by" class="form-control order_by">
                                        <option value="price_max">Giá: Tăng dần</option>
                                        <option value="price_min">Giá: Giảm dần</option>
                                        <option value="asc" >Tên: A-Z</option>
                                        <option value="desc" >Tên: Z-A</option>
                                        <option selected value="new" >Mới nhất</option>
                                        <option value="old" >Cũ nhất</option>
                                    </select>
                                </div>
                            </div><!-- End .toolbox-sort -->
                        </div><!-- End .toolbox-right -->
                    </div><!-- End .toolbox -->
                    <div class="products mb-3">
                            <div class="row justify-content-center" id="data-loadProduct">
                                @include('frontend.category.component.data')
                            </div><!-- End .row -->
                        {{-- <div class="load-more-container text-center more">
                            <a class="btn btn-outline-darker btn-load-more moreProduct" {{(isset($products) && count($products) >  0) ? "" : "hidden"}} >Xem Thêm<i class="icon-refresh"></i></a>
                        </div><!-- End .load-more-container --> --}}
                        {{-- <div class="load-more-container text-center auto-load" style="display: none">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                              </div>
                        </div> --}}
                    </div><!-- End .products -->
                </div>
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label style="font-family: Be VietNam">Bộ lọc sản phẩm:</label>
                            <a style="font-family: Be VietNam" href="#" class="sidebar-filter-clear">Xóa hết</a>
                        </div><!-- End .widget widget-clean -->
                        @if(!$categoryProducts->child->isEmpty())
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a style="font-family: Be VietNam" data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    Danh Mục
                                </a>
                            </h3><!-- End .widget-title -->
                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items">
                                        <script>
                                            var cat_id=[];
                                        </script>
                                            @foreach($categoryProducts->child as $v)
                                            @if($v->publish == 2)
                                            <script>
                                                cat_id.push({{$v->id}});
                                            </script>
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input value="{{$v->id}}" name="cat" type="checkbox" class="custom-control-input cat" id="cat-{{$v->id}}">
                                                    <label class="custom-control-label" for="cat-{{$v->id}}">{{$v->name}}</label>
                                                </div><!-- End .custom-checkbox -->
                                            </div><!-- End .filter-item -->
                                            @endif
                                            @endforeach
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                        @endif
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                    Giá
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-5">
                                <div class="widget-body">
                                    <div class="filter-items">
                                        <div class="filter-item">
                                            <div class="custom-control custom-radio">
                                                <input max="500000" min="0" name="price_cat" type="radio" class="custom-control-input" id="price-1">
                                                <label class="custom-control-label" for="price-1">Dưới 500.000đ</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-radio">
                                                <input max="1000000" min="500000" name="price_cat" type="radio" class="custom-control-input" id="price-2">
                                                <label class="custom-control-label" for="price-2">Từ 500.000đ - 1.000.000đ</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-radio">
                                                <input min="1000000" name="price_cat" type="radio" class="custom-control-input" id="price-3">
                                                <label class="custom-control-label" for="price-3">Từ 1.000.000đ trở lên</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->
                                        <div class="filter-item">
                                            <div class="custom-control custom-radio">
                                                <input min="0" name="price_cat" type="radio" class="custom-control-input" id="price-4">
                                                <label class="custom-control-label" for="price-4">Tất cả</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                    Size
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-2">
                                <div class="widget-body">
                                    <div style="display: flex;flex-wrap: wrap" class="filter-items">
                                        @if(isset($product_attrs) && is_object($product_attrs))
                                        @foreach ($product_attrs as $item)
                                        <div style="padding-left: 10px" class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input value="{{$item->id}}" name="size" type="checkbox" class="custom-control-input size" id="size-{{$item->id}}">
                                                <label class="custom-control-label" for="size-{{$item->id}}">{{$item->value}}</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->
                                        @endforeach
                                        @endif
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div>
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
<script type="text/javascript">
    var page=1;
    var ENDPOINT="{{route('home.category.index', $categoryProducts->slug)}}";
</script>
<script>
    if(cat_id==undefined){
        var cat_id=[];
        cat_id.push({{$categoryProducts->id}})
    }
</script>

