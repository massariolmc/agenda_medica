<?php
if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

$cod      = $_POST["comp"];
$espec      = $_POST["especialidade"];
$crm        = $_POST["crm"];
$dt_atual   = $_POST["dt_consulta"];//DATA ATUAL DA CONSULTA

abreconexao();
$sql = "select c.cd_prontuario as \"PRONTUARIO\" ,nome_paciente as \"PACIENTE\", nome_med as \"MEDICO\",status as \"STATUS\" ,hr_consulta as \"HORA\"
from consultas c
INNER JOIN paciente p ON (c.cd_prontuario=p.cd_prontuario)
INNER JOIN medico m ON (c.crm=m.crm AND c.crm=$crm  AND c.especialidade=m.cd_especialidade AND c.especialidade='".$espec."')
WHERE cd_consulta=".$cod;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
      
      $nome_paciente    = $tbl->PACIENTE;
      $prontuario       = $tbl->PRONTUARIO;
      $nome_med         = $tbl->MEDICO;      
      $hr               = $tbl->HORA;
      $status           = $tbl->STATUS;
    }
}
else{
    echo"A data da consulta atual não existe.";
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
        <script type="text/javascript" src="js/mostra_oculta_campo_4.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>
          
   </head>
    <body>
        <div id="confirmar_consultas"> 
             
        <form id="form_agenda" name="form_agenda" method="POST" action="index.php?p=processa">
            <input type="hidden" name="operacao"        value="confirmar_consultas">                        
            <input type="hidden" name="cd_consulta"   value="<?php echo $cod;?>">
            <input type="hidden" name="especialidade"   value="<?php echo $espec;?>">
            <input type="hidden" name="medico"          value="<?php echo $crm;?>">
            <input type="hidden" name="calendario"      value="<?php echo $dt_atual;?>">            
           
            <fieldset name="agenda">
                <legend>CONFIRMAR CONSULTAS</legend>
                                
                <label>PACIENTE:*</label>
                <input type="text" name="n" size="20" id="n"  value="<?php echo $nome_paciente; ?>" readonly>
                <br/><br/>
                <label>MEDICO:*</label>
                <input type="text" name="n" size="20" id="n"  value="<?php echo $nome_med; ?>" readonly>
                <br/><br/>
                        
                <label>ESPECIALIDADE:*</label>
                <input type="text" name="especialidad" size="20" id="especialidad"  value="<?php echo $espec; ?>" readonly>
                
                <br/><br/>
                
                <label>DATA DA CONSULTA:*</label>
                <input type="text" name="mes" size="20" id="mes"  value="<?php echo $dt_atual; ?>" readonly>
                <br/><br/>  
                <label>HORARIO:</label>
                <input type="text" name="hora" size="20" id="hora"  value="<?php echo $hr; ?>" readonly>
                <br/><br/>         
                
                <label>CONFIRMAR?*:</label>
                <input type="radio" name="comp" value="1" id="comp" >COMPARECEU
                <input type="radio" name="comp" value="0" id="comp" >FALTOU                
                <br><br>
                
                <div id="div_cid">
                <label>CID:</label>
                <input type="text" name="cid" size="20" id="cid">
                <br><br>
                </div>
                <br/><br/>
                
                <input type="submit" value="CONFIRMAR" class="botaoForm">                     
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
