<?php
    class replace_character
    {
	var $id;
	var $sourcetext;
	var $replacetext;
	var $find;
	var $save;
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
	public function getSourcetext() {
	   return $this->sourcetext;
	}

	public function setSourcetext($sourcetext) {
	   $this->sourcetext = $sourcetext;
	}
	public function getReplacetext() {
	   return $this->replacetext;
	}

	public function setReplacetext($replacetext) {
	   $this->replacetext = $replacetext;
	}
	public function getFind() {
	   return $this->find;
	}

	public function setFind($find) {
	   $this->find = $find;
	}
	public function getSave() {
	   return $this->save;
	}

	public function setSave($save) {
	   $this->save = $save;
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
