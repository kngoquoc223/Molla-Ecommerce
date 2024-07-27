<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang chủ</a></li>
                <li style="font-family: Be VietNam" class="breadcrumb-item active" aria-current="page">500</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="error-content text-center" style="background-image: url(/frontend/assets/images/backgrounds/error-bg.jpg)">
        <div class="container">
            <h1 class="error-title" style="font-family: Be VietNam">500</h1><!-- End .error-title -->
            <p style="font-family: Be VietNam">Lỗi máy chủ.Vui lòng thử lại</p>
            <a href="{{route('home.index')}}" class="btn btn-outline-primary-2 btn-minwidth-lg">
                <i class="icon-long-arrow-left"></i>
                <span style="font-family: Be VietNam">Trở về trang chủ</span>
            </a>
        </div><!-- End .container -->
    </div><!-- End .error-content text-center -->
</main><!-- End .main -->