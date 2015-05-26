<?php
$cod = $_GET["y"];
$i = $_GET["i"];

require_once("classes/paciente.class.php");
$paciente = new pacientes();
$paciente->extras_select = "WHERE cd_prontuario=".$cod;
$paciente->selecionaTudo($paciente);
$res = $paciente->retornaDados();
$cont = $paciente->linhasafetadas; 

if($cont <= 0){
echo "Usuario Inexistente. <br>";
            echo"Por favor, insira um prontuario existente.<br>";
            echo "<a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
            exit();
}


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
                
                
                <input type="hidden" name="cd_paciente" size="20" id="cd_paciente"  maxlength="5" value="<?php echo $res->cd_paciente; ?>" readonly>                 
                <input type="hidden" name="prontuario" size="20" id="prontuario" maxlength="5" value="<?php echo $res->cd_prontuario; ?>">                    
                <!--<input type="hidden" name="saram" size="20" id="saram" maxlength="7" value="<?php //echo $res->saram; ?>"> -->
                <input type="hidden" name="sexo" id="sexo" value="<?php echo $res->sexo; ?>" />                   
                <!-- <input type="hidden" name="tipo" id="tipo" value="<?php// echo $res->tipo;?>" /> -->         
                <input type="hidden" name="est_civil" id="est_civil" value="<?php echo $res->est_civil;?>" />
                 
                
                <label for="nome">NOME COMPLETO*:</label>
                <input type="text" name="nome" size="30" id="nome" value="<?php echo $res->nome_paciente; ?>" readonly>               
                <br/><br/>
                
                <label>SARAM*:</label>
                <input type="text" name="saram" size="20" id="saram" maxlength="7" value="<?php $sa = strlen($res->saram);if($sa == 7) echo $res->saram; else echo "0".$res->saram; ?>">                              
                <br/><br/>
                
                <label>DATA NASC*:</label>
                <input type="text" name="dt_nasc" id="calendario" size="30" value="<?php echo date('d/m/Y',strtotime($res->dt_nasc)); ?>">
                <br/><br>  
                               
                <label>Nº TEL:</label>
                 <input type="text" name="tel" size="30" id="tel" value="<?php echo $res->nr_tel; ?>">       
                <br><br>
                
                
                <label>Nº CEL:</label>
                <input type="text" name="cel" size="30" id="cel" value="<?php echo $res->nr_cel; ?>">        
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
                <input type="text" name="email" size="30" id="email" value="<?php echo $res->email; ?>" placeholder="Email intraer ou internet...">        
                <br><br>
                
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" size="30" value="<?php echo $res->cep; ?>">         
                <br><br>
                
                <label for="rua">RUA:*</label>
                <input type="text" name="rua" id="rua" size="30" value="<?php echo $res->endereco; ?>">        
                <br><br>
                
                <label for="numero">Nº:*</label>
                <input type="text" name="numero" id="numero" size="30" maxlength="7" value="<?php echo $res->numero; ?>">        
                <br><br>
                
                
                <label for="bairro">BAIRRO:*</label>
                <input type="text" name="bairro" id="bairro" size="30" value="<?php echo $res->bairro; ?>">        
                <br><br>
                
                
                <label for="cidade">CIDADE:*</label>
                <input type="text" name="cidade" id="cidade" size="30" value="<?php echo $res->cidade; ?>">         
                <br><br>
                                              
                <label for="uf">ESTADO*:</label>    
                <input type="text" name="estado" id="estado" size="30" value="<?php echo $res->uf; ?>">
                <br> <br>
                             
                <input type="submit" value="ALTERAR" class="botaoForm">   <br><br><br>            
                <label>ULTIMA ATUALIZAÇÃO:<?php if($l == -1) echo " PACIENTE"; else echo" ".$l;?></label>  
                
            </fieldset>
            
        </form>
          </div>
       
    </body>
</html>
