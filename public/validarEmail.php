<?php
$EMail  = "";
$User   = "";
$Domain = "";

$EMail = $_POST['email'];
list($User, $Domain) = explode("@", $EMail);
//nao existe usuario
if(checkdnsrr($Domain,"MX")){
    echo json_encode(array("valido"=>"1"));
  }else{
    echo json_encode(array("valido"=>"0"));
  }
?>
