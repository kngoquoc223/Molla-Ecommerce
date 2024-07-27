                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Thống Kê</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a style="text-decoration : none" href="{{route('product.index')}}">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Sản phẩm</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $products }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a style="text-decoration : none" href="{{route('posts.index')}}">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Bài viết</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $posts }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-edit fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a style="text-decoration : none" href="{{route('user.index')}}">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Người dùng</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $users }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a style="text-decoration : none" href="{{route('order.index')}}">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Đơn hàng</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $orders }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <form id="pending" action="{{route('order.index')}}">
                                <input hidden type="text" name="order_status" value="1">
                                <a style="text-decoration : none" href="#" onclick="document.getElementById('pending').submit()">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Đơn hàng chờ xác nhận</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $ordersPending }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </form>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <form id="confirmed" action="{{route('order.index')}}">
                                <input hidden type="text" name="order_status" value="2">
                                <a style="text-decoration : none" href="#" onclick="document.getElementById('confirmed').submit()">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Đơn hàng xác nhận</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $ordersConfirmed }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </form>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <form id="shipping" action="{{route('order.index')}}">
                                <input hidden type="text" name="order_status" value="3">
                                <a style="text-decoration : none" href="#" onclick="document.getElementById('shipping').submit()">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Đơn hàng đang vận chuyển </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $ordersShipping }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-truck fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </form>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <form id="delivered" action="{{route('order.index')}}">
                                <input hidden type="text" name="order_status" value="4">
                                <a style="text-decoration : none" href="#" onclick="document.getElementById('delivered').submit()">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Đơn hàng đã giao</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $ordersDelivered }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
