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
        <title>CADASTRAR MEDICOS</title>
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
            <input type="hidden" name="operacao" value="cad_med">
            <input type="hidden" name="cd_acesso" value="<?php echo $cd_acesso;?>">
            <fieldset name="incluir">
                <legend>CADASTRAR MEDICOS</legend>
                <p>INSIRA OS DADOS:</p>
                
                <label>CRM MEDICO:*</label>
                <input type="text" name="crm" size="20" id="crm" maxlength="5">               
                <br/><br/> 
                
                <label>NOME COMPLETO:*</label>
                <input type="text" name="nome" size="20" id="nome">               
                <br/><br/>               
               
                <label>ESPECIALIDADE:*</label>
                <select name="especialidade" id="especialidade">
                    <option value="">SELECIONAR</option>                   
                    <?php
                    require_once("classes/especialidade.class.php");                    
                    $adj = new especialidade(); 
                    $adj->selecionaTudo($adj);                   
                    while($res = $adj->retornaDados()){
                        echo "<option value='".$res->especialidade."'>".$res->especialidade."</option>";                   
                  }
                ?>                    
                </select>
                <br><br>
                
                <label>DATA NASC*:</label>
                <input type="text" name="dt_nasc" id="calendario" size="20">
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
                 <input type="text" name="tel" size="20" id="tel">       
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
