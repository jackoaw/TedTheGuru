<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title> You are feeling enlightened </title>

<script src="<?= BASE_URL ?>public/js/jquery-2.2.0.js"></script>
<script src="<?= BASE_URL ?>public/js/script.js"></script>
<!-- Bootstrap core CSS -->
<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="/public/css/nav.css"/>

<!-- Only a dummy button that points to Facebook for now, but when allowed to use Facebook API, will hopefully be integrated -->
<body>
	  <!-- Static navbar -->
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
              <li><a href="<?= BASE_URL ?>about">About</a></li>
              <li><a href="<?= BASE_URL ?>posts/">Articles</a></li>
              <li><a href="<?= BASE_URL ?>EducateYourself">Weekly Enlightenment Quiz</a></li>
              <li><a href="<?= BASE_URL ?>DailyQuote">Daily Quote</a></li>
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
                <li class="active"><a href="/login">Settings</a></li>
              <?php } 
              else {?>
                <li class="active"><a href="/login">Login</a></li>
              <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav><br>
      
        <center>
		<div id="login">
		<?php
			// Present this if not already logged in
			if( !isset($_SESSION['username']) || $_SESSION['username'] == '') { ?>
			<form action="<?php echo BASE_URL;?>/login?action=validate" method="POST" >
				<label>Username: <br><input name="uname" id="username-login" type="text"></label><br>
				<label>Password: <br><input name="pw" id="password-login" type="password"></label><br>
				<input type="submit" value="Log in">
			</form> 
			<p><a href="/signup"> Create an Account </a></p> 
		<?php
		}
		else
		{
			// Present options specifically for the Webmaster
			if($_SESSION['admin'] == 1)
			{
				echo "<h3> Welcome Guru! </h3>";
				echo '<a href="/posts/create/"> Create new post </a> <br>
					  <a href="/posts/delete/"> Delete a post </a> <br>
					  <a href="/posts/edit/"> Edit a post </a> <br>
					  <p></p>
					  <a href="/quiz/create/"> Create new quiz </a> <br>
					  <a href="/quiz/delete/"> Delete a quiz </a> <br>
					  <a href="/quiz/edit/"> Edit quiz </a> <br>
					  <p></p>
					  <a href="/quotes/create/"> Create new quote </a> <br>
					  <a href="/quotes/delete/"> Delete a quote </a> <br>
					  <a href="/quotes/edit/"> Edit a quote </a> <br>
					  <p></p>
					  <a href="/account/privileges/"> Edit user privileges </a> <br>
					  <a href="/account/delete/"> Delete user account </a> <br>'
					  ;
				
			}
			echo '<br><a class="spacelist" href="/logout/"> Logout </a> <br>';
		}
		// Show error messages if there are any, then reset
		if(isset($_SESSION['error']))
		{
			echo $_SESSION['error'];
			$_SESSION['error'] = '';
		}
		?>

	</div><br><br>

	<div id="footer"> 
		<a href="/info"> Info and References </a>
	</div></center>
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>