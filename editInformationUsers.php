<?php session_start();
include_once("./crud.php");
include_once('messages.php');
include_once('arr.php');

$responce = [
	'res' => false,
	'error' => '',
	'errorLogin' => '',
	'errorEmail' => '',
	'errorPassword' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// $fields = extractFields($_POST, ['login_sign_in', 'password_sign_in']);
	$validateErrors = messagesValidateSignIn($fields);

	if (empty($validateErrors)) {
		// $crudRead = new CRUD();
		// $crudRead->readUser($fields['login_sign_in']);
		// $responce['res'] = true;
	} else {

		if (isset($validateErrors['Error'])) {
			$responce['error'] = $validateErrors['Error'];
		}
		if (isset($validateErrors['Email'])) {
			$responce['errorEmail'] = $validateErrors['Email'];
		}
		if (isset($validateErrors['Login'])) {
			$responce['errorLogin'] = $validateErrors['Login'];
		}
		if (isset($validateErrors['Password'])) {
			$responce['errorPassword'] = $validateErrors['Password'];
		}
	}
}

echo json_encode($responce);


	// } elseif (isset($_POST['editName']) && isset($_POST['editEmail']) && isset($_POST['editLogin'])) {
	// 	if (!empty(trim($_POST['editName'])) && !empty(trim($_POST['editEmail'])) && !empty(trim($_POST['editLogin']))) {
	// 		$crudUpdate = new CRUD();
	// 		$crudUpdate->updateUser($_POST['editName'], $_POST['editEmail'], $_POST['editLogin'], $_POST['editLoginMain']);
	// 		$responce['res'] = true;
	// 	} else {
	// 		$responce['error'] = 'Поля не должны быть пусfxxfxcbтыми или заполнены пробелами';
	// 	}