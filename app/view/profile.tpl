<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title> You are feeling enlightened </title>

<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.min.js"></script>
<script src="<?= BASE_URL ?>public/js/script.js"></script>

<script>
//document.write('<?= BASE_URL ?>profile/follow');
</script>

<script type="text/javascript">

$(document).ready(function(){


// event handler for clicking "Follow" button by username
  $('.followUser, .unfollowUser').click(function(){
    // follow the current user
    // get the ID of the user to be followed

    var userID = $(this).data('user-id');
    // // send Ajax request to follow
    // //printf('<?= BASE_URL ?>/profile');


  //THIS IS THE ONE USING JSON, IT CAN NOT REACH SERVER.
    // $.post("<?= BASE_URL ?>follow",
    //     {
    //       "userID": userID
    //     } ).done(
    //     function(data,status){

    //     if(data.success == 'success') {
    //       // successfully followed the user
    //       // now hide the Follow button for that user
    //       $('.followUser').each(function(){
    //         // if this is a Follow button for a followed user ID...
    //         if($(this).data('user-id') == userID)
    //           $(this).remove(); // remove the Follow button
    //       });
    //     } else if(data.error != '') {
    //       alert(data.error); // show error message as modal dialog box
    //     } })
    //   .fail(function(){
    //       alert("Ajax error: could not reach server.");
    //   });
    
  //THIS IS THE UGLY ONE THAT DOES NOT USE JSON, IT WORKS.
    var button = $(this);
    if(button.hasClass("followUser")) {
      $.post("<?= BASE_URL ?>follow",
          {
            "userID": userID
          } ).done(
          function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
            if(data == 'success') {
              // successfully followed the user
              // now hide the Follow button for that user
              $('.followUser').each(function(){
                // if this is a Follow button for a followed user ID...
                if($(this).data('user-id') == userID)
                  $(this).removeClass("followUser"); // remove the Follow button
                  $(this).text("Unfollow");
                  $(this).addClass("unfollowUser");
              });
            }
          });
   }

   else if(button.hasClass("unfollowUser")) {
      $.post("<?= BASE_URL ?>unfollow",
          {
            "userID": userID
          } ).done(
          function(data,status){
            //alert("Data: " + data + "\nStatus: " + status);
            if(data == 'success') {
              // successfully followed the user
              // now hide the Follow button for that user
              $('.unfollowUser').each(function(){
                // if this is a Follow button for a followed user ID...
                if($(this).data('user-id') == userID)
                  $(this).removeClass("unfollowUser"); // remove the Follow button
                  $(this).text("Follow");
                  $(this).addClass("followUser");
              });
            }
          });
   }

  });
});
</script>


