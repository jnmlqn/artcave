<!DOCTYPE html>
<html>
<head>
	<title>ARTCAVE</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <style type="text/css">
    	body {
    		font-size: 1.1em !important;
    	}
    	.bgac-dust {
			background-color: #edeae6 !important;
			color: black !important;
		}
		.bgac-gold {
			background-color: #c5a173 !important;
			color: white !important;
		}
		.btn.bgac-gold:hover {
			background-color: #9c8261 !important;
		}
		.bgac-black {
			background-color: #181c16 !important;
			color: white !important;
		}
		.bgac-red {
			background-color: #cf0015 !important;
			color: white !important
		}
		.text-dust {
			color: #edeae6 !important;
		}
		.text-gold {
			color: #c5a173 !important;
		}
		.text-gold-hover:hover {
			color: #9c8261 !important;
		}
		.text-black {
			color: #181c16 !important;
		}
		.text-red {
			color: #cf0015 !important;
		}
		.border-gold {
			border: 1px solid #c5a173 !important;
		}
		.border-gray {
			border: 1px solid #ccc !important;
		}
		a {
			text-decoration: none !important;
		}
    </style>
</head>
<body>
	<div style="width: 100%; padding: 20px">
		Hi {{$name}},
		<br><br>
		We have just received a request to reset your password at 
		<a href="http://localhost:8081/backend/login">artcavegallery.com/backend/login</a> and we are here to help you with that!
		<br><br>
		Simply click on the link to set up a new password for your account:<br>
		<a href="{{env('APP_URL')}}/backend/reset/password/{{$token}}">Reset Password</a>
		<br><br>
		If you didn't request a password reset, you can ignore or delete this email.
		<br><br>
		Thank You!
		<br>
		This is an automatically generated email from inquire form. Please do not reply to this email.
	</div>
	<div class="bgac-dust" style="width: 100%; padding: 20px">
		<table style="width: 100%; border: none;">
			<tr>
				<td width="50%" style="vertical-align: text-top !important;">
					<span><b>ARTCAVE</b></span><br><br>
					<a href="{{env('APP_URL')}}/about-us" class="text-black">ABOUT US</a><br>
					<a href="{{env('APP_URL')}}/the-gallery" class="text-black">GALLERY</a><br>
					<a href="{{env('APP_URL')}}/the-cafe" class="text-black">CAFE</a><br>
					<a href="{{env('APP_URL')}}/media" class="text-black">MEDIA</a><br>
					<a href="{{env('APP_URL')}}/promos-and-events" class="text-black">PROMOS AND EVENTS</a><br>
				</td>
				<td width="50%" style="vertical-align: text-top !important;">
					<span><b>CONTACT US</b></span><br><br>
					<a href="https://www.google.com/maps/place/54+Katipunan+Ave,+Quezon+City,+Metro+Manila/@14.6070682,121.0683371,17z/data=!4m5!3m4!1s0x3397b7fa89249e01:0x21d1aad0cbd47d13!8m2!3d14.607063!4d121.0705258" class="text-black" target="_blank">
						No. 54 Katipunan Ave. <br> White Plains, Quezon City<br>Philippines, 1103
					</a><br>
					<a class="text-black">0917 572 7775</a><br>
					<a class="text-black">0917 526 5572</a><br>
					<a class="text-black">(02) 7904 8485</a><br>
					<a class="text-black">info@artcavegallery.com</a><br>
				</td>
			</tr>
		</table>
	</div>
	<div class="bgac-red" style="width: 100%; padding: 20px">
		<center>
			<a href="https://www.facebook.com/profile.php?id=100047526704669&ref=content_filter" target="_blank">
				<img loading="lazy" src="{{env('APP_URL')}}/assets/icons/fb.png" width="20">
			</a>
			<a href="https://instagram.com/artcavegalleryncafe?igshid=1332dmz2nkvxp" target="_blank">
				<img loading="lazy" src="{{env('APP_URL')}}/assets/icons/ig.png" width="20">
			</a>
			<br>
			<span style="font-size: .78em;">2020 ARTCAVE. ALL RIGHTS RESERVED.</span>
		</center>
	</div>
</body>
</html>