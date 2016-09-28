<?php

    class AppUser extends DbObject {
        // name of database table
        const DB_TABLE = 'users';

        // database fields
        protected $id;
        protected $Admin;
        protected $Username;
        protected $Password;
        protected $EnlightenedPoints;
        protected $ProfilePicture;
        protected $Birthday;
        protected $About_Me;
        protected $Name;

        // constructor
        public function __construct($args = array()) {
            $defaultArgs = array(
                'id' => null,
                'Admin' => null,
                'Username' => '',
                'Password' => '',
                'EnlightenedPoints' => 0,
                'ProfilePicture' => null,
                'Birthday' => null,
                'About_Me' => null,
                'Name' => null
                );

            $args += $defaultArgs;

            $this->id = $args['id'];
            $this->Admin = $args['Admin'];
            $this->Username = $args['Username'];
            $this->Password = $args['Password'];
            $this->EnlightenedPoints = $args['EnlightenedPoints'];
            $this->Birthday = $args['Birthday'];
            $this->About_Me = $args['About_Me'];
            $this->Name = $args['Name'];
        }

        // save changes to object
        public function save() {
            $db = db::instance();
            // omit id and any timestamps
            $db_properties = array(
                'Username' => $this->Username,
                'Password' => $this->Password,
                'EnlightenedPoints' => $this->EnlightenedPoints,
                'ProfilePicture' => $this->ProfilePicture,
                'Birthday' => $this->Birthday,
                'About_Me' => $this->About_Me,
                'Name' => $this->Name
                );

            // Store in database
            $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
        }

        // load object by ID
        public static function loadById($id) {
            $db = db::instance();
            $obj = $db->fetchById($id, __CLASS__, self::DB_TABLE);
            return $obj;
        }

        // load user by username
        public static function loadByUsername($username=null) {
            if($username === null)
                return null;

            // Make filtered query where user name is same as logged in user
            $query = sprintf(" SELECT id FROM %s WHERE Username = '%s' ",
                self::DB_TABLE,
                $username
                );
            $db = db::instance();
            $result = $db->lookup($query);
            if(!mysqli_num_rows($result))
                return null;
            else {
                $row = mysqli_fetch_assoc($result);
                $obj = self::loadById($row['id']);
                return ($obj);
            }
        }

        //Chekc if logged in user is an admin
        public static function isAdmin($admin) {
            //When user is admin
            if($this->Admin == 1) {
                return true;
            }
            //When $admin == 0
            return false;
        }

        //Check if logged in user is following target user $followee
        public function isFollowing($followeeID=null) {
            //if $foloweeID is not exist
            if($followeeID == null)
                return false;

            //if $followeeID exist
            return (Follow::areFollowing($this->id, $followeeID));
        }

        //Return the Users who logged user is following
        public static function getMyFollowers($username)
        {
            //Make a filtered query
            $db = db::instance();
            $user = AppUser::loadByUsername($username);
            $userID = $user->get('id');
            
            //Follow object which has Follower as logged in user
            $q = sprintf("SELECT * FROM %s WHERE Follower = %d",
                     'follow',
                     $userID
                    );

            $result = $db->lookup($q);
             $followers = array();

            while($row = mysqli_fetch_assoc($result)) 
            {
                //Get a user by loadByID the Followee ID
                $followee = AppUser::loadById($row['Followee']);
                $followers[] = $followee;
            }

              return $followers;
        }

    }
