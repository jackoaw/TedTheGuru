<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];
// instantiate a SiteController and route it
$sc = new SiteController();
$sc->route($action);

class SiteController {

	// Redirect to the appropriate action or page
	public function route($action) {
		switch($action) {
			case 'home':
				$this->home();
				break;

			case 'about':
				$this->about();
				break;

			// Handler for all things quiz related
			case 'quizes':
				$all = $_GET['all'];
				// If you are gathering a quiz
				if($all == 'no')
					
					if(isset($_GET['quizID']))
					{
						// Makes sure you aren't requesting a quiz that doesn't exist
						if($_GET['quizID'] > db::getMaxNum('quizes') )
						{
							
							include_once SYSTEM_PATH."/view/home.tpl";
							die('Invalid access');
						}

						else
							$this->viewQuiz($_GET['quizID']);
					}
					// The latest quiz
					else
					{
						$this->quizes();
					}
				// list view for all quizes
				else
					$this->viewAll();
				break;

			// Handler for all things quote related
			case 'quotes':
				$all = $_GET['all'];
				// If you are gathering a quote
				if($all == 'no')
					// A SPECIFIC quote
					if(isset($_GET['quoteID']))
					{
						// Makes sure you aren't requesting a quote that doesn't exist
						if($_GET['quoteID'] > db::getMaxNum('quotes') )
						{

							include_once SYSTEM_PATH."/view/home.tpl";
							die('Invalid access');
						}
						else
							$this->viewQuote($_GET['quoteID']);
					}
					// The latest quote
					else
					{
						$this->quotes();
					}
				// list view for all quotes
				else
					$this->viewAll();
				break;

			// Redirect to LogIn page
			case 'login':
				$this->login();
				break;
			// Redirect to Singup page
			case 'signup':
				$this->signup();
				break;
			// displays same page as login, different content
			case 'validate':
				$this->validate();
				break;

			// Check if the User is signed up
			case 'signupCheck': 
				$this->signupCheck();
				break;

			// Terminate and reset the $_SESSION['Username']
			case 'logout':
				$this->logout();
				break;

			//Redirect to info 
			case 'info':
				$this->info();
				break;

			//View own Profile of user
			case 'viewProfile':
				$this->profile();
				break;

			// Modify user's infromation
			case 'editProfile':
				$this->editProfile();

			// Follower/Follower 
			case 'follow':
				$this->followUser();
				break;

			// Unfollow other users by click button "Unfollow"
			case 'unfollow':
				$this->unfollowUser();
				break;
		}

	}

	// home page, or bio page
    function home() {
    	$pageTitle = 'Home';
    	$pageContent = 'Welcome to my blog! Hope you enjoy it.';

    	//Get Notification from database
    	$notifications = Notification::getAllNotifications();
		include_once SYSTEM_PATH.'/model/notificationhelper.php';
		include_once SYSTEM_PATH.'/view/home.tpl';
    }

    // about page
     function about() {
    	$pageTitle = 'About';
		include_once SYSTEM_PATH.'/view/about.tpl';
    }

    // Quiz page
    function quizes() {
    	//Get existing quizes
    	$quiz = quizOps::getLatestQuiz()->fetch_assoc();
		include_once SYSTEM_PATH.'/view/EducateYourself.tpl';
    }

    // Quotes page
    function quotes()
    {
    	// Get existing quotes
    	$quote = quoteOps::getLatestQuote()->fetch_assoc();
    	include_once SYSTEM_PATH.'/view/DailyQuote.tpl';
    }

    // Profile page
    function profile() {
    	$thisUser;
    	$notifications;
    	$followers;

    	// When user is already logged in
    	if(isset($_SESSION['username'])) 
    	{
    		//Get userName of logged in User
    		$thisUser = AppUser::loadByUsername($_SESSION['username']);
    		//Get own Notification
    		$notifications = Notification::getMyNotifications();
    		//See the profile/username of app user
   			$followers = AppUser::getMyFollowers($_SESSION['username']);
    	}

    	include_once SYSTEM_PATH.'/model/notificationhelper.php';
    	include_once SYSTEM_PATH.'/view/profile.tpl';
    }

    // Edit own profile
    function editProfile() 
    {
    	// When user is already logged in
    	if(isset($_SESSION['username'])) 
    	{
        		$thisUser = AppUser::loadByUsername($_SESSION['username']);
    	}
    	include_once SYSTEM_PATH.'/view/profileEdit.tpl';
    }

    // Quote page, with specified quote
	function viewQuote($id)
	{
		$quote = quoteOps::getQuoteById($id);
		include_once SYSTEM_PATH.'/view/DailyQuote.tpl';
	}

	// Quiz page, with specified quiz
	function viewQuiz($id)
	{
		$quiz = quizOps::getQuizById($id);
		include_once SYSTEM_PATH.'/view/EducateYourself.tpl';
	}

