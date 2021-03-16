<?php

class CRUD
{
	public $salt = "sheu2o5n21p59m0";
	public $login;
	public $xpath;
	public $xml;
	public $dom;

	public function __construct()
	{
		$this->dom = $this->workWithXPATH();
		$this->xpath = new DOMXPath($this->dom);
		$this->xml = simplexml_load_file("db.xml");
	}

	public function createUser($name, $email, $login, $password)
	{
		$add = $this->xml->addchild('user');
		$add->addAttribute('name', $name);
		$add->addAttribute('email', $email);
		$add->addAttribute('login', $login);
		$add->addAttribute('password', md5(md5($password) . $this->salt));
		$add->addAttribute('access', 0);
		$this->xml->saveXML('db.xml');

		$_SESSION['User'] = [
			"name" => $_POST['name'],
			"email" => $_POST['email'],
			"login" => $_POST['login'],
			"access" => 0
		];

		setcookie("Login", $_SESSION['User']['login'], time() + 3600);
		return $_SESSION['User'];
	}

	public function readUser($login)
	{
		$this->login = $login;
		$result = $this->xpath->query("/users/user[@login='$this->login']");
		foreach ($result as $node) {
			$_SESSION['User'] = [
				"name" => $node->getAttribute('name'),
				"email" => $node->getAttribute('email'),
				"login" => $node->getAttribute('login'),
				"access" => $node->getAttribute('access')
			];
			setcookie("Login", $_SESSION['User']['login'], time() + 3600);
			return $_SESSION['User'];
		}
	}

	public function updateUser($name, $email, $login, $loginMain)
	{
		$this->login = $login;
		$name = $name;
		$email = $email;
		$loginMain = $loginMain;

		foreach ($this->xpath->query("/users/user[@login='$loginMain']") as $item) {
			$item->setAttribute('name', "$name");
			$item->setAttribute('email', "$email");
			$item->setAttribute('login', "$this->login");
		}

		$this->dom->save('db.xml');
	}

	public function deleteUser($login)
	{
		$this->login = $login;
		$result = $this->xml->xpath("//user[@login='$this->login']");
		unset($result[0][0]);
		$this->xml->asXML('db.xml');
	}

	public function workWithXPATH()
	{
		$dom = new DomDocument("1.0");
		$dom->load("db.xml");
		return $dom;
	}
}