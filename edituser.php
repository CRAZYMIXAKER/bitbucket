<?php session_start();
include_once('./crud.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>EditUser</title>
	<script src="./javaScript/jquery-3.5.1.min.js"></script>
	<script src="./javaScript/ajax.js"></script>
	<link rel="shortcut icon" href="./img/test.png" type="image/png" />
	<link rel="stylesheet" href="./css/edituser.css" />
</head>

<body>
	<div class="main">
		<div class="main__information">
			<p>Форма, служит лишь для того, чтоб показать работаспособность редактирования бд (в форме нет проверок на
				совпадение почты и логина)</p>
			<div class="main__information-form">
				<form class="form" method="POST">
					<div class=" form__item">
						<label class="form__item-label">Name</label>
						<input class="form__item-input" type="text" name="name" value="<? echo $_GET['updateName']?>" />
						<p class="errName error"></p>
					</div>
					<div class="form__item">
						<label class="form__item-label">Email</label>
						<input class="form__item-input" type="text" name="email" value="<? echo $_GET['updateEmail']?>" />
						<p class="errEmail error"></p>
					</div>
					<div class="form__item">
						<label class="form__item-label">Login</label>
						<input class="form__item-input" type="text" name="login" value="<? echo $_GET['updateLogin']?>" />
					</div>
					<button class="form__item-button" id="btn_edit">Edit</button>
					<p class="err error"></p>
				</form>
			</div>
		</div>
		<div class="main__back">
			<a href="users.php" class="main__back-link">Вернуться</a>
		</div>
	</div>
</body>

</html>