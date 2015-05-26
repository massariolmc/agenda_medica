<?php include("../../conecta.php");
$prontuario = $_GET["cd"];
$i   = $_GET["i"];


include("../estilo.php");// NESSE ESTA A CONFIGURAÇÃO DO CABEÇALHO HTML E CSS        

        abreconexao();       
        $sql = "select cd_prontuario as \"PRONTUARIO\", nome_paciente as \"PACIENTE\", tipo as \"MIL_DEP\",dt_nasc as \"NASC\", sexo as \"SEXO\", est_civil as \"ESTADO_CIVIL\", nr_tel as \"TEL\", nr_cel as \"CEL\", email as \"EMAIL\", endereco as \"ENDERECO\", numero as \"N\", bairro as \"BAIRRO\", cidade as \"CIDADE\", uf as \"UF\", cep as \"CEP\" 
                from paciente
                where cd_prontuario=$prontuario";
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query);       
        if($cont > 0){
        
        $c = 2;
        $cores = array("#d0cbc2","#FFFFFF");          
        $html .= "<table border='1' cellspacing='0' cellpadding='5'>
                            
                            <tr>
                            <td>PRONTUARIO</td>                                                       
                            <td>NOME</td>                            
                            <td>MIL/DEP</td>
                            <td>NASC</td>
                            <td>SEXO</td>
                            <td>ESTADO CIVIL</td>
                            <td>TEL</td>            
                            <td>CEL</td>
                            <td>EMAIL</td>
                            <td>ENDEREÇO</td>
                            <td>Nº</td>
                            <td>BAIRRO</td>
                            <td>CIDADE</td>
                            <td>UF</td>
                            <td>CEP</td>
                            </tr>";        
                                
        while ($res = pg_fetch_object($query)) { 
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $html.= "<tr bgcolor=".$cor.">";
            $html.= "<td align=center>" . utf8_encode($res->PRONTUARIO) . "</td>";    
            $html.= "<td align=center>" . utf8_encode($res->PACIENTE) . "</td>";           
            $html.= "<td align=center>" . utf8_encode($res->MIL_DEP) . "</td>";            
            $html.= "<td align=center>" . ((date('d/m/Y',strtotime($res->NASC)))) . "</td>";            
            $html.= "<td align=center>" . utf8_encode($res->SEXO) . "</td>";                           
            $html.= "<td align=center>" . utf8_encode($res->ESTADO_CIVIL) . "</td>";           
            $html.= "<td align=center>" . utf8_encode($res->TEL) . "</td>";           
            $html.= "<td align=center>" . utf8_encode($res->CEL) . "</td>";                                  
            $html.= "<td align=center>" . utf8_encode($res->EMAIL) . "</td>";            
            $html.= "<td align=center>" . $res->ENDERECO . "</td>";                     
            $html.= "<td align=center>" . utf8_encode($res->N) . "</td>";           
            $html.= "<td align=center>" . utf8_encode($res->BAIRRO) . "</td><";            
            $html.= "<td align=center>" . utf8_encode($res->CIDADE) . "</td>";            
            $html.= "<td align=center>" . utf8_encode($res->UF) . "</td>";            
            $html.= "<td align=center>" . utf8_encode($res->CEP) . "</td>";
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

        