<?php
include("trocahora.php");
$dia     = $_POST["cal"];
if(empty($dia)){
    echo"SELECIONE OS DIAS PARA AGENDAMENTO DESTE MÊS.";
    echo "<p><br><a href=\"index.php?p=marc_consulta\" >VOLTAR</a></p>";
    exit();
}

if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

$mes    = $_POST["mes"];
$espec  = $_POST["especialidade"];
$crm    = $_POST["medico"];

$data = date("m");
if($mes <= $data && $dia < date('d')){
    echo"NÃO É POSSIVEL MARCAR A CONSULTA. ESTE DIA NÃO ESTA MAIS DISPONIVEL.";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    exit();
}



//***********************************VERIFICA O NOME DO MEDICO
abreconexao();
$sql = "SELECT nome_med FROM medico WHERE crm=".$crm;
$query = pg_query($sql);
        
if(pg_num_rows($query) == 0){
    echo  'Nao existe medico';
}
                    
else{
    while($tbl = pg_fetch_object($query)){
        $nome = $tbl->nome_med;
    }                     
}
fechaconexao();
//*********************************** VERIFICA O AGENDAMENTO DO MEDICO
include_once 'classes/agenda.class.php';
$ag = new agenda();
$ag->extras_select = "WHERE crm=".$crm." AND especialidade='".$espec."' AND Extract('Day' FROM dt )=".$dia."AND Extract('Month' FROM dt )=".$mes." AND Extract('Year' FROM dt )=".date('Y');
$ag->selecionaTudo($ag);
$cont = 0;
$cont = $ag->linhasafetadas;

    if($cont > 0){
        while($res = $ag->retornaDados()){
            $array[] = $res->hr;
        }
    }

