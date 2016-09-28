<?php

	// Operations for quotes object 
	class quoteOps
	{
		// Return the latest quote, the one that shows on the front page
		public function getLatestQuote()
		{
			$db = db::instance();
			$max = $db->maxColumn('quotes', 'Num');
			$max = $max->fetch_assoc();
			$quote = $db->fetchByNum($max['maxNumber'], 'quotes');
			return $quote;
		}

		// Returns a specific quote based on the given id
		public function getQuoteByID($id)
		{
			$db = db::instance();
		    $obj = $db->fetchByNum($id, 'quotes');
		    if ($obj != NULL)
		    {
		    	return $obj->fetch_assoc();
			}
			else
			{
				return NULL;
			}
		}
	
		// Based on the given ID it will delete the associated article
		public function deleteQuote($Num)
		{
			$db = db::instance();
			$db->removeByNum('quotes', $Num);
		}

		// Based on the given ID and new content it will modify the associated article
		public function modifyQuote($Num, $newContent)
		{
			$db = db::instance();
			$db->modifyQuoteByNum('quotes', $Num, $newContent);
		}

		// Create a new quote with the given parameters
		public function createQuote($Num, $content)
		{
			$db = db::instance();
			// Query directly done here
			$query = sprintf("INSERT INTO quotes (Num, Quote, DatePosted) 
			VALUES ('%s', '%s', '%s')", $Num, $content, TODAYS_DATE);
			$db->lookup($query);
		}
	}
?>