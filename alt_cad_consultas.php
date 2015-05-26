<?php require_once("valida_login.php");     valida_login();?>
<?php
if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

$prontuario = $_POST["prontuario"];
$espec      = $_POST["especialidade"];
$crm        = $_POST["medico"];
$dt_atual   = $_POST["calendario"];//DATA ATUAL DA CONSULTA
$mes_r      = $_POST["mes"];//MES QUE DESEJA REMARCAR A CONSULTA
$dia_r      = $_POST["cal"];//DIA QUE DESEJA REMARCAR A CONSULTA

$d = $dia_r."/".$mes_r."/".date('Y');
$data = date("m");
if($mes_r <= $data && $dia_r < date('d')){// nÃO SERA POSSIVEL TROCAR A CONSULTA SE ELA JÁ PASSOU.
    echo"ESTE DIA NÃO ESTA MAIS DISPONÍVEL PARA MARCAR CONSULTAS.";
    echo "<p><br><a href='./index.php?p=marc_consulta'>VOLTAR</a></p>";
    exit();
}
if(empty($dia_r)){
    echo"SELECIONE OS DIAS PARA AGENDAMENTO DESTE MÊS.";
    echo "<p><br><a href='./index.php?p=marc_consulta'>VOLTAR</a></p>";
    exit();
}
if($dt_atual < date("d/m/Y")){
    echo"NÃO E POSSIVEL ALTERAR ESTA CONSULTA. A DATA ATUAL É MAIOR QUE DA CONSULTA.";
    echo "<p><br><a href='./index.php?p=busca_alt_consultas&i=alt_cad_consultas'>VOLTAR</a></p>";
    exit();
}
require_once("classes/consultas.class.php");
$cont = 0;               
        $co = new consultas();
        $co->extras_select = "WHERE cd_prontuario=".$prontuario." AND crm=".$crm." AND especialidade='".$espec."' AND Extract('Day' FROM dt_consulta )=".$dia_r." AND Extract('Month' FROM dt_consulta )=".$mes_r." AND Extract('Year' FROM dt_consulta )=".date("Y");
        $co->selecionaTudo($co);
        $res = $co->retornaDados();
        $cont = $co->linhasafetadas;        
        //$obs_aux = $res->obs;
        //echo"obs1".$obs_aux."dia".$dia;exit();
            if($cont > 0){
                echo"Este paciente já possui agendamento com esse médico neste dia.";                
                echo "<p><br><a href=\"index.php?p=busca_alt_consultas&i=alt_cad_consultas\" >VOLTAR</a></p>";               
                exit();
            }

//***********************************LOCALIZA O COD DA CONSULTA PARA REMARCAR A CONSULTA
$dia = substr($dt_atual,0,2);
$mes = substr($dt_atual,3,2);
$ano = substr($dt_atual,-4);


$c = new consultas();
$c->extras_select = "WHERE status=1 AND cd_prontuario=".$prontuario." AND crm=".$crm." AND especialidade='".$espec."' AND Extract('Day' FROM dt_consulta )=".$dia." AND Extract('Month' FROM dt_consulta )=".$mes." AND Extract('Year' FROM dt_consulta )=".$ano;
$c->selecionaTudo($c);
$cont = $c->linhasafetadas;

if($cont <= 0){
    echo"A data da consulta atual não existe ou essa consulta já foi realizada ou cancelada.";
    echo "<p><br><a href='./index.php?p=marc_consulta'>VOLTAR</a></p>";
    exit();
}
else{
  
    while ($res = $c->retornaDados()) {
        $cd_consulta = $res->cd_consulta; 
        $obs_aux = $res->obs;
    }
}

//***********************************VERIFICA O NOME DO PACIENTE
 abreconexao();
$sql = "SELECT nome_paciente FROM paciente WHERE cd_prontuario=".$prontuario;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
      $nome_paciente = $tbl->nome_paciente;
    }
}
fechaconexao();        

 //***********************************VERIFICA O NOME DO MEdico        
abreconexao();
$sql = "SELECT nome_med FROM medico WHERE crm=".$crm;
$query = pg_query($sql);
$cont = pg_affected_rows($query); 
if($cont > 0){
    while($tbl = pg_fetch_object($query)){
      $nome_med = $tbl->nome_med;
   }
}
fechaconexao();  

//***********************************VERIFICA O AGENDAMENTO DO MEDICO
abreconexao();
$sql = "SELECT * FROM agenda WHERE crm=".$crm." AND especialidade='".$espec."' AND Extract('Day' FROM dt )=".$dia_r." AND Extract('Month' FROM dt )=".$mes_r." AND Extract('Year' FROM dt )=".date('Y');
$query = pg_query($sql);
$cont = pg_affected_rows($query);

if($cont > 0){
    while($tbl = pg_fetch_object($query)){
         $array[] = $tbl->hr;
        }
    }



//***********************************VERIFICA SE TEM HORA MARCADA
abreconexao();
$hr = array();
$marc_hr = -1;
$sql = "SELECT hr_consulta FROM consultas WHERE crm=".$crm." AND especialidade='".$espec."' AND dt_consulta='".date('Y')."/".$mes_r."/".$dia_r."'";
$query = pg_query($sql);
        
if(pg_num_rows($query) == 0){
     $marc_hr = -1;
}   
else{
    while($tbl = pg_fetch_object($query)){
        $hr[] = $tbl->hr_consulta;
        $marc_hr = 1;
    } 
}

fechaconexao();    


