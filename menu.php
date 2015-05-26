<?php require_once("valida_login.php");     valida_login();?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Menu</title>
        
        <link rel="stylesheet" type ="text/style.css" href="css/estilo_menu.css">
    </head>
    <body>
                <div id="texto">
                <h1>SISTEMA DE MARCAÇÃO DE CONSULTAS</h1>
                <p id="login">Logado:<?php echo "<b>".$login."</b>";?>
                <a href="logout.php"><img src='icons/sair2.jpg' width='30' height='30'></a></p>
                </div>
            
                <div id="m1">
		<nav id="menu">
                    <ul><?php
                    if($tipo == "ADM" || $tipo == "OPERADOR"){
                        echo"<li><a href=\"index.php?p=marc_consulta\">Home</a></li>";
                        echo"<li><a href=\"index.php?p=marc_consulta\">Agendar Consulta</a></li>";                        
                        echo"<li><a href=\"index.php?p=busca_alt_consultas&i=alt_cad_consultas\">Alterar Consulta</a></li>";
                        echo"<li><a href=\"index.php?p=busca_alt_consultas&i=cancelar_consultas\">Cancelar Consulta</a></li>";
                        echo"<li><a href=\"index.php?p=busca_alt_consultas&i=confirmar_consultas\">Confirmar Consulta</a></li>";
                        echo"<li><a href=\"index.php?p=busca&i=consultas\">Consultar</a></li>";
                    }
                       if($tipo == "ADM")
                        echo"<li><a href=\"index.php?p=adm\">Adm</a></li>";
                        ?>        
                    </ul>
                </nav>
                </div>    
    </body>
</html>
