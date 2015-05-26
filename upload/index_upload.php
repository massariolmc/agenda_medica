
<?php
include("upload.php");
$saram = $_POST["saram"];
$var = array();
$var = le_arquivo("CONTRIB.csv",$saram);
$var1 = le_arquivo("DEPEN.csv",$saram);
$aux = array_merge((array)$var, (array)$var1);//CONCATENA ARRAYS
imprimir($aux,$saram);
echo"<br>";
$frase = "Militares cadastrados na DIRSA, que podem utilizar os beneficos do Esquadrão de Saúde da BACG";
echo utf8_decode($frase);
echo"<br><a href='../index.php?p=saram'>Inicio</a>";


?>