	// Login page
	public function login() 
	{
		include_once SYSTEM_PATH.'/view/login.tpl';
	}

	//Sign up page
	public function signup() {
			include_once SYSTEM_PATH.'/view/signup.tpl';
	}


	// Validateion process for logging in
	public function validate()
	{
		if(isset($_POST['uname']) && isset($_POST['pw'])) { 
    		$username = $_POST['uname'];
			$passwd = $_POST['pw'];

			$db = db::instance();

			$sql = "SELECT * FROM users WHERE Username='$username'";
			$result=$db->lookup($sql);

			// If result matched $username and $password, table row must be 1 row
			if($result->num_rows==1){
   			 	$row = $result->fetch_assoc();
    			if ($passwd == $row['Password']){
        			$_SESSION['username'] = $username;
        			$_SESSION['admin'] = $row['Admin'];
					$_SESSION['error'] = "You are logged in as ".$username.".";
    			}
    			else {
    	    		$_SESSION['error'] = "Incorrect password.";
    			}
			}
			else{
    			$_SESSION['error'] = "Username does not exist";
			}
			include_once SYSTEM_PATH.'/view/login.tpl';
		}
	}


	// Logout of current account and start new session, as if you reached the page for the first time again
	public function logout() 
	{

			// erase the session
			unset($_SESSION['username']);
			session_destroy(); // for good measure

			// redirect to home page
			header('Location: '.BASE_URL);
			session_start();
	}

	// View all of either the quizes or quotes
	public function viewAll()
	{
		$result = lister::listall($_GET['action']);
		$output = $_GET['action'];
		include_once SYSTEM_PATH.'/view/overview.tpl';
	}

	// Info page
	public function info() 
	{
		include_once SYSTEM_PATH.'/view/info.tpl';
	}


	// Chekc if user is already singed up or not
	public function signupCheck() 
	{
		// set the header to hint the response type (JSON) for JQuery's Ajax method
		header('Content-Type: application/json'); 
			
		// get the username data
		$username = $_GET['meep']; 

		// make sure it's a real username
		if(is_null($username) || $username == '') 
		{
			echo json_encode(array('error' => 'Invalid username.'));
		}
		// username is not valid
		else 
		{

			//Set default username
			$user = "root";
			$password = DB_PASS;
			$db = "tedsdb"; 

			//connection to the database
			$db = new mysqli("127.0.0.1", $user, $password, $db) or die("unable to connect");
			$sql= sprintf("SELECT * FROM users WHERE Username='%s'", $username);
			$result=$db->query($sql);

			// If result matched $username
			if($result->num_rows==1)
			{
				echo json_encode(array(
						'success' => 'success',
						'check' => 'unavailable'
						));
			}
			// result is not mached 
			else 
			{
				// Send it to database
				echo json_encode(array(
				'success' => 'success',
				'check' => 'available'
				));
			}
				
		}
	}

	// Find the user who is following current user
	public function followUser() {
				
		$userID = null;
		
		// If 'userID' session is not null
		if(isset($_POST['userID']))
		{
			//set it to $userID variable
			$userID = $_POST['userID']; // get the username data
		}		
				

		// make sure it's a real username
		if(is_null($userID) || $userID == '') 
		{
			echo 'Invalid user ID.';
		}
		// if user name is not valid
		else 
		{
			$user = AppUser::loadByID($userID);
			// if user is exis
			if(!is_null($user)) 
			{
				// get userID of follower (logged-in user)
				$follower = AppUser::loadByUsername($_SESSION['username']);
				$followerID = $follower->get('id');

				// When the User already follwoed the other user
				if(Follow::areFollowing($followerID, $userID)) 
				{
					echo 'You are already following this user.';
				}
				else 
				{
					// save the follow connection
					$follow = new Follow(array(
					'Follower' => $followerID,
					'Followee' => $userID
					));

					// Send it to the daatabase
					$follow->save();

					echo 'success';
				}
			}
			//When user who has that user name does not exist
			else 
			{
				echo 'that user does not exist';
			}
		}
	}

	// Unfollow the currently following users
	public function unfollowUser() {
	
		$userID = null;

		// When user is already logged in
		if(isset($_POST['userID']))
		{
			$userID = $_POST['userID']; // get the username data
		}	

		// make sure it's a real username
		if(is_null($userID) || $userID == '') 
		{
				echo 'Invalid user ID.';
		}
		else
		{
			$user = AppUser::loadByID($userID);
			// If user exist
			if (!is_null($user)) 
			{
				// get userID of follower (logged-in user)
				$follower = AppUser::loadByUsername($_SESSION['username']);
				$followerID = $follower->get('id');

				// If user is already following the target user
				if (Follow::areFollowing($followerID, $userID)) 
				{
					// Unfollow the user
					if (Follow::unfollow($followerID, $userID)) 
					{
							echo 'success';
					}	
				}
			}
			//WHen user does not exist
			else 
			{
				echo 'that user does not exist';
			}
		}
	}

}
