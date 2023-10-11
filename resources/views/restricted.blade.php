<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/login.css">
@endsection
@include('includes.head', ['title' => 'RESTRICTED'])
<body>
    <div class="main">
        <div class="container">
            <br><br><br><br><br>
            <div class="row justify-content-center">
                <div class="col-11 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <center><h4 class="text-red">RESTRICTED PAGE</h4></center>
                        </div>

                        <div class="card-body">
                            <center>
                                <h4>You are not allowed to<br>access this page</h4>
                                <br><br>
                                <a href="/backend/login" class="btn bgac-black mt-1" style="width: 200px; border-radius: 15px !important; padding: 3px 30px 3px 30px !important;">
                                    <i class="fa fa-home"></i> Return to home
                                </a>
                                <br>
                                <button class="btn bgac-black mt-1" onclick="window.history.back()" style="width: 200px; border-radius: 15px !important; padding: 3px 30px 3px 30px !important;">
                                    <i class="fa fa-arrow-left"></i> Go Back
                                </button>
                            </center>
                            <br><br>
                            <center><a href="/"><img loading="lazy" src="/img/logo.png" width="150px"></a></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>