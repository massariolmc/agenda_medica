<?php
include("calendario.php");
$mes    = $_GET["mes"];
$espec  = $_GET["espec"];
$crm    = $_GET["medico"];
$op     = $_GET["op"];
//********************************
$data = date("m");
if($mes < $data){
    echo"<blockquote><blockquote><blockquote>Não é possível marcar consulta este mês.</blockquote></blockquote></blockquote>";
    exit();
}
//*********************************

$array = array();
$var = array();
if($op == "dia"){
    include_once 'classes/agenda.class.php';
    $ag = new agenda();
    $ag->extras_select = "WHERE crm=".$crm." AND especialidade='".$espec."' AND Extract('Month' FROM dt )=".$mes." AND Extract('Year' FROM dt )=".date('Y');
    $ag->selecionaTudo($ag);
    $cont = 0;
    $cont = $ag->linhasafetadas;

    if($cont > 0){
    while($res = $ag->retornaDados()){
        $array[] = date('d',strtotime($res->dt));
    }
    $aux = 0;
    $marc = 0;
    $qtde = count($array);                              
    for($i=0; $i<$qtde; $i++){
        $aux2[] = $array[$i];
        if($aux == 0){
            $var[] = $array[$i];
            $aux = 1;
        }
        else{
            $qtde2 = count($aux2)-1;                                      
            for($j=0; $j<$qtde2;$j++){
                if($array[$i] == $aux2[$j]){
                    $marc = 1;
                }                                      
            }
            if($marc == 0){
                 $var[] = $array[$i];                                     
            }
            $marc = 0;
        }
    }
    MostreCalendario($mes,$var);
    }

    else{
    if(date('m') <= $mes)
        echo"<blockquote><blockquote>Não possui agendamento para este mês.</blockquote></blockquote>";
    
    else
        echo"<blockquote><blockquote>O agendamento para esse mês está fechado.</blockquote></blockquote>";
    }

}

else{
    
}
?>

