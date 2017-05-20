<?php
    class outbox
    {
	var $UpdatedInDB;
	var $InsertIntoDB;
	var $SendingDateTime;
	var $Text;
	var $DestinationNumber;
	var $Coding;
	var $UDH;
	var $Class;
	var $TextDecoded;
	var $ID;
	var $MultiPart;
	var $RelativeValidity;
	var $SenderID;
	var $SendingTimeOut;
	var $DeliveryReport;

        var $primarykey = "ID";
        
	public function getUpdatedInDB() {
	   return $this->UpdatedInDB;
	}

	public function setUpdatedInDB($UpdatedInDB) {
	   $this->UpdatedInDB = $UpdatedInDB;
	}
	public function getInsertIntoDB() {
	   return $this->InsertIntoDB;
	}

	public function setInsertIntoDB($InsertIntoDB) {
	   $this->InsertIntoDB = $InsertIntoDB;
	}
	public function getSendingDateTime() {
	   return $this->SendingDateTime;
	}

	public function setSendingDateTime($SendingDateTime) {
	   $this->SendingDateTime = $SendingDateTime;
	}
	public function getText() {
	   return $this->Text;
	}

	public function setText($Text) {
	   $this->Text = $Text;
	}
	public function getDestinationNumber() {
	   return $this->DestinationNumber;
	}

	public function setDestinationNumber($DestinationNumber) {
	   $this->DestinationNumber = $DestinationNumber;
	}
	public function getCoding() {
	   return $this->Coding;
	}

	public function setCoding($Coding) {
	   $this->Coding = $Coding;
	}
	public function getUDH() {
	   return $this->UDH;
	}

	public function setUDH($UDH) {
	   $this->UDH = $UDH;
	}
	public function getClass() {
	   return $this->Class;
	}

	public function setClass($Class) {
	   $this->Class = $Class;
	}
	public function getTextDecoded() {
	   return $this->TextDecoded;
	}

	public function setTextDecoded($TextDecoded) {
	   $this->TextDecoded = $TextDecoded;
	}
	public function getID() {
	   return $this->ID;
	}

	public function setID($ID) {
	   $this->ID = $ID;
	}
	public function getMultiPart() {
	   return $this->MultiPart;
	}

	public function setMultiPart($MultiPart) {
	   $this->MultiPart = $MultiPart;
	}
	public function getRelativeValidity() {
	   return $this->RelativeValidity;
	}

	public function setRelativeValidity($RelativeValidity) {
	   $this->RelativeValidity = $RelativeValidity;
	}
	public function getSenderID() {
	   return $this->SenderID;
	}

	public function setSenderID($SenderID) {
	   $this->SenderID = $SenderID;
	}
	public function getSendingTimeOut() {
	   return $this->SendingTimeOut;
	}

	public function setSendingTimeOut($SendingTimeOut) {
	   $this->SendingTimeOut = $SendingTimeOut;
	}
	public function getDeliveryReport() {
	   return $this->DeliveryReport;
	}

	public function setDeliveryReport($DeliveryReport) {
	   $this->DeliveryReport = $DeliveryReport;
	}
         
    }
?>
