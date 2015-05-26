<?php
include("calendario.php");

$f = $_GET["op"];
$s = $_GET["env_nome"];

if($f == "calendario"){

    $data = date("m");

    if($s >= $data)
        MostreCalendario($s);

    else
        echo"Não é possivel agendar retroativo.";
}

else if($f == "hora"){
    echo"<input type='text' name='h' size='20'>";
    echo":";
    echo"<input type='text' name='m' size='20'>";
    echo "<br>";
}

else echo" ENTROU ERRADO";
?>
