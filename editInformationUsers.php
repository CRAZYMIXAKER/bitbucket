<?php
session_start();
include_once("./crud.php");
include_once('messages.php');
include_once('arr.php');

$workWithXML = new CRUD();
$xpath = $workWithXML->xpath;
$salt = $workWithXML->salt;

$responce = [
	'res' => false,
	'error' => '',
	'errorName' => '',
	'errorEmail' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fields = extractFields($_POST, ['name', 'email', 'login']);
	$validateErrors = messagesValidateEditUser($fields);

	if (empty($validateErrors)) {
		$crudUpdate = new CRUD();
		$crudUpdate->updateUser($fields['name'], $fields['email'], $fields['login']);
		$responce['res'] = true;
	} else {
		if (isset($validateErrors['Error'])) {
			$responce['error'] = $validateErrors['Error'];
		}
		if (isset($validateErrors['Name'])) {
			$responce['errorName'] = $validateErrors['Name'];
		}
		if (isset($validateErrors['Email'])) {
			$responce['errorEmail'] = $validateErrors['Email'];
		}
	}
}

echo json_encode($responce);