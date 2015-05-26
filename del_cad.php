<?php require_once("valida_login.php");     valida_login();?>
<?php
//include("conecta.php");OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP
if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

$cd = $_GET["cd"];//CODIGO DO QUE QUER EXCLUIR
$i = $_GET["i"];//NOME DO QUER EXCLUIR
$j = $_GET["j"];//VARIAVEL APENAS PARA A ESPECIALIDADE e AGENDA
$k = $_GET["k"];//VARIALVE APENAS PARA AGENDA
$espec = $_GET["l"];//ESPECIALIDADE


function excluir($d,$op,$mes,$ano,$espec){    
    $marc = 0;    
    if(strcmp($op,"paciente") == 0){
        include_once("classes/paciente.class.php");
        $adj = new pacientes();                     
    }
    
    else if(strcmp($op,"medico") == 0){
        include_once("classes/medico.class.php");
        $adj = new medicos();
       
    }
    else if(strcmp($op,"usuarios") == 0){
        include_once("classes/usuarios.class.php");
        $adj = new usuarios();
        
    }
    else if(strcmp($op,"agenda") == 0){
        $var = array();
        include_once("classes/agenda.class.php");
        $adj = new agenda();        
    }
    else{        
        include_once("classes/especialidade.class.php");
        $adj = new especialidade();   
    }    
    
    if($op =="agenda"){
            $adj->selecionaTudo($adj);
            while ($res = $adj->retornaDados()) {
                if($res->crm == $d && $res->especialidade == $espec && date('m',strtotime($res->dt)) == $mes && date('Y',strtotime($res->dt)) == $ano){
                    $var[] = $res->cd_agenda;
                    $marc = 1;
                }
            }
    }
    
    if($marc == 1){
        $qtde = count($var);
        for($i=0; $i<$qtde;$i++){                    
            $adj->valorpk = $var[$i];    
            $adj->deletar($adj);                        
      }
    }
    else{
        $adj->valorpk = $d;    
        $adj->deletar($adj);
    }
    
   if($adj->linhasafetadas > 0){
        header('Location: ./index.php?p=busca&i='.$op);
   }
   else{
        header('Location: ./index.php?p=erro');
   }    
   
}//FIM DA FUNÇÃO EXIBE_DADOS()

function verifica_especialidade($d){

    abreconexao();
    $sql = "SELECT * FROM medico WHERE cd_especialidade='".$d."'";
    $query = pg_query($sql);
    
    $cont = pg_affected_rows($query); 
    
    if($cont > 0){
        while($tbl = pg_fetch_object($query)){
        echo "EXISTEM MEDICOS QUE POSSUEM ESTA ESPECIALIDADE: <br> NOME: ".$tbl->nome_med;
    }
        echo"<br><br>PARA EXCLUIR A ESPECILIADADE, ALTERE A ESPECIALIDADE DO MÉDICO QUE A POSSUI.";
        fechaconexao();
        
        exit();
    } 
}

function verifica_consultas($crm, $mes, $ano, $espec){// FINALIDADE DESSA FUNÇÃO, NÃO DEIXAR EXCLUIR UMA AGENDA, SE JA TIVER CONSULTA MARCADA.
abreconexao();
$sql = "SELECT * FROM consultas WHERE crm=".$crm." AND especialidade='".$espec."' AND Extract('Month' FROM dt_consulta )=".$mes." AND Extract('Year' FROM dt_consulta )=".$ano;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    echo "Não é possível excluir esta agenda. Este médico possui consultas agendadas neste mês.";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    fechaconexao(); 
    exit();    
}
fechaconexao();

}

function verifica_agenda($cd_med){// FINALIDADE DESSA FUNÇÃO, NÃO DEIXAR EXCLUIR UM MEDICO, SE JA TIVER AGENDA.

abreconexao();
$sql = "SELECT * FROM medico WHERE cd_med=".$cd_med;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
      $crm = $tbl->crm;
    }   
}
fechaconexao();
    
abreconexao();
$sql = "SELECT * FROM agenda WHERE crm=".$crm;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    echo "Não é possível excluir este médico. Este possui algum mês agendado.";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    fechaconexao(); 
    exit();    
}
fechaconexao(); 

}

function verifica_tipo_paciente($cd){
    abreconexao();
    $sql = "SELECT cd_consulta FROM paciente p,consultas c WHERE p.cd_paciente=".$cd." AND p.cd_prontuario=c.cd_prontuario";
    $query = pg_query($sql);
    $cont = pg_affected_rows($query); 
    if($cont > 0){
        echo "Não é possível excluir este paciente. Este já realizou alguma consulta.";
        echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
        fechaconexao(); 
        exit();    
    }
fechaconexao(); 
    
}

//CONDIÇÕES INICIAIS
if($i == "especialidade"){
    verifica_especialidade($j);
    excluir($cd,$i);
}

else{
    
    if($i == "medico" || $i == "agenda"){
    verifica_consultas($cd,$j,$k,$espec);
    verifica_agenda($cd);
    }    
    if($i == "paciente")
    verifica_tipo_paciente($cd);
    excluir($cd,$i,$j,$k,$espec);    
}
?>