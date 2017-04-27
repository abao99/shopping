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

mysql_select_db($database_cartConn, $cartConn);
$query_Recordset1 = "SELECT * FROM products ORDER BY P_ID DESC";
$Recordset1 = mysql_query($query_Recordset1, $cartConn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>購物車 - 首頁</title>
</head>

<body>
<h3 align="center">購物車</h3>
<hr />
<p></p>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>|<a href="index.php">瀏覽商品</a>|<a href="showcart.php">檢視購物車</a>|<a href="cls.php">清空購物車</a>|<a href="reg.php">註冊</a>|<a href="login.php">登入</a>|</td>
  </tr>
</table>
<p></p>
<form action="" method="post" id="form1">
<table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="443" align="left" bgcolor="#3399FF">商品名稱</td>
    <td width="57" align="center" bgcolor="#3399FF">特價</td>
  </tr>
  <?php do { ?>
    <tr>
      <td width="443" align="left"><a href="product.php?P_ID=<?php echo $row_Recordset1['P_ID']; ?>"><?php echo $row_Recordset1['P_Name']; ?></a></td>
      <td width="57" align="center"><?php echo $row_Recordset1['P_Price']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  
</table>






</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
