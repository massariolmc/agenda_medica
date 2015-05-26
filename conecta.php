<?php

$con=-1;
function abreconexao(){ //sql=>string sql   //var=> nome do campo que vai mostrar ex. nome do medico/ prontuario                       
$servidor	= 'localhost';
$porta          = '5432';
$usuario	= 'postgres';
$senha          = '123456';
$nomebanco	= 'agenda_medica';     

$con = pg_connect("host=$servidor port=$porta dbname=$nomebanco user=$usuario password=$senha") or die ("ERROn");
}

function fechaconexao(){
  pg_close($con);
  $con=-1;
}
?> 
