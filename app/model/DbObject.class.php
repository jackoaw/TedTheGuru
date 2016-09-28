<?php

// DbObject class
class DbObject {
    //Variable sued for editing the class
	protected $modified = false;
	
    // Motify the variable
	public function getModified() {
		return $this->modified;
	}

	// Set the motidifed filed
	public function setModified($modified=false) {
		$this->modified = $modified;
	}
    
    // Getter
    public function get($field=null) {
        if($field == null)
            return null;
        
        return ($this->$field);
    }
    
    // Getter for id = key
    public function getId() {
        return ($this->id);   
    }

    //Geter for Num = key
    public function getNum() {
        return ($this->Num);   
    }

    //Setter for field of variable for each calss
    public function set($field=null, $val=null) {
        if($field == null)
            return null;
        
        $this->$field = $val;
        $this->modified = true;
    }
    
    // Set Id
    public function setId($val) {
        $this->id = $val;
        //Modify the variable
        $this->modified = true;
    }
}