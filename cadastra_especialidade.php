<?php require_once("valida_login.php");     valida_login();?>
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
            <input type="hidden" name="operacao" value="cad_especialidade">
            <fieldset name="incluir">
                <legend>CADASTRAR ESPECIALIDADE</legend>
                <p>INSIRA OS DADOS:</p>
                        
                <label>ESPECIALIDADE:*</label>
                <input type="text" name="espec" id="espec" size="20" placeholder="Digite a Especialidade"><br>
                                
                
                <br/><br>
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
