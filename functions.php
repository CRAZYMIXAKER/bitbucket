<?php session_start();
include_once("crud.php");

$workWithXML = new CRUD();
$xpath = $workWithXML->xpath;
$salt = $workWithXML->salt;

$responce = [
	'res' => false,
	'error' => '',
	'errorLogin' => '',
	'errorEmail' => '',
	'errorPassword' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['login_sign_in']) || isset($_POST['name']) || isset($_POST['editName'])) {
		if (isset($_POST['login_sign_in']) && isset($_POST['password_sign_in'])) {
			if (!empty(trim($_POST['login_sign_in'])) && !empty(trim($_POST['password_sign_in']))) {
				$login = trim($_POST['login_sign_in']);
				$password = trim($_POST['password_sign_in']);
				$checkPassword = md5(md5($password) . $salt);
				$checkUser = $xpath->query("/users/user[@login = '$login' and @password = '$checkPassword']");
				if ($checkUser->length == 1) {
					$crudRead = new CRUD();
					$crudRead->readUser($login);
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
					$login = trim($_POST['login']);
					$checkLogin = $xpath->query("/users/user[@login = '$login']");
					if ($checkLogin->length == 0) {
						$email = $_POST['email'];
						$checkEmail = $xpath->query("/users/user[@email = '$email']");
						if ($checkEmail->length == 0) {
							$crudAdd = new CRUD();
							$crudAdd->createUser();
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
		} elseif (isset($_POST['editName']) && isset($_POST['editEmail']) && isset($_POST['editLogin'])) {
			if (!empty(trim($_POST['editName'])) && !empty(trim($_POST['editEmail'])) && !empty(trim($_POST['editLogin']))) {
				$crudUpdate = new CRUD();
				$crudUpdate->updateUser($_POST['editName'], $_POST['editEmail'], $_POST['editLogin'], $_POST['editLoginMain']);
				$responce['res'] = true;
			} else {
				$responce['error'] = 'Поля не должны быть пустыми или заполнены пробелами';
			}
		}
	}
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET['deleteLogin'])) {
		if ($_SESSION['User']['login'] === $_GET['deleteLogin']) {
			$_SESSION['Error'] = 'Вы не можете себя удалить';
		} else {
			$crudDelete = new CRUD();
			$crudDelete->deleteUser($_GET['deleteLogin']);
			$responce['res'] = true;
		}
		header("Location: index.php");
	}
}

echo json_encode($responce);