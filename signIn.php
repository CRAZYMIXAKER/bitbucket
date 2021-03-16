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
	$fields = extractFields($_POST, ['login_sign_in', 'password_sign_in']);
	$validateErrors = messagesValidateSignIn($fields);

	if (empty($validateErrors)) {
		$crudRead = new CRUD();
		$crudRead->readUser($fields['login_sign_in']);
		$responce['res'] = true;
	} else {
		if (isset($validateErrors['Error'])) {
			$responce['error'] = $validateErrors['Error'];
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



// include_once('model/messages.php');
// include_once('core/arr.php');

// if($_SERVER['REQUEST_METHOD'] === 'POST'){
// 	$fields = extractFields($_POST, ['name', 'text']);
// 	$validateErrors = messagesValidate($fields);

// 	if(empty($validateErrors)){
// 		messagesAdd($fields);
// 		header('Location: index.php');
// 		exit();
// 	}
// }
// else{
// 	$fields = ['name' => '', 'text' => ''];
// 	$validateErrors = [];
// }

// include("views/v_add.php");