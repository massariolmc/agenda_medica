<?php include("../../conecta.php");
$mes = $_GET["mes"];
$ano = $_GET["ano"];
$i = $_GET["i"];
include("../estilo.php");// NESSE ESTA A CONFIGURAÇÃO DO CABEÇALHO HTML E CSS        

        abreconexao();       
        $sql = "select dt_nasc as \"GRUPO\",count(*) as \"QTDE\"
                from paciente p 
                INNER JOIN consultas c ON (p.cd_prontuario=c.cd_prontuario)
                WHERE Extract('Month' FROM c.dt_consulta)=$mes AND Extract('Year' FROM c.dt_consulta)=$ano AND status=2
                GROUP BY dt_nasc
                ORDER BY dt_nasc ASC";
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query);       
        if($cont > 0){
        $art = array("consulta"  => array("GRUPO","QTDE"));
        $op = "consulta";
        $c = 2;
        $cores = array("#d0cbc2","#FFFFFF");          
        $html .= "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <tr>
                            <td align=center>GRUPO(IDADE)</td>                            
                            <td align=center>QTDE</td>                            
                            </tr>";        
        
        while ($res = pg_fetch_object($query)) { 
            $date = new DateTime( $res->GRUPO  ); // data de nascimento
            $interval = $date->diff( new DateTime( ) ); // data definida
            $idade = $interval->format( '%Y' );             
            
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $html.= "<tr bgcolor=".$cor.">";
            if($idade >= 0 && $idade <= 14){
            $html.= "<td align=center>GRUPO A</td>";
            $html.= "<td align=center>" . utf8_encode($res->QTDE) . "</td>";
            }
            else if($idade > 15 && $idade <= 21){
            $html.= "<td align=center>GRUPO B</td>";
            $html.= "<td align=center>" . utf8_encode($res->QTDE) . "</td>";
            }
            else if($idade >= 22 && $idade <= 50){
            $html.= "<td align=center>GRUPO C</td>";
            $html.= "<td align=center>" . utf8_encode($res->QTDE) . "</td>";
            }
            else{
            $html.= "<td align=center>GRUPO D</td>";
            $html.= "<td align=center>" . utf8_encode($res->QTDE) . "</td>";
            }
                        
            $html.= "</tr>";
        }
        $html.="</table>";
        fechaconexao();
        }       
        
         $html.= '</div>
            
            <div id="rodape">
                <div id="data">
                </div>
                <div id="pag">
                 </div>
            </div>
        
        </div> 
        
    </body>
</html>';
         
         
include("../gera_pdf.php");// NESSE ARQUIVO AS CONFIGURAÇÕES DO PDF
         
?>

        
