<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title> You are feeling enlightened </title>


<script src="<?= BASE_URL ?>public/js/jquery-2.2.0.js"></script>
<script src="<?= BASE_URL ?>public/js/script.js"></script>
<!-- Bootstrap core CSS -->
<link href="<?= BASE_URL ?>/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= BASE_URL ?>/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/css/nav.css"/>


<body>
	<!-- Static navbar -->
	<!-- Navagation bar using bootstrap -->
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
              <li><a href="<?= BASE_URL ?>about">About</a></li>
              <li class="active"><a href="<?= BASE_URL ?>posts/">Articles</a></li>
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
	</ul> <br>


	<center>
	<h1> <?php //Article Image
			echo $article["Title"]; 
			?> </h1> 

	<?php
		// Form the article image
		echo '<img id="postImage" src=' . $article["Image"] . '>'
	?>
	<div id="posts">
	<p id="ArticleText"> 
	<?php
		// Article
		echo $article["Article"]
	?>
	</div>


	<!-- //Getting a flickr Image by using flickrImageURL in articleController.php -->
	<div class="flickrImage"><img id="phpApiImg" src="<?php echo $flickrImageURL; ?>"></div>

	
	</p>

	<!-- The naviagation bar will allow you to easily go through all of Ted's articles, there are checks to make sure you don't go out of bounds and throw an error-->
	<ul class="navigation">
	<a class="NAVbutton" id="first" href=<?php echo BASE_URL."posts/".$min; ?> ><button id="first-button" class="btn btn-default">First</button></a>
		<a class="NAVbutton" id="previous" href=<?php
			if($id == 1)
				echo "#";
			else
				// load previous article
				echo BASE_URL."posts/".$prev;
		?>><button id="previous-button" class="btn btn-default">Previous</button></a>
		<a class="NAVbutton" id="next" href=<?php 
			if($id === $max)
				echo "#";
			else
				// load next article
				echo BASE_URL."posts/".$next;
		?>><button id="next-button" class="btn btn-default">Next</button></a>
		<a class="NAVbutton" id="last" href=<?php echo BASE_URL."posts/".$max; ?> ><button id="last" class="btn btn-default">Last</button></a>

	</ul>
	<!-- Table is used to properly format the comments section -->
	<!-- Comments are not connected to a database and won't be until Facebook integrated-->
		
<talbe>

		
		<tr>
<h2>Comments</h2>

	<div id="comments">
	<?php 
	//Only let logged in user post comments
	if(isset($_SESSION['username'])):
		//echo $postID = $article["Num"];
		$postID = $article["Num"];
		$pURL = BASE_URL."posts/".$postID."/comment/add";
		$userName = $_SESSION['username'];
		

		$user = AppUser::loadByUsername($_SESSION['username']); // get logged-in userna
		$userNum = $user->get('id');

		?>
		<form name="commentsForm" id="comments-form" method="POST" action=<?php echo $pURL."/"; ?>>
			<input type="text" name="yourComment">

			<input type="submit" name="submit" value="Post Comment">

		</form>
	<?php else: ?>
		<p>Please log in to comment.</p>
	<?php endif; ?>

<?php
	//List out all the comments if there are any.
	if(!is_null($comments)) {
		foreach($comments as $c) {
			echo '<p class="comment">'.$c->get('Comment').'</p>';

			$author = AppUser::loadById($c->get('User'));
			$authorName = $author->get('Username');
			$authorUrl = BASE_URL."profile/".$author->get('Username');
			?>
				
			<p class="author">	<a href="<?php echo $authorUrl; ?>"><?php echo $authorName; ?></a> commented </a> on 
			

			<?php
			echo ' on '.date("F j, Y", strtotime($c->get('Date'))).'</p>';
			
		}
	} else {
		echo '<p>No comments yet.</p>';
	}
?>
	</div><!-- #comments -->
	




	
	</table>	
	<!-- List view of all articles -->
	<a href="/posts/all"> View all posts by Ted </a></center><br><br><br><br>
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