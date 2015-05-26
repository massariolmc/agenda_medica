<?php
//include("conecta.php"); OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

//######### INICIO Paginação
        $pg = $_GET["pg"];//NO MOMENTO NÃO ESTA SENDO USADO, MAS SERVA PARA RECEBER UM VALOR E MOSTRAR QUANTOS REGISTROS POR PAGINA O USUARIOS DESEJAR VER
	$numreg = 300; // Quantos registros por página vai ser mostrado
	if (!$pg) {
		$pg = 0;// TEM QUE SER INCIADO COM ZERO PARA QUANDO CHAMAR A FUNÇÃO ABRIR NA PRIMEIRA PAGINA
	}
	$inicial = ($pg * $numreg); 
	
//######### FIM dados Paginação
	       
    $op = $_GET["op"];//  
    echo "LISTA COMPLETA DE ".strtoupper($op)."S <br><br>";
        $art = array(
        "paciente"  => array("PRONTUARIO","NOME DO PACIENTE","SEXO", "DT NASC","TIPO"),
        "medico"    => array("CRM/NOME DO MEDICO","ESPECIALIDADE","SEXO","DT NASC","SITUAÇÃO"),
        "usuario"   => array("USUARIO","MODO DE ACESSO"),
        "especialidade" => array("NOME DA ESPECIALIDADE"),
        "agenda" => array("CRM/NOME","ESPECIALIDADE","MES/ANO")
    );
    
    if(strcmp($op,"paciente") == 0){
        require_once("classes/paciente.class.php");
        $adj = new pacientes();
        $aux = "nome_paciente";
        $adj->selecionaTudo($adj);
        $quantreg = $adj->linhasafetadas;// Quantidade de registros pra paginação
    }
    
    else if(strcmp($op,"medico") == 0){         
        require_once("classes/medico.class.php");
        $adj = new medicos();
        $aux = "nome_med";
        $adj->selecionaTudo($adj);
        $quantreg = $adj->linhasafetadas;// Quantidade de registros pra paginação
        
    }
    else if(strcmp($op,"usuario") == 0){
        require_once("classes/usuarios.class.php");
        $adj = new usuarios();
        $aux = "usuario";
        $adj->selecionaTudo($adj);
        $quantreg = $adj->linhasafetadas;// Quantidade de registros pra paginação
    }
    else if(strcmp($op,"agenda") == 0){
        //require_once("classes/agenda.class.php");
        //$adj = new agenda();
        //$aux = "nome_med";
        require_once("classes/medico.class.php");
        $adj = new medicos();
        $aux = "nome_med";
    }
    else{
        require_once("classes/especialidade.class.php");
        $adj = new especialidade();
        $aux = "especialidade";
        $adj->selecionaTudo($adj);
        $quantreg = $adj->linhasafetadas;// Quantidade de registros pra paginação
    }    
        
    //FAZ O SELECT PARA PEGAR A QUANTIDADE DE PAGINAS COMEÇANDO PELO VALOR QUE ESTA NO $INICIAL
        
       $adj->extras_select = "ORDER BY ".$aux." ASC LIMIT ".$numreg." OFFSET ".$inicial;
        
        $adj->selecionaTudo($adj);  
        
	include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>
	
	echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo
        
        $cont = $adj->linhasafetadas;
        
        if ($cont > 0 and ($op == "paciente" or $op == "medico")) {
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        $cores = array("#2E82FF","#FFFFFF");  
        $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            <th>N° DE ORDEM</th>
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
           $return.= "<td align=center>" . ($c-2) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->cd_prontuario) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->nome_paciente) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->sexo) . "</td>";            
            $return.= "<td align=center>" . ((date('d/m/Y',strtotime($res->dt_nasc)))) . "</td>";
            $return.= "<td align=center>" . utf8_encode($res->tipo) . "</td>";
            $return.= "<td align=center><a href='index.php?p=alt_cad_paciente&cd=".$res->cd_prontuario."&i=edit'><img src='icons/edit.png' width='30' height='25'></a></td>";
            $return.= "<td align=center><a onclick=\"return confirm('Tem certeza que deseja excluir?')\" href='index.php?p=del_cad&cd=".$res->cd_paciente."&i=paciente'><img src='icons/del.png' width='30' height='25'></a></td>";
            $return.= "<td align=center><a href='rel/imp/rel_info_paciente.php?cd=".$res->cd_prontuario."&i=INFORMAÇÕES DO PACIENTE'><img src='icons/impressora.png' width='30' height='25'></a></td>";
            $return.= "</tr>";
        }
        echo $return.="</table>";
        echo "<br>TOTAL: ".$quantreg;
       }
       else{     
           
        // Captura os dados da consulta e inseri na tabela HTML
        while ($res = $adj->retornaDados()) {
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];
            
            $return.= '<tr bgcolor="'.$cor.'">';
            $return.= "<td align=center>" . ($c-2) . "</td>";
            $return.= "<td align=center>" . $res->crm ."/".utf8_encode($res->nome_med). "</td>";
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
        echo "<br>TOTAL: ".$quantreg;
       }
    } //IF DO PACIENTE OU MEDICO
    
    else if ($cont > 0 and $op == "usuario") {
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        $cores = array("#2E82FF","#FFFFFF");  
  
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
        echo "<br>TOTAL: ".$quantreg;
    }//IF DO USUARIO
    
    else if ($cont > 0 and $op == "especialidade") {
        // Atribui o código HTML para montar uma tabela
        $c = 2;
        $cores = array("#2E82FF","#FFFFFF");  
        
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
        echo "<br>TOTAL: ".$quantreg;
    }//IF DA ESPECIALIDADE 
    
          
        
        
?>
