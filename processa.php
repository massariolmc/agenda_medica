<?php
//include("conecta.php");
if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP



//FUNÇÃO QUE VERIFICA SE EXISTE PACIENTE, USUARIOS, ESPECIALIDADE IGUAIS
function verifica_existe($tabela, $valor, $cond, $aux,$aux2){//ESTE ULTIMO ELEMENTO ($AUX2) SERVE APENAS O MEDICO, PARA OS OUTROS NÃO E UTILIZADO
    $aux2 = mb_strtoupper($aux2);
    if($tabela == "paciente"){
        require_once("classes/paciente.class.php");
        $adj = new pacientes();
    }
    else if($tabela == "medico"){
        require_once("classes/medico.class.php");
        $adj = new medicos();
    }
    else if($tabela == "usuarios"){
        require_once("classes/usuarios.class.php");
        $adj = new usuarios();
    }
    else if($tabela == "consultas"){
        abreconexao();
        $sql = "SELECT * FROM paciente WHERE cd_prontuario=".$valor;
        $query = pg_query($sql);    
        $cont = pg_affected_rows($query); 
        if($cont <= 0){
            echo "Usuario Inexistente. <br>";
            echo"Por favor, insira um prontuario existente.<br>";
            echo "<a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
            fechaconexao();
            exit();
        }
        fechaconexao();
        return 1;
        //require_once("classes/consultas.class.php");
        //$adj = new consultas();
    }
    else{
        require_once("classes/especialidade.class.php");
        $adj = new especialidade();
    }
    
            if(is_numeric($valor)){
                $adj->extras_select = "WHERE ".$cond."=".$valor;
            }
            else {
                $valor = mb_strtoupper($valor);
                $adj->extras_select = "WHERE ".$cond."='".$valor."'";    
            }
            
            $adj->selecionaTudo($adj);            
            $cont = $adj->linhasafetadas;        
            if ($cont > 0 && $tabela == "paciente")
            {
            echo "Prontuario existente <br>";
            echo "<br>Esse prontuario pertence a: <br>";
            while ($res = $adj->retornaDados()) {
                echo "<br>NOME: ".$res->nome_paciente."<br> SEXO: ".$res->sexo."<br> DATA DE NASC: ".$res->dt_nasc."<br>";
            }
            echo "<br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
            exit();
            }
            
            else if($cont > 0 && $tabela == "medico"){// NAO DEIXA CADASTRAR O DUAS ESPECIALIDADE IGUAIS PARA O MESMO MEDICO
                while ($res = $adj->retornaDados()) {// E NEM DOIS CRM PARA MEDICOS DIFERENTES
                        $r1 = $res->cd_especialidade;//LEMBRANDO QUE O MEDICO PODE TER VARIAS ESPECIALIDADES
                        $r2 = $res->crm;
                        $r3 = $res->nome_med;
                        if(!is_numeric($aux)){
                    if($r1 == $aux){
                        echo "O MEDICO JA POSSUI ESTA ESPECIALIDADE. CADASTRE OUTRA.<br><br>";
                        echo "<br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";                        
                        exit();
                    }
                }
                else {
                    if($r3 == $aux2){// COMPARA SE O CRM DO MEDICO A SER CADASTRADO PERTENCE A ELE MESMO
                        return 0;
                    }
                    else{
                         echo "<br>Esse CRM ".$r2." pertence a: <br>";
                         echo "<br>NOME: ".$r3."<br>";
                         echo "<br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
                         exit();
                    }
                    
                    }
                }
                
                
               
                    
           } 
                
            
            else if ($cont > 0 && $tabela == "especialidade")
            {
            echo "Especialidade existente <br>";
                        
            echo "<a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
            exit();
            }
            
            else if ($cont > 0 && $tabela == "usuarios")
            {
            echo "Usuario existente <br>";
            echo "<br>Esse usuario pertence a: <br>";
            while ($res = $adj->retornaDados()) {
                echo "<br>NOME: ".$res->nome_acesso."<br> USUARIO: ".$res->usuario."<br>";
            }
            echo "<a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
            exit();
            }
            
            else if ($cont < 0 && $tabela == "consultas")
            {
                if($aux == 0){
                    echo "Paciente Inexistente <br>";
                    echo"Por favor, insira um prontuario existente.<br>";
                    echo"<a href='index.php?p=marc_consulta'>VOLTAR</a><br>";
                    exit();
                }
            }
            
            else{
                
            }
}//FIM DO VERIFICA SE EXISITE

