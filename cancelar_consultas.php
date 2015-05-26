<?php require_once("valida_login.php");     valida_login();?>
<?php
if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

$prontuario = $_POST["prontuario"];
$espec      = $_POST["especialidade"];
$crm        = $_POST["medico"];
$dt_atual   = $_POST["calendario"];//DATA ATUAL DA CONSULTA

//***********************************LOCALIZA O COD DA CONSULTA PARA CANCELAR A CONSULTA
$dia = substr($dt_atual,0,2);
$mes = substr($dt_atual,3,2);
$ano = substr($dt_atual,-4);

require_once("classes/consultas.class.php");
$c = new consultas();
$c->extras_select = "WHERE status=1 AND cd_prontuario=".$prontuario." AND crm=".$crm." AND especialidade='".$espec."' AND Extract('Day' FROM dt_consulta )=".$dia." AND Extract('Month' FROM dt_consulta )=".$mes." AND Extract('Year' FROM dt_consulta )=".$ano;
$c->selecionaTudo($c);
$cont = $c->linhasafetadas;

if($cont <= 0){
    echo"A data da consulta atual não existe.";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    exit();
}
else{
  
    while ($res = $c->retornaDados()) {
        $cd_consulta = $res->cd_consulta; 
        $obs_aux = $res->obs;
    }
}

//***********************************VERIFICA O NOME DO PACIENTE
 abreconexao();
$sql = "SELECT nome_paciente FROM paciente WHERE cd_prontuario=".$prontuario;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
      $nome_paciente = $tbl->nome_paciente;
    }
}
fechaconexao();        

 //***********************************VERIFICA O NOME DO MEdico        
abreconexao();
$sql = "SELECT nome_med FROM medico WHERE crm=".$crm;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
      $nome_med = $tbl->nome_med;
   }
}
fechaconexao();  


//***********************************VERIFICA SE TEM HORA MARCADA
abreconexao();

$sql = "SELECT hr_consulta FROM consultas WHERE cd_consulta=".$cd_consulta;
$query = pg_query($sql);
$cont =  pg_affected_rows($query);       
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
        $hr = $tbl->hr_consulta;        
    } 
}

fechaconexao();    


?>  

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ALTERAR CONSULTA</title>
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
             
        <form id="form_alt_consulta" name="form_alt_consulta" method="POST" action="index.php?p=processa">
            <input type="hidden" name="operacao"        value="cancelar_consultas">
            <input type="hidden" name="cd_consulta"     value="<?php echo $cd_consulta;?>">
            <input type="hidden" name="prontuario"      value="<?php echo $prontuario;?>">
            <input type="hidden" name="especialidade"   value="<?php echo $espec;?>">
            <input type="hidden" name="crm"             value="<?php echo $crm;?>">
            <input type="hidden" name="dt_consulta"     value="<?php echo $dt_atual;?>">
            <input type="hidden" name="obs_aux"         value="<?php echo $obs_aux;?>">
            
           
            <fieldset name="agenda">
                <legend>CANCELAR CONSULTAS</legend>
                                
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
                <br/>  
                
                <label>OBSERVAÇÃO:</label>
                <textarea name="obs" rows="5" id="obs"  cols="42" placeholder="Colocar aqui o motivo do cancelamento..."></textarea>
                <br/><br/>
                
                <br/><br/>
                
                <input type="submit" value="CONFIRMAR CANCELAMENTO" class="botaoForm">                     
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
