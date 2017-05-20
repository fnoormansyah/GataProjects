<?php
    class master_department
    {
	var $departmentid;
	var $description;

        var $primarykey = "departmentid";
        
	public function getDepartmentid() {
	   return $this->departmentid;
	}

	public function setDepartmentid($departmentid) {
	   $this->departmentid = $departmentid;
	}
	public function getDescription() {
	   return $this->description;
	}

	public function setDescription($description) {
	   $this->description = $description;
	}
         
    }
?>
