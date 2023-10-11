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
                            @if(empty($error) && empty($success))
                                <form action="/backend/reset/password/{{$token}}" method="POST">
                                    @csrf
                                    @if(!is_null(session('error')))
                                        <div class="alert bgac-red"><center>{{session('error')}}</center></div>
                                    @endif

                                    @if(!is_null(session('success')))
                                        <div class="alert bg-success text-light"><center>{{session('success')}}</center></div>
                                    @endif
                                    <label class="text-gold">Enter new password</label>
                                    <input type="password" class="form-control" name="password" minlength="8" maxlength="100" required placeholder="Enter new password">
                                    <br>
                                    <label class="text-gold">Re-enter new password</label>
                                    <input type="password" class="form-control" name="retype" minlength="8" maxlength="100" required placeholder="Re-enter new password">
                                    <br>
                                    <center>
                                        <button type="submit" class="btn bgac-black">
                                            SUBMIT
                                        </button>
                                    </center>
                                </form>
                                <br>
                            @elseif(!empty($error))
                                <div class="alert bgac-red"><center>{{$error}}</center></div>
                            @elseif(!empty($success))
                                <div class="alert bg-success text-light"><center>{{$success}}</center></div>
                                <center><a class="text-gold" href="/backend/login">Go back to login page</a></center>
                                <br>
                            @endif
                            <center><a href="/"><img loading="lazy" src="/img/logo.png" width="150px"></a></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>