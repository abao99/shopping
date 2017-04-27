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
<form action="showcart.php" method="post" id="form1">
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="121" bgcolor="#3399FF">訂單編號</td>
      <td width="124" bgcolor="#3399FF">訂購者</td>
      <td width="160" align="center" bgcolor="#3399FF">日期</td>
      <td width="93" align="center" bgcolor="#3399FF">金額</td>
      <td width="90" align="center" bgcolor="#3399FF">狀態</td>
    </tr>
    <?php 
  $_SESSION['Total']=0;
  foreach($_SESSION['Cart'] as $i => $val){ ?>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="right"><label for="Modify[]"></label></td>
      <td align="right">&nbsp;</td>
    </tr>
    <?php }?>
  </table>
</form>
</body>
</html>