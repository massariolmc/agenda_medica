<?php include("../../conecta.php");
$mes = $_GET["mes"];
$ano = $_GET["ano"];
$crm = $_GET["crm"];
$i = $_GET["i"];
include("../estilo.php");// NESSE ESTA A CONFIGURAÇÃO DO CABEÇALHO HTML E CSS        

        abreconexao();       
        $sql = "select p.nome_paciente as \"PACIENTE\", m.nome_med as \"MEDICO\", dt_consulta as \"DT\", hr_consulta as \"HORA\", cid as \"CID\", c.especialidade as \"ESPECIALIDADE\"
                FROM consultas c
                INNER JOIN paciente p ON (status=2 AND p.cd_prontuario=c.cd_prontuario AND Extract('Month' FROM c.dt_consulta )=$mes AND Extract('Year' FROM c.dt_consulta )=$ano)
                INNER JOIN medico m ON(m.crm=".$crm." AND m.cd_especialidade=c.especialidade)
                ORDER BY dt_consulta, p.nome_paciente";
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query);       
        if($cont > 0){
        $art = array("consulta"  => array("PACIENTE","MEDICO","DATA", "HORA","CID","ESPECIALIDADE"));
        $op = "consulta";
        $c = 2;
        $cores = array("#d0cbc2","#FFFFFF");          
        $html .= "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <tr>
                            <td align=center>PACIENTE</td>                            
                            <td align=center>MEDICO</td>
                            <td align=center>ESPECIALIDADE</td>
                            <td align=center>DATA</td>
                            <td align=center>HORA</td>
                            <td align=center>CID</td>                            
                            </tr>";        
        
        while ($res = pg_fetch_object($query)) { 
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $html.= "<tr bgcolor=".$cor.">";
            $html.= "<td align=center>" . utf8_encode($res->PACIENTE) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->MEDICO) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->ESPECIALIDADE) . "</td>";
            $html.= "<td align=center>" . ((date('d/m/Y',strtotime($res->DT)))) . "</td>";            
            $html.= "<td align=center>" . utf8_encode($res->HORA) . "</td>";
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

        