function verifica_arq_dirsa($var,$nome){
    $cont = 0;$marc=0;
    $cont = count($var);
    
    if($cont == 0){
        echo"O paciente não pode marcar consultas. Por favor, entre em contato com SAME do Esquadrão de Saúde.<br>";
        echo"<a href='index.php?p=marc_consulta'>VOLTAR</a><br>";
        exit();
    }

    else{
         foreach($var as $aux):  
             
                $n = $aux;
                $t = explode(' ', $n);               
                $t_aux = explode(' ', $nome);                
                if($t[0] == $t_aux[0]){
                    $marc = 1;                    
                }
                            
         endforeach;    
    }
    if($marc == 0){
        echo"Por favor entre em contato com SAME para poder marcar consultas.<br>";
        echo"<a href='index.php?p=marc_consulta'>VOLTAR</a><br>";
        exit();
    }
         
}

function decoder_hora($aux){
    $cont   = 0;
    $tam    = strlen($aux);        
    $pos    = strpos($aux,'/');// função que verifica a primeira ocorrencia do "/" para demarcar a hora. Se for false não encontrou, se for true achou. É booleano
    $cont   = substr_count($aux, '/');//função que verifica quantas vezes aparece um determinado valor em um string
    if ($pos === false) {
        echo "A string  não foi encontrada. ";        
    }
    else {    
       
        $rest = substr($aux, $pos+1, 5);
     }     
        return $rest;    
    
}//FIM DA FUNÇÃO DECODER_HORA()

function decoder_dia($aux){
    $cont   = 0;
    $tam    = strlen($aux);        
    $pos    = strpos($aux,'/');// função que verifica a primeira ocorrencia do "/" para demarcar o dia. Se for false não encontrou, se for true achou. É booleano
    $cont   = substr_count($aux, '/');//função que verifica quantas vezes aparece um determinado valor em um string
    
    if ($pos === false) {
        echo "A string DIA não foi encontrada. ";        
    }
    else {        
            $rest = substr($aux, 0, $pos);        
     }
       return $rest;    
    
}//FIM DA FUNÇÃO DECODER_dia()

function verifica_consulta($m,$mes,$ano,$decoder,$crm,$espec){
    abreconexao();
$sql = "SELECT * FROM consultas WHERE crm=".$crm." AND especialidade='".$espec."' AND Extract('Day' FROM dt_consulta )=".$m." AND Extract('Month' FROM dt_consulta )=".$mes." AND Extract('Year' FROM dt_consulta )=".$ano." AND hr_consulta='".$decoder."'";
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){  
    fechaconexao();
    return 1;       
}
else {
    fechaconexao();
return 0;}

}

function envia_email($pront,$crm,$espec,$data,$hora,$dt_cad,$hr_cad,$cod,$obs){
    
    
    abreconexao();
              
            $sql = "SELECT nome_acesso as \"AGENDADO\"
                    FROM usuarios 
                    WHERE cd_acesso=$cod";
            $query = pg_query($sql);    
            $cont = pg_affected_rows($query); 
                if($cont > 0){
                    while ($res = pg_fetch_object($query)) {
                        $nome_acesso = $res->AGENDADO;
                    }
                    
                }
                    
            $sql = "SELECT nome_paciente as \"PACIENTE\",email as \"EMAIL\"
                    FROM paciente p 
                    WHERE cd_prontuario=".$pront;
            $query = pg_query($sql);    
            $cont = pg_affected_rows($query); 
                if($cont > 0){
                    while ($res = pg_fetch_object($query)) {
                        $nome_paciente = $res->PACIENTE;
                        $email_paciente = $res->EMAIL;
                    }
                }
                     
    
    
                    $sql = "SELECT nome_med as \"MEDICO\"
                    FROM medico 
                    WHERE crm=".$crm;
                    $query = pg_query($sql);    
                    $cont = pg_affected_rows($query); 
                    if($cont > 0){
                    while ($res = pg_fetch_object($query)) {
                        $medico = $res->MEDICO;
                        
                    }
                }
                
                fechaconexao();
                if(empty($nome_acesso))
                    $nome_acesso = $nome_paciente;
            
            $conteudo_email  = utf8_decode("CONSULTA MÉDICA - AGENDAMENTO ONLINE<br><br>");
            if($obs)
                $conteudo_email  .= utf8_decode("SUA CONSULTA FOI REMARCADA. ATENTE PARA O NOVO HORARIO<br><br>");
            $conteudo_email .= "NOME: ".$nome_paciente."<br>";
            $conteudo_email .= "MEDICO: ".$medico."<br>";
            $conteudo_email .= "ESPECIALIDADE: ".$espec."<br>";
            $conteudo_email .= utf8_decode("DATA DA CONSULTA: ".$data." às $hora <br><br>");
            $conteudo_email .= utf8_decode("AGENDADO DIA: ".$dt_cad." às ".$hr_cad." por ".$nome_acesso."<br>");
            include("mail.php");          
}

