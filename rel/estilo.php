<?php 
$html = "<style>
#foto{ height: 23mm;border: 3px red solid;}
#dir_foto{overflow: auto; width: 68px; height: 79px; border: 3px red solid; float:right; margin-left:0px;}
#esq_foto{overflow: auto; width: 68px; height: 79px; border: 3px red solid; float:left;}
#centro_foto{overflow: auto; width: 75px; height: 79px; border: 3px red solid; float:left; margin-left:250px;}
#cabeçalho{  height: 33mm;border: 3px red solid;}
#cabeçalho h1{color:black;text-align: center;font:14px \"Arial\";border: 3px black solid;width:230px;margin-left:235px;margin-top:0px;}
#cabeçalho em{font:bold 14px \"Arial\";}
#cabeçalho p{font:14px \"Arial\";color:black;text-align: center;border: 3px black solid;width:340px;margin-left:200px;margin-top:0px;}
table{font-family:\"Arial\";width:100%;border-collapse:collapse; }
table td, th{border:1px solid #2424FF;padding:3px 7px 2px 7px;font-size:10px;text-align:center; }
#borda td, th{border-color: #FFFFFF;}
</style>";

$html.='<html>
    
    <body>       
        <div id="rel_todos_os_atendimentos">
            <div id="foto">
                <div id="esq_foto">
                <img src="../../img/ES1.jpg"></img>
                </div>
                <div id="centro_foto">
                 <img src="../../img/brasao.jpeg"></img>   
                </div>
                <div id="dir_foto">
                <img src="../../img/bacg.jpg"></img>
                </div>
             </div>              
            <div id="cabeçalho">
                 <h1><em>MINISTERIO DA DEFESA</em><br>
                    COMANDO DA AERONÁUTICA<br>
                   BASE AEREA DE CAMPO GRANDE<br>
                       ESQUADRÃO DE SAÚDE</h1><br>
                <p>'.$i.'</p><br>';
                if(strcmp($i,"MAPA DE ATENDIMENTO AMBULATORIAL") == 0){// ESSE IF É APENAS PARA IMPRESSÃO DA AGENDA DE CONSULTAS DO MÉDICO
                $html.='<table id="borda">
                <tr><td align="left">CLINICA:'.$espec.'</td><td align="left">MES/ANO:'.$mes.'/'.$ano.' </td> <td align="left">DIA:'.$dia.'</td>
                </tr>
                </table><br>'; }               
            
                $html.='</div>
                <div id="conteudo"> ';
?>

