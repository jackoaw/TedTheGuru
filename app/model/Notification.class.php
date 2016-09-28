<?php

class Notification extends DbObject {
    // name of database table
    const DB_TABLE = 'notifications';

    // database fields
    protected $Num;
    protected $ActionID;
    protected $User1;
    protected $User2;
    protected $Description;
    protected $BlogPost_1;
    protected $Comment_1;
    protected $Quote_1;
    protected $Quiz_1;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'Num' => null,
            'ActionID' => 0,
            'User1' => null,
            'User2' => null,
            'BlogPost_1' => null,
            'Description' => null,
            'Comment_1' => null,
            'PublishedTime' => null,
            'Quote_1'=> null,
            'Quiz_1'=> null
            );

        $args += $defaultArgs;

        // Initailize the variables
        $this->Num = $args['Num'];
        $this->ActionID = $args['ActionID'];
        $this->User1 = $args['User1'];
        $this->User2 = $args['User2'];
        $this->BlogPost_1 = $args['BlogPost_1'];
        $this->Description = $args['Description'];
        $this->Comment_1 = $args['Comment_1'];
        $this->PublishedTime = $args['PublishedTime'];
        $this->Quote_1 = $args['Quote_1'];
        $this->Quiz_1 = $args['Quiz_1'];
    }

    // save changes to object
    public function save() {
        $db = db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'ActionID' => $this->ActionID,
            'User1' => $this->User1,
            'User2' => $this->User2,
            'BlogPost_1' => $this->BlogPost_1,
            'Comment_1' => $this->Comment_1,
            'Quote_1'=>$this->Quote_1,
            'Quiz_1'=>$this->Quiz_1
            );
        $db->storeFollow($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    // load object by ID
    public static function loadByNum($Num) {
        $db = db::instance();
        $obj = $db->fetchByNum2($Num, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    // Get all notification
    public static function getAllNotifications() {
      $db = db::instance();
      //query by get Notification classes in time order
      $q = sprintf("SELECT * FROM %s ORDER BY PublishedTime DESC ", self::DB_TABLE);

      $result = $db->lookup($q);
      $notifications = array();

      //Fetch the Notification and store them in $notifications array
      while($row = mysqli_fetch_assoc($result)) 
      {
          $notifications[] = self::loadByNum($row['Num']);
      }

      // Return the Notification array
      return $notifications;
    }

    // delete notification by comment Num
    // delete notification by comment Num
    public function deleteNotificationByComment($Commentnum)
    {
         $db = db::instance();

            $q = sprintf("SELECT * FROM %s WHERE Comment_1 = %d",
                self::DB_TABLE,
                $Commentnum);
            $result = $db->lookup($q);
            $notifications = array();

            while($row = mysqli_fetch_assoc($result)) 
            {
                $db->removeByNum('notifications', $row['Num']);
            }

    }

    // Get notification taht only specific user created
    public static function getMyNotifications()
    {
        $db = db::instance();
        //Get a logged in user
        $user = AppUser::loadByUsername($_SESSION['username']);
        $userID = $user->get('id');
        
        //Get Notification where User1(creater) == currently logged in user
        $q = sprintf("SELECT * FROM %s WHERE User1 = %d",
             self::DB_TABLE,
             $userID
             );

        // Use the lookup table to get query
        $result = $db->lookup($q);
        $notifications = array();

        //Store Noticiation class in $notification array
        while($row = mysqli_fetch_assoc($result)) 
        {
            //Get each notification by using 'Num' key
            $notifications[] = self::loadByNum($row['Num']);
        }

        // Return filtered Notification array
        return $notifications;
    }




    public function deleteNotificationByPost($postNum)
    {
            $db = db::instance();

            $q = sprintf("SELECT * FROM %s WHERE BlogPost_1 = %d",
                self::DB_TABLE,
                $postNum);
            $result = $db->lookup($q);
            $notifications = array();

            while($row = mysqli_fetch_assoc($result)) 
            {
                $db->removeByNum('notifications', $row['Num']);
            }
            
    }

    public function deleteNotificationByQuote($quotNum)
    {
            $db = db::instance();

            $q = sprintf("SELECT * FROM %s WHERE Quote_1 = %d",
                self::DB_TABLE,
                $quotNum);
            $result = $db->lookup($q);
            $notifications = array();

            while($row = mysqli_fetch_assoc($result)) 
            {
                $db->removeByNum('notifications', $row['Num']);
            }
            
    }

    public function deleteNotificationByQuiz($quizNum)
    {
            $db = db::instance();

            $q = sprintf("SELECT * FROM %s WHERE Quiz_1 = %d",
                self::DB_TABLE,
                $quizNum);
            $result = $db->lookup($q);
            $notifications = array();

            while($row = mysqli_fetch_assoc($result)) 
            {
                $db->removeByNum('notifications', $row['Num']);
            }
            
    }
    

}