function inverteData($data){
    if(count(explode("/",$data)) > 1){
        return implode("/",array_reverse(explode("/",$data)));
    }elseif(count(explode("-",$data)) > 1){
        return implode("/",array_reverse(explode("-",$data)));
    }
}

//VEM VIA FORMULARIO E PARA DECIDIR QUE OPERAÇÃO(CADASRTAR OU ALTERAR PACIENTE/MEDICOS/ESPECIALIDADE/USUARIOS) REALIZAR
$operacao = $_POST['operacao'];

if($operacao == "cad_paciente" || $operacao == "alt_paciente")
    {
    $cd_prontuario  = $_POST['prontuario'];
    require_once("classes/paciente.class.php");
    
        if($operacao == "alt_paciente"){
            $cd_paciente    = $_POST['cd_paciente'];
            $pac = new pacientes();
            $pac->extras_select = "WHERE cd_paciente=".$cd_paciente;
            $pac->selecionaTudo($pac);            
            $cont = $pac->linhasafetadas;                      
            if($cont > 0){
                while ($res = $pac->retornaDados()) {                  
                        if($res->cd_prontuario !=  $cd_prontuario){
                            verifica_existe("paciente", $cd_prontuario, "cd_prontuario",0);                            
                        }
                }              
            }
               
       }
       else{       
       verifica_existe("paciente", $cd_prontuario, "cd_prontuario",0);       
       }
        //$cd_paciente    = $_POST[''];
        $cd_acesso      = $_POST['cd_acesso'];
        $nome_paciente  = $_POST['nome'];
        $dt_nasc        = inverteData($_POST['dt_nasc']);
        $dt_cad         = date("Y/m/d");
        $sexo           = $_POST['sexo'];
        $est_civil      = $_POST['est_civil'];
        $nr_tel         = $_POST['tel'];
        $nr_cel         = $_POST['cel'];
        $op_cel         = $_POST['operadora'];
        $email          = $_POST['email'];        
        $endereco       = $_POST['rua'];
        $cidade         = $_POST['cidade'];
        $bairro         = $_POST['bairro'];
        $uf             = $_POST['estado'];
        $numero         = $_POST['numero'];
        $cep            = $_POST['cep'];
        $tipo           = $_POST['tipo'];
        $saram           = $_POST['saram'];
                
        $paciente = new pacientes();

        $paciente->setValor('cd_paciente',$cd_paciente);
        $paciente->setValor('cd_acesso',$cd_acesso);
        $paciente->setValor('nome_paciente',$nome_paciente);
        $paciente->setValor('dt_nasc',$dt_nasc);
        $paciente->setValor('dt_cad',$dt_cad);
        $paciente->setValor('sexo',$sexo);
        $paciente->setValor('est_civil',$est_civil);
        $paciente->setValor('nr_tel',$nr_tel);
        $paciente->setValor('nr_cel',$nr_cel);
        $paciente->setValor('op_cel',$op_cel);
        $paciente->setValor('email',$email);
        $paciente->setValor('cd_prontuario',$cd_prontuario);
        $paciente->setValor('endereco',$endereco);
        $paciente->setValor('cidade',$cidade);
        $paciente->setValor('bairro',$bairro);
        $paciente->setValor('uf',$uf);
        $paciente->setValor('numero',$numero);
        $paciente->setValor('cep',$cep);
        $paciente->setValor('tipo',$tipo);
        $paciente->setValor('saram',$saram);
        
        if($operacao == "cad_paciente"){
            $paciente->inserir($paciente);
            $h = 1;
        }
        
        else {//se cair nesse else entao é para alterar os dados
                    
            $paciente->valorpk = $cd_paciente;
            $paciente->atualiza($paciente);            
            //header('Location: ./index.php?p=adm');
            $h = 1;
        }
        
        if($paciente->linhasafetadas > 0){
            if($h == 1){echo "<script> a = confirm(\"Opera\u00e7\u00e3o feita com sucesso.\");
                if (a == true) { location.href = \"./index.php?p=busca&i=paciente\"; }
                else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
            </script>";}
            else
                header('Location: ./index.php?p=adm');            
        }
            else
                header('Location: ./index.php?p=erro');
        
}
//INSERE OU ALTERA MEDICO
else if($operacao == "cad_med"|| $operacao == "alt_med")
    {
        
        $nome_medico        = $_POST['nome'];
        $cd_especialidade   = $_POST['especialidade'];
        $crm                = $_POST['crm'];
        
        require_once("classes/medico.class.php");
        
        if($operacao == "alt_med"){
            
            $cd_med    = $_POST['cd_med'];
            $med = new medicos();
            $med->extras_select = "WHERE crm=".$crm;
            $med->selecionaTudo($med);            
            $cont = $med->linhasafetadas;                      
            if($cont > 0){                      
                while ($res = $med->retornaDados()) {                          
                        $arraycd[] = $res->cd_med;
                        $arrayesp[] = $res->cd_especialidade;
                }                
            }
            $marc=0;
            $cont = count($arraycd);
                for($i=0; $i < $cont; $i++){
                    if($arraycd[$i] == $cd_med){                        
                        if($arrayesp[$i] == $cd_especialidade)
                            $marc = 1;
                        else
                            $cd = $arraycd[$i];
                    }                    
                }
                if($marc == 0){
                    verifica_existe("medico", $crm, "crm",$cd_especialidade);//VERIFICA SE A ESPECIALIDADE EXISTE  
                }
       }
       
       else{        
            verifica_existe("medico", $nome_medico, "nome_med",$cd_especialidade);//VERIFICA SE A ESPECIALIDADE EXISTE
            verifica_existe("medico", $crm, "crm",0,$nome_medico);////VERIFICA SE O MEDICO EXISTE
       }
               
        $cd_acesso          = $_POST['cd_acesso'];
        $cd_agenda          = 5;//$_POST[''];ISSO AQUI NÃO TEM NECESSIDADE, PODE TIRAR ESTE CAMPO DA BANCO DE DADOS       
        $dt_nasc            = inverteData($_POST['dt_nasc']);
        $dt_cad             = date("Y/m/d");
        $sexo               = $_POST['sexo'];
        $nr_tel             = $_POST['tel'];
        $nr_cel             = $_POST['cel'];
        $op_cel             = $_POST['operadora'];
        $situacao           = $_POST['situacao'];
     
        $medico = new medicos();
               
        $medico->setValor('crm',$crm);
        $medico->setValor('cd_acesso',$cd_acesso);
        $medico->setValor('cd_agenda',$cd_agenda);//ISSO AQUI NÃO TEM NECESSIDADE, PODE TIRAR ESTE CAMPO DA BANCO DE DADOS               
        $medico->setValor('nome_med',$nome_medico);      
        $medico->setValor('dt_nasc',$dt_nasc);        
        $medico->setValor('sexo',$sexo);        
        $medico->setValor('nr_tel',$nr_tel);
        $medico->setValor('nr_cel',$nr_cel);
        $medico->setValor('op_cel',$op_cel);
        $medico->setValor('dt_cad',$dt_cad);
        $medico->setValor('situacao',$situacao);
       
        if($operacao == "cad_med"){
            $medico->setValor('cd_med',$cd_med);
            $medico->setValor('cd_especialidade',$cd_especialidade);            
            $medico->inserir($medico);            
        }
        
        else {                     
                if($marc==1){
                    $cont = count($arraycd);
                    for($i=0; $i < $cont; $i++){
                        $medico->setValor('cd_especialidade',$arrayesp[$i]);
                        $medico->valorpk = $arraycd[$i];              
                        $medico->atualiza($medico);                                                 
                    }
                }
                else{                        
                        $medico->setValor('cd_especialidade',$cd_especialidade);                                                  
                        $medico->valorpk = $cd;              
                        $medico->atualiza($medico);                         
                }                                                    
          }          
                
          if($medico->linhasafetadas > 0){                          
              echo "<script> a = confirm(\"Opera\u00e7\u00e3o feita com sucesso.\");
                if (a == true) { location.href = \"./index.php?p=cadastra_medico\"; }
                else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
            </script>";
                //header('Location: ./index.php?p=adm');            
                
            }
            else
                header('Location: ./index.php?p=erro');
    
}
//INSERE OU ALTERA USUARIO
else if($operacao == "cad_usuario" || $operacao == "alt_usuario" || $operacao == "alt_senha_usuario" || $operacao == "autentica")
    {   
        $user = $_POST['usuario'];
        require_once("classes/usuarios.class.php");
        if($operacao == "autentica"){            
            $senha = md5($_POST['senha']);
            $senha = strtoupper($senha);//AQUI TEM QUE SER MAISUCULO POIS E ALFANUMERICO E TODO DADO NO BANCO É INSERIDO EM MAISUSCULO
            include("valida_login.php");            
            logar($user,$senha);
            exit();
        }
        
        else if($operacao == "alt_usuario" || $operacao == "alt_senha_usuario"){
            $cd_acesso    = $_POST['cd_acesso'];
            $usu = new usuarios();
            $usu->extras_select = "WHERE cd_acesso=".$cd_acesso;
            $usu->selecionaTudo($usu);            
            $cont = $usu->linhasafetadas;                      
            if($cont > 0){
                while ($res = $usu->retornaDados()) {             
                   
                        if($res->usuario !=  mb_strtoupper($user)){
                             verifica_existe("usuarios", $user, "usuario",0);                          
                        }
                        $senha = $res->senha;
                }              
            }
            if ($operacao == "alt_senha_usuario"){
           //verifica se alterou a senha
                
            $senha_aux = $_POST["n_senha"];
            $senha_aux2 = $_POST["conf_senha"];
            if(!empty($senha_aux) && !empty($senha_aux2)){
                if($senha_aux != $senha_aux2){
                    echo "A senha não confere. <br>";
                    echo"Por favor, digite novamente.<br>";
                    echo "<a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
                    exit();
                }
            }
            else if(empty($senha_aux) && !empty($senha_aux2)){
                    echo "A senha não confere. <br>";
                    echo"Por favor, digite novamente.<br>";
                    echo "<a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
                    exit();
            }
            else if(!empty($senha_aux) && empty($senha_aux2)){
                    echo "A senha não confere. <br>";
                    echo"Por favor, digite novamente.<br>";
                    echo "<a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
                    exit();      
            }     
            $senha = md5($senha_aux);
       }
       
       }       
       else
       verifica_existe("usuarios", $user, "usuario",0);
       
        //$cd_acesso    = $_POST[''];
        $nome_acesso            = $_POST['nome'];
        $tp_acesso              = $_POST['tp_acesso'];
        if($operacao == "cad_usuario")
        $senha                  = md5($_POST['senha']); 
               
        $usuario = new usuarios();

        $usuario->setValor('cd_acesso',$cd_acesso);
        $usuario->setValor('nome_acesso',$nome_acesso);
        $usuario->setValor('tp_acesso',$tp_acesso);        
        $usuario->setValor('usuario',$user);
        $usuario->setValor('senha',$senha);
         
        if($operacao == "cad_usuario"){
            $usuario->inserir($usuario);        
        }
        
        else {
                    
            $usuario->valorpk = $cd_acesso;
            $usuario->atualiza($usuario);           
        }
       
        if($usuario->linhasafetadas > 0){ 
            echo "<script> a = confirm(\"Opera\u00e7\u00e3o feita com sucesso.\");
                if (a == true) { location.href = \"./index.php?p=adm\"; }
                else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
            </script>";
                //header('Location: ./index.php?p=adm');            
            }
        else{
                header('Location: ./index.php?p=erro');    
        }
  }
//INSERE OU ALTERA ESPECIALIDADE
else if($operacao == "cad_especialidade"|| $operacao == "alt_especialidade")
    {
        $nome = $_POST['espec'];
        require_once("classes/especialidade.class.php");
        
        if($operacao == "alt_especialidade"){
            $cd_especialidade    = $_POST['cd_especialidade'];
       }
       verifica_existe("especialidade", $nome, "especialidade",0);
        
        //$cd_especialidade   = $_POST[''];
        $n_nome             = $_POST['especialidade'];
        //$nome               = $_POST['espec'];
        
        $esp = new especialidade();
              
       $esp->setValor('especialidade',$nome);     
        
        if($operacao == "cad_especialidade"){
            $esp->inserir($esp);
        }  
        else {                    
            $esp->valorpk = $cd_especialidade;
            $esp->atualiza($esp);
            header('Location: adm.php');
        }
        
        if($esp->linhasafetadas > 0){echo "<script> a = confirm(\"Opera\u00e7\u00e3o feita com sucesso.\");
                if (a == true) { location.href = \"./index.php?p=cadastra_especialidade\"; }
                else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
            </script>";
                //header('Location: ./index.php?p=adm');            
            }
        else
           header('Location: ./index.php?p=erro');         
}   
    
 else if($operacao == "cad_agenda" || $operacao == "alt_agenda"){ 
     require_once("classes/agenda.class.php");
     
     $crm   = $_POST["nome"];
     $espec = $_POST["especialidade"];
     $mes   = $_POST["mes"];
     $cal   = $_POST["dados"];
     $hora  = $_POST["hora"];
     $dt_cad  = date("Y/m/d");
     $hr_cad  = date("H:i:s");
     $ano       =$_POST["ano"];//usado apenas no alt_agenda
     
     if(empty($hora)){//IF PARA TESTAR SE AS HORAS FORAM SELECIONADAS.
        
        echo" NÃO FORAM SELECIONADAS AS HORAS.";
        echo "<br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a>";
        exit();
     }
     
     $ag = new agenda();
     if($operacao == "cad_agenda"){
     $cont = 0;
     if (!empty($cal)) {//NESSE IF FICA TODOS OS DIAS SELECIONADOS PARA MONTAR A AGENDA                
        $qtd = count($cal);        
        for ($i = 0; $i < $qtd; $i++) {                       
            $ag->setValor('cd_agenda',$cd_agenda);
            $ag->setValor('crm',$crm);
            $ag->setValor('especialidade',$espec);
            $ag->setValor('dt_cad',$dt_cad);
            $ag->setValor('hr_cad',$hr_cad);
            $ag->setValor('cd_acesso',$cd_acesso);
            $j = $cal[$i]."/".$mes."/".date("Y");             
            $j = inverteData($j);
            $ag->setValor('dt',$j);            
            if (!empty($hora)) {//NESSE IF FICA TODOS AS HORAS DO DIA ACIMA SELECINADO PARA AGENDAMENTO                
                $qtde = count($hora);                
                for ($k = 0; $k < $qtde; $k++) {                    
                    $m = decoder_dia($hora[$k]);                     
                    if($m == $cal[$i]){                        
                        $decoder = decoder_hora($hora[$k]);                        
                        $ag->setValor('hr',$decoder);
                        $ag->inserir($ag);
                        $cont += $ag->linhasafetadas;
                    }
                }
            }            
        }
    }    
    if($cont == $qtde){
       // if($h == 1){
          echo "<script> a = confirm(\"Operação realizada com sucesso.\");
                if (a == true) { location.href = \"./index.php?p=agenda\"; }
                else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
          </script>";//}
         //else header('Location: ./index.php?p=adm');
         
        //header('Location: ./index.php?p=adm');            
            }
    else
        header('Location: ./index.php?p=erro');      
 }//FIM DO IF DA CAD AGENDA
 else{
        
    $marc = 0;
    $qtd = count($cal);   
    abreconexao();
    $j=0;
    $cod = array();
    for($i=0; $i<$qtd;$i++){
        $qtde = count($hora);
             for ($k = 0; $k < $qtde; $k++) {                
                $m = decoder_dia($hora[$k]);
                if($m == $cal[$i]){                    
                    $decoder = decoder_hora($hora[$k]);
                    $v = verifica_consulta($m,$mes,$ano,$decoder,$crm,$espec);                    
                    if($v == 1){
                       $h = 1;                        
                    }
                    else{
                    $sql = "Select cd_agenda FROM agenda WHERE crm=".$crm." AND Extract('Month' FROM dt )=".$mes." AND Extract('Day' FROM dt )=".$m." AND Extract('Year' FROM dt )=".$ano." AND hr='".$decoder."'";
                    $query = pg_query($sql);
                    $cont = pg_affected_rows($query);                    
                    if($cont > 0){
                        while($tbl = pg_fetch_object($query)){
                            $cod[$j] = $tbl->cd_agenda;                            
                            $j++;
                        }
                    } 
                    
                  }
                }
            }//FIM DO FOR
      }//FIM DO FOR MAIOR 
      
      $cont = 0;
      $qtde = count($cod);      
      for($i=0; $i<$qtde;$i++){                    
            $ag->valorpk = $cod[$i];    
            $ag->deletar($ag);
            $cont += $ag->linhasafetadas;            
      }
      if($cont == $qtde){
          if($h == 1){
          echo "<script> a = confirm(\"Existem pacientes agendados em alguns horários. Para excluir todos os horários, por favor remarque o paciente em outro dia e horário.\");
                if (a == true) { location.href = \"./index.php?p=adm\"; }
                else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
          </script>";}
          else{
              echo"<script> a = confirm(\"Operação realizada com sucesso.\"); 
                  if (a == true) { location.href = \"./index.php?p=adm\"; }
                  else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
                  </script>
                    ";
              //header('Location: ./index.php?p=adm');
          }
          
      }
      else{
        header('Location: ./index.php?p=erro');
      }
         
      fechaconexao();
 }// FIM DO ALT_AGENDA
 
 }//FIM DO IF CAD_AGENDA OU ALT_AGENDA
 
 
 else if($operacao == "marc_consulta"|| $operacao == "alt_cad_consultas" || $operacao == "cancelar_consultas" || $operacao == "alt_cancelar_consultas" || $operacao == "alt_confirmar_consultas")
    {
        
        $cd_prontuario = $_POST['prontuario'];
        $hora = $_POST['hora'];
        verifica_existe("consultas", $cd_prontuario, "cd_prontuario",0);//VERIFICA PACIENTE INEXISTENTE
        
        abreconexao();
        $sql = "SELECT * FROM paciente WHERE cd_prontuario=".$cd_prontuario;
        $query = pg_query($sql);
        $cont = pg_affected_rows($query); 
        if($cont > 0){
            while($tbl = pg_fetch_object($query)){
                $t1 = $tbl->tipo;
                $n1 = $tbl->nome_paciente;
                $s1 = $tbl->saram;
            }
            include("upload/upload.php");
            
            $sa = strlen($s1);
            if($sa < 7) {//ERRA ROTINA RETIRA O ULTIMO DIGITO DO SARAM, POIS NA PESQUISA DO ARQUIVO DA SARAM O ULTIMO DIGITO NÃO É USADO
                $s1 = substr($s1, 0, 5);//RETIRA O ULTIMO DIGITO
                $s1 = "0".$s1;//COMO O SARAM É MENOR QUE 7, ENTAO ESTA FALTANDO O ZERO MAIS A ESQUERDA, ESTA FUNÇÃO INSERE O ZERO             
            }
            else
                $s1 = substr($s1, 0, 6);//RETIRA O ULTIMO DIGITO
            
            $w = le_arquivo("upload/CONTRIB.csv",$s1);
            $w1 = le_arquivo("upload/DEPEN.csv",$s1);            
            $aux = array_merge((array)$w, (array)$w1);//CONCATENA ARRAYS            
            
            verifica_arq_dirsa($aux,$n1);//TESTA SE O PACIENTE AINDA ESTA CADASTRA NA DIRSA, CASO NÃO, NÃO MARCA CONSULTA
            
            if($t1 == "DESATIVADO"){
                echo"Este paciente não tem autorização para marcar consulta. Ele está desativado.";
                echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
                exit();
            }
        }
        fechaconexao();
        
        if(empty($hora)){//VERIFICA SE SELECIONOU AS HORAS
            echo"SELECIONE A HORA PARA AGENDAMENTO.";
            echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
            exit();
        }      
        $crm    = $_POST['crm'];
        $espec  = $_POST['especialidade'];
        $mes    = inverteData($_POST['mes']);//mes completo xx/xx/xxxx        
        $mesn   = $_POST['mesn'];//mes 05 ou 07
        $dia    = $_POST['dia'];
        $nome   = $_POST['medico'];
        $hora   = $_POST['hora'];
        $dt_cad  = date("Y/m/d");
        $hr_cad  = date("H:i:s");
        $obs     = $_POST['obs'];
        $obs_aux     = $_POST['obs_aux'];
        
        $ano = substr($mes,0 ,4);
        $comp   = $_POST['comp'];
        $cid   = $_POST['cid'];
        
        require_once("classes/consultas.class.php");        
        
        
        if($operacao == "alt_cad_consultas" || $operacao == "cancelar_consultas" || $operacao == "alt_cancelar_consultas" || $operacao == "alt_confirmar_consultas"){
            $cd_consulta    = $_POST['cd_consulta'];
              
       }      
        
        else{
        $cont = 0;               
        $co = new consultas();
        $co->extras_select = "WHERE cd_prontuario=".$cd_prontuario." AND crm=".$crm." AND especialidade='".$espec."' AND Extract('Day' FROM dt_consulta )=".$dia." AND Extract('Month' FROM dt_consulta )=".$mesn." AND Extract('Year' FROM dt_consulta )=".$ano;
        $co->selecionaTudo($co);
        $res = $co->retornaDados();
        $cont = $co->linhasafetadas;        
        //$obs_aux = $res->obs;
        //echo"obs1".$obs_aux."dia".$dia;exit();
            if($cont > 0 && $res->status != 3){
                //ISSO É PARA CASO A PESSOA CANCELA A MARCAÇÃO, E DEPOIS QUER MARCAR A CONSULTA NO MESMO DIA, POREM EM HORARIO DIFERENTE
                               
                echo"Este paciente já possui agendamento com esse médico neste dia.";
                if($operacao == "alt_cad_consultas")
                    echo "<p><br><a href=\"index.php?p=alt_cad_consultas\" >VOLTAR</a></p>";
                else
                    echo "<p><br><a href=\"index.php?p=marc_consulta\" >VOLTAR</a></p>";
                exit();
            }
            
       }
       
       $c = new consultas();
       $c->setValor('cd_consulta',$cd_consulta);       
       $c->setValor('cd_prontuario',$cd_prontuario);
       $c->setValor('crm',$crm);
       $c->setValor('especialidade',$espec);
       $c->setValor('dt_consulta',$mes);
       $c->setValor('hr_consulta',$hora);      
       $c->setValor('dt_cad',$dt_cad);
       $c->setValor('hr_cad',$hr_cad);
       if(!empty($cd_acesso)){
       $c->setValor('cd_acesso',$cd_acesso);
       
       }
       else{
       $c->setValor('cd_acesso',-1);//se for -1, quer dizer que quem fazer a marcação foi o paciente       
       }
       
       if(!empty($obs_aux))
       $obs = $obs_aux." ".$obs;
       
       $c->setValor('obs',$obs);
       
       if($operacao == "alt_cad_consultas" || $operacao == "marc_consulta")
           $c->setValor('status',1);
       else if($operacao == "confirmar_consultas"){
           if($comp == 1)
                $c->setValor('status',2);  
           else
               $c->setValor('status',4);
           
           $c->setValor('cid',$cid);
       }   
       else if($operacao == "cancelar_consultas")
           $c->setValor('status',3);
       else if($operacao == "alt_cancelar_consultas")
           $c->setValor('status',1);    
       else if($operacao == "alt_confirmar_consultas"){
           if($comp == 1)
                $c->setValor('status',2);  
           else 
               $c->setValor('status',4);             
           
           $c->setValor('cid',$cid);
       }
               
            
        if($operacao == "marc_consulta"){
            $c->inserir($c);   //echo"aqui";exit();
            $h = 1;//apenas de serve de marcador
        }  
        else {                    
            $c->valorpk = $cd_consulta;
            $c->atualiza($c);
            //header('Location: ./index.php?p=marc_consulta');
            $h = 1;//apenas de serve de marcador
        }
        
        if($c->linhasafetadas > 0){ 
            if($h == 1){
                if($operacao == "marc_consulta")
                    envia_email($cd_prontuario,$crm,$espec,$mes,$hora,$dt_cad,$hr_cad,$cd_acesso,0);          
                else if ($operacao == "alt_cad_consultas")
                    envia_email($cd_prontuario,$crm,$espec,$mes,$hora,$dt_cad,$hr_cad,$cd_acesso,$obs);
                echo "<script> a = confirm(\"Sua operação foi realizada com sucesso.\");
                if (a == true) { location.href = \"./index.php?p=marc_consulta\"; }
                else { location.href = \"./index.php?p=erro\"; } //esse esle não é usado em caso nenhum. so ta aki para mostrar
            </script>";}
            else
           header('Location: ./index.php?p=marc_consulta');            
            }
        else
           header("Location: ./index.php?p=erro");         
}// FIM DO MARC_CONSULTA

else if($operacao == "confirmar_consultas"){
        
        $cod   = $_POST["cd_consulta"];
        $comp  = $_POST["comp"];
        $cid   = $_POST["cid"];
        
        
                
        abreconexao();                 
                if($comp == 1)
                $sql = "UPDATE consultas SET status=2, cid='".$cid."' WHERE cd_consulta=".$cod;
                else
                $sql = "UPDATE consultas SET status=4 WHERE cd_consulta=".$cod;    
                $query = pg_query($sql);
                $cont = pg_affected_rows($query);
                fechaconexao();
                if($cont > 0){
                    $e     = $_POST["especialidade"];
                    $c     = $_POST["medico"];
                    $d     = inverteData($_POST["calendario"]);
                    echo "<script>alert(\"Operação realizada com sucesso\");</script>"  ;                    
                    header('Location: ./index.php?p=confirmar_consultas&especialidade='.$e.'&medico='.$c.'&calendario='.$d);
                }  
                else{
                    echo"Erro. Não foi possivel fazer essa alteração.";
                    echo "<p><br><a href=\"index.php?p=busca_alt_consultas&i=confirmar_consultas\">VOLTAR</a></p>";
                    exit();
                    header("Location: ./index.php?p=erro");
                }  
                   
}

 
else {
    echo "ESSE IF NÃO FAZ NADA";
}

?>
