<?php

	class articleOp extends DbObject
	{
		// name of database table
    	const DB_TABLE = 'posts';

	    // database fields
	    protected $Num;
	    protected $Title;
	    protected $Article;
	 
	    protected $DatePosted;
	    protected $Image;

	    // constructor
	    public function __construct($args = array()) {
	        $defaultArgs = array(
	            'Num' => null,
	            'Title' => '',
	            'Article' => '',
	           
	            'DatePosted' => null,
	            'Image' =>''
	            );

	        $args += $defaultArgs;

	        $this->Num = $args['Num'];
	        $this->Title = $args['Title'];
	        $this->Article = $args['Article'];
	      
	        $this->DatePosted = $args['DatePosted'];
	        $this->Image = $args['Image'];
	    }

		// Based on the given ID it will return the associated article
		public function getArticleByID($id)
		{
			$db = db::instance();
	        $obj = $db->fetchByNum($id, 'posts' );
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
		public function deleteArticle($Num)
		{
			$db = db::instance();
			$db->removeByNum('posts', $Num);
		}

		// Based on the given ID and new content it will modify the associated article
		public function modifyArticle($Num, $newContent)
		{
			$db = db::instance();
			$db->modifyByNum('posts', $Num, $newContent);
		}

		// Create a new article with the given parameters
		public function createArticle($Num, $title, $imageURL, $content)
		{
			$db = db::instance();
			// Query directly done here
			$query = sprintf("INSERT INTO posts (Num, Title, Article, DatePosted, Image) 
			VALUES ('%s', '%s', '%s', '%s', '%s')", $Num, $title, $content, TODAYS_DATE ,$imageURL);
			$db->lookup($query);
		}

		// Based on the given ID and new title it will modify the associated article
		public function modifyArticleTitle($Num, $newTitle)
		{
			$db = db::instance();
			$db->modifyArticleTitleByNum('posts', $Num, $newTitle);
		}

		// Based on the given ID and new title it will modify the associated article
		public function modifyArticleImage($Num, $newUrl)
		{
			$db = db::instance();
			$db->modifyArticleImageByNum('posts', $Num, $newUrl);
		}

		// Modify in a given table, an item using a unique $Num
		// $newContent will replace the old content
		public function modifyArticleTitleByNum($table, $Num, $newContent)
		{
			$query = sprintf('UPDATE %s SET Title="%s" WHERE Num=%s',
			$table, $newContent, $Num);
			$result = $this->lookup($query);
		}

		public static function getAllArticles($limit=null) {
        $query = sprintf(" SELECT Num FROM %s ORDER BY DatePosted DESC ",
            self::DB_TABLE
            );
        $db = db::instance();
        $result = $db->lookup($query);
        if(!mysqli_num_rows($result))
            return null;
        else {
            $objects = array();
            while($row = mysqli_fetch_assoc($result)) {
                $objects[] = self::getArticleByID($row['Num']);
            }
            return ($objects);
        }
    }
	
}
?>