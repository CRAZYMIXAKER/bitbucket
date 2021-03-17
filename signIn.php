<?php session_start();
include_once("./crud.php");
include_once('messages.php');
include_once('arr.php');

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