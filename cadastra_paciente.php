<?php require_once("valida_login.php");     valida_login();?>
<?php
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
        <title>CADASTRA PACIENTE</title>
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
        <script type="text/javascript" src="js/ajax.js"></script>
        
    
   </head>
    <body>
        <div id="cadastra"> 
             
        <form id="form_paciente" name="form_paciente" method="POST" action="processa.php">
            <input type="hidden" name="operacao" value="cad_paciente">
            <input type="hidden" name="cd_acesso" value="<?php echo $cd_acesso;?>">
            <fieldset name="incluir">
                <legend>CADASTRA PACIENTE</legend>
                <p>INSIRA OS DADOS:</p>                
                             
                    
                <label>PRONTUARIO*:</label>
                <input type="text" name="prontuario" size="20" id="prontuario" maxlength="5" onblur="getDados('cad_paciente');">               
                <br/>
                <label id="nprontuario"></label>
                <br/><br/>
                
                <label>SARAM*:</label>
                <input type="text" name="saram" size="20" id="saram" maxlength="7">                              
                <br/><br/>
                
                <label for="nome">NOME COMPLETO*:</label>
                <input type="text" name="nome" size="20" id="nome">                 
                <br/><br/>
                
                
                <label>DATA NASC*:</label>
                <input type="text" name="dt_nasc" id="calendario" size="20">
                <br/><br>
                
                
                <label>SEXO*:</label>
                <input type="radio" name="sexo" value="M" id="sexo">MASCULINO
                <input type="radio" name="sexo" value="F" id="sexo">FEMININO
                <br><br>
                
                <label>TIPO:</label>
                <select name="tipo">
                    <option value="MILITAR_ATV" selected="selected">MILITAR ATIVA</option>
                    <option value="MILITAR_IATV">MILITAR INATIVO</option>
                    <option value="AMH">DEPENDENTE AMH</option>
                    <option value="AMHC">DEPENDENTE AMHC</option>
                    <option value="PENSIONISTA">PENSIONISTA</option>
                    <option value="DESATIVADO">DESATIVADO</option>
                    <option value="OUTROS">OUTROS</option>
                </select>
                <br><br>
                
                
                <label>ESTADO CIVIL:</label>
                <select name="est_civil">
                    <option value="NAOINFORMADO" selected="selected">SELECIONAR</option>
                    <option value="SOLTEIRO">SOLTEIRO</option>
                    <option value="CASADO">CASADO</option>
                    <option value="DIVORCIADO">DIVORCIADO</option>
                    <option value="VUIVO">VIUVO</option>
                </select>
                <br><br>
                
                
                <label>Nº TEL:</label>
                 <input type="text" name="tel" size="20" id="tel" >       
                <br><br>
                
                
                <label>Nº CEL:</label>
                <input type="text" name="cel" size="20" id="cel">        
                <br><br>
                
                
                <label>OPERADORA:</label>
                <select name="operadora">
                    <option value="NAOINFORMADO" selected="selected">SELECIONAR</option>
                    <option value="VIVO">VIVO</option>
                    <option value="OI">OI</option>
                    <option value="TIM">TIM</optoin>
                    <option value="CLARO">CLARO</optoin>
                    <option value="OUTRO">OUTROS</optoin>
                </select>      
                <br><br>
                                
                <label>EMAIL:</label>
                <input type="text" name="email" size="20" id="email" placeholder="Email intraer ou internet...">        
                <br><br>
                
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" size="20" maxlength="8">         
                <br><br>
                
                <label for="rua">RUA:*</label>
                <input type="text" name="rua" id="rua" size="20">        
                <br><br>
                
                <label for="numero">Nº:*</label>
                <input type="text" name="numero" id="numero" size="20" maxlength="7">        
                <br><br>
                
                
                <label for="bairro">BAIRRO:*</label>
                <input type="text" name="bairro" id="bairro" size="20" maxlength="50">        
                <br><br>
                
                
                <label for="cidade">CIDADE:*</label>
                <input type="text" name="cidade" id="cidade" size="20" maxlength="30">         
                <br><br>
                                              
                <label for="uf">ESTADO*:</label>    
                <input type="text" name="estado" id="estado" size="20" maxlength="2">
                <br> <br>
                             
                <input type="submit" value="CADASTRAR" class="botaoForm">
                <input type="reset" value="LIMPAR" class="botaoForm">
                
                
            </fieldset>
            
        </form>
          </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
