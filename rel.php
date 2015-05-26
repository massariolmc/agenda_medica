<?php

$rel    = $_POST["rel"];
$mesano = $_POST["mesano"];
$crm    = $_POST["medico"];
$esp    = $_POST["especialidade"];
$cid    = $_POST["cid"];
$pos    = strpos($mesano,'/');
$mes    = substr($mesano, 0, $pos);
$ano    = substr($mesano, $pos+1, 4);

if($rel == 1){
     header("Location: rel/atendidas/rel_todos_atendimentos.php?mes=$mes&ano=$ano&i=RELATÓRIO DE TODOS OS ATENDIMENTOS");
}
else if($rel == 2){
     header("Location: rel/atendidas/rel_atendidas_med.php?mes=$mes&ano=$ano&crm=$crm&i=RELATÓRIO DE ATENDIMENTOS POR MÉDICO");
}
else if($rel == 3){
     header("Location: rel/atendidas/rel_atendidas_esp.php?mes=$mes&ano=$ano&esp=$esp&i=RELATÓRIO DE ATENDIMENTOS POR ESPECIALIDADE");
}
else if($rel == 4){
     header("Location: rel/cancelados/rel_todos_cancelados.php?mes=$mes&ano=$ano&i=RELATÓRIO DE TODAS CONSULTAS CANCELADAS");
}
else if($rel == 5){
     header("Location: rel/cancelados/rel_cancelados_med.php?mes=$mes&ano=$ano&crm=$crm&i=RELATÓRIO TODAS CONSULTAS CANCELADAS POR MÉDICO");
}
else if($rel == 6){
     header("Location: rel/cancelados/rel_cancelados_esp.php?mes=$mes&ano=$ano&esp=$esp&i=RELATÓRIO TODAS CONSULTAS CANCELADAS POR ESPECIALIDADE");
}
else if($rel == 7){
     header("Location: rel/faltas/rel_todas_faltas.php?mes=$mes&ano=$ano&i=RELATÓRIO TOTAL DE ABSENTEÍSMO");
}
else if($rel == 8){
     header("Location: rel/faltas/rel_faltas_med.php?mes=$mes&ano=$ano&crm=$crm&i=TOTAL DE ABSENTEÍSMO POR MÉDICO");
}
else if($rel == 9){
     header("Location: rel/faltas/rel_faltas_esp.php?mes=$mes&ano=$ano&esp=$esp&i=TOTAL DE ABSENTEÍSMO POR ESPECIALIDADE");
}
else if($rel == 10){
     header("Location: rel/qtde/rel_qtde.php?mes=$mes&ano=$ano&i=RELATÓRIO DA QUANTIDADE CONSULTAS POR ESPECIALIDADE");
}
else if($rel == 11){
     header("Location: rel/qtde/rel_qtde_cid?mes=$mes&ano=$ano&i=RELATÓRIO DA QUANTIDADES TOTAL DE CIDS");
}
else if($rel == 12){
     header("Location: rel/imp/rel_paciente_cid.php?mes=$mes&ano=$ano&cid=$cid&i=RELATÓRIO DE CID POR PACIENTE");
}
else if($rel == 13){
     header("Location: rel/qtde/rel_qtde_idade.php?mes=$mes&ano=$ano&i=RELATÓRIO DOS PACIENTES POR GRUPO");
}
else{
    echo"NÃO ENCONTRADO2.";
}



?>

