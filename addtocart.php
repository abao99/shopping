<?php
	session_start();
	 if(isset($_SESSION['Cart'])){
		 if(in_array($_POST['P_ID'],$_SESSION['Cart'])){
			 header ('Content-type: text/html; charset=utf-8');
			 die("<a href=javascript:history.back(-1)>商品已在購物車內</a>");
		 }
	 }
	 $_SESSION['Cart'][]=$_POST['P_ID'];
	 $_SESSION['Name'][]=$_POST['P_Name'];
	 $_SESSION['Price'][]=$_POST['P_Price'];
	 $_SESSION['Quantity'][]=1;
	 header("Location:showcart.php");
?>