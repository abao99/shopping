<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<?php
	session_start();
	unset($_SESSION['O_ID']);
	unset($_SESSION['Cart']);
	unset($_SESSION['Name']);
	unset($_SESSION['Price']);
	unset($_SESSION['Quantity']);
	header("Location:index.php");
?>
</body>
</html>