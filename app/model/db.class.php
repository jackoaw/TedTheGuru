<?php

// Represents a Database with associated methods
class db {
    private static $_instance = null;
    // connection
    private $conn;

    // Construct the database class
	private function __construct() 
	{
		$host     = DB_HOST;
		$database = DB_DATABASE;
		$username = DB_USER;
		$password = DB_PASS;

		$this->conn = mysqli_connect($host, $username, $password, $database)
			or die ('Error: Could not connect to MySql database');

	}

	// Return an instance of this Database
	public static function instance() {
		if (self::$_instance === null) {
			self::$_instance = new Db();
		}
		return self::$_instance;
	}

	//Query the database for information
	public function lookup($query) {
		$result = mysqli_query($this->conn, $query);
		if(!$result)
		{
			die('Invalid query: ' . $query);
		}
		return ($result);
	}

	// Fetch information from a given $db_table with the $id, as all tables in tedsdb have it
    public function fetchByNum($id, $db_table) {
		if ($id === null) {
			return null;
		}

		$query = sprintf("SELECT * FROM `%s` WHERE Num = '%s';",
				$db_table,
				$id
			     );
		//echo $query;
		$result = $this->lookup($query);

		if(!mysqli_num_rows($result)) {
			return null;
		} else {
			return $result;
		}
	}

	public function fetchByNum2($id, $class_name, $db_table) {
		if ($id === null) {
			return null;
		}

		$query = sprintf("SELECT * FROM `%s` WHERE Num = '%s';",
				$db_table,
				$id
			     );
		//echo $query;
		$result = $this->lookup($query);

		if(!mysqli_num_rows($result)) {
			return null;
		} else {
			$row = mysqli_fetch_assoc($result);
			$obj = new $class_name($row);
			return $obj;
		}
	}

	public function fetchById($id, $class_name, $db_table) {
		if ($id === null) {
			return null;
		}

		$query = sprintf("SELECT * FROM `%s` WHERE id = '%s';",
				$db_table,
				$id
			     );
		//echo $query;
		$result = $this->lookup($query);

		if(!mysqli_num_rows($result)) {
			return null;
		} else {
			$row = mysqli_fetch_assoc($result);
			$obj = new $class_name($row);
			return $obj;
		}
	}

	public function fetchByIdForFollower($id, $class_name, $db_table) {
		if ($id === null) {
			return null;
		}

		$query = sprintf("SELECT * FROM follow WHERE Follower = '%d';",
				
				$id
			     );
		//echo $query;
		$result = $this->lookup($query);

		if(!mysqli_num_rows($result)) {
			return null;
		} else {
			$row = mysqli_fetch_assoc($result);
			$obj = new $class_name($row);
			return $obj;
		}
	}

	// Returns the max number found in a column, used now for only the column Num
	public function maxColumn($table, $column)
	{
		if ($table === null || $column === null) {
			return null;
		}

		$query = sprintf("SELECT MAX(%s) AS maxNumber FROM %s ",
				$column,
				$table
			     );

		$result = $this->lookup($query);

		return $result;
	}

	// Remove from a given table, an item using a unique $Num
	public function removeByNum($table, $Num)
	{

		$query = "DELETE FROM " . $table . " WHERE Num=" . $Num;
		$result = $this->lookup($query);
		return $result;
	}

	// Remove from a given table, an item using a unique $id
	public function removeById($table, $Num)
	{

		$query = "DELETE FROM " . $table . " WHERE id=" . $Num;
		$result = $this->lookup($query);
		return $result;
	}

	// Modify in a given table, an item using a unique $Num
	// $newContent will replace the old content
	public function modifyArticleImageByNum($table, $Num, $newUrl)
	{
		$query = sprintf('UPDATE %s SET Image="%s" WHERE Num=%s',
		$table, $newUrl, $Num);
		$result = $this->lookup($query);
	}

	// Modify in a given table, an item using a unique $Num
	// $newContent will replace the old content
	public function modifyByNum($table, $Num, $newContent)
	{
		$query = sprintf('UPDATE %s SET Article="%s" WHERE Num=%s',
		$table, $newContent, $Num);
		$result = $this->lookup($query);
	}

	public function modifyArticleTitleByNum($table, $Num, $newContent)
	{
		$query = sprintf('UPDATE %s SET Title="%s" WHERE Num=%s',
		$table, $newContent, $Num);
		$result = $this->lookup($query);
	}


	//modify quote by number
	public function modifyQuoteByNum($table, $Num, $newContent)
	{
		$query = sprintf('UPDATE %s SET Quote="%s" WHERE Num=%s',
		$table, $newContent, $Num);
		$result = $this->lookup($query);
	}

