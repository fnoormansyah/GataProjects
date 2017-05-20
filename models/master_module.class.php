<?php
    class master_module
    {
	var $id;
	var $module;
	var $descriptionhead;
	var $description;
	var $picture;
	var $classcolour;
	var $onclick;
	var $onclicksubmenu;
	var $parentid;
	var $public;
	var $entrytime;
	var $entryuser;
	var $entryip;
	var $updatetime;
	var $updateuser;
	var $updateip;

        var $primarykey = "id";
        
	public function getId() {
	   return $this->id;
	}

	public function setId($id) {
	   $this->id = $id;
	}
	public function getModule() {
	   return $this->module;
	}

	public function setModule($module) {
	   $this->module = $module;
	}
	public function getDescriptionhead() {
	   return $this->descriptionhead;
	}

	public function setDescriptionhead($descriptionhead) {
	   $this->descriptionhead = $descriptionhead;
	}
	public function getDescription() {
	   return $this->description;
	}

	public function setDescription($description) {
	   $this->description = $description;
	}
	public function getPicture() {
	   return $this->picture;
	}

	public function setPicture($picture) {
	   $this->picture = $picture;
	}
	public function getClasscolour() {
	   return $this->classcolour;
	}

	public function setClasscolour($classcolour) {
	   $this->classcolour = $classcolour;
	}
	public function getOnclick() {
	   return $this->onclick;
	}

	public function setOnclick($onclick) {
	   $this->onclick = $onclick;
	}
	public function getOnclicksubmenu() {
	   return $this->onclicksubmenu;
	}

	public function setOnclicksubmenu($onclicksubmenu) {
	   $this->onclicksubmenu = $onclicksubmenu;
	}
	public function getParentid() {
	   return $this->parentid;
	}

	public function setParentid($parentid) {
	   $this->parentid = $parentid;
	}
	public function getPublic() {
	   return $this->public;
	}

	public function setPublic($public) {
	   $this->public = $public;
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
         
    }
?>
