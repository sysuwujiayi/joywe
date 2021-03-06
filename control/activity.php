<?php
class Activity {
	public $id;
	public $actname;	
	public $actinfo;
	public $actuserID;	
	public $actdate;		
	public $actstart;
	public $actend;
	public $actloc;

	public function __construct($data) {		
		$this->id = (int)$data[0];
		$this->actname = $data[1];
		$this->actinfo = $data[2];
		$this->actuserID = $data[3];
		$this->actdate = $data[4];
		$this->actstart = $data[5];
		$this->actend = $data[6];
		$this->actloc = $data[7];
	}
	
	public function getUser(){
		$type = new ReflectionClass('User');
		return getDataById($type,'user',$this->actuserID);
	}
	
	public function getUsers($start, $count = 20){
		$sql = "select user.* from user,joinin 
		where joinin.UserID = user.id and joinin.ActID = ?
		order by user.Date desc 
		limit $start,$count";
		$type = new ReflectionClass('User');
		return getClassByInput($type,$sql,array($this->id));
	}
	
	public function getUserNum(){
		$table = "(select user.* from user,joinin 
		where joinin.UserID = user.id and joinin.ActID = $this->id) temp";
		return countNum($table);
	}
}
?>