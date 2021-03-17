<?php
include_once("./crud.php");

function messagesValidateSignIn(array &$fields): array
{
	$errors = [];
	$patternLogin = '/^[a-zA-Zа-яА-ЯЁё0-9]{6,32}$/u';
	$patternPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,32}$$/u';
	if (checkUser($fields)->length == 0) {
		$errors['Error'] = 'Неправильный логин или пароль';
	}

	if (empty($fields['login_sign_in']) || empty($fields['password_sign_in'])) {
		$errors['Error'] = 'Поля не должны быть пустыми или заполнены пробелами!';
	}

	if (!preg_match($patternLogin, $fields['login_sign_in'])) {
		$errors['Login'] = 'Логин должен, состоять только из букв и цифр, и не быть короче 6 символов и длинее 32';
	}

	if (!preg_match($patternPassword, $fields['password_sign_in'])) {
		$errors['Password'] = 'Пароль, обязательно должен содержать цифру, буквы в разных регистрах и спец символ (знаки) и не быть короче 6 символов и длинее 32';
	}

	return $errors;
}

function messagesValidateSignUp(array &$fields): array
{
	$errors = [];
	$patternName = '/^[a-zA-Zа-яА-ЯЁё0-9]{2,2}$/u';
	$patternLogin = '/^[a-zA-Zа-яА-ЯЁё0-9]{6,32}$/u';
	$patternPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,32}$$/u';

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

	if (!preg_match($patternName, $fields['name'])) {
		$errors['Name'] = 'Имя должно, состоять только из букв и цифр, и 2 символов';
	}

	if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['Email'] = 'Введите валидную почту';
	}

	if (!preg_match($patternLogin, $fields['login'])) {
		$errors['Login'] = 'Логин должен, состоять только из букв и цифер, и не быть короче 6 символов и длинее 32';
	}

	if (!preg_match($patternPassword, $fields['password'])) {
		$errors['Password'] = 'Пароль, обязательно должен содержать цифру, буквы в разных регистрах и спец символ (знаки) и не быть короче 6 символов и длинее 32';
	}

	return $errors;
}

function messagesValidateEditUser(array &$fields): array
{
	$errors = [];
	$patternName = '/^[a-zA-Zа-яА-ЯЁё0-9]{2,2}$/u';

	if (empty($fields['name']) || empty($fields['email']) || empty($fields['login'])) {
		$errors['Error'] = 'Поля не должны быть пустыми или заполнены пробелами!';
	}

	if (!preg_match($patternName, $fields['name'])) {
		$errors['Name'] = 'Имя должно, состоять только из букв и цифр, и 2 символов';
	}

	if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['Email'] = 'Введите валидную почту';
	}

	return $errors;
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
