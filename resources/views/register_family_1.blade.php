<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>NGS Kidsclub</title>

	<link rel="stylesheet" href="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}">
	  <script src="{{asset('front/js/jquery.min.js')}}"></script>
	  <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>


	  <style>
	  	.step-form.row {
		    margin: 50px auto;
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
		    float: right;
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
	


		.row.formbox {
		    border: 1px solid #333;
		    padding: 15px;
		    border-radius: 4px;
		    margin:25px auto;
		        min-height: 400px;
		}
		.formbox h4 {
		    font-size: 14px;
		    font-weight: 600;
		    text-align: center;
		    font-family: sans-serif;
		    margin-top: 0px;
		    border-bottom: 1px solid #333;
		    padding-bottom: 15px;
		}
		a.addpform , a.addcform {
		    position: absolute;
		    right: 30px;
		    font-size: 29px;
		    margin-top: -54px;
		    color: #000;
		    cursor: pointer;
		    text-decoration: none;
		}
		a.removebtn {
	       position: absolute;
		    right: 30px;
		    font-size: 17px;
		    margin-top: -45px;
		    color: #000;
		    font-weight: 700;
		    cursor: pointer;
		    text-decoration: none;
		    display: none;
		}
		.row.formbox.added {
    background: rgba(33, 150, 243, 0.09019607843137255);
}
.added a.addpform {
    display: none;
}
.added a.removebtn {
    display: block;
}
	  </style>
</head>
<body>
	<section>
		<div class="container">
			@include('flash')
			<div class="step-form row">
				<div class="col-md-6 col-md-offset-3">
					
					<h3>Sign-up as a Member</h3>
					<p>On behalf of a family</p>
					<form name="step1" method="POST" action="{{route('register.family')}}">
						@csrf
						<input type="hidden" name="register_type" value="family">
						<div class="row boxsign1 formbox">

							<h4>Add Parent(s) / guardian(s)</h4>
							<a class="addpform">+</a>
							
							<div class="form-group col-md-12 col-xs-12">
						      <label for="first_name">First Name:</label>
						      <input type="text" class="form-control" placeholder="Enter First Name" name="parent[0][first_name]">
						    </div>

						    <div class="form-group col-md-12 col-xs-12">
						      <label for="last_name">Last Name:</label>
						      <input type="text" class="form-control" placeholder="Enter Last Name" name="parent[0][last_name]">
						    </div>

						    <div class="form-group col-md-12 col-xs-12">
						      <label for="email">Email Add:</label>
						      <input type="email" class="form-control" placeholder="Enter email" name="parent[0][email]">
						    </div>

						    <div class="form-group col-md-12 col-xs-12">
						      <label for="username">Username:</label>
						      <input type="text" class="form-control" placeholder="Enter username" name="parent[0][username]">
						    </div>
						    
						    <div class="form-group col-md-12 col-xs-12">
						      <label for="password">Password:</label>
						      <input type="password" class="form-control" placeholder="Enter password" name="parent[0][password]">
						    </div>

						     <div class="form-group col-md-12 col-xs-12">
						     	 <input type="checkbox" required="" name="terms_and_conditions" value="accepted">
						        <label for="terms">I agree to the <a href="#">Terms and conditions</a> of this online activity.</label>
						     
						    </div>

						     <div class="form-group col-md-12 col-xs-12">
						     	 <input type="checkbox" required="" name="privacy_policy" value="accepted">
						        <label for="terms">I agree to the <a href="#">Privacy Policy</a></label>
						     
						    </div>

						   
						</div>

						<div class="row boxsign2 formbox">

							<h4>Add Children</h4>
							<a class="addcform">+</a>
							
							<div class="form-group col-md-12 col-xs-12">
						      <label for="first_name">First Name:</label>
						      <input type="text" class="form-control" placeholder="Enter First Name" name="children[0][first_name]">
						    </div>

						    <div class="form-group col-md-12 col-xs-12">
						      <label for="last_name">Last Name:</label>
						      <input type="text" class="form-control" placeholder="Enter Last Name" name="children[0][last_name]">
						    </div>


						    <div class="form-group col-md-12 col-xs-12">
						      <label for="year_of_birth">Year of Birth</label>
						      <input type="number" class="form-control" placeholder="Year of birth" name="children[0][year_of_birth]">
						    </div>

						    <div class="form-group col-md-12 col-xs-12">
						      <label for="username">Username</label>
						      <input type="text" class="form-control" placeholder="Enter Username" name="children[0][username]">
						    </div>

						    <div class="form-group col-md-12 col-xs-12">
						      <label for="password">Password:</label>
						      <input type="password" class="form-control" placeholder="Enter password" name="children[0][password]">
						    </div>

						

						</div>

							<div class="form-group col-md-12 col-xs-12">
								<button class="btn btn-primary" type="submit">Confirm</button>
							</div>
					</form>

					


				</div>
			</div>
		</div>
	</section>
	

	<script type="text/javascript">
		$(document).ready(function(){
			var i = 1;
			var j = 1
			$(".addpform").click(function(){
				var html = '<div class="row formbox added">'+

				'<h4>Add Parent(s) / guardian(s)</h4>'+
				'<a class="removebtn">X</a>'+

				'<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="first_name">First Name:</label>'+
				      '<input type="text" class="form-control" placeholder="Enter First Name" name="parent['+i+'][first_name]">'+
				    '</div>'+

				    '<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="last_name">Last Name:</label>'+
				      '<input type="text" class="form-control" placeholder="Enter Last Name" name="parent['+i+'][last_name]">'+
				    '</div>'+

				    '<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="username">Username:</label>'+
				      '<input type="text" class="form-control" placeholder="Enter username" name="parent['+i+'][username]">'+
				    '</div>'+
				    
				    '<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="password">Password:</label>'+
				      '<input type="password" class="form-control" placeholder="Enter password" name="parent['+i+'][password]">'+
				    '</div>'+

				'</div>';
				$(this).parent(".formbox").after(html)
				i++;
			});

			$(".addcform").click(function(){
				var html = '<div class="row formbox added">'+

				'<h4>Add Children</h4>'+
				'<a class="removebtn">X</a>'+

				'<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="first_name">First Name:</label>'+
				      '<input type="text" class="form-control" placeholder="Enter First Name" name="children['+j+'][first_name]">'+
				    '</div>'+

				    '<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="last_name">Last Name:</label>'+
				      '<input type="text" class="form-control" placeholder="Enter Last Name" name="children['+j+'][last_name]">'+
				    '</div>'+

				    '<div class="form-group col-md-12 col-xs-12">'+
					   '<label for="year_of_birth">Year of Birth</label>'+
					   '<input type="number" class="form-control" placeholder="Year of birth" name="children['+j+'][year_of_birth]">'+
					'</div>'+

				    '<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="username">Username:</label>'+
				      '<input type="text" class="form-control" placeholder="Enter username" name="children['+j+'][username]">'+
				    '</div>'+
				    
				    '<div class="form-group col-md-12 col-xs-12">'+
				      '<label for="password">Password:</label>'+
				      '<input type="password" class="form-control" placeholder="Enter password" name="children['+j+'][password]">'+
				    '</div>'+

				'</div>';
				$(this).parent(".formbox").after(html)
				j++;
			});

		});


		$(document).on('click', '.removebtn', function() {
	     $(this).parent().remove();
		});


	</script>
</body>
</html>