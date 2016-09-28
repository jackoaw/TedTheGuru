<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];
// instantiate a SiteController and route it
$sc = new ProfileController();
$sc->route($action);

class ProfileController {

	// Redirect to the appropriate action or page
	public function route($action) {
		switch($action) {
			// Viewing specific profile
			case 'editName':
				$this->edit($action);
				break;


			// Edit the profile
			case 'editAbout':
				$this->edit($action);
				break;		
			
			// Edit the birthday
			// non-text field
			case 'editBirthday':
				$this->edit($action);
				break;
			

			default :
				$this->edit($action);
			}

	}

	// Edit the User information
	function edit($action)
	{	
		// AppUser class
		$thisUser = AppUser::loadByUsername($_SESSION['username']);
		switch($action)
		{
			case 'editName':
				// Edit the username in User talbe
				userOp::modifyName($thisUser->get('id'), $_POST['myName1']);

				header('Location:' .BASE_URL . 'profile/' .$_SESSION['username'] );
				include_once SYSTEM_PATH.'/view/profile.tpl';
				echo 'Success!';
				break;

			case 'editBirthday':
				// Edit the birthday 
				userOp::modifyBirthday($thisUser->get('id'), $_POST['profile-birthMonth'], $_POST['profile-birthDay'], $_POST['profile-birthYear']);

				header('Location:' .BASE_URL . 'profile/' .$_SESSION['username'] );
				include_once SYSTEM_PATH.'/view/profile.tpl';
				echo 'Success!';
				break;

			case 'editAbout':
				// Edit the "aboutMe" text area
				userOp::modifyAboutMe($thisUser->get('id'), $_POST['aboutMe1']);

				header('Location:' .BASE_URL . 'profile/' .$_SESSION['username'] );
				include_once SYSTEM_PATH.'/view/profile.tpl';
				break;

			case 'editPassword':
				// Change the password
				userOp::modifyPassword($thisUser->get('id'), $_POST['myPassword1']);
				header('Location:' .BASE_URL . 'profile/' .$_SESSION['username'] );
				include_once SYSTEM_PATH.'/view/profile.tpl';
				break;
		}
	}


	

}
