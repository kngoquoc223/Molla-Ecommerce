 <!-- Custom scripts for all pages-->
        <script src="{{asset('backend/js/sb-admin-2.min.js')}}"></script>
    
        <!-- Page level plugins -->
        <script src="{{asset('backend/vendor/chart.js/Chart.min.js')}}"></script>
    
        <!-- Page level custom scripts -->
        <script src="{{asset('backend/js/demo/chart-area-demo.js')}}"></script>
        <script src="{{asset('backend/js/demo/chart-pie-demo.js')}}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

@if (isset($config['js']) && is_array($config['js']))
        @foreach ($config['js'] as $key => $val )
            {!! '<script src="'.$val.'"></script>' !!}
        @endforeach
@endif
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>