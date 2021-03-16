<?php
include_once("./crud.php");

function messagesValidateSignIn(array &$fields): array
{
	$errors = [];
	$loginLen = mb_strlen($fields['login_sign_in'], 'UTF-8');
	$passwordLen = mb_strlen($fields['password_sign_in'], 'UTF-8');

	if (checkUser($fields)->length == 0) {
		$errors['Error'] = 'Неправильный логин или пароль';
	}

	if (empty($fields['login_sign_in']) || empty($fields['password_sign_in'])) {
		$errors['Error'] = 'Поля не должны быть пустыми или заполнены пробелами!';
	}

	if ($loginLen < 6) {
		$errors['Login'] = 'Логин не короче 6 символов!';
	}

	if ($loginLen > 15) {
		$errors['Login'] = 'Логин не длинее 15 символов!';
	}

	if ($passwordLen < 5) {
		$errors['Password'] = 'Пароль не короче 5 символов!';
	}

	return $errors;
	// $fields['name'] = htmlspecialchars($fields['name']);
	// $fields['text'] = htmlspecialchars($fields['text']);
}

function messagesValidateSignUp(array &$fields): array
{
	$errors = [];

	if (empty($fields['name']) || empty($fields['email']) || empty($fields['login']) || empty($fields['password']) || empty($fields['confirm_password'])) {
		$errors['Error'] = 'Поля не должны быть пустыми или заполнены пробелами!';
	}

	if (checkEmail($fields)->length != 0) {
		$errors['Email'] = 'Пользователь, с такой почтой уже существует, выберите пожалуйста другую почту';
	}

	if (checkLogin($fields)->length != 0) {
		$errors['Login'] = 'Пользователь, с таким логином уже существует, выберите пожалуйста другой логин';
	}
	if ($fields['password'] != $fields['confirm_password']) {
		$errors['Password'] = 'Пароли, должны быть одинаковыми';
	}

	// if ($loginLen < 6) {
	// 	$errors['Login'] = 'Логин не короче 6 символов!';
	// }

	// if ($loginLen > 15) {
	// 	$errors['Login'] = 'Логин не длинее 15 символов!';
	// }

	// if ($passwordLen < 5) {
	// 	$errors['Password'] = 'Пароль не короче 5 символов!';
	// }

	return $errors;
	// $fields['name'] = htmlspecialchars($fields['name']);
	// $fields['text'] = htmlspecialchars($fields['text']);
}

function checkEmail(array &$fields)
{
	$workWithXML = new CRUD();
	$xpath = $workWithXML->xpath;

	$email = $fields['email'];
	$checkEmail = $xpath->query("/users/user[@email = '$email']");

	return $checkEmail;
}

function checkLogin(array &$fields)
{
	$workWithXML = new CRUD();
	$xpath = $workWithXML->xpath;

	$login = $fields['login'];
	$checkLogin = $xpath->query("/users/user[@login = '$login']");

	return $checkLogin;
}

function checkUser(array &$fields)
{
	$workWithXML = new CRUD();
	$xpath = $workWithXML->xpath;
	$salt = $workWithXML->salt;

	$login = $fields['login_sign_in'];
	$password = $fields['password_sign_in'];
	$checkPassword = md5(md5($password) . $salt);
	$checkUser = $xpath->query("/users/user[@login = '$login' and @password = '$checkPassword']");

	return $checkUser;
}