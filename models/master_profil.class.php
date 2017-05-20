<?php
    class master_profil
    {
	var $id;
	var $nik;
	var $user;
	var $avatar;
	var $departmentid;
	var $unitid;

        var $primarykey = "id";
        
	public function getId() {
	   return $this->id;
	}

	public function setId($id) {
	   $this->id = $id;
	}
	public function getNik() {
	   return $this->nik;
	}

	public function setNik($nik) {
	   $this->nik = $nik;
	}
	public function getUser() {
	   return $this->user;
	}

	public function setUser($user) {
	   $this->user = $user;
	}
	public function getAvatar() {
	   return $this->avatar;
	}

	public function setAvatar($avatar) {
	   $this->avatar = $avatar;
	}
	public function getDepartmentid() {
	   return $this->departmentid;
	}

	public function setDepartmentid($departmentid) {
	   $this->departmentid = $departmentid;
	}
	public function getUnitid() {
	   return $this->unitid;
	}

	public function setUnitid($unitid) {
	   $this->unitid = $unitid;
	}
         
    }
?>
