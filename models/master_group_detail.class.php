<?php
    class master_group_detail
    {
	var $id;
	var $groupcode;
	var $module;
	var $read;
	var $confirm;
	var $entry;
	var $update;
	var $delete;
	var $print;
	var $export;
	var $import;
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
	public function getGroupcode() {
	   return $this->groupcode;
	}

	public function setGroupcode($groupcode) {
	   $this->groupcode = $groupcode;
	}
	public function getModule() {
	   return $this->module;
	}

	public function setModule($module) {
	   $this->module = $module;
	}
	public function getRead() {
	   return $this->read;
	}

	public function setRead($read) {
	   $this->read = $read;
	}
	public function getConfirm() {
	   return $this->confirm;
	}

	public function setConfirm($confirm) {
	   $this->confirm = $confirm;
	}
	public function getEntry() {
	   return $this->entry;
	}

	public function setEntry($entry) {
	   $this->entry = $entry;
	}
	public function getUpdate() {
	   return $this->update;
	}

	public function setUpdate($update) {
	   $this->update = $update;
	}
	public function getDelete() {
	   return $this->delete;
	}

	public function setDelete($delete) {
	   $this->delete = $delete;
	}
	public function getPrint() {
	   return $this->print;
	}

	public function setPrint($print) {
	   $this->print = $print;
	}
	public function getExport() {
	   return $this->export;
	}

	public function setExport($export) {
	   $this->export = $export;
	}
	public function getImport() {
	   return $this->import;
	}

	public function setImport($import) {
	   $this->import = $import;
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