?>  

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ALTERAR CONSULTA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>        
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>            
        <script type="text/javascript" src="js/valida_cad_agenda.js"></script> 
        <script type="text/javascript" src="js/ajax.js"></script>
          
   </head>
    <body>
        <div id="alt_cad_consulta"> 
             
        <form id="form_alt_consulta" name="form_alt_consulta" method="POST" action="index.php?p=processa">
            <input type="hidden" name="operacao"        value="alt_cad_consultas">
            <input type="hidden" name="cd_consulta"     value="<?php echo $cd_consulta;?>">
            <input type="hidden" name="prontuario"      value="<?php echo $prontuario;?>">
            <input type="hidden" name="especialidade"   value="<?php echo $espec;?>">
            <input type="hidden" name="crm"             value="<?php echo $crm;?>">
            <input type="hidden" name="mesn"             value="<?php echo $mes;?>">
            <input type="hidden" name="obs_aux"         value="<?php echo $obs_aux;?>">
            
           
            <fieldset name="agenda">
                <legend>ALTERAR CONSULTA</legend>
                                
                <label>PACIENTE:*</label>
                <input type="text" name="n" size="20" id="n"  value="<?php echo $nome_paciente; ?>" readonly>
                <br/><br/>
                <label>MEDICO:*</label>
                <input type="text" name="n" size="20" id="n"  value="<?php echo $nome_med; ?>" readonly>
                <br/><br/>
                        
                <label>ESPECIALIDADE:*</label>
                <input type="text" name="especialidad" size="20" id="especialidad"  value="<?php echo $espec; ?>" readonly>
                
                <br/><br/>
                
                <label>DATA DA CONSULTA:*</label>
                <input type="text" name="mes" size="20" id="mes"  value="<?php echo $dia_r."/".$mes_r."/".date("Y"); ?>" readonly>
                <br/><br/>  
                <label>ESCOLHA O HORARIO:</label>
                <br/>
                <?php
              
                $mat = array();
                $vesp = array();
                $marc = 0;
                $k=0;
                $n=0;
                $cont_aux = 0;
                $qtde = count($array);
                for($j=0; $j<$qtde;$j++){
                    if(!empty($array[$j])){
                       $marc=1;   
                       $cont_aux = 0;
                       if($array[$j] > "07:00:00" && $array[$j] <= "13:00:00"){
                            if($marc_hr == -1)
                                $cont_aux = 0;
                            
                            else{
                                for($z=0; $z < count($hr); $z++){
                                    if($hr[$z] == $array[$j])
                                        $cont_aux = 1;                                    
                                }                                
                            
                            }
                            if($cont_aux == 0){
                                $mat[$k] = $array[$j];  
                                $k++;
                            }
                       }
                       else if($array[$j] > "13:00:00" && $array[$j] <= "17:50:00"){
                           if($marc_hr == -1)
                                $cont_aux = 0;
                            
                            else{
                                for($z=0; $z < count($hr); $z++){
                                    if($hr[$z] == $array[$j])
                                       $cont_aux = 1;                                    
                                }                                
                            
                            }
                            if($cont_aux == 0){
                                $vesp[$n] = $array[$j];
                                $n++;
                            }
                       }
                       
                       else if($array[$j] > "17:50:00" && $array[$j] <= "22:10:00"){
                           if($marc_hr == -1)
                                $cont_aux = 0;
                            
                            else{
                                for($z=0; $z < count($hr); $z++){
                                    if($hr[$z] == $array[$j])
                                       $cont_aux = 1;                                    
                                }                                
                            
                            }
                            if($cont_aux == 0){
                                $not[$x] = $array[$j];
                                $x++;
                            }
                       }
                                    
                   }//FIM DO IF (!empty($array[$j])) 
                                   
               }//FIM DO FOR COM J
               if($marc == 1){
                  echo "<hr>"; 
                  $marc=0; $u=5;                                                      
                  $qtde = count($mat);
                  if($qtde > 0){
                     echo"<BR>MATUTINO: <BR>";
                     for($k=0; $k<$qtde;$k++){
                         if($k == $u){
                             $u += 5; 
                            echo"<br>";                            
                         }
                       echo"<input type='radio' class = 'mat' name='hora' value='".$mat[$k]."'>".$mat[$k];
                     }
                  }
                  $qtde = 0;$u=5;
                  $qtde = count($vesp);
                  if($qtde > 0){
                    echo"<BR><BR>VESPERTINO: <BR>";
                    for($k=0; $k<$qtde;$k++){
                        if($k == $u){
                             $u += 5; 
                            echo"<br>";                            
                         }
                      echo"<input type='radio' class = 'ves' name='hora' value='".$vesp[$k]."'>".$vesp[$k];
                    }
                 }
                 
                 $qtde = 0;
                  $qtde = count($not);
                  if($qtde > 0){
                    echo"<BR><BR>NOTURNO: <BR>";
                    for($k=0; $k<$qtde;$k++){
                        if($k == $u){
                             $u += 5; 
                            echo"<br>";                            
                         }
                      echo"<input type='radio' class = 'not' name='hora' value='".$not[$k]."'>".$not[$k];
                    }
                 }
                 
                 } 
                
                 echo "<hr>";           
                
                
                ?>
                <br/><br/>
                <label>OBSERVAÇÃO:</label>
                <textarea name="obs" rows="5" id="obs"  cols="42" placeholder="Colocar aqui o motivo da alteração..."></textarea>
                <br/><br/> 
                
                
                <input type="submit" value="ALTERAR" class="botaoForm">                     
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
