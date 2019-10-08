//oracle connect
<?php
try{
  $db=new PDO("oci:dbname=dbname;charset=utf8","id","password");
}catch(PDOException $e){
   echo "db connect error...".$e->getMessage();
 }
//$db=null;
?>
