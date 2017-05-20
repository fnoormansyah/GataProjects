<?php
    class graph_model
    {
	var $id;
	var $type;
	var $name;
	var $filename;
	var $description;
	var $title;
	var $subtitle;
	var $xaxiscategories;
	var $xaxistitle;
	var $yaxistitle;
	var $tooltips;
	var $series;
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
	public function getType() {
	   return $this->type;
	}

	public function setType($type) {
	   $this->type = $type;
	}
	public function getName() {
	   return $this->name;
	}

	public function setName($name) {
	   $this->name = $name;
	}
	public function getFilename() {
	   return $this->filename;
	}

	public function setFilename($filename) {
	   $this->filename = $filename;
	}
	public function getDescription() {
	   return $this->description;
	}

	public function setDescription($description) {
	   $this->description = $description;
	}
	public function getTitle() {
	   return $this->title;
	}

	public function setTitle($title) {
	   $this->title = $title;
	}
	public function getSubtitle() {
	   return $this->subtitle;
	}

	public function setSubtitle($subtitle) {
	   $this->subtitle = $subtitle;
	}
	public function getXaxiscategories() {
	   return $this->xaxiscategories;
	}

	public function setXaxiscategories($xaxiscategories) {
	   $this->xaxiscategories = $xaxiscategories;
	}
	public function getXaxistitle() {
	   return $this->xaxistitle;
	}

	public function setXaxistitle($xaxistitle) {
	   $this->xaxistitle = $xaxistitle;
	}
	public function getYaxistitle() {
	   return $this->yaxistitle;
	}

	public function setYaxistitle($yaxistitle) {
	   $this->yaxistitle = $yaxistitle;
	}
	public function getTooltips() {
	   return $this->tooltips;
	}

	public function setTooltips($tooltips) {
	   $this->tooltips = $tooltips;
	}
	public function getSeries() {
	   return $this->series;
	}

	public function setSeries($series) {
	   $this->series = $series;
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
