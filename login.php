<?php require_once('Connections/cartConn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['C_Username'])) {
  $loginUsername=$_POST['C_Username'];
  $password=$_POST['C_Password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cartConn, $cartConn);
  
  $LoginRS__query=sprintf("SELECT C_Username, C_Password FROM customer WHERE C_Username=%s AND C_Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $cartConn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員登入</title>
</head>

<body>
<h3 align="center">購物車 - 會員登入</h3>
<hr />
<p></p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>|<a href="index.php">瀏覽商品</a>|檢視購物車|清空購物車|</td>
  </tr>
</table>
<p></p>
<form action="<?php echo $loginFormAction; ?>" method="POST" id="form1">
<table width="300" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#3399FF" style="text-align: center"><p>登入</p></td>
    </tr>
  <tr>
    <td width="57">帳號：</td>
    <td width="243"><label for="C_Username"></label>
      <input type="text" name="C_Username" id="C_Username" /></td>
  </tr>
  <tr>
    <td>密碼：</td>
    <td><label for="C_Password"></label>
      <input type="text" name="C_Password" id="C_Password" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><input type="submit" name="button" id="button" value="送出" /></td>
    </tr>
</table>






</form>
<p>&nbsp;</p>
</body>
</html>