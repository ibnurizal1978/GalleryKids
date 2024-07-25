
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Welcome NGS - Kidsclub</title>

	<link rel="stylesheet" href="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}">
	  <script src="{{asset('front/js/jquery.min.js')}}"></script>
	  <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>


	  <style>
	  	.step-form.row {
		    margin: 50px auto;
		}
		.step-form ul {
		    list-style: none;
		    padding: 0px;
		    margin: 0px;
		    display: flex;
		}
		.step-form ul li {
		       width: 33.33%;
    position: relative;
    text-align: center;
    background: #eeeeee;
    font-size: 18px;
    font-weight: 100;
    font-family: fantasy;
    letter-spacing: 1px;
    color: #2aadde;
    line-height: 50px;
    border-top: 1px solid #dddddd;
    border-bottom: 1px solid #dddddd;
		}
		.step-form ul li.active {
		    background: #2aadde;
		    border-top: 1px solid #2aadde;
		    border-bottom: 1px solid #2aadde;
		    color: #ffffff;

		}
		.step-form ul li:first-child {
	border-left: 1px solid #dddddd;
}

.step-form ul li:last-child {
	border-right: 1px solid #dddddd;
}

.step-form ul li.active,
.step-form ul li.completed {
	background: #2aadde;
	border-top: 1px solid #2aadde;
	border-bottom: 1px solid #2aadde;
	color: #ffffff;
}

.step-form ul li.completed {
	color: #82cfec;
}

.step-form ul li.active:first-child,
.step-form ul li.completed:first-child {
	border-left-color: #2aadde;
}

.step-form ul li.active:last-child,
.step-form ul li.completed:last-child {
	border-right-color: #2aadde;
}

.step-form ul li:before,
.step-form ul li:after {
	display: block;
	position: absolute;
	content: '';
	top: -1px;
	width: 0;
	height: 0;
	border-top: 26px solid transparent;
	border-bottom: 26px solid transparent;
	z-index: 10;
}

.step-form ul li:before {
	right: -27px;
	border-left: 26px solid #e0e0e0;
}

.step-form ul li:after {
	right: -26px;
	border-left: 26px solid #eeeeee;
}

.step-form ul li.active:before,
.step-form ul li.completed:before {
	border-left: 26px solid rgba(255, 255, 255, 0.3);
}

.step-form ul li.active:after,
.step-form ul li.completed:after {
	border-left: 26px solid #2aadde;
}

.step-form ul li:last-child:before,
.step-form ul li:last-child:after {
	display: none;
}

		.step-form h3 {
		    font-weight: bold;
		    color: #2196F3;
		    margin-bottom: 0px;
		    text-align: center;
		}

		.step-form>div>p {
		    font-size: 14px;
		    color: #828282;
		    margin-bottom: 40px;
		    text-align: center;
		}
		.step-form .btn-primary {
		    
		    width: 210px;
		    background: #2aadde;
		    margin-top: 25px;
		    margin-bottom: 0px;
		}
		input.form-control.upload {
		    position: absolute;
		    opacity: 0;
		}
		span.uploadspan {
		    width: 100%;
		    display: block;
		    text-align: center;
		    line-height: 32px;
		    border-radius: 5px;
		    background: #bebebe;
		    font-weight: bold;
		    color: #000;
		    border: 1px solid #868686;
		}
		.step2 p{
			text-align: center;
		}
		.step3 p {
		    text-align: center;
		    max-width: 360px;
		    margin: auto;
		}
		.otpinput{
		    max-width: 332px;
		    margin: auto;
		    margin-top: 50px;
		    margin-bottom: 30px;
		}
		.alignoptbtn {
		    clear: both;
		    text-align: center;
		    margin: auto !important;
		}
		.step3 .btn-warning{
		    float: right;
		    margin-top: 0px;
		    width: 150px;
		}
		.step3 .btn-primary{
		    float: left;
		    margin-top: 0px;
		    width: 150px;
		}

		.step2,.step3{
			display: none;
		}

		.invalid-feedback{
			color: #fd2222;
		}

	  </style>
</head>
<body>
	<section>
		<div class="container">
			@include('flash')	
			<div class="step-form row">
				<div class="col-md-10 col-md-offset-1">
						 

						<div class="row">
							
							<h3>Welcome to KIDS CLUB</h3>
							<h3>You are officially a member now</h3>
							 
						    <div align="center"> 
						    	<a href="/" class="btn btn-primary">Let's start exploring</a>
						    </div>
						
						</div>
					 
				</div>
			</div>
		</div>
	</section>
	 
</body>
</html>