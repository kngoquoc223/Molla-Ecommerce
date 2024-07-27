<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    </nav><!-- End .breadcrumb-nav -->
    <div class="container">
        <div class="page-header page-header-big text-center" style="background-image: url('/frontend/assets/images/contact-header-bg.jpg')">
            <h1 style="font-family: Open Sans" class="page-title text-white">Liên Hệ</h1>
        </div><!-- End .page-header -->
    </div><!-- End .container -->

    <div class="page-content pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-2 mb-lg-0">
                    <h2 style="font-family: Open Sans" class="title mb-1">Thông tin liên hệ</h2><!-- End .title mb-2 -->
                    <br>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="contact-info">
                                <ul class="contact-list">
                                    <li>
                                        <i class="icon-map-marker"></i>
                                        22 Lý Chiêu Hoàng, Phường 10, Quận 6, TP HCM
                                    </li>
                                    <li>
                                        <i class="icon-phone"></i>
                                        <a href="#" onClick="return false;">076 4211 220</a>
                                    </li>
                                    <li>
                                        <i class="icon-envelope"></i>
                                        <a href="#" onClick="return false;">kngoquoc223@gmail.com</a>
                                    </li>
                                </ul><!-- End .contact-list -->
                            </div><!-- End .contact-info -->
                        </div><!-- End .col-sm-7 -->
                    </div><!-- End .row -->
                </div><!-- End .col-lg-6 -->
                <div class="col-lg-6">
                    <h2 style="font-family: Open Sans" class="title mb-1">Để lại lời nhắn</h2><!-- End .title mb-2 -->
                    <br>
                    <form id="contact_submit" class="contact-form mb-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="cname" class="sr-only">Tên</label>
                                <input type="text" class="form-control" id="cname" placeholder="Tên *" required>
                            </div><!-- End .col-sm-6 -->

                            <div class="col-sm-6">
                                <label for="cemail" class="sr-only">Email</label>
                                <input type="email" class="form-control" id="cemail" placeholder="Email *" required>
                            </div><!-- End .col-sm-6 -->
                        </div><!-- End .row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="cphone" class="sr-only">Số điện thoại</label>
                                <input type="tel" class="form-control" id="cphone" placeholder="Số điện thoại">
                            </div><!-- End .col-sm-6 -->

                            <div class="col-sm-6">
                                <label for="csubject" class="sr-only">Subject</label>
                                <input type="text" class="form-control" id="csubject" placeholder="Subject">
                            </div><!-- End .col-sm-6 -->
                        </div><!-- End .row -->

                        <label for="cmessage" class="sr-only">Lời nhắn</label>
                        <textarea class="form-control" cols="30" rows="4" id="cmessage" required placeholder="Lời nhắn *"></textarea>

                        <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                            <span>Gửi</span>
                            <i class="icon-long-arrow-right"></i>
                        </button>
                    </form><!-- End .contact-form -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->