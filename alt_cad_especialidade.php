<?php require_once("valida_login.php");     valida_login();?>
<?php
$cod = $_GET["cd"];
$i = $_GET["i"];

require_once("classes/especialidade.class.php");
$esp = new especialidade();
$esp->extras_select = "WHERE cd_especialidade=".$cod;
    $esp->selecionaTudo($esp);
    $res = $esp->retornaDados();    
    $cont = $esp->linhasafetadas; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CADASTRAR ESPECIALIDADE</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>        
        <script type="text/javascript" src="js/valida_cad_especialidade.js"></script>
        
    </head>
    <body>
        <div id="cadastra"> 
             
        <form id="form_especialidade" name="form_especialidade" method="POST" action="processa.php">
            <input type="hidden" name="operacao" value="alt_especialidade">
            <fieldset name="incluir">
                <legend>ALTERAR ESPECIALIDADE</legend>
                <p>INSIRA OS DADOS:</p>
                
                <label>ESPECIALIDADE Nº:</label>
                <input type="text" name="cd_especialidade" size="20" id="cd_especialidade"  maxlength="5" value="<?php echo $res->cd_especialidade; ?>" readonly>               
                <br/><br/>
                
                <label>NOME:*</label>
                <input type="text" name="espec" size="20" id="espec" value="<?php echo $res->especialidade; ?>" >               
                <br/><br/>               

                <input type="submit" value="ALTERAR" class="botaoForm">       
                
            </fieldset>
            
        </form>
          </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
