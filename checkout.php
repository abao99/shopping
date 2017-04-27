<?php require_once('Connections/cartConn.php'); ?>
<?php
session_start();
	if(!isset($_SESSION['O_ID']))
		$_SESSION['O_ID'] = date("YmdHis").substr(md5(uniqid(rand())),0,10);

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
	foreach($_POST['D_PName'] as $i => $val){		

  $insertSQL = sprintf("INSERT INTO orderdetail (D_OID, D_PName, D_PPrice, D_PQuantity, D_ItemTotal) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['D_OID'], "text"),
                       GetSQLValueString($_POST['D_PName'][$i], "text"),
                       GetSQLValueString($_POST['D_PPrice'][$i], "int"),
                       GetSQLValueString($_POST['D_PQuantity'][$i], "int"),
                       GetSQLValueString($_POST['D_ItemTotal'][$i], "int"));
	
  mysql_select_db($database_cartConn, $cartConn);
  $Result1 = mysql_query($insertSQL, $cartConn) or die(mysql_error());

 } $insertGoTo = "purchase.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<h3 align="center">購物車</h3>
<hr />
<p></p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>|<a href="index.php">瀏覽商品</a>|<a href="showcart.php">檢視購物車</a>|<a href="cls.php">清空購物車</a>|</td>
  </tr>
</table>
<p></p>
<form name="form1" action="<?php echo $editFormAction; ?>" method="POST" id="form1">
  <p>&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp;	&nbsp;	訂單編號:
    <input name="D_OID" type="hidden" id="D_OID" value="<?php echo $_SESSION['O_ID']; ?>">
  <?php echo $_SESSION['O_ID']; ?></p>
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="71" bgcolor="#3399FF">商品編號</td>
      <td width="165" bgcolor="#3399FF">商品名稱</td>
      <td width="134" align="center" bgcolor="#3399FF">單價</td>
      <td width="95" align="center" bgcolor="#3399FF">數量</td>
      <td width="123" align="right" bgcolor="#3399FF">小計</td>
    </tr>
    <?php 
  foreach($_SESSION['Cart'] as $i => $val){ ?>
    <tr>
      <td align="center"><?php echo $_SESSION['Cart'][$i]; ?></td>
      <td><input name="D_PName[]" type="hidden" id="D_PName[]" value="<?php echo $_SESSION['Name'][$i]; ?>">
      <?php echo $_SESSION['Name'][$i]; ?></td>
      <td align="center"><input name="D_PPrice[]" type="hidden" id="D_PPrice[]" value="<?php echo $_SESSION['Price'][$i]; ?>">
      <?php echo $_SESSION['Price'][$i]; ?></td>
      <td align="right"><label for="Modify[]">
        <?php echo $_SESSION['Quantity'][$i]; ?>
        <input name="D_PQuantity[]" type="hidden" id="D_PQuantity[]" value="<?php echo $_SESSION['Quantity'][$i]; ?>">
      </label></td>
      <td align="right"><?php echo $_SESSION['itemTotal'][$i]; ?>        <input name="D_ItemTotal[]" type="hidden" id="D_ItemTotal[]" value="<?php echo $_SESSION['itemTotal'][$i]; ?>"></td>
    </tr>
    <?php }?>
    <tr>
      <td colspan="5" align="right">Total:<?php echo $_SESSION['Total']; ?></td>
    </tr>
    <tr>
      <td colspan="5" align="right"><input type="submit" name="button" id="button" value="送出"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>