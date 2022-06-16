  <!-- <script src="{{ asset('assets/login/js/jquery-3.2.1.min.js') }}"></script> -->
  <script src="{{asset('assets/admin/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/admin/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/admin/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/admin/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/admin/js/plugins/chartjs.min.js')}}"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/admin/js/material-dashboard.min.js?v=3.0.2')}}"></script>
  <script src="{{ asset('assets/login/js/sweetalert.min.js') }}"></script>
  <script src="{{asset('assets/admin/js/main.js')}}"></script>