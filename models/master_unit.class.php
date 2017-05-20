<?php
    class master_unit
    {
	var $unitid;
	var $unitname;
	var $description;

        var $primarykey = "unitid";
        
	public function getUnitid() {
	   return $this->unitid;
	}

	public function setUnitid($unitid) {
	   $this->unitid = $unitid;
	}
	public function getUnitname() {
	   return $this->unitname;
	}

	public function setUnitname($unitname) {
	   $this->unitname = $unitname;
	}
	public function getDescription() {
	   return $this->description;
	}

	public function setDescription($description) {
	   $this->description = $description;
	}
         
    }
?>
