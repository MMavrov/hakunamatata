<?php
//class containing user data and methods
	require_once('include/session.php');
	require_once('include/db.php');
	
	class user{
		public $userId;
		public $userName;
		public $firstName;
		public $lastName;
		public $email;
		
		public static function checkUserLoggedIn(){
			global $pdo;
			global $session;

			$stm = $pdo -> prepare('SELECT * FROM login WHERE session = :session');
			$stm -> execute(array(':session' => $session));
			return ($stm -> rowCount() === 1);
		}
		
		public static function login($username, $password){
			global $pdo;
			global $session;
			$checkExists = $pdo -> prepare('SELECT * FROM login WHERE name = :username AND password = :password');
			$checkExists -> execute(array(':username' => $username, ':password' => $password));

			$selectUserId = $pdo -> prepare('SELECT u.id 
											FROM login AS l
											INNER JOIN users AS u
											ON l.id = u.loginId
											WHERE l.name = :username AND l.password= :password');
			$selectUserId -> execute(array(':username' => $username, ':password' => $password));
			$userId = $selectUserId -> fetch();
			$_SESSION['userId'] = $userId;
			var_dump($userId);
			var_dump($selectUserId);

			if ($checkExists -> rowCount() === 1){
				session_regenerate_id();
				$session = session_id();
				$loginQuery = $pdo -> prepare('UPDATE login SET session = :session WHERE name = :username AND password = :password');
				$loginQuery -> execute(array(':username' => $username, ':password' => $password, ':session' => $session));
				return true;
			}else{
				return false;		
			}
		}

		public static function registerUser($username, $firstName, $lastName, $password, $email){
			global $pdo;
			global $session;

			$exist = $pdo -> prepare('SELECT * FROM login WHERE name = :username');
			$exist -> execute(array(':username' => $username));
			if ($exist -> rowCount() === 1){
				return false;
			}else{
				
				$sql = $pdo -> prepare('INSERT INTO login (name, password) VALUES (:name, :pass)');
				$sql -> execute(array(':name' => $username, ':pass' => $password));
				
				$sql = $pdo -> prepare('INSERT INTO users (firstName, lastName, email, loginId) VALUES (:name, :lastName, :email, :loginId)');
				$sql -> execute(array(':name' => $firstName, ':lastName' => $lastName, ':email' => $email, ':loginId' => $pdo -> lastInsertId()));
				return true;
			}
		}
		
		public function getUserData(){
			global $pdo;
			global $session;

			if (self::checkUserLoggedIn()){
				$stm = $pdo -> prepare('SELECT u.id, l.name, u.firstName, u.lastName, u.email 
										FROM users AS u 
										INNER JOIN login AS l
										ON u.loginId = l.id WHERE l.session = :session');
				$stm -> execute(array(':session' => $session));
				$result = $stm->fetch();
				$this -> userId    = $result[0];
				$this -> userName  = $result[1];
				$this -> firstName = $result[2];
				$this -> lastName  = $result[3];
				$this -> email     = $result[4];
			}else {
				die('laina');
			}

		}


		public function postGossip($gossip){
			global $pdo;
			global $session;

			$stm = $pdo -> prepare('SELECT u.id 
									FROM users AS u 
									INNER JOIN login AS l
									ON u.loginId = l.id 
									WHERE l.session = :session AND l.name = :username');
			$stm -> execute(array(':session' => $session, ':username' => $this -> userName));
			$result = $stm -> fetch();

			$currentDate = date('Y-m-d H:i:s');

			$sql = $pdo -> prepare('INSERT INTO posts (userPosted, post, date) VALUES (:userPosted, :post, :date)');
			$sql -> execute(array(':userPosted' => $result[0], ':post' => $gossip, ':date' => $currentDate));
		}

		public function getAllGossips(){
			global $pdo;

			$stm = $pdo -> prepare('SELECT posts.post, login.name
									FROM posts
									INNER JOIN users 
									ON users.id = posts.userPosted
									INNER JOIN login
									ON login.id = users.loginId
									ORDER BY posts.date DESC');
			$stm -> execute();
			$result = $stm -> fetchAll();
			return $result;
		}

		public function postMessage($message, $toUser){
			global $pdo;
			global $session;

			$currentDate = date('Y-m-d H:i:s');
			
			$stm = $pdo -> prepare('INSERT INTO messages(fromUser, toUser, message, messageSent, messageSeen) VALUES (:fromuser, :touser, :message, :messagesent, :messageseen)');
			$stm -> execute(array(':fromuser' => $this -> userId, ':touser' => $toUser, ':message' => $message, ':messagesent' => $currentDate, ':messageseen' => 0));
			//var_dump($stm);
		}


		public function getFriends(){
			global $pdo;

			$stm = $pdo -> prepare('SELECT u.id, u.firstName 
									FROM users AS u 
									INNER JOIN friendstable AS f
									ON u.id = f.firstUserId
									WHERE f.secondUserId = :userid');
			$stm -> execute(array(':userid' => $this -> userId));
			$result = $stm->fetchAll();
			return $result;
		}

		public function getNotFriends(){
			global $pdo;

			$stm = $pdo -> prepare('SELECT usr.id, usr.firstName
									FROM users AS usr
									WHERE usr.id NOT IN (SELECT u.id 
									FROM users AS u 
									INNER JOIN friendstable AS f
									ON u.id = f.firstUserId
									WHERE f.secondUserId = :userid) AND usr.id != :userid');
			$stm -> execute(array(':userid' => $this -> userId));
			$result = $stm->fetchAll();
			return $result;
		}

		public function getSeenMessages(){
			global $pdo;

			$stm = $pdo -> prepare('SELECT u.firstName, m.id
									FROM messages AS m
									INNER JOIN users AS u
									ON m.fromUser = u.id
									WHERE m.toUser = :userid AND m.messageSeen = 1');
			$stm -> execute(array(':userid' => $this -> userId));
			$result = $stm->fetchAll();
			return $result;
		}

		public function getNewMessages(){
			global $pdo;

			$stm = $pdo -> prepare('SELECT u.firstName, m.id
									FROM messages AS m
									INNER JOIN users AS u
									ON m.fromUser = u.id
									WHERE m.toUser = :userid AND m.messageSeen = 0');
			$stm -> execute(array(':userid' => $this -> userId));
			$result = $stm->fetchAll();
			return $result;
		}

		public function getFriendUnvitations(){
			global $pdo;

			$stm = $pdo -> prepare('SELECT u.id, u.firstName
									FROM friendsinvitation AS fi
									INNER JOIN users AS u
									ON fi.firstUserId = u.id
									WHERE fi.secondUserId= :userid');
			$stm -> execute(array(':userid' => $this -> userId));
			$result = $stm->fetchAll();
			return $result;
		}

		public function sendFriendsRequest($toUser){
			global $pdo;

			$stm = $pdo -> prepare('INSERT INTO friendsinvitation(firstUserId, secondUserId) 
									VALUES (:sender, :other)');
			$stm -> execute(array(':sender' => $this -> userId, ':other' => $toUser));

		}

		public function acceptFriendship($uId){
			global $pdo;

			$stm = $pdo -> prepare('DELETE FROM friendsinvitation 
									WHERE firstUserId = :userid');
			$stm -> execute(array(':userid' => $uId));

			$stm = $pdo -> prepare('INSERT INTO friendstable (firstUserId, secondUserId) 
									VALUES (:firstuserid, :seconduserid)');
			$stm -> execute(array(':firstuserid' => $uId, ':seconduserid' => $this -> userId));
			
			$stm = $pdo -> prepare('INSERT INTO friendstable (firstUserId, secondUserId) 
									VALUES (:firstuserid, :seconduserid)');
			$stm -> execute(array(':firstuserid' => $this -> userId, ':seconduserid' => $uId));
		}

		public function changeMessageStatus($messageId){
			global $pdo;

			$stm = $pdo -> prepare('UPDATE messages
									SET messageSeen=1 
									WHERE messages.id = :messageid');
			$stm -> execute(array(':messageid' => $messageId));
		}

		public function getMessage($msgId){
			global $pdo;

			$stm = $pdo -> prepare('SELECT m.message
									FROM messages AS m
									WHERE m.id = :messageid');
			$stm -> execute(array(':messageid' => $msgId));
			$result = $stm->fetch();
			return $result[0];
		}

		public function haveNewMessages(){
			$result = $this -> getNewMessages();
			return($result);
		}

		public function isFriendRequestSent($reciever){
			global $pdo;

			$stm = $pdo -> prepare('SELECT * 
									FROM friendsinvitation AS frinv
									WHERE frinv.firstUserId = :sender AND frinv.secondUserId = :reciever');
			$stm -> execute(array(':sender' => $this -> userId, ':reciever' => $reciever));
			$result = $stm -> fetch();
			return $result;

		}

		public function __construct(){
			$this -> getUserData();
		}



	}
?>
