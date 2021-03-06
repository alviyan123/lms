<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="">
        <img src="{{asset('assets/admin/img/logo-ct.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">PKU MUI</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a id="btnDashboard" class="nav-link text-white" href="{{ route('dashboard') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a id="btnTugas" class="nav-link text-white " href="{{ route('tugas') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">menu_book</i>
            </div>
            <span class="nav-link-text ms-1">Tugas</span>
          </a>
        </li>
        <li class="nav-item">
          <a id="btnTugasMl" class="nav-link text-white " href="{{ route('tugasMl') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">computer</i>
            </div>
            <span class="nav-link-text ms-1">Micro Learning</span>
          </a>
        </li>
        @if(Auth::user()->role == '1' || Auth::user()->role == '2')
        <li class="nav-item">
          <a id="btnMasterJadwal" class="nav-link text-white " href="{{ route('jadwal') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">access_time</i>
            </div>
            <span class="nav-link-text ms-1">Master Jadwal Kuliah</span>
          </a>
        </li>
        @endif
        @if(Auth::user()->role == '1')
        <li class="nav-item">
          <a id="btnMasterML" class="nav-link text-white " href="{{ route('microLearning') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">chat</i>
            </div>
            <span class="nav-link-text ms-1">Master Micro Learning</span>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a id="btnUser" class="nav-link text-white " href="{{ route('user') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">User</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>