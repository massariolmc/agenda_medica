
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SARAM</title>
        <link href="css/estilo_menu.css" rel="stylesheet" type="text/css"/>
        <link href="css/estilo_main.css" rel="stylesheet" type="text/css"/>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>                    
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>        
        <script type="text/javascript" src="js/jquery.validate.js"></script>     
        <script type="text/javascript" src="js/valida_saram.js"></script>
    </head>
    <body>    
                
                <div id="id_saram">
                      <form id="form_saram" name="form_saram" method="post" action="upload/index_upload.php">
                          
                        <fieldset name="campo_saram">
                        <legend>SARAM</legend>
                        <label>DIGITE O SARAM:</label><br>
                        <label>(6 digitos)</label>
                        <input type="text" name="saram" size="20" maxlength="6" id="saram"><br>                       
                        <br>      
                        <input type="submit" value="ENTRAR" class="botaoForm">
                        <input type="reset" value="LIMPAR" class="botaoForm">
                        </fieldset>
                      </form>
                </div> 

    </body>
</html>
