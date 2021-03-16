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
	$fields = extractFields($_POST, ['name', 'email', 'login', 'password', 'confirm_password']);
	$validateErrors = messagesValidateSignUp($fields);

	if (empty($validateErrors)) {
		$crudAdd = new CRUD();
		$crudAdd->createUser($fields['name'], $fields['email'], $fields['login'], $fields['password']);
		$responce['res'] = true;
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