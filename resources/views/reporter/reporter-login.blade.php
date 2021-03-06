<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('back/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="login-box" style="min-height: 420px;">
        <form class="login-form" method="post" action="{{route('reporter.login')}}">
          @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Login Reporter</h3>
          <div class="form-group">
            <label class="control-label">Username</label>
            <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" type="text" placeholder="Username" name="username" autofocus value="{{ENV('APP_ENV') == 'development' ? 'admin' : old('username')}}">
            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
          <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="Password" name="password" value="{{ENV('APP_ENV') == 'development' ? '121212' : ''}}">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox"><span class="label-text" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Stay Signed in</span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>{{ __('Login') }}</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('back/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('back/js/popper.min.js')}}"></script>
    <script src="{{asset('back/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('back/js/main.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{asset('back/js/plugins/pace.min.js')}}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
      });
    </script>

     @if(Session::has('alert'))

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
          title: '{{Session::get('title')}}',
          text: '{{Session::get('text')}}',
          icon:'{{Session::get('icon')}}',
        });
    </script>
    @endif
  </body>
</html>
