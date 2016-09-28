<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

$ac = new QuizController();
$ac->redirect($action);

$db = db::instance();

/**
*	Controls the aQuiz
*/
class QuizController{

	// Redirect to the appropriate action or page
	function redirect($action)
	{
		switch($action)
		{
			// Create a new quiz
			case 'create':
				$this->editor();
				break;

			// Delete an quiz
			case 'delete':
				$this->editor();
				break;

			// Edit an existing quiz
			case 'edit':
				$this->editor();
				break;

			// Used for submitting a query from the previous 3 options
			case 'submit':
				$this->submitToDB();
				break;
		}

	}

	// Redirect to quizEditer
	function editor()
	{
		$action = $_GET['action'];
		// will determine page content from within
		include_once SYSTEM_PATH.'/view/quizEditor.tpl';
	}

	// Submit changes to Database
	function submitToDB()
	{
		$action;
		// All of these are just to choose the appropriate action based on the POST variables recieved
		if(isset($_POST['c1']) && isset($_POST['c2']) && isset($_POST['c3']) && isset($_POST['c4']) 
			&& isset($_POST['question']) && isset($_POST['quiz#']) && isset($_POST['correct']) && isset($_POST['response']))
		{
			// Create Quiz
			$action = 'create';
		}
		else if(isset($_POST['newQuestion']) && isset($_POST['quiz#']))
		{
			// Edit the quiz already existed
			$action = 'edit';
		}
		else if(isset($_POST['quiz#']))
		{
			// Delete the quiz
			$action = 'delete';
		}
		else
		{
			echo "ERROR";
		}

		include_once SYSTEM_PATH. '/view/quizEditor.tpl';

		// Do the action
		switch($action)
		{
			case 'create':
				// Create new quiz.class
				quizOps::createQuiz($_POST['quiz#'], $_POST['question'], $_POST['c1'], $_POST['c2'], $_POST['c3'], $_POST['c4'], $_POST['correct'], $_POST['response']);

				// Create new Notification 'quiz_created' 
				$logEvent = new Notification(array(
				'ActionID' => NotificationType::getIdByName('quiz_created'),
				'User1' => 1,
				'Quiz_1' => $_POST['quiz#']
				));
				
				// Save in Database				 
				$logEvent->save();				
				echo 'Success!';
				break;

			case 'delete':
				// Delete the quiz that already existed
				quizOps::deleteQuiz($_POST['quiz#']);
				Notification::deleteNotificationByQuiz($_POST['quiz#']);
				echo 'Success!';
				break;

			case 'edit':
				// Edit the quiz by modifyQuiz
				quizOps::modifyQuiz($_POST['quiz#'], $_POST['newQuestion'], $_POST['newC1'], $_POST['newC2'], $_POST['newC3'], 
					$_POST['newC4'], $_POST['newCorrect'], $_POST['newResponse']);
				
				echo 'Success!';
				break;
		}
	}
}