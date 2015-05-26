
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SISTEMA DE MARCAÇÃO DE CONSULTAS</title>
        <link href="css/estilo_menu.css" rel="stylesheet" type="text/css"/>
        <link href="css/estilo_main.css" rel="stylesheet" type="text/css"/>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>                    
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>        
        <script type="text/javascript" src="js/jquery.validate.js"></script>     
        <script type="text/javascript" src="js/valida_usuario.js"></script>
    </head>
    <body>
        
        <div id="main">
                            
            <div id="topo">                 
            </div>
            
                <hr>
                
                <div id="menu">
                   <h3>SISTEMA DE MARCAÇÃO DE CONSULTAS</h3>  
                   <a href='index.php'>Inicio</a><br>
                </div> 
                
                <div id="conteudo">
                      <form id="login" name="login" method="post" action="processa.php">
                          <input type="hidden" name="operacao" value="autentica">
                        <fieldset name="login">
                        <legend>LOGIN</legend>
                        <label>Login:</label>
                        <input type="text" name="usuario" size="20" maxlength="15" id="usuario"><br><br>
                        <label>Senha:</label>
                        <input type="password" name="senha" size="20" maxlength="10" id="senha">
                        <br><br>       

                        <input type="submit" value="ENTRAR" class="botaoForm">
                        <input type="reset" value="LIMPAR" class="botaoForm">
                        </fieldset>
                      </form>
                </div>
                
                <hr>  
                
                <div id="rodape">                    
                             <p>DESENVOLVIDO POR TEN MASSARIOL<?php echo " - ".date('Y'); ?></p>
                </div>
       
        </div>          
       
    </body>
</html>
