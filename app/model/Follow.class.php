<?php

class Follow extends DbObject {
    // name of database table
    const DB_TABLE = 'follow';

    // database fields
    protected $Num;
    protected $Follower;
    protected $Followee;
    protected $PublishedTime;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'Num' => null,
            'Follower' => null,
            'Followee' => null,
            'PublishedTime' => null
            );

        $args += $defaultArgs;

        $this->Num = $args['Num'];
        $this->Follower = $args['Follower'];
        $this->Followee = $args['Followee'];
        $this->PublishedTime = $args['PublishedTime'];
    }

    // save changes to object
    public function save() {
        $db = db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'Follower' => $this->Follower,
            'Followee' => $this->Followee
            );
        $db->storeFollow($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    public static function unfollow($followerID=null, $followeeID=null) {
        $db = db::instance();

      $q = sprintf("SELECT * FROM %s WHERE Follower = %d AND Followee = %d ",
        self::DB_TABLE,
        $followerID,
        $followeeID
        );
      $result = $db->lookup($q);
        if(mysqli_num_rows($result) == 1) {
            $row = $result->fetch_assoc();
            $db->removeByNum(self::DB_TABLE, $row["Num"]);
        return true;
      } else {
        return false;
      }




    }

    // load object by ID
    public static function loadById($Num) {
        $db = db::instance();

        $obj = $db->fetchByIdForFollower($Num, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    // is the first user following the second user?
    public static function areFollowing($followerID=null, $followeeID=null) {
      if($followerID == null || $followeeID == null)
        return false;

      $db = db::instance();
      $q = sprintf("SELECT * FROM %s WHERE Follower = %d AND Followee = %d ",
        self::DB_TABLE,
        $followerID,
        $followeeID
        );
      $result = $db->lookup($q);
      if(mysqli_num_rows($result) != 0) {
        // follow was wound
        return true;
      } else {
        return false;
      }
    }



    public static function getMyFollowers()
    {
        $db = db::instance();
        $user = AppUser::loadByUsername($_SESSION['username']);
        $userID = $user->get('id');
        

      $q = sprintf("SELECT * FROM %s WHERE Follower = %d",
             self::DB_TABLE,
             $userID
             );

      $result = $db->lookup($q);
      $followers = array();

      while($row = mysqli_fetch_assoc($result)) 
      {
       
        //$followers[] = self::loadByNum($row['Num']);
        //echo $row['Followee'];
        $followee = AppUser::loadById($row['Followee']);
        //echo $followee->get('Username');
        $followers[] = $followee;
      }

      return $followers;
    }

    public static function loadByNum($Num) {
        $db = db::instance();
        $obj = $db->fetchByNum2($Num, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    
}
