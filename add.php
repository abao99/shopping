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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO products (P_Name, P_Introduce, P_Price, P_State) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['P_Name'], "text"),
                       GetSQLValueString($_POST['P_Introduce'], "text"),
                       GetSQLValueString($_POST['P_Price'], "int"),
                       GetSQLValueString($_POST['P_State'], "text"));

  mysql_select_db($database_cartConn, $cartConn);
  $Result1 = mysql_query($insertSQL, $cartConn) or die(mysql_error());

  $insertGoTo = "index.php";
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
<title>新增產品</title>
<script src="tinymce/tinymce.min.js"></script>
<script>tinymce.init({
  selector: 'textarea',
  height: 500,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });</script>


</head>

<body>
<h3 align="center">新增產品</h3>
<hr />

<form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="form1">
<table width="500px" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" bgcolor="#3399FF">新增產品</td>
    </tr>
  <tr>
    <td width="17%">商品名稱&nbsp;:</td>
    <td width="83%"><label for="P_Name"></label>
      <input name="P_Name" type="text" id="P_Name" size="40" /></td>
  </tr>
  <tr>
    <td>商品介紹:</td>
    <td><label for="P_Introduce"></label>
      <textarea name="P_Introduce" id="P_Introduce" cols="50" rows="15"></textarea></td>
  </tr>
  <tr>
    <td>商品單價:</td>
    <td><label for="P_Price"></label>
      NT$
        <input type="text" name="P_Price" id="P_Price" />
      元</td>
  </tr>
  <tr>
    <td>商品狀態:</td>
    <td><label for="P_State"></label>
      <label for="P_State"></label>
      <select name="P_State" id="P_State">
        <option value="正常">正常</option>
        <option value="缺貨">缺貨</option>
      </select></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align: center"><input type="submit" name="button" id="button" value="送出" /></td>
    </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>