	//modify quiz by number
	public function modifyQuizByNum($table, $Num, $newQuestion, $newC1, $newC2, $newC3, $newC4, $newCorrect, $newResponse)
	{
		$query = sprintf('UPDATE %s SET Question="%s", Choice1="%s", Choice2="%s", Choice3="%s", Choice4="%s", Correct="%s", CorrectResponse="%s" WHERE Num=%s',
		$table, $newQuestion, $newC1, $newC2, $newC3, $newC4, $newCorrect, $newResponse, $Num);
		$result = $this->lookup($query);
	}

	//modify user's name by id
    public function modifyUserNameByNum($table, $Num, $newContent)
    {
        $query = sprintf('UPDATE %s SET Name="%s" WHERE id=%s',
        $table, $newContent, $Num);
        $result = $this->lookup($query);
    }

    //modify user's password by id
    public function modifyUserPasswordByNum($table, $Num, $newContent)
    {
        $query = sprintf('UPDATE %s SET Password="%s" WHERE id=%s',
        $table, $newContent, $Num);
        $result = $this->lookup($query);
    }

    //modify user's birthday by id
    public function modifyUserBirthdayByNum($table, $Num, $date)
    {
        $query = sprintf('UPDATE %s SET Birthday="%s" WHERE id=%s',
        $table, $date, $Num);
        $result = $this->lookup($query);
    }

    //modify user's bio by id
    public function modifyUserAboutMeByNum($table, $Num, $newContent)
    {
        $query = sprintf('UPDATE %s SET About_Me="%s" WHERE id=%s',
        $table, $newContent, $Num);
        $result = $this->lookup($query);
    }

    //modify user's admin privilege by id
    public function modifyUserAdminByNum($table, $Num, $adminBoolean)
    {
        $query = sprintf('UPDATE %s SET Admin="%s" WHERE id=%s',
        $table, $adminBoolean, $Num);
        $result = $this->lookup($query);
    }


	// gets the maximum Num value from the num column in a given table
	public function getMaxNum($table)
	{
		$db = db::instance();
		$obj = $db->maxColumn($table, 'Num');
		return $obj->fetch_assoc()['maxNumber'];
	}

	public function store(&$obj, $class_name, $db_table, $data)
	{
		// find out if this item already exists so we know to use INSERT or UPDATE
		if($obj->getId() === null) {
			// ID would only be null for a new item, so let's use INSERT
			$query = $this->buildInsertQuery($db_table, $data);
			//echo $query;
			$this->execute($query); // execute the query we've built
			$obj->setId($this->getLastInsertID()); //get back the ID for the new item
		} else {
			// item ID exists, so let's use UPDATE
			// only hit the database if the instance has been modified
			if($obj->getModified()) {
				$query = $this->buildUpdateQuery($db_table, $data, $obj->getId());
				//echo $query;
				$this->execute($query); // execute the query we've built
			}
		}
		//echo $query; // print the query
		$obj->setModified(false); // reset the flag
	}

	public function storeFollow(&$obj, $class_name, $db_table, $data)
	{
		// find out if this item already exists so we know to use INSERT or UPDATE
		if($obj->getNum() === null) {
			// ID would only be null for a new item, so let's use INSERT
			$query = $this->buildInsertQuery($db_table, $data);
			//echo $query;
			$this->execute($query); // execute the query we've built
			$obj->setId($this->getLastInsertID()); //get back the ID for the new item
		} else {
			// item ID exists, so let's use UPDATE
			// only hit the database if the instance has been modified
			if($obj->getModified()) {
				$query = $this->buildUpdateQuery($db_table, $data, $obj->getNum());
				//echo $query;
				$this->execute($query); // execute the query we've built
			}
		}
		//echo $query; // print the query
		$obj->setModified(false); // reset the flag
	}

	// Formats a string for use in SQL queries.
	// Use this on ANY string that comes from external sources (i.e. the user).
	public function quoteString($s) {
		return "'" . mysqli_real_escape_string($this->conn, $s) . "'";
	}

	// Formats a date (i.e. UNIX timestamp) for use in SQL queries.
	public function quoteDate($d) {
		return date("'Y-m-d H:i:s'", $d);
	}

	//Execute operations like UPDATE or INSERT
	public function execute($query) {
		$ex = mysqli_query($this->conn, $query);
		if(!$ex)
			die ('Query failed:' . mysqli_error($this->conn));
	}