//***********************************VERIFICA SE TEM HORA MARCADA
abreconexao();
$hr = array();
$marc_hr = -1;
$sql = "SELECT hr_consulta FROM consultas WHERE status=1 AND crm=".$crm." AND especialidade='".$espec."' AND dt_consulta='".date('Y')."/".$mes."/".$dia."'";
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

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>AGENDAR CONSULTA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>               
        <script type="text/javascript" src="js/valida_marc_hora.js"></script>
        
               
    </head>
    <body onload="document.form_marc_hora.prontuario.focus();">
        
        <div id="marc_hora"> 
             
        <form id="form_marc_hora" name="form_marc_hora" method="POST" action="index.php?p=processa">
            <input type="hidden" name="operacao"        value="marc_consulta">
            <input type="hidden" name="crm"             value="<?php echo $crm;?>">   
            <input type="hidden" name="dia"             value="<?php echo $dia;?>">
            <input type="hidden" name="mesn"            value="<?php echo $mes;?>">
            <input type="hidden" name="especialidade"   value="<?php echo $espec;?>">
            
            
            <fieldset name="incluir">
                <legend>AGENDAR CONSULTA</legend>
                <p>INSERA OS DADOS:</p>                
                
                <label>PRONTUARIO:*</label>
                <input type="text" name="prontuario" size="20" id="prontuario" maxlength="5" placeholder="Insera seu Prontuario..." >                
                <br/><br>
                
                <label>ESPECIALIDADE:</label>
                <input type="text" name="espec" size="20" id="espec"  value="<?php echo $espec;?>" readonly>
                <br/><br>                
                
                <label>MEDICO:</label>
                <input type="text" name="medico" size="20" id="medico"  value="<?php echo $nome; ?>" readonly>
                <br/><br>
                
                <label>DATA DA CONSULTA:</label>
                <input type="text" name="mes" size="20" id="mes"  value="<?php echo $dia."/".$mes."/".date("Y"); ?>" readonly>
                <br/><br/>  
                <label>ESCOLHA O HORARIO:</label>
                <br/>
                <?php
                $mat = array();
                $vesp = array();
                $not = array();
                $marc = 0;
                $k=0;
                $n=0;
                $x=0;
                $cont_aux = 0;
                $qtde = count($array);
                for($j=0; $j<$qtde;$j++){
                    if(!empty($array[$j])){
                       $marc=1;   
                       $cont_aux = 0;
                       if(trocahora($array[$j]) > trocahora("07:00:00") && trocahora($array[$j]) <= trocahora("13:00:00")){//FUNÇÃO TROCA É PARA TRANSFORMAR O HORARIO EM NUMERO PARA PODER COMPARAR
                            if($marc_hr == -1)
                                $cont_aux = 0;
                            
                            else{
                                for($z=0; $z < count($hr); $z++){
                                    //echo "<br>hora marcada: ".trocahora($hr[$z]);
                                    //echo "<br>horas: ".trocahora($array[$j]);
                                    if(trocahora($hr[$z]) == trocahora($array[$j])){
                                        $cont_aux = 1;
                                    }
                                }                                
                            
                            }
                            if($cont_aux == 0){
                                $mat[$k] = $array[$j];  
                                $k++;
                            }
                       }
                       else if(trocahora($array[$j]) > trocahora("13:00:00") && trocahora($array[$j]) <= trocahora("17:50:00")){
                           if($marc_hr == -1)
                                $cont_aux = 0;
                            
                            else{
                                for($z=0; $z < count($hr); $z++){
                                    if(trocahora($hr[$z]) == trocahora($array[$j]))
                                       $cont_aux = 1;                                    
                                }                                
                            
                            }
                            if($cont_aux == 0){
                                $vesp[$n] = $array[$j];
                                $n++;
                            }
                       }
                       else if(trocahora($array[$j]) > trocahora("17:50:00") && trocahora($array[$j]) <= trocahora("22:10:00")){
                           if($marc_hr == -1)
                                $cont_aux = 0;
                            
                            else{
                                for($z=0; $z < count($hr); $z++){
                                    if(trocahora($hr[$z]) == trocahora($array[$j]))
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
                  
                  if(count($mat) <= 0 && count($vesp) <= 0 && count($not) <= 0)
                      echo"Todos os horários já foram agendados.";
                  
                  $fora = 0;
                  $marc=0;                                                       
                  $qtde = count($mat);
                  if($qtde > 0){
                     echo"<BR>MATUTINO: <BR>";
                     for($k=0; $k<$qtde;$k++){
                      $tempo = strtotime(date("H:i:s"));
                       $tempo_aux = strtotime($mat[$k]);
                       $tempo_m = date("m");                            
                       
                      if($mes > $tempo_m){//SE O HORARIO FOR MAIOR QUE O DISPONIVEL NÃO PODE MARCAR CONSULTA 
                          $data = new DateTime($mat[$k]);
                          echo"<input type='radio' class = 'mat' name='hora' value='".$mat[$k]."'>".$data->format('H:i');
                          $fora = 1;
                      }
                      else{
                          if(($mes == $tempo_m && $dia > date("d"))){
                              $data = new DateTime($mat[$k]);
                            echo"<input type='radio' class = 'mat' name='hora' value='".$mat[$k]."'>".$data->format('H:i');
                          }
                          else if ($mes == $tempo_m && $dia == date("d") && $tempo_aux > $tempo){
                              $data = new DateTime($mat[$k]);
                            echo"<input type='radio' class = 'mat' name='hora' value='".$mat[$k]."'>".$data->format('H:i');
                            $fora = 1;
                          }
                     }
                    }
                  }  
                  $qtde = 0;
                  $qtde = count($vesp);
                  if($qtde > 0){
                    echo"<BR><BR>VESPERTINO: <BR>";
                    for($k=0; $k<$qtde;$k++){
                       $tempo = strtotime(date("H:i:s"));
                       $tempo_aux = strtotime($vesp[$k]);
                       $tempo_m = date("m");                            
                       
                      if($mes > $tempo_m){//SE O HORARIO FOR MAIOR QUE O DISPONIVEL NÃO PODE MARCAR CONSULTA 
                          $data = new DateTime($vesp[$k]);
                        echo"<input type='radio' class = 'ves' name='hora' value='".$vesp[$k]."'>".$data->format('H:i');
                        $fora = 1;                      
                      }
                      else{
                          if(($mes == $tempo_m && $dia > date("d"))){
                              $data = new DateTime($vesp[$k]);
                              echo"<input type='radio' class = 'ves' name='hora' value='".$vesp[$k]."'>".$data->format('H:i');
                              $fora = 1;
                          }
                          
                          else if ($mes == $tempo_m && $dia == date("d") && $tempo_aux > $tempo){
                              $data = new DateTime($vesp[$k]);
                             echo"<input type='radio' class = 'ves' name='hora' value='".$vesp[$k]."'>".$data->format('H:i');
                             $fora = 1;
                          }
                          
                      }//FIM DO ELSE
                    }//FIM DO FOR
                 }// FIM DO IF QTDE
                 
                 $qtde = 0;
                  $qtde = count($not);
                  if($qtde > 0){
                    echo"<BR><BR>NOTURNO: <BR>";
                    for($k=0; $k<$qtde;$k++){
                       $tempo = strtotime(date("H:i:s"));
                       $tempo_aux = strtotime($not[$k]);
                       $tempo_m = date("m");                            
                       
                      if($mes > $tempo_m){//SE O HORARIO FOR MAIOR QUE O DISPONIVEL NÃO PODE MARCAR CONSULTA 
                          $data = new DateTime($not[$k]);
                        echo"<input type='radio' class = 'not' name='hora' value='".$not[$k]."'>".$data->format('H:i');
                        $fora = 1;                      
                      }
                      else{
                          if(($mes == $tempo_m && $dia > date("d"))){
                              $data = new DateTime($not[$k]);
                              echo"<input type='radio' class = 'not' name='hora' value='".$not[$k]."'>".$data->format('H:i');
                              $fora = 1;
                          }
                          
                          else if ($mes == $tempo_m && $dia == date("d") && $tempo_aux > $tempo){
                              $data = new DateTime($not[$k]);
                             echo"<input type='radio' class = 'not' name='hora' value='".$not[$k]."'>".$data->format('H:i');
                             $fora = 1;
                          }
                          
                      }//FIM DO ELSE
                    }//FIM DO FOR
                 }// FIM DO IF QTDE                                    
                 
                  if ($fora == 0 && count($mat) > 0 && count($vesp) > 0)
                      echo"<table><tr bgcolor='#FF0000'><td>Neste horário não é possivel marcar consulta.</td></tr></table>";
                  }
                 echo "<hr>";           
                
                
                ?>
                <br/><br/>
                <?php
                if(!(count($mat) <= 0 && count($vesp) <= 0 && count($not) <= 0) && !($fora == 0 && count($mat) > 0 && count($vesp) > 0 && count($not) > 0))
                echo"<input type='submit' value='CONFIRMAR' class='botaoForm'>";
                ?>           
            </fieldset>
            
        </form>       
        </div>
        
    </body>
</html>
