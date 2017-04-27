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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="reg.php";
  $loginUsername = $_POST['C_Username'];
  $LoginRS__query = sprintf("SELECT C_Username FROM customer WHERE C_Username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_cartConn, $cartConn);
  $LoginRS=mysql_query($LoginRS__query, $cartConn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO customer (C_Username, C_Password, C_Name, C_Addr, C_Phone, C_Email) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['C_Username'], "text"),
                       GetSQLValueString($_POST['C_Password'], "text"),
                       GetSQLValueString($_POST['C_Name'], "text"),
                       GetSQLValueString($_POST['C_Addr'], "text"),
                       GetSQLValueString($_POST['C_Phone'], "text"),
                       GetSQLValueString($_POST['C_Email'], "text"));

  mysql_select_db($database_cartConn, $cartConn);
  $Result1 = mysql_query($insertSQL, $cartConn) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員註冊</title>
</head>

<body>
<h3 align="center">購物車 - 會員註冊</h3>
<hr />
<form name="form1" action="<?php echo $editFormAction; ?>" method="POST" id="form1">
<table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#3399FF" style="text-align: center"><p>註冊</p></td>
    </tr>
  <tr>
    <td width="74">帳號：</td>
    <td width="420"><label for="C_Username"></label>
      <input name="C_Username" type="text" id="C_Username" /></td>
  </tr>
  <tr>
    <td>密碼：</td>
    <td><label for="C_Password"></label>
      <input type="text" name="C_Password" id="C_Password" /></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><label for="C_Email"></label>
      <input type="text" name="C_Email" id="C_Email" /></td>
  </tr>
  <tr>
    <td>姓名：</td>
    <td><label for="C_Name"></label>
      <input type="text" name="C_Name" id="C_Name" /></td>
  </tr>
  <tr>
    <td>電話：</td>
    <td><label for="C_Phone"></label>
      <input type="text" name="C_Phone" id="C_Phone" /></td>
  </tr>
  <tr>
    <td>住址：</td>
    <td><label for="C_Addr"></label>
      <input name="C_Addr" type="text" id="C_Addr" size="56" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="login.php">登入</a>      <input type="submit" name="button" id="button" value="註冊" /></td>
    </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" />






</form>
<p>&nbsp;</p>
</body>
</html>