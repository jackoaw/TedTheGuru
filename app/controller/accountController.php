<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];
// instantiate a SiteController and route it
$sc = new AccountController();
$sc->route($action);

class AccountController {

	// Redirect to the appropriate action or page
	public function route($action) {
		switch($action) {
			case 'editPrivileges':
				$this->editor();
				break;
			case 'deleteAccount':
				$this->editor();
				break;
			case 'submit':
				$this->submitToDB();
				break;
			}

	}

	function editor()
	{
		$action = $_GET['action'];
		// will determine page content from within
		include_once SYSTEM_PATH.'/view/accountEditor.tpl';
	}

	function submitToDB()
	{	
		$action;
		if(isset($_POST['user-privileges']) && isset($_POST['user#']))
		{
			$action = 'editPrivileges';
		}
		else if(isset($_POST['user#']))
		{
			$action = 'deleteAccount';
		}
		else
		{
			echo "ERROR";
		}
		include_once SYSTEM_PATH. '/view/accountEditor.tpl';

		switch($action)
		{
			case 'editPrivileges':
				userOp::modifyAdmin($_POST['user#'], $_POST['user-privileges']);
				echo 'Success!';
				break;
			case 'deleteAccount':
				userOp::deleteAccount($_POST['user#']);
				echo 'Success!';
				break;
		}
	}


	

}
