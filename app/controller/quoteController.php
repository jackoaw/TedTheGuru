<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

$ac = new QuoteController();
$ac->redirect($action);

$db = db::instance();

/**
*	Controls the quotes 
*/
class QuoteController{

	// Redirect to the appropriate action or page
	function redirect($action)
	{
		switch($action)
		{
			// Create a new quotes
			case 'create':
				$this->editor();
				break;

			// Delete an quotes
			case 'delete':
				$this->editor();
				break;

			// Edit an existing quotes
			case 'edit':
				$this->editor();
				break;

			// Used for submitting a query from the previous 3 options
			case 'submit':
				$this->submitToDB();
				break;
		}

	}

	// Ediotr page
	function editor()
	{
		$action = $_GET['action'];
		// will determine page content from within
		include_once SYSTEM_PATH.'/view/quoteEditor.tpl';
	}

	// Get action and submit to Database
	function submitToDB()
	{
		$action;
		// All of these are just to choose the appropriate action based on the POST variables recieved
		if(isset($_POST['quoteContent']) && isset($_POST['quote#']))
		{
			$action = 'create';
		}
		// When user edited the content of the existing quote
		else if(isset($_POST['newQuoteContent']) && isset($_POST['quote#']))
		{
			$action = 'edit';
		}
		// Delete the quotes based on 'Num' of quote
		else if(isset($_POST['quote#']))
		{
			$action = 'delete';
		}
		else
		{
			echo "ERROR";
		}
		include_once SYSTEM_PATH. '/view/quoteEditor.tpl';


		// Do the action
		switch($action)
		{
			case 'create':
				// Create the new quote
				quoteOps::createQuote($_POST['quote#'], $_POST['quoteContent']);

				// Create the new Notification 
				// 'quote_created' type
				$logEvent = new Notification(array(
					'ActionID' => NotificationType::getIdByName('quote_created'),
					'User1' => 1,
					'Quote_1' => $_POST['quote#']
					));

				// Save new notification into database
				$logEvent->save();

				echo 'Success!';
				break;

			case 'delete':
				// Delete the exsit quote
				quoteOps::deleteQuote($_POST['quote#']);
				Notification::deleteNotificationByQuote($_POST['quote#']);
				echo 'Success!';
				break;

			case 'edit':
				//eidt the exist quote
				quoteOps::modifyQuote($_POST['quote#'], $_POST['newQuoteContent']);
				echo 'Success!';
				break;
		}
	}
}