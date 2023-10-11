<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/login.css">
@endsection
@include('includes.head', ['title' => 'BACKEND LOGIN'])
<body>
    <div class="main">
        <div class="container">
            <br><br><br>
            <div class="row justify-content-center">
                <div class="col-11 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <center><h4>{{Request::is('backend/login*') ? 'LOGIN' : 'FORGOT PASSWORD'}}</h4></center>
                        </div>

                        <div class="card-body">
                            @if(Request::is('backend/login*'))
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="text-gold">Email Address</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="text-gold">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="text-gold">
                                        Remember me
                                    </label>
                                </div>

                                <center>
                                    <button type="submit" class="btn bgac-black">
                                        LOGIN
                                    </button>
                                    <br><br>
                                    <span class="small">Forgot Password? Click <a href="/backend/forgot-password">here</a></span>
                                </center>
                            </form>
                            @elseif(Request::is('backend/forgot-password*'))
                            <form action="/backend/forgot-password" method="POST">
                                @csrf

                                @if(is_null(session('success')))
                                
                                    @if(!is_null(session('error')))
                                        <div class="alert bgac-red"><center>{{session('error')}}</center></div>
                                    @endif                                   

                                    <center><label class="text-gold">Enter your email address</label></center>
                                    <input type="email" class="form-control" name="email" required placeholder="Enter your Email Address">
                                    <br>
                                    <center>
                                        <button type="submit" class="btn bgac-black">
                                            SUBMIT
                                        </button>
                                    </center>

                                @else
                                    <div class="alert bg-success text-light"><center>{{session('success')}}</center></div>
                                @endif
                            </form>
                            @endif
                            <br>
                            <center><a href="/"><img loading="lazy" src="/img/logo.png" width="150px"></a></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>