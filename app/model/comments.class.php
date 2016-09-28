<?php

class Comments extends DbObject {
    // name of database table
    const DB_TABLE = 'comments';

    // database fields
    protected $Num;
    protected $User;
    protected $ArticleNum;
    protected $Comment;
    protected $Date;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'Num' => null,
            'User' => '0',
            'ArticleNum' => '0',
            'Comment' => '',
            'Date' => null
            );

        $args += $defaultArgs;

        //Initialize the variables
        $this->Num = $args['Num'];
        $this->User = $args['User'];
        $this->ArticleNum = $args['ArticleNum'];
        $this->Comment = $args['Comment'];
        $this->Date = $args['Date'];
    }

    // save changes to object
    public function save() {
        $db = db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'User' => $this->User,
            'ArticleNum' => $this->ArticleNum,
            'Comment' => $this->Comment
            );
        $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    public function deleteComment($Num)
    {
        $db = db::instance();
        $db->removeByNum('comments', $Num);
    }

    // load object by ID
    public static function loadByNum($Num) {
        $db = db::instance();
        $obj = $db->fetchByNum2($Num, __CLASS__, self::DB_TABLE);
        return $obj;
    }


    // load all comments on this blog
    public static function getByBlogPostId($postID=null, $limit=null) {

        // $c = Comment object
        // $b = BlogPost where $c is commented
        $query = sprintf(" SELECT c.Num AS commentID FROM %s c
          INNER JOIN %s b ON c.ArticleNum = b.Num
          WHERE b.Num = %d
          ORDER BY c.Date DESC ",
            self::DB_TABLE,
            articleOp::DB_TABLE,
            $postID
            );

        $db = db::instance();
            
        //Look up query
        $result = $db->lookup($query);

        // If there is no comment in this $b Post
        if(!mysqli_num_rows($result))
            return null;
        //If there is
        else {
            $objects = array();
            while($row = mysqli_fetch_assoc($result)) {

                //Store in $objects[]
                $objects[] = self::loadByNum($row['commentID']);
            }
            //Return Notification array
            return ($objects);
        }
    }

    public static function deleteCommentByPost($postNum)
    {
        $db = db::instance();
        $q = sprintf("SELECT * FROM %s WHERE ArticleNum = %d",
            self::DB_TABLE,
            $postNum);
        $result = $db->lookup($q);
        $comments = array();

        while($row = mysqli_fetch_assoc($result))
        {
            $db->removeByNum('comments', $row['Num']);
        }

    }

    // Based on the given ID it will modify the associated article comment
    public function modifyComment($Num, $newContent)
    {
        $db = db::instance();
        $db->modifyCommentByNum('comments', $Num, $newContent);
    }


}
