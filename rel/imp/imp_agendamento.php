<?php require_once("../../conecta.php");
$crm = $_GET["crm"];
$espec = $_GET["espec"];
$dia = $_GET["dia"];
$mes = $_GET["mes"];
$ano = $_GET["ano"];
$i = $_GET["i"];

include("../estilo.php");// NESSE ESTA A CONFIGURAÇÃO DO CABEÇALHO HTML E CSS        

        abreconexao();       
        $sql = "select c.dt_consulta as \"DIA\", c.hr_consulta as \"HORA\", c.cd_prontuario as \"PRONTUARIO\", 
                p.nome_paciente as \"NOME\", p.sexo as \"SEXO\", p.dt_nasc as \"GRUPO\", p.tipo as \"TIPO\",
                m.nome_med as \"MEDICO\", m.cd_especialidade as \"ESPECIALIDADE\",
                c.cid as \"CID\"
                FROM consultas c
                INNER JOIN medico m ON (c.crm=m.crm AND m.cd_especialidade=c.especialidade)
                INNER JOIN paciente p ON (c.cd_prontuario=p.cd_prontuario AND m.cd_especialidade=c.especialidade)
                where status = 1 AND Extract('Day' FROM c.dt_consulta )=$dia AND Extract('Month' FROM c.dt_consulta )=$mes AND Extract('Year' FROM c.dt_consulta )=$ano AND c.crm=$crm AND c.especialidade='$espec'
                group by c.dt_consulta, c.hr_consulta, c.cd_prontuario, p.nome_paciente, p.sexo, p.dt_nasc, p.dt_nasc,p.tipo ,m.nome_med, m.cd_especialidade, c.cid 
                ORDER BY c.hr_consulta ASC";
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query);       
        if($cont > 0){
        $art = array("consulta"  => array("DIA","HORA","PRONTUARIO", "NOME","SEXO","GRUPO","TIPO","MEDICO","ESPECIALIDADE","CID"));
        $op = "consulta";
        $c = 2;
        $cores = array("#d0cbc2","#FFFFFF");          
        $html .= "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <tr>
                            <td align=center>Nº DE ORDEM</td>
                            <td align=center>HORA</td>                            
                            <td align=center>PRONTUARIO</td>
                            <td align=center>NOME</td>
                            <td align=center>SEXO</td>
                            <td align=center>TIPO</td>
                            <td align=center>GRUPO</td>
                            <td align=center>CID</td>
                            </tr>";        
        
        while ($res = pg_fetch_object($query)) { 
            $date = new DateTime( $res->GRUPO  ); // data de nascimento
            $interval = $date->diff( new DateTime( ) ); // data definida
            $idade = $interval->format( '%Y' ); // 110 Anos, 2 Meses e 2 Dias
            $medico = $res->MEDICO;
            
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $html.= "<tr bgcolor=".$cor.">";
            $html.= "<td align=center>".($c-2)."</td>";
            $html.= "<td align=center>" . utf8_encode($res->HORA) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->PRONTUARIO) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->NOME). "</td>";            
            $html.= "<td align=center>" . utf8_encode($res->SEXO) . "</td>";
            $html.= "<td align=center>" . utf8_encode($res->TIPO) . "</td>";            
            if($idade >= 0 && $idade <= 14)
            $html.= "<td align=center>GRUPO A</td>";
            
            else if($idade > 15 && $idade <= 21)
            $html.= "<td align=center>GRUPO B</td>";
            
            else if($idade >= 22 && $idade <= 50)
            $html.= "<td align=center>GRUPO C</td>";
            
            else
            $html.= "<td align=center>GRUPO D</td>";
            
            //$html.= "<td align=center>" . utf8_encode($res->GRUPO) . "</td>"; 
            $html.= "<td width=\"20%\" align=center>" . utf8_encode($res->CID) . "</td>"; 
            $html.= "</tr>";
        }
        $html.="</table>";
        $html.="<br>";
        $html.="<br>";
        $html.="<table id=\"borda\">";
        $html.= "<tr>";
        $html.= "<td align=right>___________________________________________</td>";
        $html.= "</tr>";
        $html.= "<tr>";
        $html.= "<td align=right >MEDICO: ".$medico." - CRM: ".$crm."</td>";
        $html.= "</tr>";
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

        
