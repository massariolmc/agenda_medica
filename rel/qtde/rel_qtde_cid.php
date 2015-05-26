<?php include("../../conecta.php");
$mes = $_GET["mes"];
$ano = $_GET["ano"];
$i = $_GET["i"];
include("../estilo.php");// NESSE ESTA A CONFIGURAÇÃO DO CABEÇALHO HTML E CSS        

        abreconexao();       
        $sql = "select cid as \"CID\",count(*) as \"QTDE\"
                from consultas c 
                WHERE Extract('Month' FROM c.dt_consulta)=$mes AND Extract('Year' FROM c.dt_consulta)=$ano 
                GROUP BY cid
                ORDER BY cid ASC";
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query);       
        if($cont > 0){
        $art = array("consulta"  => array("PACIENTE","MEDICO","DATA", "HORA","CID","ESPECIALIDADE"));
        $op = "consulta";
        $c = 2;
        $cores = array("#d0cbc2","#FFFFFF");          
        $html .= "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <tr>
                            <td align=center>CID</td>                            
                            <td align=center>QTDE</td>                            
                            </tr>";        
        
        while ($res = pg_fetch_object($query)) { 
            if(!empty($res->CID)){//SE O CID FOR VAZIO NÃO DEVE MOSTRAR
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $html.= "<tr bgcolor=".$cor.">";
            $html.= "<td align=center>" . utf8_encode($res->CID) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->QTDE) . "</td>";             
            $html.= "</tr>";
            }
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

        
