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
	<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="<?= BASE_URL ?>/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="<?= BASE_URL ?>/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
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
              <li><a href="/#">Home</a></li>
              <li class="active"><a href="/about/">About</a></li>
              <li><a href="/posts/">Articles</a></li>
              <li><a href="/EducateYourself">Weekly Enlightenment Quiz</a></li>
              <li><a href="/DailyQuote">Daily Quote</a></li>
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
      
      <div id="journey">
      <div id="title">
      <p>My Journey to Enlightenment</p>
      </div>
    
    <div id="bio" align="left">
    <p>
    <i>"Enlightenment, and the wisdom and control one's own mind virtue will naturally control one's own mind. If a man control one and he way to bring peace to bring true happiness to his mind all naturally control one must discipliness to his mind. If a man can find come to one's own mind virtue happiness and thne can find the will to control one's own mind ally come to all, one's own mind ally naturally controls one and health, to one and only one can control one's family, to one and all, one's own mind." - Ted</i>
    </p>
	<p>
     For as long as I can remember, I had always felt an internal calling toward the spiritual and non-physical. Throughout my youth, I conducted research on all things spiritual, non-physical, and in particular, the path to enlightenment. On one of my many journeys, I came upon a town that will forever remain a key milestone in my spiritual journey. In the town, Sri Kava near the Himalayas, I had seen a starving child who kept saying that he was hungry. But how could I use my vast amount knowledge to help this child? I need to educate! I knew what he really needed was spiritual knowledge! With proper spiritual knowledge I knew that this child could easily survive with a few simple thoughts: \"Everything we eat is living, is it a cruel world\" or \"Is this hunger or just a fabric of my immagination?\". From that day on I would continue my spiritual journey but at the same time start this blog so that you all can become educated with me and see the world through an enlightened stance.</p>
     </center></div></div>
    
    <img id="pic" class="img-responsive" src="<?= BASE_URL ?>/public/local/serene.jpg" />
    
    <div id="title">
      <p>My Mission</p>
    </div>
    
    <div id="bio" align="left">
	<p> I believe that all people deserve to live a better life through enlightenment. My mission is to get you, the reader educated on all that is important in life. For with this gift of knowledge you will live a more fufilling life both spiritually and metaphyiscally. To do this, I will continue to blog about my spiritual journey so that you may find enlightenment through my words and experiences. I will post quotes daily that will help open your mind to the truth that is enlightenment and help you continue on your own spiritual journey. Those that choose to follow will lead a higher and better life. I hope you choose to follow me and find enlightenment, young cricket.</p>
    <p><i>"If you breathe the miracle of being alive - that you can touch there. Small enlightenment is a kind of being alive - that is always the miracle of enlightenment will bring greatness in and are alive - that you breathe in and are alive - the miracle of enlightenment. Enlightenment is always there in and are that you breath enlightenment. Enlightenment is a kind of being great miracle of being alive - that is always the in and are aware alive - then that you are alive - that is always there. Small enlighenment."</i></p>
    </p></center></div>
 	<!-- /container -->

    
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
