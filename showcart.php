<?php session_start(); 
	if(isset($_POST['Modify'])){
		foreach($_SESSION['Quantity'] as $i => $val){
			$_SESSION['Quantity'][$i] = $_POST['Modify'][$i];
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>購物車清單</title>
</head>

<body>
<h3 align="center">購物車 - 購物車清單</h3>
<hr />
<p></p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>|<a href="index.php">瀏覽商品</a>|<a href="showcart.php">檢視購物車</a>|<a href="cls.php">清空購物車</a>|</td>
  </tr>  
</table>
<p></p>
<form action="showcart.php" method="post" id="form1">
<table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="80" bgcolor="#3399FF">商品編號</td>
    <td width="350" bgcolor="#3399FF">商品名稱</td>
    <td width="50" align="center" bgcolor="#3399FF">單價</td>
    <td width="30" align="right" bgcolor="#3399FF">數量</td>
    <td width="90" align="right" bgcolor="#3399FF">小計</td>
  </tr>
  <?php 
  $_SESSION['Total']=0;
  foreach($_SESSION['Cart'] as $i => $val){ ?>
  <tr>        
    <td align="center"><?php echo $_SESSION['Cart'][$i]; ?></td>
    <td><?php echo $_SESSION['Name'][$i]; ?></td>
    <td align="center"><?php echo number_format($_SESSION['Price'][$i]); ?></td>
    <td align="right"><label for="Modify[]"></label>
      <input name="Modify[]" type="text" id="Modify[]" value="<?php echo $_SESSION['Quantity'][$i]; ?>" size="5" /></td>
    <td align="right">
    <?php //小計與總價格
		echo number_format($_SESSION['itemTotal'][$i] = $_SESSION['Price'][$i] * $_SESSION['Quantity'][$i]);
		$_SESSION['Total'] += $_SESSION['itemTotal'][$i];
    ?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="5" align="right">Total:<?php echo number_format($_SESSION['Total']); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><a href="checkout.php">
      <input type="image" name="imageField" id="imageField" src="img/update.png" />
      <img src="img/pay.png" width="61" height="24" /></a></td>
  </tr>
</table>






</form>
</body>
</html>