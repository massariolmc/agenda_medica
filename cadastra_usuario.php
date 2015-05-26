<?php require_once("valida_login.php");     valida_login();?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CADASTRAR USUARIO</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>     
        <script type="text/javascript" src="js/valida_cad_usuario.js"></script>
        
    </head>
    <body>
        <div id="cadastra"> 
             
        <form id="form_usuario" name="form_usuario" method="POST" action="processa.php">
            <input type="hidden" name="operacao" value="cad_usuario">
            <fieldset name="incluir">
                <legend>CADASTRAR USUARIO</legend>
                <p>SELECIONE AS OPÇÕES</p>
                
                <label>NOME COMPLETO:</label>
                <input type="text" name="nome" size="20" id="nome">               
                <br/><br/>
                
                <label>USUARIO:</label>
                <input type="text" name="usuario" size="20" id="usuario">               
                <br/><br/>
                
                
                <label>SENHA:</label>
                <input type="password" name="senha" size="20" id="senha" maxlength="10">
                <br/><br>
                
                
                <label>TIPO DE ACESSO:</label>
                <input type="radio" name="tp_acesso" value="ADM" id="tp_acesso">ADM
                <input type="radio" name="tp_acesso" value="OPERADOR" id="tp_acesso">OPERADOR
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
