<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title> You are feeling enlightened </title>
	<!-- Bootstrap requires JQuery -->
	<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="<?= BASE_URL ?>/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="<?= BASE_URL ?>/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/nav.css"/>

<body>
	<!-- Static navbar -->
	<!-- Navagation bar using bootstrap -->
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
                <li><a href="/login">Settings</a></li>
              <?php } 
              else {?>
                <li><a href="/login">Login</a></li>
              <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav><center>
	<?php
	// Make sure nobody but Ted can access these options
	if(isset($_SESSION['username']) && $_SESSION['username'] == 'Ted'){
		switch($action)
		{
			case 'edit':
			// This is the Edit view for editing an already existing databse record inside of the 'post' table.
	?>
				<h2>Edit your quiz here</h2><br>
				<form method="POST" action="<?php echo BASE_URL;?>quiz/edit?action=submit">
				Quiz Number:<br>
				<input type="text" name="quiz#"><br>
				New Question:<br>
				<input type="text" name="newQuestion"><br>
				New Choice 1:<br>
				<input type="text" name="newC1"><br>
				New Choice 2:<br>
				<input type="text" name="newC2"><br>
				New Choice 3:<br>
				<input type="text" name="newC3"><br>
				New Choice 4:<br>
				<input type="text" name="newC4"><br>
				New Correct:<br>
				<input type="text" name="newCorrect"><br>
				New CorrectResponse:<br>
				<input type="text" name="newResponse"><br>
				<br><input type="submit" value="Submit">
				</form> 
	<?php
				break;
			case 'create':
			// This is the Create view for creating a completely new record in the table 'posts'
	?>
				<h2>Create your quiz here</h2><br>
				<form method="POST" action="<?php echo BASE_URL;?>quiz/create?action=submit">
				Quiz Number:<br>
				<input type="text" name="quiz#"><br>
				Question:<br>
				<input type="text" name="question"><br>
				Choice 1:<br>
				<input type="text" name="c1"><br>
				Choice 2:<br>
				<input type="text" name="c2"><br>
				Choice 3:<br>
				<input type="text" name="c3"><br>
				Choice 4:<br>
				<input type="text" name="c4"><br>
				Correct:<br>
				<input type="text" name="correct"><br>
				CorrectResponse:<br>
				<input type="text" name="response"><br>
				<br><input type="submit" value="Submit">
				</form> 
	<?php
				break;

			case 'delete':
			// // This is the Delete view for removing a record from the table 'posts'
	?>
				<h2>Delete your quiz here</h2><br>
				<form method="POST" action="<?php echo BASE_URL;?>quiz/delete?action=submit">
				Post Number:<br>
				<input type="text" name="quiz#"><br>
				<br><input type="submit" value="Submit">
				</form> 
	<?php
				break;
		}
	}
	else
	{
		// Gotcha! You aren't Ted!
		echo "You are not authorized to be here.";
	}
	?>

	<div id="footer"> 
	<a href="/info"> Info and References </a>
	</div>

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