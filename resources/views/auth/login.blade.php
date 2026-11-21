<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>SMART NOTES | Admin | Login</title>
    <!-- Global stylesheets -->
    <link href="{{ asset('assets/admin/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/components.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/colors.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('assets/admin/js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/core/libraries/bootstrap.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/forms/validation/validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <!-- /theme JS files -->

    <script type="text/javascript">
        // If page is restored from bfcache (Back/Forward), reload to get a fresh CSRF token
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</head>

<body class="login-container">
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Content area -->
                <div class="content">
                  <form action="{{route('login')}}" method="POST">
                    @csrf
                        <div class="panel panel-body login-form">
                
                            <div class="text-center">
                                <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                                <h5 class="content-group">{{ __('Login To Your Account') }}<small
                                        class="display-block">{{ __('Enter Your Credentials Below') }}</small></h5>
                            </div>
                
                            @if (\Session::has('alert'))
                              <div class="alert alert-danger">
                                {!! \Session::get('alert') !!}
                              </div>
                            @endif
                            @if (\Session::has('error'))
                              <div class="alert alert-danger">
                                {{ \Session::get('error') }}
                              </div>
                            @endif
                
                            <div class="form-group has-feedback has-feedback-left">
                                <div class="form-control-feedback"><i class="icon-envelop text-muted"></i></div>
                                <input type="text" class="form-control" placeholder="{{ __('username') }}" name="username" id="username" value="{{ old('username') }}" required autofocus>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                
                            <div class="form-group has-feedback has-feedback-left">
                                <div class="form-control-feedback"><i class="icon-lock2 text-muted"></i></div>
                                <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password"
                                    id="password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                
                            {{-- <div class="form-group login-options">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="styled" name="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <a href="">{{ __('Forgot Password') }}</a>
                                    </div>
                                </div>
                            </div> --}}
                
                            <div class="form-group">
                                <button type="submit" id="btnAdminLogin" class="btn bg-blue btn-block">{{ __('Login') }}<i
                                        class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Footer -->
                    <div class="footer text-muted text-center">
                        &copy;{{ date('Y') }}. Admin Panel by <a target="_blank">NISL</a>
                    </div>
                    <!-- /footer -->
                </div>
                <!-- /content area -->
            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->
    </div>
    <!-- /page container -->
    <script>
        document.querySelector('form')?.addEventListener('submit', function() {
            var btn = document.getElementById('btnAdminLogin');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="icon-spinner2 spinner position-left"></i> Authenticating...';
            }
        });
    </script>
</body>

</html>
