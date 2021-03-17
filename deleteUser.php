<?php session_start();
include_once("./crud.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET['deleteLogin'])) {
		if ($_SESSION['User']['login'] != $_GET['deleteLogin']) {
			$crudDelete = new CRUD();
			$crudDelete->deleteUser($_GET['deleteLogin']);
			header("Location: users.php?success=1");
		} else {
			header("Location: users.php?success=0");
		}
	}
}