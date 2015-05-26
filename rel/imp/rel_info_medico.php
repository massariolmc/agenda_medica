<?php include("../../conecta.php");
$cod = $_GET["cd"];
$i   = $_GET["i"];


include("../estilo.php");// NESSE ESTA A CONFIGURAÇÃO DO CABEÇALHO HTML E CSS        

        abreconexao();       
        $sql = "select crm as \"CRM\",nome_med as \"MEDICO\", cd_especialidade as \"ESPECIALIDADE\",dt_nasc as \"NASC\", sexo as \"SEXO\", nr_tel as \"TEL\", nr_cel as \"CEL\"
                from medico
                where cd_med=$cod";
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query);       
        if($cont > 0){
        
        $c = 2;
        $cores = array("#d0cbc2","#FFFFFF");          
        $html .= "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <tr>
                            <td align=center>CRM</td>                            
                            <td align=center>MEDICO</td>
                            <td align=center>ESPECIALIDADE</td>
                            <td align=center>NASC</td>
                            <td align=center>SEXO</td>
                            <td align=center>TEL</td>
                            <td align=center>CEL</td>                            
                            </tr>";        
        
        while ($res = pg_fetch_object($query)) { 
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $html.= "<tr bgcolor=".$cor.">";
            $html.= "<td align=center>" . utf8_encode($res->CRM) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->MEDICO) . "</td>";            
            $html.= "<td align=center>" . utf8_encode($res->ESPECIALIDADE) . "</td>";
            $html.= "<td align=center>" . ((date('d/m/Y',strtotime($res->NASC)))) . "</td>";            
            $html.= "<td align=center>" . utf8_encode($res->SEXO) . "</td>";    
            $html.= "<td align=center>" . utf8_encode($res->TEL) . "</td>"; 
            $html.= "<td align=center>" . utf8_encode($res->CEL) . "</td>"; 
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

        