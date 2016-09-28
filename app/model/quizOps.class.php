<?php
	class quizOps
	{
		// Return the latest quiz, the one that shows on the front page
		public function getLatestQuiz()
		{
			$db = db::instance();
			$max = $db->maxColumn('quizes', 'Num');
			$max = $max->fetch_assoc();
			$quiz = $db->fetchByNum($max['maxNumber'], 'quizes' );
			return $quiz;
		}

		// Returns a specific quiz based on the given id
		public function getQuizByID($id)
		{
			$db = db::instance();
		    $obj = $db->fetchByNum($id, 'quizes');

		    if($obj != NULL)
		    {
		    	return $obj->fetch_assoc();
		    }
		    else
		    {
		    	return NULL;
		    }
		}

		// Based on the given ID it will delete the associated Quiz
		public function deleteQuiz($Num)
		{
			$db = db::instance();
			$db->removeByNum('quizes', $Num);
		}

		// Based on the given ID and new content it will modify the associated Quiz
		public function modifyQuiz($Num, $newQuestion, $c1, $c2, $c3, $c4, $correct, $response)
		{
			$db = db::instance();
			$db->modifyQuizByNum('quizes', $Num, $newQuestion, $c1, $c2, $c3, $c4, $correct, $response);
		}

		// Create a new Quiz with the given parameters
		public function createQuiz($Num, $question, $c1, $c2, $c3, $c4, $correct, $response)
		{
			$db = db::instance();
			// Query directly done here
			$query = sprintf("INSERT INTO quizes (Num, Question, Choice1, Choice2, Choice3, Choice4, DatePosted, Correct, CorrectResponse) 
			VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $Num, $question, $c1, $c2, $c3, $c4, TODAYS_DATE , $correct, $response);
			$db->lookup($query);
		}
	}
?>