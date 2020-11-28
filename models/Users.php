<?php
class Users extends Dao
{

	private $uid;

	private $id = null;
	private $name = null;
	private $email = null;
	private $username = null;
	private $pass = null;
	private $loginhash = null;
	private $deleted = null;
	private $admin = null;



	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getPass()
	{
		return $this->pass;
	}

	public function setPass($pass)
	{
		$this->pass = $pass;
	}


	public function validateUsername($u)
	{
		if (preg_match('/^[a-z0-9]+$/', $u)) {
			return true;
		} else {
			return false;
		}
	}


	public function clearLoginHash()
	{
		$_SESSION['chathashlogin'] = '';
	}

	//bug
	public function updateGroups($groups)
	{
		$groupstring = '';
		if (count($groups) > 0) {
			$groupstring = '!' . implode('!', $groups) . '!';
		}

		$sql = "UPDATE users SET last_update = NOW(), groups = :groups WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':groups', $groupstring);
		$sql->bindValue(':id', $this->uid);
		$sql->execute();
	}

	//bug
	public function clearGroups()
	{
		$sql = "UPDATE users SET groups = '' WHERE last_update < DATE_ADD(NOW(), INTERVAL -2 MINUTE)";
		$this->db->query($sql);
	}

	/*
	public function getName() {

		$sql = "SELECT username FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $this->uid);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch();
			return $data['username'];
		}

		return '';
	}

	public function getEmail() {

		$sql = "SELECT email FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $this->uid);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch();

			return $data['email'];
		}

		return '';
	}

	public function getUsername() {

		$sql = "SELECT username FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $this->uid);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch();

			return $data['username'];
		}

		return '';
	}

	public function getPass() {

		$sql = "SELECT pass FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $this->uid);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch();

			return $data['pass'];
		}

		return '';
	}

	*/

	public function updateData($id, $value)
	{
		if (isset($_POST['data']) && (!empty($_POST['data'])) && $value == 'deleted') {
			$sql = "UPDATE users SET $value = 1 WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':id', $id);
			$sql->execute();
			header("Location: " . BASE_URL . 'login');
		}

		if (isset($_POST['data']) && (!empty($_POST['data']))) {
			$sql = "UPDATE users SET $value = :newData WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':newData', $_POST['data']);
			$sql->bindValue(':id', $id);
			$sql->execute();
			header("Location: " . BASE_URL . 'settings');
		}
	}
	public function updatePass($id)
	{

		if (isset($_POST['password']) && (!empty($_POST['password']))) {
			$pass = $_POST['password'];
			$newpass = password_hash($pass, PASSWORD_DEFAULT);
			$sql2 = "UPDATE users SET pass = :pass WHERE id = :id";
			$sql2 = $this->db->prepare($sql2);
			$sql2->bindValue(":pass", $newpass);
			$sql2->bindValue(":id", $id);
			$sql2->execute();
			header("Location:" . BASE_URL . 'settings');
		}
	}



	public function recoveryPassword($email)
	{
		$sql = "SELECT * FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":email", $email);
		$sql->execute();
		if ($sql->rowCount() > 0) {

			$sql = $sql->fetch();
			$id = $sql['id'];
			$token = md5(time() . rand(0, 99999) . rand(0, 99999));
			$sql = "INSERT INTO user_token (id_user, ut_hash) VALUES (:id_user, :ut_hash);";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_user", $id);
			$sql->bindValue(":ut_hash", $token);
			$sql->execute();

			$link = "http://projetox.pc/login/resetpass?token=" . $token;

			$mensagem = "Clique no link para redefinir sua senha:<br/>" . $link;

			$assunto = "Redefinição de senha";

			$headers = 'From: seuemail@seusite.com.br' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			//mail($email, $assunto, $mensagem, $headers);
			echo $mensagem;
			exit;
		}
	}

	public function resetPass($token)
	{
		$sql = "SELECT * FROM user_token WHERE ut_hash = :ut_hash AND used = 0";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":ut_hash", $token);
		$sql->execute();
		if ($sql->rowCount() > 0) {
			$sql = $sql->fetch();
			$id = $sql['id_user'];
			if (isset($_POST['password'])) {
				$pass = $_POST['password'];
				$newpass = password_hash($pass, PASSWORD_DEFAULT);
				$_SESSION['chathashlogin'] = '';
				$sql2 = "UPDATE users SET pass = :pass WHERE id = :id";

				$sql2 = $this->db->prepare($sql2);
				$sql2->bindValue(":pass", $newpass);

				$sql2->bindValue(":id", $id);
				$sql2->execute();
				header("Location:" . BASE_URL . 'login');
			}
		} else {
			header("Location:" . BASE_URL . 'login');
		}
	}
}
