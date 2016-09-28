<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title> You are feeling enlightened </title>

<script src="<?= BASE_URL ?>/public/js/jquery-2.2.0.min.js"></script>
<script src="<?= BASE_URL ?>public/js/script.js"></script>

<script>
//   $(document).ready(function() {
//     $('.startsDisabled').keyup(function() {

//         var empty = false;
//         $('.startsDisabled').each(function() {
//             if ($(this).val().length == 0) {
//                 empty = true;
//             }
//         });

//         if (empty) {
//             $('.startsDisabled').attr('disabled', 'disabled');
//         } else {
//             $('.startsDisabled').removeAttr('disabled');
//         }
//     });
// });

  // checks to make sure the field is all numerical characters for Day an Year
  function checkAllNums(str)
  {
    var xhttp;

    var isnum = /^\d+$/.test(str);
    var nothing = /^$/.test(str);
    if (!isnum && !nothing) { 
      document.getElementById("txtHint").innerHTML = "Day and Year only accept numerical characters";
      return;
    }
    else{
      document.getElementById("txtHint").innerHTML = "";
      return;
    }
      xhttp.send();   
  }

  // checks to make sure that the field is not blank for password submission
  function checkNotBlank(str)
  {
    var nothing = /^$/.test(str);
    if (nothing) {
      $('#submit-password').attr('disabled', 'disabled'); 
      window.alert("Field cannot be blank");
    }
    else {
       $('#submit-password').removeAttr('disabled');
    }
  }
  // checks to make sure that the field is not blank for Name SUbmission
  function checkNotBlankName(str)
  {
    var nothing = /^$/.test(str);
    if (nothing) {
      $('#submit-name').attr('disabled', 'disabled'); 
      window.alert("Field cannot be blank");
    }
    else {
       $('#submit-name').removeAttr('disabled');
    }
  }

  // Make sure the birthday fields are not empty, method exists due to naming error
  function checkBirthday()
  {
    var value1 = /^$/.test(document.getElementById("write-day").value);
    var value2 = /^$/.test(document.getElementById("write-year").value);
    if(value1 || value2)
      window.alert("Field cannot be blank");
  }
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
      </nav><br><br>
      
        <center>
        <img id="pic" class="pull-left" style="" width="50%" height="400" src="<?= BASE_URL ?>/public/local/ted.jpg" />
        <div id="profile">

        <!-- Populate data with the current user's username -->
        <p><b>Username:</b> <?php 
                      echo $thisUser->get('Username'); 
              ?></p>

        <!-- We have separate input forms for everything you can edit on the page, this way you can update just one thing at a time.  -->     
        <p><b>Password:</b>  
                     <form name="myPassword" id="myPassword" method="POST" action="<?= BASE_URL ?>edit/password">

                      <input type="password" name="myPassword1" onclick="checkNotBlank(myPassword1.value)" onkeyup="checkNotBlank(myPassword1.value)">
                      <input type="submit" id="submit-password" name="submit-password" value="Change Password"> 
                    </form>
                    </p> 
             <!--  Edit Name -->
              <p><b>Name:</b> 
                      <form name="myName" id="myName" method="POST" action="<?= BASE_URL ?>edit/name">

                      <input type="text" name="myName1" onclick="checkNotBlankName(myName1.value)" onkeyup="checkNotBlankName(myName1.value)" placeholder=<?php echo $thisUser->get('Name')?> >
                      <input type="submit" id="submit-name" name="submit-name" value="Edit Name">

                      </form> 
              </p>
              <!--  Edit Birthday -->
              <p>
              <form method="POST" action="<?= BASE_URL ?>edit/birthday" id="myBirthday">
                <fieldset id="profile-birthday-field">
                  <label id="profile-month-label" class="month">
                    <Strong>Birthday</Strong>
                    <select name="profile-birthMonth" id="profile-month-select" onchange="" size="1">
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
            
                  <label id="profile-day-label" class="day">
                    <!-- <strong>Day</strong> -->
                    <input type="text" id="write-day" name="profile-birthDay" size="3" placeholder="Day" onkeyup="checkAllNums(this.value)">
                  </label>
                  
                  
                  <label id="profile-year-label" class="year">
                    <!-- <strong>Year</strong> -->
                    <input type="text" id="write-year" name="profile-birthYear" size="5" placeholder="Year" onkeyup="checkAllNums(this.value)">
                  </label>
            
                  <input type="submit" name="submit-birthday" value="Edit Birthday">
                </fieldset>
              </form>
              </p>
              <span id="txtHint"></span>
              <!--  Edit Bio -->
              <p><b>Bio:</b> 
                <form name="aboutMe" id="aboutMe" method="POST" action="<?= BASE_URL ?>edit/about">

                <textarea id="aboutMe1" name="aboutMe1" placeholder= <?php echo $thisUser->get('About_Me')?> > </textarea> 
                <input type="submit" id="submit-aboutMe" name="submit-aboutMe" value="Edit About Me" >

                </form>
              </p>
        


</div><br><br>
<!--  Option to delete your account -->
  <form name="deleteMe" id="deleteMe" method="POST" action="<?= BASE_URL ?>edit/delete">
      <input type="submit" onclick="return confirm('Are you sure?')" name="submit-delete" value="Delete Account">
      <p>*Note: You will lose all progress towards enlightenment.</p>

  </form>

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