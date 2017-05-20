<?php
    class dashboard_user
    {
	var $id;
	var $graph_query_id;
	var $user;

        var $primarykey = "id";
        
	public function getId() {
	   return $this->id;
	}

	public function setId($id) {
	   $this->id = $id;
	}
	public function getGraph_query_id() {
	   return $this->graph_query_id;
	}

	public function setGraph_query_id($graph_query_id) {
	   $this->graph_query_id = $graph_query_id;
	}
	public function getUser() {
	   return $this->user;
	}

	public function setUser($user) {
	   $this->user = $user;
	}
         
    }
?>
