<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 style="text-transform: uppercase;font-family: Open Sans" class="page-title">Kiểm Tra Đơn Hàng<span>Trang</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Open Sans" href="{{route('home.index')}}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a style="font-family: Open Sans" href="{{route('home.showFormCheckOrder')}}">Kiểm tra đơn hàng</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <hr class="mt-3 mb-5 mt-md-1">
            <div class="touch-container row justify-content-center">
                <div class="col-md-9 col-lg-7">
                    <div class="text-center">
                    <h2 style="font-family: Open Sans" class="title mb-1">Tra cứu tình trạng đơn hàng</h2><!-- End .title mb-2 -->
                    <p style="font-family: Open Sans" class="lead text-primary">
                        (Dành cho đơn hàng Online!).
                    </p><!-- End .lead text-primary -->
                    <p style="font-family: Open Sans" class="mb-3">Điền các thông tin bên dưới để tra cứu tình trạng đơn hàng.</p>
                    </div><!-- End .text-center -->
                    <form id="checkOrder">
                        <label style="font-family: Open Sans" for="csubject" class="sr-only">Mã đơn hàng</label>
                        <input type="text" class="form-control" id="order-code" placeholder="Nhập mã đơn hàng (từ email đã gửi khi hoàn tất thanh toán)">
                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>Kiểm Tra</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div><!-- End .text-center -->
                    </form>
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
    <div id="order" class="container">
    </div>
</main><!-- End .main -->