	//Build an INSERT query.  Mostly here to make things neater elsewhere.
	//$table  -> Name of the table to insert into
	//$fields -> List of attributes to populate
	//$values -> Values that will populate the new row
	//RETURN  -> A mysql insert query in the form of:
	//					 "INSERT INTO <table> (<fields>) VALUES (<values>)"
	//NOTE: This function DOES NOT actually EXECUTE the query, only gives a
	//			string to be used elsewhere.
	public function buildInsertQuery($table = '', $data = array()) {
		$fields = '';
		$values = '';

		foreach ($data as $field => $value) {
			if($value !== null) { // skip unset fields
				$fields .= "`".$field . "`, ";
				$values .= $this->quoteString($value) . ", ";
			}
		}

		 // cut off the last ', ' for each
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -2);

		$query = sprintf("INSERT INTO `%s` (%s) VALUES (%s);",
				$table,
				$fields,
				$values
			     );

		return ($query);
	}

	public function buildUpdateQuery($table = '', $data = array(), $id=0) {
		$all_null = true;
		$query = "UPDATE `" . $table . "` SET `";

		foreach ($data as $field => $value) {
			if($value === null) {
				$query .= $field . "` = NULL, `";
        } else {
				$query .= $field . "` = " . $this->quoteString($value) . ", `";
				$all_null = false;
			}
		}

		$query = substr($query, 0, -3); // cut off the last ', `'
		$query .= " WHERE id = '" . $id . "';";

		// only return a real query if there's something to update
		if($all_null)
			return '';
		else
			return ($query);
	}

	//Get the ID of the last row inserted into the database.  Useful for getting
	//the id of a new object inserted using AUTO_INCREMENT in the db.
	//RETURN -> The ID of the last inserted row
	public function getLastInsertID() {
		$query = "SELECT LAST_INSERT_ID() AS id";
		$result = mysqli_query($this->conn, $query);
		if(!$result)
			die('Invalid query.');

		$row = mysqli_fetch_assoc($result);
		return ($row['id']);
	}

		public function nextColumn($table, $column, $currentNum)
	{
		if ($table === null || $column === null) {
			return null;
		}

		$query = sprintf("SELECT %s FROM %s ",
				$column,
				$table
			     );

		$result = $this->lookup($query);

		if (mysqli_num_rows($result) > 0) {
    		while ($row = mysqli_fetch_assoc($result)) {
    			//If we found the current row
        		if ($row[$column] == $currentNum) {
        			//Get the next row and return it
        			$row = mysqli_fetch_assoc($result);
            		$nextcol = $row[$column]; 
            		return $nextcol;
        		}
    		}
		}

		return null;
	}

	// Returns the next number found in a column, used now for only the column Num
	public function prevColumn($table, $column, $currentNum)
	{
		if ($table === null || $column === null) {
			return null;
		}

		$query = sprintf("SELECT %s FROM %s ",
				$column,
				$table
			     );

		$result = $this->lookup($query);

		if (mysqli_num_rows($result) > 0) {
    		while ($row = mysqli_fetch_assoc($result)) {
    			//If we made it to the current column, and it is not the first column
        		if ($row[$column] == $currentNum && isset($prev)) {
        			//return the column that we last looked at
            		$prevcol = $prev[$column];
            		return $prevcol;
        		}	
        	$prev = $row;
    		}
		}

		return null;
	}

	// Returns the min number found in a column, used now for only the column Num
	public function minColumn($table, $column)
	{
		if ($table === null || $column === null) {
			return null;
		}

		$query = sprintf("SELECT MIN(%s) AS minNumber FROM %s ",
				$column,
				$table
			     );

		$result = $this->lookup($query);

		return $result;
	}



// gets the minimum Num value from the num column in a given table
	public function getMinNum($table)
	{
		$db = db::instance();
		$obj = $db->minColumn($table, 'Num');
		return $obj->fetch_assoc()['minNumber'];
	}

	// gets the next Num value from the num column in a given table
	public function getNextNum($table, $currentNum)
	{
		$db = db::instance();
		$obj = $db->nextColumn($table, 'Num', $currentNum);
		return $obj;
	}

	// gets the prev Num value from the num column in a given table
	public function getPrevNum($table, $currentNum)
	{
		$db = db::instance();
		$obj = $db->prevColumn($table, 'Num', $currentNum);
		return $obj;
	}

	// Modify in a given table, an item using a unique $Num
	// $newContent will replace the old content
	public function modifyCommentByNum($table, $Num, $newContent)
	{
		$query = sprintf('UPDATE %s SET Comment="%s" WHERE Num=%s',
		$table, $newContent, $Num);
		$result = $this->lookup($query);
	}

}