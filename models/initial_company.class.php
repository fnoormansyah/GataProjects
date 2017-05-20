<?php
    class initial_company
    {
	var $id;
	var $company_name;
	var $username;
	var $database_name;
	var $logo;
	var $bgfile;

        var $primarykey = "id";
        
	public function getId() {
	   return $this->id;
	}

	public function setId($id) {
	   $this->id = $id;
	}
	public function getCompany_name() {
	   return $this->company_name;
	}

	public function setCompany_name($company_name) {
	   $this->company_name = $company_name;
	}
	public function getUsername() {
	   return $this->username;
	}

	public function setUsername($username) {
	   $this->username = $username;
	}
	public function getDatabase_name() {
	   return $this->database_name;
	}

	public function setDatabase_name($database_name) {
	   $this->database_name = $database_name;
	}
	public function getLogo() {
	   return $this->logo;
	}

	public function setLogo($logo) {
	   $this->logo = $logo;
	}
	public function getBgfile() {
	   return $this->bgfile;
	}

	public function setBgfile($bgfile) {
	   $this->bgfile = $bgfile;
	}
         
    }
?>
