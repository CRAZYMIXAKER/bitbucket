<?php session_start();
$salt = "sheu2o5n21p59m0";

$responce = [
	'res' => false,
	'error' => '',
	'errorLogin' => '',
	'errorEmail' => '',
	'errorPassword' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['login_sign_in']) || isset($_POST['name'])) {
		if (isset($_POST['login_sign_in']) && isset($_POST['password_sign_in'])) {
			if (!empty(trim($_POST['login_sign_in'])) && !empty(trim($_POST['password_sign_in']))) {

				$xpath = workWithXPATH();
				$xml = simplexml_load_file("db.xml");

				$login = trim($_POST['login_sign_in']);
				$password = trim($_POST['password_sign_in']);


				$checkPassword = md5(md5($password) . $salt);
				$checkUser = $xpath->query("/users/user[@login = '$login' and @password = '$checkPassword']");

				if ($checkUser->length == 1) {
					$result = $xpath->query("/users/user[@login='$login']");

					foreach ($result as $node) {
						$_SESSION['User'] = [
							"name" => $node->getAttribute('name'),
							"email" => $node->getAttribute('email'),
							"login" => $node->getAttribute('login')
						];
					}

					$responce['res'] = true;
				} else {
					$responce['error'] = 'Неправильный логин или пароль';
				}
			} else {
				$responce['error'] = 'Поля не должны быть пустыми или заполнены пробелами';
			}
		} elseif (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
			if (!empty(trim($_POST['name'])) && !empty(trim($_POST['email'])) && !empty(trim($_POST['login'])) && !empty(trim($_POST['password'])) && !empty(trim($_POST['confirm_password']))) {
				if ($_POST['password'] == $_POST['confirm_password']) {

					$xpath = workWithXPATH();
					$xml = simplexml_load_file("db.xml");

					$login = trim($_POST['login']);

					$checkLogin = $xpath->query("/users/user[@login = '$login']");

					if ($checkLogin->length == 0) {
						$email = $_POST['email'];
						$checkEmail = $xpath->query("/users/user[@email = '$email']");

						if ($checkEmail->length == 0) {
							$add = $xml->addchild('user');
							$add->addAttribute('name', $_POST['name']);
							$add->addAttribute('email', $_POST['email']);
							$add->addAttribute('login', $_POST['login']);
							$add->addAttribute('password', md5(md5($_POST['password']) . $salt));
							$xml->saveXML('db.xml');

							$_SESSION['User'] = [
								"name" => $_POST['name'],
								"email" => $_POST['email'],
								"login" => $_POST['login']
							];

							$responce['res'] = true;
						} else {
							$responce['errorEmail'] = 'Пользователь, с такой почтой уже существует, выберите пожалуйста другую почту';
						}
					} else {
						$responce['errorLogin'] = 'Пользователь, с таким логином уже существует, выберите пожалуйста другой логин';
					}
				} else {
					$responce['errorPassword'] = 'Пароли, должны быть одинаковыми';
				}
			} else {
				$responce['error'] = 'Поля не должны быть пустыми или заполнены пробелами';
			}
		}
	}
}

function workWithXPATH()
{
	$dom = new DomDocument("1.0");
	$dom->load("db.xml");
	$xpath = new DomXPath($dom);
	return $xpath;
}

echo json_encode($responce);