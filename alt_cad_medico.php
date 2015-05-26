<?php require_once("valida_login.php");     valida_login();?>
<?php

$cod = $_GET["cd"];
$i = $_GET["i"];
include 'classes/medico.class.php';
$medico = new medicos();
$medico->extras_select = "WHERE cd_med=".$cod;
$medico->selecionaTudo($medico);
$res = $medico->retornaDados();
$cont = $medico->linhasafetadas;     

abreconexao();
$sql = "SELECT * FROM usuarios WHERE usuario='".$login."'";
            $query = pg_query($sql);
            $cont = pg_affected_rows($query); 
            if($cont > 0){
                while($tbl = pg_fetch_object($query)){
                    $cd_acesso = $tbl->cd_acesso;
                }
            }

fechaconexao();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ALTERAR CADASTRO DO MEDICO</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
        <script type="text/javascript" src="js/calendario.js"></script>        
        <script type="text/javascript" src="js/mascaravalidacao.js"></script>
        <script type="text/javascript" src="js/valida_cad_medico.js"></script>
        
    </head>
    <body>
        <div id="cadastra"> 
             
        <form id="form_medico" name="form_medico" method="POST" action="processa.php">
            <input type="hidden" name="operacao" value="alt_med">
            <input type="hidden" name="cd_acesso" value="<?php echo $cd_acesso;?>">
            <fieldset name="incluir">
                <legend>ALTERAR DADOS DOS MEDICOS</legend>
                <p>INSIRA OS DADOS:</p>
                
                <label>MEDICO Nº:</label>
                <input type="text" name="cd_med" size="20" id="cd_med"  maxlength="5" value="<?php echo $res->cd_med; ?>" readonly>               
                <br/><br/>
                
                <label>CRM MEDICO:*</label>
                <input type="text" name="crm" size="20" id="crm" maxlength="5" value="<?php echo $res->crm; ?>"readonly>               
                <br/><br/>
                
                <label>NOME COMPLETO:*</label>
                <input type="text" name="nome" size="20" id="nome" value="<?php echo $res->nome_med; ?>">               
                <br/><br/>
                
                <label>ESPECIALIDADE:*</label>
                <select name="especialidade" id="especialidade">
                    <option value="">SELECIONAR</option>
                    <option value="<?php echo $res->cd_especialidade;?>" selected="selected"> <?php echo $res->cd_especialidade;?></option>  
                     <?php
                        
                            abreconexao();                            
                            $sql = "SELECT especialidade FROM especialidade";
                            $query = pg_query($sql);
                            while($tbl = pg_fetch_object($query)){
                            echo "<option value='".$tbl->especialidade."'>".$tbl->especialidade."</option>";
                            } 
                           fechaconexao();
                    ?>                   
                </select>                            
                
                <br/><br>
                
                <label>DATA NASC*:</label>
                <input type="text" name="dt_nasc" id="calendario" size="20" value="<?php echo date('d/m/Y',strtotime($res->dt_nasc)); ?>">
                <br/><br>
                
                <label>SITUAÇÃO:*</label>
                <input type="radio" name="situacao" id ="situacao" value="1" <?php echo $res->situacao == '1' ? 'checked=\"checked\"' : "";?>>ATIVO
                <input type="radio" name="situacao" id ="situacao" value="0" <?php echo $res->situacao == '0' ? 'checked=\"checked\"' : "";?>>INATIVO
                <br><br>
                
                <label>SEXO:*</label>
                <input type="radio" name="sexo" id ="sexo" value="M" <?php echo $res->sexo == 'M' ? 'checked=\"checked\"' : "";?>>MASCULINO
                <input type="radio" name="sexo" id ="sexo" value="F" <?php echo $res->sexo == 'F' ? 'checked=\"checked\"' : "";?>>FEMININO
                <br><br>               
                
                <label>Nº TEL:</label>
                 <input type="text" name="tel" size="20" id="tel" value="<?php echo $res->nr_tel; ?>">       
                <br><br>
                
                <label>Nº CEL:</label>
                <input type="text" name="cel" size="20" id="cel" value="<?php echo $res->nr_cel; ?>">        
                <br><br>
                
                <label>OPERADORA:</label>                
                <select name='operadora'>
                    <option value='NAOINFORMADO' <?php echo $res->op_cel == "NAOINFORMADO" ? 'selected=\"selected\"' : "";?>selected='selected'>SELECIONAR</option>
                    <option value='VIVO'<?php echo $res->op_cel == "VIVO" ? 'selected=\"selected\"' : "";?>>VIVO</option>
                    <option value='OI'<?php echo $res->op_cel == "OI" ? 'selected=\"selected\"' : "";?>>OI</option>
                    <option value='TIM'<?php echo $res->op_cel == "TIM" ? 'selected=\"selected\"' : "";?>>TIM</option>
                    <option value='CLARO'<?php echo $res->op_cel == "CLARO" ? 'selected=\"selected\"' : "";?>>CLARO</option>
                    <option value='OUTRO'<?php echo $res->op_cel == "OUTROS" ? 'selected=\"selected\"' : "";?>>OUTROS</option>
                </select>
                <br><br>
                
                <input type="submit" value="ALTERAR" class="botaoForm">
                
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
