<?php
	// List class used for list all classes
	class lister
	{
		// Use to help gather lists for overview.tpl
		function listall($table)
		{
			$db = db::instance();
			$result;
			$query = "SELECT * FROM ".$table." ORDER BY Num DESC";
			$result = $db->lookup($query);

			// Make sure the results don't suck
	        if(!mysqli_num_rows($result))
	        {
	            return null;
	        }
	        //return the list
			return $result;
		}
	}

?>