<?php session_start();
include_once('./crud.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Users</title>
	<script src="./javaScript/jquery-3.5.1.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="shortcut icon" href="./img/test.png" type="image/png" />
	<link rel="stylesheet" href="./css/users.css" />
</head>

<body>
	<div class="main">
		<div class="table">
			<table class="table_main" id="Table">
				<thead>
					<tr>
						<th>Edit</th>
						<th>Имя</th>
						<th>Почта</th>
						<th>Логин</th>
						<th>Уровень Доступа</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$crud = new CRUD();
					$xpath = $crud->xpath;
					$countUsers = $xpath->query("/users/user")->length;
					for ($i = 0; $i < $countUsers; $i++) :
					?>
					<tr>
						<td>
							<a title="Изменить данные пользователя"
								href="./editUser.php?updateName=<?php echo $xpath->query('/users/user')[$i]->getAttribute('name') . "&updateEmail=" . $xpath->query('/users/user')[$i]->getAttribute('email') . "&updateLogin=" . $xpath->query('/users/user')[$i]->getAttribute('login') ?>">
								<img src="./img/Edit.png"></a>
						</td>
						<td>
							<? echo $xpath->query("/users/user")[$i]->getAttribute('name')?>
						</td>
						<td>
							<? echo $xpath->query("/users/user")[$i]->getAttribute('email')?>
						</td>
						<td>
							<? echo $xpath->query("/users/user")[$i]->getAttribute('login')?>
						</td>
						<td>
							<? if($xpath->query("/users/user")[$i]->getAttribute('access')==1) : echo " Админ"; else : echo "Пользователь" ; endif;?>
						</td>
						<td><a title=" Удалить пользователя"
								href="./users.php?delete=<?php echo $xpath->query('/users/user')[$i]->getAttribute('login') ?>">
								<img src=" ./img/Delete.png"></a>
						</td>
					</tr>
					<?php endfor; ?>
				</tbody>
			</table>
		</div>
		<a href="./index.php">На главную</a>
	</div>

	<script src="/javaScript/users.js"></script>
</body>

</html>