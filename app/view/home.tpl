<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/../../favicon.ico">

    <title>You are Feeling Enlightened</title>
    
    <!-- Bootstrap requires JQuery -->
	<script src="public/js/jquery-2.2.0.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/public/css/nav.css"/>
  </head>

<script>
    // function loads json string from bio.json
    function loadJSON(){
    var data_file = "/public/local/bio.json";
    var http_request = new XMLHttpRequest();

      http_request.onreadystatechange = function(){

        if (http_request.readyState == 4){
        // Javascript function JSON.parse to parse JSON data
        var jsonObj = JSON.parse(http_request.responseText);

        // jsonObj variable now contains the data structure and can
        // be accessed as jsonObj.name and jsonObj.country.
        document.getElementById("bio").innerHTML = jsonObj.bio;
        }
    } 

    http_request.open("POST", data_file, true);
    http_request.send();

    $("#biobutton").hide();
}

</script>

  <body>

    <div class="container">
      <!-- Navagation bar using bootstrap -->
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
              <li class="active"><a href="<?= BASE_URL ?>">Home</a></li>
              <li><a href="<?= BASE_URL ?>about/">About</a></li>
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
      </nav>

      <div>
      <!-- Free use image from Unsplash -->
      <img id="pic" class="img-responsive" src="<?= BASE_URL ?>/public/local/ted.jpg" />
      </div>
    
    <!-- Short bio of Ted -->
    <div id="bio">
	<p><center>  <button type="button" id="biobutton" onclick="loadJSON()">Enter my world</button> <br><br>
	 - Love Ted &lt;3</center></p><br>
    </p></center></div>
 	<!-- /container -->

  <h3>Activity Feed</h3>
<?php

  if(count($notifications) > 0) {
    echo '<ul>';


    foreach($notifications as $e) {
      if(formatNotification($e) != '')
      {
        echo '<li>'.formatNotification($e).'</li>';
      }
    }

    echo '</ul>';
  }

?>
    
    <!-- The footer present on every page -->
	<div id="footer"> 
	<a href="info"> Info and References </a>
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
