<?php
date_default_timezone_set('America/Cuiaba');
$p = $_GET['p'];//verificar pqnão funciona o PoST
//echo $p;

include("conecta.php");

    if (!isset($_SESSION)){
    session_start();
       if(isset($_SESSION["nome_usuario"])){
           $login = $_SESSION["nome_usuario"];//echo "$login_aux";
       }
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SISTEMA DE MARCAÇÃO DE CONSULTAS</title>
        <link href="css/estilo_menu.css" rel="stylesheet" type="text/css"/>
        <link href="css/estilo_main.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        
        <div id="main">
                            
            <div id="topo">                 
            </div>
            
                <hr>
                
                <div id="menu">
                   <?php
                   if(!empty($login)){     
                                        
                                    abreconexao();
                                        $sql = "SELECT * FROM usuarios WHERE usuario='".$login."'";
                                        $query = pg_query($sql);
                                        $cont = pg_affected_rows($query); 
                                    if($cont > 0){
                                        while($tbl = pg_fetch_object($query)){
                                            $tipo= $tbl->tp_acesso;
                                            $cd_acesso = $tbl->cd_acesso;
                                        }
                                    }
                                    fechaconexao();
                                    }        
                                    
                   if(!empty($login))
                    include("menu.php");
                       
                   else{
                   echo"<h2>SERVIÇOS ONLINE DISPONIBILIZADOS PELO ESQUADRÃO DE SAÚDE DA BACG</h2>";
                   echo"<hr>";
                   echo"<a href='index.php'>Página Inicial</a><br>";
                   
                   }
                   ?>                
                </div> 
                
                <div id="conteudo">
                      <?php
                        
                    if ($p == ''){
                            echo"<br><br><div class=\"formata\" id=\"noticias\"><img src='img/medico.jpg' width='250' height='130'>";
                            echo"<b>AGENDE AGORA SUA CONSULTA ONLINE.</b> Agendamento 24h: mais fácil, mais rápido e na hora que você precisa.";
                            echo"</div>";
                            
                            echo"<div id=\"servicos\">";
                            echo"<a href='index.php?p=advertencia'><img src='icons/agendar.png' width='60' height='25'>AGENDAR CONSULTA MEDICA</a><br>";
                            echo"<a href='index.php?p=busca&i=consultas'><img src='icons/consulta.png' width='60' height='25'>CONSULTE SEU AGENDAMENTO MEDICO</a><br>";
                            echo"<br>";
                            echo"<a href='index.php'><img src='icons/agendar.png' width='60' height='25'>AGENDAR CONSULTA ODONTOLOGICA</a><br>";
                            echo"<a href='index.php'><img src='icons/consulta.png' width='60' height='25'>CONSULTE SEU AGENDAMENTO ODONTOLOGICO</a><br>";
                            echo"<br>";
                            echo"<a href='../inspecao/index.php?p=marc_insp'><img src='icons/agendar.png' width='60' height='25'>AGENDAR SUA INSPEÇÃO DE SAUDE</a><br>";
                            echo"<a href='../inspecao/index.php?p=busca&i=consultas'><img src='icons/consulta.png' width='60' height='25'>CONSULTE O DIA DA INSPEÇÃO</a><br>";
                            echo"<br>";
                            echo"<a href='index.php?p=saram'><img src='icons/consulta.png' width='60' height='25'>CONSULTAR DEPENDENTES NA SARAM</a><br>";
                            echo"</div>";
                    
                            echo"<div id=\"log\">";
                            echo"<a href='index_login.php'><img src='icons/login.jpeg' width='30' height='25'>LOGIN</a><br>";
                            echo"<a href='index.php?p=busca&i=paciente'><img src='icons/login.jpeg' width='30' height='25'>ATUALIZAR INFORMAÇÕES PESSOAIS</a><br>";                           
                            echo"</div>";
                        }
                    
                        else{
                        $p = $p . '.php';
                        }
                    
                        include($p);
                      ?>
                </div>
                
                  
                
                <div id="rodape">   <hr>                 
                             <p>DESENVOLVIDO POR TEN MASSARIOL<?php echo " - ".date('Y'); ?></p>
                </div>
       
        </div>          
       
    </body>
</html>
