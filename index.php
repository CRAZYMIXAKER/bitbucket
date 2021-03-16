<?php include_once('./crud.php');
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Main</title>
	<script src="./js/jquery-3.5.1.min.js"></script>
	<script src="ajax.js"></script>
	<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
	<link rel="shortcut icon" href="./img/test.png" type="image/png" />
	<link rel="stylesheet" href="./css/main.css" />
</head>

<body>

	<?php if (!isset($_COOKIE["Login"])) {
		unset($_SESSION['User']);
	};
	if (!isset($_SESSION['User'])) : ?>
	<div class="main" id="SingInUp">
		<div class="main__title">
			<a href="#" class="main__title-in">Авторизация</a>
			<a href="#" class="main__title-up">Регистрация</a>
		</div>
		<div class="form">
			<div class="form__sign-in">
				<form class="form__sign sign_in" method="POST">
					<div class="form__item">
						<label class="form__item-label">Логин</label>
						<input type="text" class="form__item-input" name="login_sign_in" />
						<!-- pattern="^[A-Za-zА-Яа-я0-9Ёё\s]{6,}" -->
						<p class="errLogin error"></p>
					</div>
					<div class="form__item">
						<label class="form__item-label">Пароль </label>
						<input type="password" class="form__item-input" name="password_sign_in" />
						<!-- pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$" -->
						<p class="errPassword error">
						</p>
					</div>
					<button class="form__sign-button" id="btn_sign-in">
						Вход
					</button>
					<p class="err error"></p>
				</form>
			</div>
			<div class="form__sign-up form__sign--closed">
				<form class="form__sign sign_up" method="POST">
					<div class="form__item">
						<label class="form__item-label">Имя</label>
						<input type="text" class="form__item-input" name="name" pattern="^[A-Za-zА-Яа-я0-9Ёё\s]{1,2}" required />
					</div>
					<div class="form__item">
						<label class="form__item-label">Почта</label>
						<input type="email" class="form__item-input" name="email" placeholder="example@example.com" required />
						<p class="errEmail error"></p>
					</div>
					<div class=" form__item">
						<label class="form__item-label">Логин</label>
						<input type="text" class="form__item-input" name="login" pattern="^[A-Za-zА-Яа-я0-9Ёё\s]{6,}" required />
						<p class="errLogin error"></p>
					</div>
					<div class="form__item">
						<label class="form__item-label">Пароль</label>
						<input type="password" class="form__item-input" name="password"
							pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$" required />
					</div>
					<div class="form__item">
						<label class="form__item-label">Подтвердите пароль</label>
						<input type="password" class="form__item-input" name="confirm_password"
							pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$" equired />
						<p class="errPassword error"></p>
					</div>
					<button class="form__sign-button" id="btn_sign-up">
						Регистрация
					</button>
					<p class="err error"></p>
				</form>
			</div>
			<div id="fatal_error"></div>
		</div>
	</div>
	<?php else : ?>
	<h2>
		<? echo "Hello, " . $_SESSION['User']['name'];?>
	</h2>
	<?php if ($_SESSION['User']['access'] == 1) : ?>
	<h2>
		<?php echo "Ваш уровень доступа: " . "Администратор, "; ?>
		<a href="./users.php">вы владеете правами редактирования информации пользователей.</a>
	</h2>
	<?php else : ?>
	<h2>
		<?php echo "Ваш уровень доступа: " . "Пользователь"; ?>
	</h2>
	<?php endif; ?>

	<a href="logOut.php">Выход</a>
	<?php endif; ?>

	<script src="./js/scripts.js"></script>
	<script>
	setTimeout("window.location.reload()", 3600000);
	</script>
</body>

</html>