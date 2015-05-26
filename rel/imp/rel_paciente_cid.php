<?php include("../../conecta.php");
$mes = $_GET["mes"];
$ano = $_GET["ano"];
$cid = $_GET["cid"];
$i   = $_GET["i"];

include("../estilo.php");// NESSE ESTA A CONFIGURAÇÃO DO CABEÇALHO HTML E CSS        

        abreconexao();       
        $sql = "select m.nome_med as \"MEDICO\",c.especialidade as \"ESPECIALIDADE\" ,p.nome_paciente as \"PACIENTE\", cid as \"CID\" 
                from consultas c INNER JOIN medico m ON (c.crm=m.crm AND c.especialidade=m.cd_especialidade)
                INNER JOIN paciente p ON(p.cd_prontuario=c.cd_prontuario)
                WHERE Extract('Month' FROM c.dt_consulta)=$mes AND Extract('Year' FROM c.dt_consulta)=$ano AND c.cid='JNB32'
                GROUP BY m.nome_med, p.nome_paciente, cid,c.especialidade";
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query);       
        if($cont > 0){
        
        $c = 2;
        $cores = array("#d0cbc2","#FFFFFF");          
        $html .= "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <tr>
                            <td align=center>MEDICO</td>                            
                            <td align=center>ESPECIALIDADE</td>
                            <td align=center>PACIENTE</td>
                            <td align=center>CID</td>                            
                            </tr>";        
        
        while ($res = pg_fetch_object($query)) { 
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];            
            $html.= "<tr bgcolor=".$cor.">";
            $html.= "<td align=center>" . utf8_encode($res->MEDICO) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->ESPECIALIDADE) . "</td>";                      
            $html.= "<td align=center>" . utf8_encode($res->PACIENTE) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->CID) . "</td>";             
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

        