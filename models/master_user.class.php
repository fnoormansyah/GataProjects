<?php
    class master_user
    {
	var $id;
	var $user;
	var $description;
	var $password;
	var $username;
	var $entrytime;
	var $entryuser;
	var $entryip;
	var $updatetime;
	var $updateuser;
	var $updateip;
	var $avatar;
	var $nik;
	var $departmentid;
	var $unitid;

        var $primarykey = "user";
        
	public function getId() {
	   return $this->id;
	}

	public function setId($id) {
	   $this->id = $id;
	}
	public function getUser() {
	   return $this->user;
	}

	public function setUser($user) {
	   $this->user = $user;
	}
	public function getDescription() {
	   return $this->description;
	}

	public function setDescription($description) {
	   $this->description = $description;
	}
	public function getPassword() {
	   return $this->password;
	}

	public function setPassword($password) {
	   $this->password = $password;
	}
	public function getUsername() {
	   return $this->username;
	}

	public function setUsername($username) {
	   $this->username = $username;
	}
	public function getEntrytime() {
	   return $this->entrytime;
	}

	public function setEntrytime($entrytime) {
	   $this->entrytime = $entrytime;
	}
	public function getEntryuser() {
	   return $this->entryuser;
	}

	public function setEntryuser($entryuser) {
	   $this->entryuser = $entryuser;
	}
	public function getEntryip() {
	   return $this->entryip;
	}

	public function setEntryip($entryip) {
	   $this->entryip = $entryip;
	}
	public function getUpdatetime() {
	   return $this->updatetime;
	}

	public function setUpdatetime($updatetime) {
	   $this->updatetime = $updatetime;
	}
	public function getUpdateuser() {
	   return $this->updateuser;
	}

	public function setUpdateuser($updateuser) {
	   $this->updateuser = $updateuser;
	}
	public function getUpdateip() {
	   return $this->updateip;
	}

	public function setUpdateip($updateip) {
	   $this->updateip = $updateip;
	}
	public function getAvatar() {
	   return $this->avatar;
	}

	public function setAvatar($avatar) {
	   $this->avatar = $avatar;
	}
	public function getNik() {
	   return $this->nik;
	}

	public function setNik($nik) {
	   $this->nik = $nik;
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
