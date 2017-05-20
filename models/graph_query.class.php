<?php
    class graph_query
    {
	var $id;
	var $id_graph_model;
	var $group_code;
	var $query;
	var $crosstab;
	var $tabletemp;
	var $lastupdate;
	var $timing;
	var $month;
	var $year;
	var $Title;
	var $SubTitle;
	var $xaxistitle;
	var $yaxistitle;
	var $tooltips;
	var $querytable;
	var $querytable2;
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
	public function getId_graph_model() {
	   return $this->id_graph_model;
	}

	public function setId_graph_model($id_graph_model) {
	   $this->id_graph_model = $id_graph_model;
	}
	public function getGroup_code() {
	   return $this->group_code;
	}

	public function setGroup_code($group_code) {
	   $this->group_code = $group_code;
	}
	public function getQuery() {
	   return $this->query;
	}

	public function setQuery($query) {
	   $this->query = $query;
	}
	public function getCrosstab() {
	   return $this->crosstab;
	}

	public function setCrosstab($crosstab) {
	   $this->crosstab = $crosstab;
	}
	public function getTabletemp() {
	   return $this->tabletemp;
	}

	public function setTabletemp($tabletemp) {
	   $this->tabletemp = $tabletemp;
	}
	public function getLastupdate() {
	   return $this->lastupdate;
	}

	public function setLastupdate($lastupdate) {
	   $this->lastupdate = $lastupdate;
	}
	public function getTiming() {
	   return $this->timing;
	}

	public function setTiming($timing) {
	   $this->timing = $timing;
	}
	public function getMonth() {
	   return $this->month;
	}

	public function setMonth($month) {
	   $this->month = $month;
	}
	public function getYear() {
	   return $this->year;
	}

	public function setYear($year) {
	   $this->year = $year;
	}
	public function getTitle() {
	   return $this->Title;
	}

	public function setTitle($Title) {
	   $this->Title = $Title;
	}
	public function getSubTitle() {
	   return $this->SubTitle;
	}

	public function setSubTitle($SubTitle) {
	   $this->SubTitle = $SubTitle;
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
	public function getQuerytable() {
	   return $this->querytable;
	}

	public function setQuerytable($querytable) {
	   $this->querytable = $querytable;
	}
	public function getQuerytable2() {
	   return $this->querytable2;
	}

	public function setQuerytable2($querytable2) {
	   $this->querytable2 = $querytable2;
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
