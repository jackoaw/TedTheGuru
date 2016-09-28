<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>sign up</title>
<!-- <link rel="stylesheet" type="text/css" href="stylesK.css">
<script src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="js/scripts.js"></script> -->

<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/nav.css"/>

<script src="<?= BASE_URL ?>public/js/jquery-2.2.0.js"></script>
<script src="<?= BASE_URL ?>public/js/script.js"></script>
<!-- Bootstrap core CSS -->
<link href="<?= BASE_URL ?>/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= BASE_URL ?>/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/nav.css"/>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/derick.css"/>
<script type="text/javascript">


	$(document).ready(function(){

		// event handler for username textbox on Register page
		$('#create-account #username-signup').blur(function(){
			var textbox = $(this); // remember our trigger textbox

			// first, remove any status classes attached to this textbox
			$(textbox).removeClass('unavailable').removeClass('available');

			// ajax GET request to see if username is available
			$.get(
				'<?= BASE_URL ?>signup/check',
				{ "meep": $(textbox).val() } )
				.done(function(data){
					if(data.success == 'success') {
						// successfully reached the server
						if(data.check == 'available') {
							$(textbox).addClass('available');
						} else {
							$(textbox).addClass('unavailable');
						}
					} else if(data.error != '') {
						alert("Please provide a valid username.");
					} })
				.fail(function(){
						alert("Ajax error: could not reach server.");
				});
		});

	});

</script>


</head>

<body>
	<ul id="navigation">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="<?= BASE_URL ?>">Home</a></li>
              <li><a href="#">Articles</a></li>
              <li><a href="<?= BASE_URL ?>/EducateYourself">Weekly Enlightenment Quiz</a></li>
              <li><a href="<?= BASE_URL ?>/DailyQuote">Daily Quote</a></li>
              <li><a href="<?= BASE_URL ?>tedswalk">Forest of Enlightenment</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <?php if (isset($_SESSION['username']))  {
              ?>
              	<li><a href=<?php 
                      echo "/profile/" . ($_SESSION['username']);
                      ?>
                      >Profile</a></li>
              <?php } 
              
              if (isset($_SESSION['username']) && $_SESSION['username'] == 'Ted') { ?>
                <li><a href="/login">Settings</a></li>
              <?php } 
              else {?>
                <li><a href="/login">Login</a></li>
              <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
	</ul> <br>
	<h1 id="signup-title">Welcome To The Path of Ted</h1>
	
	<div class="nav-header">
		
		<div id="left-signup-nav">
			<a href="<?= BASE_URL ?>/">Back To Home</a>
		</div>
		
		<div id="right-signup-nav">
			<a href="<?= BASE_URL ?>/login">Already a follower?</a>
		</div>
	</div>
	
	<div id="still-wrapper">
	<section id="sign-up-div">
	<h2 id="signup-div-title">Sign up now!</h2>
	<div id="sign-up-border">	
		<div id="email-box">
		<form method="POST" action="<?= BASE_URL ?>/app/model/signupAssist.php" id="create-account">
			
			<ol>
				<li>
					<label>
						<strong>Username</strong>
					</label>
					<input type="text" id="username-signup" name="username-signup" value="">
				</li>
				<li>
					<label>
					<Strong>Password</Strong>
					</label>
					<input type="password" name="password1" id="password1" value="">
					
				</li>
				<li>
					<label>
					<Strong>Re-enter Password</Strong>
					</label>
					<input type="password" name="password2" id="password2" value="">
					
				</li>
				<li>
					<fieldset id="birthday-field">
					<label id="month-label" class="month">
						<Strong>Birthday</Strong>
						<select name="birthMonth" id="month-select" onchange="" size="1">
						<option value="" disabled selected>Month</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					</label>
					
					
					<label id="day-label" class="day">
						<!-- <strong>Day</strong> -->
						<input type="text" id="write-day" name="birthDay" size="3" placeholder="Day">
					</label>
					
					
					<label id="year-label" class="year">
						<!-- <strong>Year</strong> -->
						<input type="text" id="write-year" name="birthYear" size="5" placeholder="Year">
					</label>
					
					
					</fieldset>
				</li>
				<li>
					<input class="create-submit" type="submit" value="Join Now">
				</li>
			</ol>
		</form>
		</div>
        
	</div>
	</section>
	</div>
</body>
</html>