<?php require_once("valida_login.php");     valida_login();?>
<?php
if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

$espec      = $_POST["especialidade"];
$crm        = $_POST["medico"];
$dt_atual   = $_POST["calendario"];//DATA ATUAL DA CONSULTA

if(empty($espec) && empty($crm) && empty($dt_atual)){// ESSE IF É PARA A PAGINA INC_CONFIRMAR_CONSULTAS, ELE MANDA OS DADOS VIA GET
$espec      = $_GET["especialidade"];
$crm        = $_GET["medico"];
$dt_atual   = $_GET["calendario"];//DATA ATUAL DA CONSULTA
}

if($dt_atual >= date("Y/m/d")){
   echo"Sem permissão para confirmar a consulta. Data atual superior a data da consulta.";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    exit(); 
}

//***********************************LOCALIZA O COD DA CONSULTA PARA CANCELAR A CONSULTA
$dia = substr($dt_atual,0,2);
$mes = substr($dt_atual,3,2);
$ano = substr($dt_atual,-4);

$cod = array();
$paciente = array();
$prontuario = array();
$medico = array();
$hora = array();

abreconexao();
$sql = "select cd_consulta as \"CODIGO\",c.cd_prontuario as \"PRONTUARIO\" ,nome_paciente as \"PACIENTE\", nome_med as \"MEDICO\",status as \"STATUS\" ,hr_consulta as \"HORA\"
from consultas c
INNER JOIN paciente p ON (c.cd_prontuario=p.cd_prontuario)
INNER JOIN medico m ON (c.crm=m.crm AND c.crm=$crm  AND c.especialidade=m.cd_especialidade AND c.especialidade='".$espec."')
WHERE Extract('Day' FROM dt_consulta )=$dia AND Extract('Month' FROM dt_consulta )=$mes AND Extract('Year' FROM dt_consulta )=$ano
ORDER BY hr_consulta ASC";
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
      $cod[]        = $tbl->CODIGO;
      $paciente[]   = $tbl->PACIENTE;
      $prontuario[] = $tbl->PRONTUARIO;
      $medico       = $tbl->MEDICO;      
      $hora[]       = $tbl->HORA;
      $status[]       = $tbl->STATUS;
    }
}
else{
    echo"A data da consulta atual não existe..";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    exit();
}    
fechaconexao();

?>  

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CONFIRMAR CONSULTA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>        
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>            
        <script type="text/javascript" src="js/valida_confirma_consulta.js"></script>         
        <script type="text/javascript" src="js/ajax.js"></script>
          
   </head>
    <body>
        <div id="confirmar_consultas"> 
             
        <form id="form_agenda" name="form_agenda" method="POST" action="index.php?p=inc_confirmar_consultas">
            
            <input type="hidden" name="especialidade"   value="<?php echo $espec;?>">
            <input type="hidden" name="crm"             value="<?php echo $crm;?>">
            <input type="hidden" name="dt_consulta"     value="<?php echo $dt_atual;?>">
              
           
            <fieldset name="agenda">
                <legend>CONFIRMAR CONSULTAS</legend>
                
                <?php
                echo"<label>CONSULTAS DO DIA:</label>".$dt_atual."<br>";
                echo"<label>MEDICO:</label>".$medico."<br>";
                echo"<label>ESPECIALIDADE:</label>".$espec."<br>";
                echo"<br>";
                 $c = 2;
                 $cores = array("#e1e1e1","#FFFFFF");          
                 $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <th>Nº DE ORDEM</th>
                            <th>SELECIONE</th>                            
                            <th>HORARIO</th>
                            <th>PRONTUARIO</th>
                            <th>PACIENTE</th>
                            <th>SITUAÇÃO</th>
                            ";
                                       
                 $return = "$tabela";
                 for($i=0;$i<$cont;$i++) {
                        $index = $c % 2;
                        $c++;
                        $cor = $cores[$index];
                            
                        $return.= '<tr bgcolor="'.$cor.'">';
                        $return.= "<td align=center>".($i+1)."</td>";
                        if($status[$i] == 1)
                        $return.= "<td align=center><input type='radio' name='comp'  id='comp' value='".$cod[$i]."'></td>";                        
                        else
                        $return.= "<td align=center>OK</td>";
                        $return.= "<td align=center>" . $hora[$i] . "</td>";                                    
                        $return.= "<td align=center>" . $prontuario[$i] . "</td>";  
                        $return.= "<td align=center>" . $paciente[$i] . "</td>";
                        if($status[$i] == 1)
                            $return.= "<td align=center style=\"color:red;\">AGUARDANDO CONFIRMAÇÃO</td>";
                        else if($status[$i] == 2)
                            $return.= "<td align=center>OK</td>";
                        else if($status[$i] == 4)
                            $return.= "<td align=center>FALTA</td>";
                        
                        $return.= "</tr>";
                }
                    echo $return.="</table>";
                    echo"<br><br>";
       ?>         
           
                <input type="submit" value="CONFIRMAR" class="botaoForm">                     
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