<!-- Bootstrap core CSS -->
<link href="<?= BASE_URL ?>/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= BASE_URL ?>/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/css/nav.css"/>

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
                <li class="active"><a href=<?php 
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
      </nav><br><br>
      
        <center>
        <img id="pic" class="pull-left" style="" width="50%" height="400" src="<?= BASE_URL ?>/public/local/ted.jpg" />
        <div id="profile">

        <?php
          //echo str_replace("/", "", $_SERVER['REQUEST_URI']);  is the last part of the html page without the "/"
          //The way this works is you find the person you are trying to follow based on their username in the html page when
          //looking at their profile page...

          $followee_username = str_replace("/profile/", "", $_SERVER['REQUEST_URI']);
          $followee = AppUser::loadByUsername($followee_username);
          $followers_for_followee = AppUser::getMyFollowers($followee_username);

          //If the user is logged in..
          if(isset($_SESSION['username'])) {
            //and the user is looking at someone elses profile. Then we don't want them
            //to see the edit page option. And we want to populate the data from the other user's
            //account in the database. Also show follow button.
            if($followee_username != $_SESSION['username']) {

            ?>

                <p><b>Username:</b> <?php  
                        echo $followee_username; 
                ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

            <?php
                //Toggle between the follow or unfollw button.
                if(!$thisUser->isFollowing($followee->get('id'))) {
                  echo  ' <button class="btn btn-info btn-sm followUser" data-user-id="'.$followee->get('id').'">
                          <span class="glyphicon glyphicon-plus" ></span> Follow 
                          </button>';
                }
                else {
                  echo  ' <button class="btn btn-info btn-sm unfollowUser" data-user-id="'.$followee->get('id').'">
                          <span class="glyphicon glyphicon-plus" ></span> Unfollow 
                          </button>';
                }

            ?>
                </p>


                <p><b>Name:</b> <?php  
                      echo $followee->get('Name'); 
                ?></p>
        
                <p><b>Birthday:</b> <?php  
                      echo $followee->get('Birthday'); 
                ?> </p>
        
                <p><b>Enlightenment Points:</b> <?php  
                      echo $followee->get('EnlightenedPoints'); 
                ?></p>
        
                <p><b>Bio:</b> <?php  
                      echo $followee->get('About_Me'); 
                ?> </p>
        
                <p><b>Following:</b></p></div><br>

                <?php
                //Get the list of people this user is following, and print out their names.
                  if(count($followers_for_followee) > 0) {
                    
                  echo '<ul>';

                   foreach($followers_for_followee as $e) {
     
                      echo '<li>'.formatFollower($e).'</li>'; //formatFollower makes it so there are links to users
                    }

                  echo '</ul>';
                  }

                  ?>
            
            <?php
            }
            //This part for is if you are logged in looking at your own page:
            //--Show edit page option
            //--Populate with current user data
            //--Show Activity Feed for current user via button
            else {
            ?>
              <p><b>Username:</b> <?php  
                      echo $thisUser->get('Username'); 
              ?></p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

              <a href=<?php 
                      echo "/profile/" . ($_SESSION['username']) . "/edit/";
                      ?>>Edit Page</a>

              <p><b>Name:</b> <?php  
                      echo $thisUser->get('Name'); 
              ?></p>
        
              <p><b>Birthday:</b> <?php  
                      echo $thisUser->get('Birthday'); 
              ?> </p>
        
              <p><b>Joined:</b> February 1, 2016</p>
        
              <p><b>Enlightenment Points:</b> <?php  
                      echo $thisUser->get('EnlightenedPoints'); 
                ?></p>
        
              <p><b>Bio:</b> <?php  
                      echo $thisUser->get('About_Me'); 
                ?> </p>
        
              <p><b>Following:</b></p></div><br>



                  <?php
                  if(count($followers) > 0) {
                    
                  echo '<ul>';

                   foreach($followers as $e) {
     
                      echo '<li>'.formatFollower($e).'</li>';
                    }

                  echo '</ul>';
                  }

                  ?>


            <?php
            }
          } 
          //I am not logged in so I am just a guest user creeping on randos.
          //See everything as a logged in user looking at someone else's page
          // except for the follow button.
          else {
          ?>
               <p><b>Username:</b> <?php  
                        echo $followee_username; 
                ?></p>

                <p><b>Name:</b> <?php  
                      echo $followee->get('Name'); 
                ?></p>
        
                <p><b>Birthday:</b> <?php  
                      echo $followee->get('Birthday'); 
                ?> </p>
        
                <p><b>Joined:</b> February 1, 2016</p>
        
                <p><b>Enlightenment Points:</b> <?php  
                      echo $followee->get('EnlightenedPoints'); 
                ?></p>
        
                <p><b>Bio:</b> <?php  
                      echo $followee->get('About_Me'); 
                ?> </p>
        
                <p><b>Following:</b></p>

                  <?php
                  //Get the list of people this user is following, and print out their names.
                  if(count($followers_for_followee) > 0) {
                    
                  echo '<ul>';

                   foreach($followers_for_followee as $e) {
     
                      echo '<li>'.formatFollower($e).'</li>';
                    }

                  echo '</ul>';
                  }

                  ?>
       




              </div><br>
          <?php
          }
          ?>


<br></br><br></br>

<br></br>
<br></br>
<br></br>

<?php
//This part is to get the account info of the profile you are looking at.
  $followee_username = str_replace("/profile/", "", $_SERVER['REQUEST_URI']);
  $followee = AppUser::loadByUsername($followee_username);
  //Only let a user see activity info if it's their own profile page.
  if (isset($_SESSION['username']) && $_SESSION['username'] == $followee_username)
  {
  ?>
      <div class="userActivity">
      <a href="#demo" class="btn btn-info" data-toggle="collapse">Activity</a>
        <div id="demo" class="collapse">
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






        </div>
      </div>
<?php 
  } 
?>

<script>
//collpases and hides the activity feed.
$(document).on('click',function(){
$('.collapse').collapse('hide');
})
</script> 


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