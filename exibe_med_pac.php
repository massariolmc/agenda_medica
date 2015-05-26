<?php
//include("conecta.php");
if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

$espec      = $_POST["especialidade"];
$crm        = $_POST["medico"];
$dt_atual   = $_POST["calendario"];//DATA ATUAL DA CONSULTA

//***********************************LOCALIZA O COD DA CONSULTA PARA CANCELAR A CONSULTA
$dia = substr($dt_atual,0,2);
$mes = substr($dt_atual,3,2);
$ano = substr($dt_atual,-4);

require_once("classes/consultas.class.php");
$c = new consultas();
$c->extras_select = "WHERE crm=".$crm." AND especialidade='".$espec."' AND Extract('Month' FROM dt_consulta )=".$mes." AND Extract('Year' FROM dt_consulta )=".$ano." ORDER BY dt_consulta,status ASC";
$c->selecionaTudo($c);
$cont = $c->linhasafetadas;

if($cont <= 0){//FIZ UMA ALTERAÇÃO. ELE PROCURA AS CONSULTAS MARCADAS NO MES, E NO SOMENTE NO DIA. VAI DAR ERRO SE
    echo"A data da consulta atual não existe.";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    exit();
}
else{
  
    while ($res = $c->retornaDados()) {
        $prontuario[] = $res->cd_prontuario;
        $cd_consulta[] = $res->cd_consulta;
        $hr[] = $res->hr_consulta;  
        $status[] = $res->status; 
        $dia_r[] = date('d',strtotime($res->dt_consulta));
        $mes_r[] = date('m',strtotime($res->dt_consulta));
    }
}

//***********************************VERIFICA O NOME DO PACIENTE
 abreconexao();
$k = 0;
$k = count($prontuario);
 for($i=0; $i < $k; $i++){
    $sql = "SELECT nome_paciente FROM paciente WHERE cd_prontuario=".$prontuario[$i];
    $query = pg_query($sql);
    $cont = pg_affected_rows($query); 
        if($cont > 0){
            while($tbl = pg_fetch_object($query)){
            $nome_paciente[] = $tbl->nome_paciente;
            }
        }
}
fechaconexao();        

 //***********************************VERIFICA O NOME DO MEdico        
abreconexao();
    for($i=0; $i < $k; $i++){
        $sql = "SELECT nome_med FROM medico WHERE crm=".$crm;
        $query = pg_query($sql);
        $cont = pg_affected_rows($query); 
            if($cont > 0){
                while($tbl = pg_fetch_object($query)){
                    $nome_med = $tbl->nome_med;
                }
            }
    }
fechaconexao();  



?>  

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>EXIBIR AGENDAMENTO POR DIA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>        
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>            
        <script type="text/javascript" src="js/valida_cad_agenda.js"></script> 
        <script type="text/javascript" src="js/ajax.js"></script>
          
   </head>
    <body>
        <div id="alt_cad_consulta"> 
             
        <form id="form_alt_consulta" name="form_alt_consulta" method="POST" >          
            <fieldset name="agenda">
                <legend>PACIENTES AGENDADOS</legend>
                <?php 
                    $c = 2;
                    $cores = array("#2E82FF","#FFFFFF");  
        
                    $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                            
                            <th>DIA</th>
                            <th>MES</th>
                            <th>PACIENTE</th>
                            <th>ESPECIALIDADE</th>
                            <th>MEDICO</th>
                            <th>HORARIO</th>
                            <th>STATUS</th>";                            
                                       
                    $return = "$tabela";
                    // Captura os dados da consulta e inseri na tabela HTML
                        $k = 0;
                        $k = count($prontuario);
                        for($i=0; $i < $k; $i++){
            
                            $index = $c % 2;
                            $c++;
                            $cor = $cores[$index];
            
                            $return.= '<tr bgcolor="'.$cor.'">';
                            if($dia == $dia_r[$i]){
                            $return.= "<td><font color='ff0000'>" . $dia_r[$i] . "</font></td>"; 
                            $return.= "<td><font color='ff0000'>" . $mes_r[$i] . "</font></td>";
                            $return.= "<td><font color='ff0000'>" . $nome_paciente[$i] . "</font></td>";
                            $return.= "<td><font color='ff0000'>" . $espec . "</font></td>";
                            $return.= "<td><font color='ff0000'>" . $nome_med . "</font></td>";
                            $return.= "<td><font color='ff0000'>" . $hr[$i] . "</font></td>";
                            if($status[$i]  == 1)
                                $return.= "<td><font color='ff0000'>AGENDADO</font></td>";
                            else if($status[$i]  == 2)
                                $return.= "<td><font color='ff0000'>ATENDIDO</font></td>";
                            else if($status[$i]  == 3)
                                $return.= "<td><font color='ff0000'>CANCELADO</font></td>";
                            else
                                $return.= "<td><font color='ff0000'>FALTOU</font></td>";
                            }
                            else{
                              $return.= "<td>" . $dia_r[$i] . "</td>"; 
                            $return.= "<td>" . $mes_r[$i] . "</td>";
                            $return.= "<td>" . $nome_paciente[$i] . "</td>";
                            $return.= "<td>" . $espec . "</td>";
                            $return.= "<td>" . $nome_med . "</td>";
                            $return.= "<td>" . $hr[$i] . "</td>";
                            if($status[$i]  == 1)
                                $return.= "<td>AGENDADO</td>";
                            else if($status[$i]  == 2)
                                $return.= "<td>ATENDIDO</td>";
                            else if($status[$i]  == 3)
                                $return.= "<td>CANCELADO</td>";
                            else
                                $return.= "<td>FALTOU</td>";                              
                            }
                            $return.= "</tr>";
                        }
                    echo $return.="</table>";
                    echo"<br>";echo"<br>";
                
                ?>         
                
                <input type="button" value="OK" class="botaoForm" onclick="javascript:window.location.href='index.php?p=adm'">                     
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
