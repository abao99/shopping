<?php require_once('Connections/cartConn.php'); ?>
<?php
session_start();
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO orders (O_OID, O_CName, O_CAddr, O_CPhone, O_CEmail, O_Date, O_Total, O_State) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['O_OID'], "text"),
                       GetSQLValueString($_POST['O_CName'], "text"),
                       GetSQLValueString($_POST['O_CAddr'], "text"),
                       GetSQLValueString($_POST['O_CPhone'], "text"),
                       GetSQLValueString($_POST['O_CEmail'], "text"),
                       GetSQLValueString($_POST['O_Date'], "date"),
                       GetSQLValueString($_POST['O_Total'], "int"),
                       GetSQLValueString($_POST['O_State'], "text"));

  mysql_select_db($database_cartConn, $cartConn);
  $Result1 = mysql_query($insertSQL, $cartConn) or die(mysql_error());

  $insertGoTo = "mail.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_cartConn, $cartConn);
$query_Recordset1 = sprintf("SELECT * FROM customer WHERE C_Username = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $cartConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<h3 align="center">購物車 - 確認訂單</h3>
<hr />
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>|<a href="index.php">瀏覽商品</a>|<a href="showcart.php">檢視購物車</a>|<a href="cls.php">清空購物車</a>|</td>
  </tr>
</table>
<p>&nbsp;</p>
<form name="form1" action="<?php echo $editFormAction; ?>" method="POST" id="form1">
  <table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="74">訂單編號：</td>
      <td width="420"><label for="C_Username"><?php echo $_SESSION['O_ID']; ?></label></td>
    </tr>
    <tr>
      <td>姓名:</td>
      <td><label for="O_CPhone"></label>
        <input name="O_CName" type="text" id="O_CName" value="<?php echo $row_Recordset1['C_Name']; ?>" /></td>
    </tr>
    <tr>
      <td>電話：</td>
      <td><label for="O_CPhone"></label>
        <input name="O_CPhone" type="text" id="O_CPhone" value="<?php echo $row_Recordset1['C_Phone']; ?>" /></td>
    </tr>
    <tr>
      <td>Emai：</td>
      <td><label for="O_CEmail"></label>
        <input name="O_CEmail" type="text" id="O_CEmail" value="<?php echo $row_Recordset1['C_Email']; ?>" /></td>
    </tr>
    <tr>
      <td>住址：</td>
      <td><label for="O_CAddr"></label>
        <input name="O_CAddr" type="text" id="O_CAddr" value="<?php echo $row_Recordset1['C_Addr']; ?>" size="56" /></td>
    </tr>
    <tr>
      <td colspan="2" align="right"><a href="login.php">
        <input name="O_OID" type="hidden" id="O_OID" value="<?php echo $_SESSION['O_ID']; ?>">
        <input name="O_Date" type="hidden" id="O_Date" value="<?php echo date("Y-m-d H:i:s"); ?>">
        <input name="O_Total" type="hidden" id="O_Total" value="<?php echo $_SESSION['Total']; ?>">
        <input type="hidden" name="O_State" id="O_State">
        登入</a>
        <input type="submit" name="button" id="button" value="註冊" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
