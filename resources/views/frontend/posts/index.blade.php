<main class="main">
    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{Request::segment(3)!=''?'Danh sách bài viết':'Tất cả bài viết'}}<span>{{Request::segment(3)}}</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.posts.index')}}">{{Request::segment(3)!=''?'Bài viết':'Tất cả bài viết'}}</a></li>
                @if(Request::segment(3)!='')<li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.category.posts.index',['slug' => Request::segment(3)])}}">{{Request::segment(3)}}</a></li>@endif
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    @foreach ($posts as $item)
                    <article class="entry entry-list">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <figure class="entry-media">
                                    <a href="{{route('home.posts.single.index',['slug' => $item->slug])}}">
                                        <img src="/storage/{{$item->image}}" alt="image desc">
                                    </a>
                                </figure><!-- End .entry-media -->
                            </div><!-- End .col-md-5 -->

                            <div class="col-md-7">
                                <div class="entry-body">
                                    <div class="entry-meta">
                                        <span class="entry-author">
                                            by <a style="font-family: Be VietNam" href="#" onClick="return false;">{{$item->user->name??'Người dùng đã xóa'}}</a>
                                        </span>
                                        <span class="meta-separator">|</span>
                                        <a href="#" onClick="return false;">{{$item->created_at}}</a>
                                        <span class="meta-separator">|</span>
                                        @php
                                        $count=0;
                                        foreach ($item->comment as $v) {
                                            if($v->parent_id == 0){
                                                $count++;
                                            }
                                        }
                                        @endphp
                                        <a href="#" onClick="return false;">{{$count}} Comments</a>
                                    </div><!-- End .entry-meta -->
                                    <h2 class="entry-title">
                                        <a style="font-family: Be VietNam" href="{{route('home.posts.single.index',['slug' => $item->slug])}}">{{$item->title}}</a>
                                    </h2><!-- End .entry-title -->
                                    <div class="entry-cats">
                                        in <a style="font-family: Be VietNam" href="{{route('home.category.posts.index',['slug' => $item->category->slug])}}">{{$item->category->name}}</a>,
                                    </div><!-- End .entry-cats -->
                                    <div style="font-family: Be VietNam" class="entry-content">
                                        {!!$item->desc!!}
                                        <a style="font-family: Be VietNam" href="{{route('home.posts.single.index',['slug' => $item->slug])}}" class="read-more">Chi tiết bài viết</a>
                                    </div><!-- End .entry-content -->
                                </div><!-- End .entry-body -->
                            </div><!-- End .col-md-7 -->
                        </div><!-- End .row -->
                    </article><!-- End .entry -->
                    @endforeach
                    {{
                        $posts->links('pagination::bootstrap-4')
                    }}
                </div><!-- End .col-lg-9 -->

                <aside class="col-lg-3">
                    <div class="sidebar">
                        <div class="widget widget-cats">
                            <h3 style="font-family: Be VietNam" class="widget-title">Danh mục</h3><!-- End .widget-title -->
                            <ul>
                            @foreach ($category_posts as $cat)
                            <li><a style="font-family: Be VietNam" href="{{route('home.category.posts.index',['slug' => $cat->slug])}}">{{$cat->name}}<span>{{count($cat->posts)}}</span></a></li>
                            @endforeach
                            </ul>
                        </div><!-- End .widget -->
                        <div class="widget">
                            <h3 style="font-family: Be VietNam" class="widget-title">Bài viết mới nhất</h3><!-- End .widget-title -->
                            <ul class="posts-list">
                                @foreach ($new_posts as $item)
                                <li>
                                    <figure>
                                        <a href="{{route('home.posts.single.index',['slug' => $item->slug])}}">
                                            <img src="/storage/{{$item->image}}" alt="post">
                                        </a>
                                    </figure>

                                    <div>
                                        <span>{{$item->created_at}}</span>
                                        <h4><a style="font-family: Be VietNam" href="{{route('home.posts.single.index',['slug' => $item->slug])}}">{{$item->title}}</a></h4>
                                    </div>
                                </li>
                                @endforeach
                            </ul><!-- End .posts-list -->
                        </div><!-- End .widget -->

                    </div><!-- End .sidebar -->                 
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->