<?php
include("conecta.php");
function exibe_dados($d,$op,$ano){//$d=> nome ou prontuario ou crm $op=>agenda/usuario/paciente/medico
                                  //ano vale apenas para agenda
    
    $art = array(
        "paciente"  => array("PRONTUARIO","NOME DO PACIENTE","SEXO", "DT NASC","TIPO"),
        "medico"    => array("CRM/NOME DO MEDICO","ESPECIALIDADE","SEXO","DT NASC","SITUAÇÃO"),
        "usuario"   => array("USUARIO","MODO DE ACESSO"),
        "especialidade" => array("NOME DA ESPECIALIDADE"),                   
        "agenda" => array("CRM/NOME","ESPECIALIDADE","MES/ANO"),
        "consultas" => array("PACIENTE","MEDICO","ESPECIALIDADE","DATA CONSULTA","HORA","STATUS","OBS","AGENDADO POR")
    );
    
    if(strcmp($op,"paciente") == 0){
        require_once("classes/paciente.class.php");
        $adj = new pacientes();
        $aux = "nome_paciente";         
    }
    
    else if(strcmp($op,"medico") == 0){         
        require_once("classes/medico.class.php");
        $adj = new medicos();
        $aux = "nome_med";
        
    }
    else if(strcmp($op,"usuario") == 0){
        require_once("classes/usuarios.class.php");
        $adj = new usuarios();
        $aux = "usuario";
    }
    else if(strcmp($op,"agenda") == 0){
        //require_once("classes/agenda.class.php");
        //$adj = new agenda();
        //$aux = "nome_med";
        require_once("classes/medico.class.php");
        $adj = new medicos();
        $aux = "nome_med";
    }
    else if(strcmp($op,"consultas") == 0){
        require_once("classes/consultas.class.php");
        $adj = new consultas();
        $aux = "cd_prontuario";
    }    
    else{
        require_once("classes/especialidade.class.php");
        $adj = new especialidade();
        $aux = "especialidade";
    }    
    
    if($op == "paciente"){
        if(!is_numeric($d))
            $adj->extras_select = "WHERE ".$aux." ILIKE '%".$d."%' ORDER BY ".$aux." ASC";
        else
            $adj->extras_select = "WHERE cd_prontuario=".$d;
    }
    else if($op == "medico"){
        if(!is_numeric($d))
            $adj->extras_select = "WHERE ".$aux." ILIKE '%".$d."%' ORDER BY ".$aux." ASC";
        else
            $adj->extras_select = "WHERE crm=".$d;
    }
    else if($op == "consultas"){
        if(!is_numeric($d)){
            echo"Insera apenas números.";            
            exit();
        }
        else 
            $adj->extras_select = "WHERE cd_prontuario=".$d." AND Extract('Year' FROM dt_consulta )=".$ano." ORDER BY dt_consulta DESC ";
        
    }
    else if($op == "agenda"){
       if(!is_numeric($d))
            $adj->extras_select = "WHERE ".$aux." ILIKE '%".$d."%' ORDER BY ".$aux." ASC";
        else
            $adj->extras_select = "WHERE crm=".$d;
    }//FIM DA AGENDA
    
    else
        $adj->extras_select = "WHERE ".$aux." ILIKE '%".$d."%'ORDER BY ".$aux." ASC";;
    
        $adj->selecionaTudo($adj);
        
        $cont = 0;
        $cont = $adj->linhasafetadas;
                
    
        if ($cont > 0 and ($op == "paciente" or $op == "medico")) {
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        $cores = array("#e1e1e1","#FFFFFF");
         
         
        $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <th>".$art[$op][0]."</th>                            
                            <th>".$art[$op][1]."</th>
                            <th>".$art[$op][2]."</th>
                            <th>".$art[$op][3]."</th>
                            <th>".$art[$op][4]."</th>
                            <th>EDITAR</th>
                            <th>DELETAR</th>
                            <th>IMPRIMIR</th>";
                                       
        $return = "$tabela";
               
        
        if($op == "paciente"){        
        // Captura os dados da consulta e inseri na tabela HTML
        while ($res = $adj->retornaDados()) {
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $return.= '<tr bgcolor="'.$cor.'">';
            $return.= "<td align=center>" . utf8_encode($res->cd_prontuario) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->nome_paciente) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->sexo) . "</td>";            
            $return.= "<td align=center>" . ((date('d/m/Y',strtotime($res->dt_nasc)))) . "</td>";
            $return.= "<td align=center>" . $res->tipo . "</td>";
            $return.= "<td align=center><a href='index.php?p=alt_cad_paciente&cd=".$res->cd_prontuario."&i=edit'><img src='icons/edit.png' width='30' height='25'></a></td>";            
            $return.= "<td align=center><a onclick=\"return confirm('Tem certeza que deseja excluir?')\" href='index.php?p=del_cad&cd=".$res->cd_paciente."&i=paciente'><img src='icons/del.png' width='30' height='25'></a></td>";
            $return.= "<td align=center><a href='rel/imp/rel_info_paciente.php?cd=".$res->cd_prontuario."&i=INFORMAÇÕES DO PACIENTE'><img src='icons/impressora.png' width='30' height='25'></a></td>";
            
            $return.= "</tr>";
        }
        echo $return.="</table>";
       }
       else{     
           
        // Captura os dados da consulta e inseri na tabela HTML
        while ($res = $adj->retornaDados()) {
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $return.= '<tr bgcolor="'.$cor.'">';
            $return.= "<td align=center>" .$res->crm."/".utf8_encode($res->nome_med)."</td>";
            $return.= "<td align=center>" . utf8_encode($res->cd_especialidade) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->sexo) . "</td>";            
            $return.= "<td align=center>" . ((date('d/m/Y',strtotime($res->dt_nasc)))) . "</td>";
            if($res->situacao == 0)
            $return.= "<td align=center>INATIVO</td>";
            if($res->situacao == 1)
            $return.= "<td align=center>ATIVO</td>";
            $return.= "<td align=center><a href='index.php?p=alt_cad_medico&cd=".$res->cd_med."&i=edit'><img src='icons/edit.png' width='30' height='25'></a></td>";
            $return.= "<td align=center><a onclick=\"return confirm('Tem certeza que deseja excluir?')\" href='index.php?p=del_cad&cd=".$res->cd_med."&i=medico'><img src='icons/del.png' width='30' height='25'></a></td>";
            $return.= "<td align=center><a href='rel/imp/rel_info_medico.php?cd=".$res->cd_med."&i=INFORMAÇÕES DO MÉDICO'><img src='icons/impressora.png' width='30' height='25'></a></td>";
            $return.= "</tr>";
        }
        echo $return.="</table>";
       }
    } //IF DO PACIENTE OU MEDICO
    
    else if ($cont > 0 and $op == "usuario") {
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        $cores = array("#e1e1e1","#FFFFFF");  
  
        $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <th>".$art[$op][0]."</th>                            
                            <th>".$art[$op][1]."</th>                            
                            <th>EDITAR</th>
                            <th>DELETAR</th>";
                                       
        $return = "$tabela";
        // Captura os dados da consulta e inseri na tabela HTML
        while ($res = $adj->retornaDados()) {
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $return.= '<tr bgcolor="'.$cor.'">';            
            $return.= "<td>" . utf8_encode($res->usuario) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->tp_acesso) . "</td>";            
            if($res->usuario == "admin"){
                $return.= "<td align=center>----</td>";
                $return.= "<td align=center>----</td>";
            }
            else{
            $return.= "<td align=center><a href='index.php?p=alt_cad_usuario&cd=".$res->cd_acesso."&i=edit'><img src='icons/edit.png' width='30' height='25'></a></td>";
            $return.= "<td align=center><a onclick=\"return confirm('Tem certeza que deseja excluir?')\" href='index.php?p=del_cad&cd=".$res->cd_acesso."&i=usuarios'><img src='icons/del.png' width='30' height='25'></a></td>";
            }
            $return.= "</tr>";
        }
        echo $return.="</table>";
    }//IF DO USUARIO
    
    else if ($cont > 0 and $op == "especialidade") {
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        $cores = array("#e1e1e1","#FFFFFF");  
        
        $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <th>".$art[$op][0]."</th>                                                        
                            <th>EDITAR</th>
                            <th>DELETAR</th>";
                                       
        $return = "$tabela";
        // Captura os dados da consulta e inseri na tabela HTML
        while ($res = $adj->retornaDados()) {
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $return.= '<tr bgcolor="'.$cor.'">';
            $return.= "<td>" . utf8_encode($res->especialidade) . "</td>";
            $return.= "<td align=center><a href='index.php?p=alt_cad_especialidade&cd=".$res->cd_especialidade."&i=edit'><img src='icons/edit.png' width='30' height='25'></a></td>";
            $return.= "<td align=center><a onclick=\"return confirm('Tem certeza que deseja excluir?')\" href='index.php?p=del_cad&cd=".$res->cd_especialidade."&i=especialidade&j=".$res->especialidade."'><img src='icons/del.png' width='30' height='25'></a></td>";
            $return.= "</tr>";
        }
        echo $return.="</table>";
    }//IF DA ESPECIALIDADE 
    
    
    else if ($cont > 0 and $op == "consultas") {
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        //$cores = array("#e1e1e1","#FFFFFF");  
        $cores = array("#e1e1e1","#FFFFFF");  
        
        $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <th>".$art[$op][0]."</th>
                            <th>".$art[$op][1]."</th>
                            <th>".$art[$op][2]."</th>
                            <th>".$art[$op][3]."</th>
                            <th>".$art[$op][4]."</th>
                            <th>".$art[$op][5]."</th>
                            <th>".$art[$op][6]."</th>
                            <th>".$art[$op][7]."</th>";
                            
                                       
        $return = "$tabela";
        // Captura os dados da consulta e inseri na tabela HTML
        while ($res = $adj->retornaDados()) {
            
            abreconexao();
            $sql = "SELECT nome_paciente FROM paciente WHERE cd_prontuario=".$res->cd_prontuario;
            $query = pg_query($sql);
            $cont = pg_affected_rows($query); 
            if($cont > 0){
                while($tbl = pg_fetch_object($query)){
                    $nome_paciente = $tbl->nome_paciente;
                }
            }
            fechaconexao();        
            
            abreconexao();
            $sql = "SELECT nome_med FROM medico WHERE crm=".$res->crm;
            $query = pg_query($sql);
            $cont = pg_affected_rows($query); 
            if($cont > 0){
                while($tbl = pg_fetch_object($query)){
                    $nome_med = $tbl->nome_med;
                }
            }
            fechaconexao();
            
            abreconexao();
            $sql = "SELECT nome_acesso FROM usuarios WHERE cd_acesso=".$res->cd_acesso;
            $query = pg_query($sql);
            $cont = pg_affected_rows($query); 
            if($cont > 0){
                while($tbl = pg_fetch_object($query)){
                    $nome_acesso = $tbl->nome_acesso;
                }
            }
            fechaconexao(); 
                  
            
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $return.= '<tr bgcolor="'.$cor.'">';
            $return.= "<td align=center>" . utf8_encode($nome_paciente) . "</td>";
            $return.= "<td align=center>" . utf8_encode($nome_med) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->especialidade) . "</td>";
            $return.= "<td align=center>" . utf8_encode((date('d/m/Y',strtotime($res->dt_consulta)))) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->hr_consulta) . "</td>";
             
            if($res->status == 1)
            $return.= "<td align=center>AGENDADO</td>";//"<td align=center><img src='icons/no.png' width='30' height='25'></td>";
            else if($res->status == 2)
            $return.= "<td align=center>ATENDIDO</td>";//"<td align=center><img src='icons/yes.png' width='30' height='25'></td>";
            else if($res->status == 3)
            $return.= "<td align=center>CANCELADO</td>";//"<td align=center><img src='icons/yes.png' width='30' height='25'></td>";
            else
            $return.= "<td align=center>FALTOU</td>";//"<td align=center><img src='icons/yes.png' width='30' height='25'></td>";
            
            if(!empty($res->obs))
            $return.= "<td>" . utf8_encode($res->obs) . "</td>";
            else
            $return.= "<td align=center>------</td>";
            
            if($res->cd_acesso == -1)
            $return.= "<td>PACIENTE</td>";
            else
            $return.= "<td>" . utf8_encode($nome_acesso) . "</td>";    
                
            $return.= "</tr>";
        }
        echo $return.="</table>";
        echo"<br>";echo"<br>";
 }//IF DA CONSULTAS   
    
    else if ($cont > 0 and $op == "agenda") {
        $k = 0;
        while ($res = $adj->retornaDados()) {
            $arrayaux[] = $res->crm;
            $arrayn[] = $res->nome_med;                        
        }       
        //require_once("classes/agenda.class.php");
        abreconexao();        
        $sql = "SELECT * FROM agenda WHERE Extract('Year' FROM dt )=".$ano." ORDER BY dt DESC";        
        $query = pg_query($sql);
        $cont = pg_num_rows($query);
        if($cont == 0){
            echo" Este Medico não possui agenda no ano informado.";
            fechaconexao();
            exit();
        }
        for($i=0; $i<count($arrayaux);$i++){
            while($tbl = pg_fetch_object($query)){            
                if($tbl->crm == $arrayaux[$i]){
                    $array[] = $tbl->crm;
                    $arraynome[] = $arrayn[$i];
                    $arrayespecialidade[] = $tbl->especialidade;
                    $arraymes[] = (date('m',strtotime($tbl->dt)));
                    $arrayano[] = (date('Y',strtotime($tbl->dt)));
                }
            }           
        } 
         if(empty($arraymes)){// VERIFICA SE O MEDICO TEM AGENDA 
                echo"Cadastre uma agenda para o medico.";
                fechaconexao();
                exit();
        }
        $marc=0;
        
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        $cores = array("#e1e1e1","#FFFFFF");  
        
        $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <th>".$art[$op][0]."</th> 
                            <th>".$art[$op][1]."</th>
                            <th>".$art[$op][2]."</th>
                            <th>IMPRIMIR</th>
                            <th>EDITAR</th>
                            <th>DELETAR</th>";
                                       
        $return = "$tabela";
        
        //**************************************************************************************
        //ROTINA PARA NÃO DUPLICAR BUSCA. NÃO MOSTRA VALORES (crm/NOME) REPETIDO. NESSE CASO, O MES NÃO SE REPETE
        $aux = 0;
        $marc = 0; 
        $qtde = count($array); 
        $c = 0;
        for($i=0; $i<$qtde; $i++){
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            $aux2[] = $array[$i];
            $return.= '<tr bgcolor="'.$cor.'">';
            if($aux == 0){
                //$return.= '<tr bgcolor="'.$cor.'">';
                $return.= "<td>" . $array[$i]."/".$arraynome[$i]. "</td>";
                $return.= "<td>" . $arrayespecialidade[$i] . "</td>";
                $return.= "<td>" .$arraymes[$i]."/".$arrayano[$i] . "</td>";
                $return.= "<td align=center><a href='index.php?p=imp_agenda&cd=".$array[$i]."&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/impressora.png' width='30' height='25'></a></td>";
                if($arraymes[$i] < date('m') && $arrayano[$i] <= date('Y')){//SE O MES JA TIVER PASSADO NÃO PODE ALTERAR
                $return.= "<td align=center><a href='index.php?p=alt_cad_agenda&cd=".$array[$i]."&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/edit.png' width='30' height='25'></a></td>";
                $return.= "<td align=center><img src='icons/bloqueado.jpg' width='40' height='35'></td>";
                }
                else{
                $return.= "<td align=center><a href='index.php?p=alt_cad_agenda&cd=".$array[$i]."&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/edit.png' width='30' height='25'></a></td>";
                $return.= "<td align=center><a onclick=\"return confirm('Tem certeza que deseja excluir?')\" href='index.php?p=del_cad&cd=".$array[$i]."&i=agenda&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/del.png' width='30' height='25'></a></td>";
                }
                $return.= "</tr>";
                $aux = 1;
             }
             
             else{
                 $qtde2 = count($aux2)-1;                
                 for($j=0; $j<$qtde2;$j++){
                    if($array[$i] == $aux2[$j] && $arraymes[$i] == $arraymes[$j] && $arrayespecialidade[$i] == $arrayespecialidade[$j]){
                        $marc = 1;                        
                    }                                      
                 }
                 if($marc == 0){
                     //$return.= '<tr bgcolor="'.$cor.'">';
                     $return.= "<td>" . $array[$i]. "/".$arraynome[$i]. "</td>";
                     $return.= "<td>" . $arrayespecialidade[$i] . "</td>";
                     $return.= "<td>" .$arraymes[$i]."/".$arrayano[$i] . "</td>";
                     $return.= "<td align=center><a href='index.php?p=imp_agenda&cd=".$array[$i]."&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/impressora.png' width='30' height='25'></a></td>";
                     if($arraymes[$i] < date('m') && $arrayano[$i] <= date('Y')){
                        $return.= "<td align=center><a href='index.php?p=alt_cad_agenda&cd=".$array[$i]."&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/edit.png' width='30' height='25'></a></td>";
                        $return.= "<td align=center><img src='icons/bloqueado.jpg' width='40' height=35'></td>";
                    }
                    else{
                        $return.= "<td align=center><a href='index.php?p=alt_cad_agenda&cd=".$array[$i]."&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/edit.png' width='30' height='25'></a></td>";
                        $return.= "<td align=center><a onclick=\"return confirm('Tem certeza que deseja excluir?')\" href='index.php?p=del_cad&cd=".$array[$i]."&i=agenda&j=".$arraymes[$i]."&k=".$arrayano[$i]."&l=".$arrayespecialidade[$i]."'><img src='icons/del.png' width='30' height='25'></a></td>";
                    }
                     $return.= "</tr>";                                        
                 }
                 
                 $marc = 0;
                 }
            }         
            echo $return.="</table>";
           //**************************************************************************************
       }//FIM DO ELSE IF AGENDA  
    
    else {
        // Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
        echo "Não foram encontrados registros!";
    }
    
}//FIM DA FUNÇÃO EXIBE_DADOS()

$f = $_GET["env_nome"];
$e = $_GET["op"];
$ano = $_GET["ano"];

if(!empty($f)){      
        exibe_dados($f,$e,$ano);  
        
}
else{
   echo "Não foram encontrados registros!";        
}


?>