<?php require_once("valida_login.php");     valida_login();?>
<?php
$cod = $_GET["cd"];
$i = $_GET["i"];

require_once("classes/paciente.class.php");
$paciente = new pacientes();
$paciente->extras_select = "WHERE cd_prontuario=".$cod;
$paciente->selecionaTudo($paciente);
$res = $paciente->retornaDados();
$cont = $paciente->linhasafetadas; 

abreconexao();
$sql = "SELECT * FROM usuarios WHERE usuario='".$login."'";
            $query = pg_query($sql);
            $cont1 = pg_affected_rows($query); 
            if($cont1 > 0){
                while($tbl = pg_fetch_object($query)){
                    $cd_acesso = $tbl->cd_acesso;
                    
                }
            }            

fechaconexao();

abreconexao();
$sql = "SELECT * FROM usuarios WHERE cd_acesso=".$res->cd_acesso;
            $query = pg_query($sql);
            $cont2 = pg_affected_rows($query); 
            if($cont2 > 0){
                while($tbl = pg_fetch_object($query)){
                    $l = $tbl->usuario;
                    
                }
            }
            else
                $l = -1;

fechaconexao();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>PACIENTE</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>        
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
        <script type="text/javascript" src="js/cep.js"></script> 
        <script type="text/javascript" src="js/calendario.js"></script>        
        <script type="text/javascript" src="js/mascaravalidacao.js"></script>
        <script type="text/javascript" src="js/valida_cad_paciente.js"></script>    
   </head>
    <body>
        <div id="cadastra"> 
             
        <form id="form_paciente" name="form_paciente" method="POST" action="processa.php">
            <input type="hidden" name="operacao" value="alt_paciente">
            <input type="hidden" name="cd_acesso" value="<?php if($cont1 > 0) echo $cd_acesso; else echo -1;?>">
            <fieldset name="incluir">
                <legend>ALTERAR DADOS DO PACIENTE</legend>
                <p>INSERA OS DADOS:</p>                                
                
                <label>PACIENTE Nº:</label>
                <input type="text" name="cd_paciente" size="20" id="cd_paciente"  maxlength="5" value="<?php echo $res->cd_paciente; ?>" readonly> 
                <br/><br/>
                
                <label>PRONTUARIO*:</label>
                <input type="text" name="prontuario" size="20" id="prontuario" maxlength="5" value="<?php echo $res->cd_prontuario; ?>">               
                <br/><br/>
                
                <label>SARAM*:</label>
                <input type="text" name="saram" size="20" id="saram" maxlength="7" value="<?php $sa = strlen($res->saram);if($sa == 7) echo $res->saram; else echo "0".$res->saram; ?>">                              
                <br/><br/>
                
                <label for="nome">NOME COMPLETO*:</label>
                <input type="text" name="nome" size="20" id="nome" value="<?php echo $res->nome_paciente; ?>">               
                <br/><br/>
                
                
                <label>DATA NASC*:</label>
                <input type="text" name="dt_nasc" id="calendario" size="20" value="<?php echo date('d/m/Y',strtotime($res->dt_nasc)); ?>">
                <br/><br>
                
                
                <label>SEXO*:</label>               
                <input type="radio" name="sexo" value="M" id="sexo" <?php echo $res->sexo == 'M' ? 'checked=\"checked\"' : "";?>/>MASCULINO
                <input type="radio" name="sexo" value="F" id="sexo" <?php echo $res->sexo == 'F' ? 'checked=\"checked\"' : "";?>/>FEMININO
                <br><br>
                
                <label>TIPO:</label>
                <select name="tipo">
                    <option value="MILITAR_ATV"<?php echo $res->tipo == "MILITAR_ATV" ? 'selected=\"selected\"' : "";?>>MILITAR ATIVA</option>
                    <option value="MILITAR_IATV"<?php echo $res->tipo == "MILITAR_IATV" ? 'selected=\"selected\"' : "";?>>MILITAR INATIVO</option>
                    <option value="AMH"<?php echo $res->tipo == "AMH" ? 'selected=\"selected\"' : "";?>>DEPENDENTE AMH</option>
                    <option value="AMHC"<?php echo $res->tipo == "AMHC" ? 'selected=\"selected\"' : "";?>>DEPENDENTE AMHC</option>
                    <option value="PENSIONISTA"<?php echo $res->tipo == "PENSIONISTA" ? 'selected=\"selected\"' : "";?>>PENSIONISTA</option>
                    <option value="DESATIVADO"<?php echo $res->tipo == "DESATIVADO" ? 'selected=\"selected\"' : "";?>>DESATIVADO</option>
                    <option value="OUTROS"<?php echo $res->tipo == "OUTROS" ? 'selected=\"selected\"' : "";?>>OUTROS</option>
                </select>
                <br><br>
                
                <label>ESTADO CIVIL:</label>
                <select name="est_civil">
                    <option value="NAOINFORMADO"<?php echo $res->est_civil == "NAOINFORMADO" ? 'selected=\"selected\"' : "";?>>SELECIONAR</option>
                    <option value="SOLTEIRO"    <?php echo $res->est_civil == "SOLTEIRO" ? 'selected=\"selected\"' : "";?>>SOLTEIRO</option>
                    <option value="CASADO"      <?php echo $res->est_civil == "CASADO" ? 'selected=\"selected\"' : "";?>>CASADO</option>
                    <option value="DIVORCIADO"  <?php echo $res->est_civil == "DIVORCIADO" ? 'selected=\"selected\"' : "";?>>DIVORCIADO</option>
                    <option value="VIUVO"       <?php echo $res->est_civil == "VIUVO" ? 'selected=\"selected\"' : "";?>>VIUVO</option>
                </select>
                <br><br>
                
                
                <label>Nº TEL:</label>
                 <input type="text" name="tel" size="20" id="tel" value="<?php echo $res->nr_tel; ?>">       
                <br><br>
                
                
                <label>Nº CEL:</label>
                <input type="text" name="cel" size="20" id="cel" value="<?php echo $res->nr_cel; ?>">        
                <br><br>
                
                
                <label>OPERADORA:</label>
                <select name="operadora">
                    <option value="NAOINFORMADO" <?php echo $res->operadora == "NAOINFORMADO" ? 'selected=\"selected\"' : "";?>>SELECIONAR</option>
                    <option value="VIVO"    <?php echo $res->op_cel == "VIVO" ? 'selected=\"selected\"' : "";?>>VIVO</option>
                    <option value="OI"      <?php echo $res->op_cel == "OI" ? 'selected=\"selected\"' : "";?>>OI</option>
                    <option value="TIM"     <?php echo $res->op_cel == "TIM" ? 'selected=\"selected\"' : "";?>>TIM</optoin>
                    <option value="CLARO"   <?php echo $res->op_cel == "CLARO" ? 'selected=\"selected\"' : "";?>>CLARO</optoin>
                    <option value="OUTRO"   <?php echo $res->op_cel == "OUTRO" ? 'selected=\"selected\"' : "";?>>OUTROS</optoin>
                </select>      
                <br><br>
                                
                <label>EMAIL:</label>
                <input type="text" name="email" size="20" id="email" value="<?php echo $res->email; ?>" placeholder="Email intraer ou internet...">        
                <br><br>
                
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" size="20" value="<?php echo $res->cep; ?>">         
                <br><br>
                
                <label for="rua">RUA:*</label>
                <input type="text" name="rua" id="rua" size="20" value="<?php echo $res->endereco; ?>">        
                <br><br>
                
                <label for="numero">Nº:*</label>
                <input type="text" name="numero" id="numero" size="20" maxlength="7" value="<?php echo $res->numero; ?>">        
                <br><br>
                
                
                <label for="bairro">BAIRRO:*</label>
                <input type="text" name="bairro" id="bairro" size="20" value="<?php echo $res->bairro; ?>">        
                <br><br>
                
                
                <label for="cidade">CIDADE:*</label>
                <input type="text" name="cidade" id="cidade" size="20" value="<?php echo $res->cidade; ?>">         
                <br><br>
                                              
                <label for="uf">ESTADO*:</label>    
                <input type="text" name="estado" id="estado" size="20" maxlength="2" value="<?php echo $res->uf; ?>">
                <br> <br>
                             
                <input type="submit" value="ALTERAR" class="botaoForm">   <br><br><br>            
                <label>ULTIMA ATUALIZAÇÃO:<?php if($l == -1) echo " PACIENTE"; else echo" ".$l;?></label>  
                
            </fieldset>
            
        </form>
          </div>
       
    </body>
</html>
