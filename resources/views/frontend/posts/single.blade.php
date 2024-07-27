<main class="main">
    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 style="font-family: Be VietNam" class="page-title">Bài viết<span>{{$posts->title}}</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.category.posts.index',['slug' => $posts->category->slug])}}">{{$posts->category->name}}</a></li>
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.posts.single.index',['slug' => $posts->slug])}}">{{$posts->slug}}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="mx-auto col-lg-8">
                    <article class="entry single-entry">
                        <figure class="entry-media">
                            <img src="/storage/{{$posts->image}}" alt="image desc">
                        </figure><!-- End .entry-media -->
                        <div class="entry-body">
                            <div class="entry-meta">
                                <span class="entry-author">
                                    by <a style="font-family: Be VietNam" href="#">{{$posts->user->name ?? 'Người dùng đã xóa'}}</a>
                                </span>
                                <span class="meta-separator">|</span>
                                <a href="#" onClick="return false;">{{$posts->created_at}}</a>
                                <span class="meta-separator">|</span>
                                <a href="#" onClick="return false;">{{count($comments)}} Bình luận</a>
                            </div><!-- End .entry-meta -->

                            <h2 style="font-family: Be VietNam" class="entry-title">
                                {{$posts->title}}
                            </h2><!-- End .entry-title -->
                            <div class="entry-cats">
                                in <a style="font-family: Be VietNam" href="#">{{$posts->category->name}}</a>,
                            </div><!-- End .entry-cats -->

                            <div class="entry-content editor-content">
                                {!!$posts->content!!}
                            </div><!-- End .entry-content -->

                            <div class="entry-footer row no-gutters flex-column flex-md-row">
                                <div class="col-md-auto mt-2 mt-md-0">
                                    <div class="social-icons social-icons-color">
                                        <span class="social-label">Share this post:</span>
                                        <a href="#" onClick="return false;" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                        <a href="#" onClick="return false;" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                        <a href="#" onClick="return false;" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                        <a href="#" onClick="return false;" class="social-icon social-linkedin" title="Linkedin" target="_blank"><i class="icon-linkedin"></i></a>
                                    </div><!-- End .soial-icons -->
                                </div><!-- End .col-auto -->
                            </div><!-- End .entry-footer row no-gutters -->
                        </div><!-- End .entry-body -->

                        <div class="entry-author-details">
                            <figure class="author-media">
                                <a href="#" onClick="return false;">
                                    <img src="/storage/{{$posts->user->image??''}}" alt="User name">
                                </a>
                            </figure><!-- End .author-media -->

                            <div class="author-body">
                                <div class="author-header row no-gutters flex-column flex-md-row">
                                    <div class="col">
                                        <h4><a style="font-family: Be VietNam" href="#" onClick="return false;">{{$posts->user->name??'Người dùng đã xóa'}}</a></h4>
                                    </div><!-- End .col -->
                                </div><!-- End .row -->

                                <div class="author-content">
                                    <p style="font-family: Be VietNam">{!!$posts->desc!!} </p>
                                </div><!-- End .author-content -->
                            </div><!-- End .author-body -->
                        </div><!-- End .entry-author-details-->
                    </article><!-- End .entry -->
                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="related-posts">
                        <h3 style="font-family: Be Vietnam; text-transform: uppercase" class="title">Các bài viết khác</h3><!-- End .title -->
                        <div class="owl-carousel owl-simple" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":1
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    }
                                }
                            }'>
                            @foreach ($posts->category->posts as $item)
                            <article class="entry entry-grid">
                                <figure class="entry-media">
                                    <a href="{{route('home.posts.single.index',['slug' => $item->slug])}}">
                                        <img src="/storage/{{$item->image}}" alt="image desc">
                                    </a>
                                </figure><!-- End .entry-media -->

                                <div class="entry-body">
                                    <div class="entry-meta">
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
                                        <a style="font-family: Be VietNam" href="#" onClick="return false;">{{$count}} Bình luận</a>
                                    </div><!-- End .entry-meta -->

                                    <h2 class="entry-title">
                                        <a style="font-family: Be VietNam" href="{{route('home.posts.single.index',['slug' => $item->slug])}}">{{$item->title}}.</a>
                                    </h2><!-- End .entry-title -->

                                    <div class="entry-cats">
                                        in <a style="font-family: Be VietNam" href="{{route('home.category.posts.index',['slug' => $item->category->slug])}}">{{$item->category->name}}</a>,
                                    </div><!-- End .entry-cats -->
                                </div><!-- End .entry-body -->
                            </article><!-- End .entry -->
                            @endforeach
                        </div><!-- End .owl-carousel -->
                    </div><!-- End .related-posts -->
                    <div class="comments">
                        <h3 style="font-family: Open Sans" class="title">{{count($comments)}} Bình luận</h3><!-- End .title -->
                        <ul>
                            @foreach ($comments as $key => $item)
                            <li>
                                <div class="comment">
                                    <figure class="comment-media">
                                        <div class="col-auto">
                                            <a href="#" onClick="return false;">
                                                <img src="/storage/{{$item->user->avatar}}">
                                            </a>
                                            @if(Session::get('customer')!=null)
                                            @if(Session::get('customer')->user_catalogue_id==1)<a data-key="{{$item->id}}" href="#" onClick="return false;" class="remove-comment"><i class="icon-close"></i></a>@endif
                                            @endif
                                        </div>
                                    </figure>
                                    <div class="comment-body">
                                        <div style="padding-left: 50px" class="col">
                                            <a style="font-family: Open Sans" href="#" onClick="return false;" data-key="{{$item->id}}" class="comment-reply">Trả lời</a>
                                            <div class="comment-user">
                                                <h4><a style="font-family: Be VietNam" href="#" onClick="return false;">{{$item->user->name}}</a></h4>
                                                <span class="comment-date">{{$item->created_at}}</span>
                                            </div><!-- End .comment-user -->
                                            <div class="comment-content">
                                                <p style="font-family: Be VietNam">{{$item->comment}}</p>
                                            </div><!-- End .comment-content -->
                                        </div>
                                    </div><!-- End .comment-body -->
                                </div><!-- End .comment -->
                                {{-- @php
                                print_r($item->child);
                                @endphp --}}
                                @foreach ($item->child as $v)
                                <ul>
                                    <li>
                                        <div class="comment">
                                            <figure class="comment-media">
                                                <a href="#" onClick="return false;">
                                                    <img src="/storage/{{$v->user->avatar}}">
                                                </a>
                                                @if(Session::get('customer')!=null)
                                                @if(Session::get('customer')->user_catalogue_id==1)<a data-key="{{$v->id}}" href="#" onClick="return false;" class="remove-comment"><i class="icon-close"></i></a>@endif
                                                @endif
                                            </figure>
                                            <div class="comment-body">
                                                <a style="font-family: Open Sans" href="#" onClick="return false;" data-key="{{$item->id}}" class="comment-reply">Trả lời</a>
                                                <div class="comment-user">
                                                    <h4><a style="font-family: Be VietNam" href="#" onClick="return false;">{{$v->user->name}}</a></h4>
                                                    <span class="comment-date">{{$v->created_at}}</span>
                                                </div><!-- End .comment-user -->
                                                <div class="comment-content">
                                                    <p style="font-family: Be VietNam">{{$v->comment}}</p>
                                                </div><!-- End .comment-content -->
                                            </div><!-- End .comment-body -->
                                        </div><!-- End .comment -->
                                    </li>
                                </ul>
                                @endforeach
                                <ul class="comment-reply-key" id="comment-reply-{{$item->id}}" style="display: none">
                                    <li>
                                        <div class="reply">
                                            <form>
                                                <textarea name="comment" id="reply-comment-{{$item->id}}" cols="30" rows="4" class="form-control" placeholder="Viết bình luận *"></textarea>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input value="{{Session::get('customer')->name??''}}" readonly type="text" class="form-control" id="reply-name-{{$item->id}}" name="reply_user_name_{{$item->id}}" placeholder="Tên *">
                                                    </div><!-- End .col-md-6 -->
                                                    <input type="hidden" name="reply_posts_id_{{$item->id}}" value="{{$posts->id}}">
                                                    <input type="hidden" name="reply_user_id_{{$item->id}}" value="{{Session::get('customer')->id??''}}">
                                                    <div class="col-md-6">
                                                        <label style="font-family: Be VietNam" class="sr-only">Email</label>
                                                        <input value="{{Session::get('customer')->email??''}}" readonly type="text" class="form-control" id="reply-email-{{$item->id}}" name="reply_user_email_{{$item->id}}" placeholder="Email *">
                                                    </div><!-- End .col-md-6 -->
                                                </div><!-- End .row -->
                                                <button data-key="{{$item->id}}" type="button" class="btn btn-outline-primary-2 reply-comment">
                                                    <span>Gửi</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>
                                            </form>
                                        </div><!-- End .reply -->
                                    </li>
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div><!-- End .comments -->
                    <div class="reply">
                        <div class="heading">
                            <h3 style="font-family: Open Sans" class="title">Bình luận</h3><!-- End .title -->
                            <p style="font-family: Be VietNam;font-size: 1.5rem" class="title-desc">Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được đánh dấu <span class="text-danger">(*)</span></p>
                        </div><!-- End .heading -->
                        <form id="posts_comment">
                            <textarea name="comment" id="comment-comment" cols="30" rows="4" class="form-control" placeholder="Viết bình luận *"></textarea>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-family: Be VietNam" class="sr-only">Tên</label>
                                    <input value="{{Session::get('customer')->name??''}}" readonly type="text" class="form-control" id="comment-name" name="user_name" placeholder="Tên *">
                                </div><!-- End .col-md-6 -->
                                <input type="hidden" name="posts_id" value="{{$posts->id}}">
                                <input type="hidden" name="user_id" value="{{Session::get('customer')->id??''}}">
                                <div class="col-md-6">
                                    <label style="font-family: Be VietNam" class="sr-only">Email</label>
                                    <input value="{{Session::get('customer')->email??''}}" readonly type="text" class="form-control" id="comment-email" name="user_email" placeholder="Email *">
                                </div><!-- End .col-md-6 -->
                            </div><!-- End .row -->
                              <div class="row">
                                <button type="submit" class="btn btn-outline-primary-2">
                                    <span>Gửi</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>
                              </div>
                        </form>
                    </div><!-- End .reply -->
                </div>
            </div>
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->