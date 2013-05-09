<?php
class User {
	public $id;
	public $name;	
	public $info;	
	public $picPath;		
	public $isAdmin;
	public $createTime;
	public $sex;
	public $birth;
	public $city;

	public function __construct($data) {		
		$this->id = (int)$data[0];
		$this->name = $data[1];
		$this->info = $data[3];
		$this->picPath = $data[4];
		$this->isAdmin = $data[5];
		$this->createTime = $data[6];
		$this->sex = $data[7];
		$this->birth = $data[8];
		$this->city = $data[9];
	}
	
	public function getActivities() {
		$sql = "select activity.* from activity,joinin 
		where joinin.UserID = ? and activity.id = joinin.ActID;
		order by Date desc";
		$type = new ReflectionClass('Activity');
		return getClassByInput($type,$sql,array($this->id));
	}
	
	public function getActivityNum(){
		$table = "(select activity.* from activity,joinin 
		where joinin.Userid = $this->id and joinin.ActID = activity.id) temp";
		return countNum($table);
	}
	
	public function getFriends() {
		$sql = "select user.*
		from user,friend
		where (user.id = friend.UserB and friend.UserA = ?)
		order by Date desc";
		$type = new ReflectionClass('User');
		return getClassByInput($type,$sql,array($this->id));
	}
	
	public function getFriendNum(){
		$table = "(select user.*
		from user,friend
		where (user.id = friend.UserB and friend.UserA = $this->id)) temp";
		return countNum($table);
	}

	public function isInActivity($ActID) {
		$sql = "select 1 from joinin
		where joinin.UserID = ? and joinin.ActID = ?";
		return isrecord($sql,array($this->id, $ActID));
	}
	
	public function isActAdmin($ActID) {
		$sql = "select 1 from activity
		where activity.UserID = ? and activity.id = ?";
		return isrecord($sql,array($this->id, $ActID));
	}
	
	public function isFriend($id) {
		$sql = "select 1
		from friend
		where (friend.UserA = ? and friend.UserB = ?) or (friend.UserA = ? and friend.UserB = ?)";
		return isrecord($sql,array($this->id,$id,$id,$this->id));
	}
}
?>