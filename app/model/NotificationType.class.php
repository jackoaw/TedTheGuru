<?php

  class NotificationType extends DbObject {
  // name of database table
  const DB_TABLE = 'notification_type';

  // database fields
  protected $Num;
  protected $Name;

  // constructor
  public function __construct($args = array()) {
      $defaultArgs = array(
          'Num' => null,
          'Name' => null
          );

      $args += $defaultArgs;

      $this->Num = $args['Num'];
      $this->Name = $args['Name'];
  }

  // save changes to object
  public function save() {
      $db = db::instance();
      // omit id and any timestamps
      $db_properties = array(
          'Name' => $this->Name
          );
      $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
  }

  // load object by ID
  public static function loadByNum($Num) {
      $db = db::instance();
      $obj = $db->fetchByNum2($Num, __CLASS__, self::DB_TABLE);
      return $obj;
  }


  // load object by name
  public static function getIdByName($Name) {
    $db = db::instance();

    // Find the query that 'Name' is match to $Name
    $q = sprintf("SELECT * FROM %s WHERE `Name` = '%s'; ",
      self::DB_TABLE,
      $Name
      );

    $result = $db->lookup($q);

    // if there is not matched object
    if(mysqli_num_rows($result) == 0) {
      return null;
    }
    // when there is matched object 
    else 
    {
        $row = mysqli_fetch_assoc($result);
        //Return the object
        return ($row['Num']);
    }
  }

}
