<div class="login-container">
    <img src="{{asset('assets/login/img/avatar.svg')}}" alt="" class="img-avatar" />
    <h1 class="title">PKU MUI KABUPATEN BOGOR</h1>

    <form class="validate-form" action="{{ route('doAuth') }}" method="POST" redirect="{{ route('dashboard') }}">
        {{ csrf_field() }}
        <div class="input-box">
        <input type="text" class="input" placeholder="username" id="username" name="username" />
        <i class="fas fa-envelope"></i>
        </div>
        <div class="input-box">
        <input type="password" class="input" placeholder="Password" id="pwd"  name="password"/>
        <i class="fas fa-lock"></i>
        <i class="fas fa-eye" id="icon-eye"></i>
        </div>

        <input type="submit" class="btn" value="Login" id="btnSubmit"/>
    </form>

    <div class="footer-container">
        
    </div>
</div>