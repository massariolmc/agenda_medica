
<?php
$cod = $_GET["cd"];
$espec = $_GET["l"];
$mes = $_GET["j"];
$ano = $_GET["k"];

$espec = strtoupper($espec);

require_once("classes/agenda.class.php");
$ag = new agenda();
$ag->extras_select = "WHERE crm=".$cod." AND especialidade='".$espec."' AND Extract('Month' FROM dt )=".$mes." AND Extract('Year' FROM dt )=".$ano." ORDER BY dt ASC"; ;
$ag->selecionaTudo($ag);
$res = $ag->retornaDados();
$cont = $ag->linhasafetadas; 
?>

<?php

require_once("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP


abreconexao();
$j=0;
for($i=0; $i<32;$i++){
    $sql = "Select dt,hr FROM agenda WHERE crm=".$res->crm." AND especialidade='".$espec."' AND Extract('Month' FROM dt )=".date('m',strtotime($res->dt))." AND Extract('Day' FROM dt )=".$i." ORDER BY dt ASC"; 
    $query = pg_query($sql);
    $cont = pg_affected_rows($query);
    if($cont > 0){
        while($tbl = pg_fetch_object($query)){
            $dia[$i][$j] = $tbl->hr;
            $j++;
        }
    }
    else
        $dia[$i][$j] = 0;
    
    $j=0;
}
fechaconexao();
//********************
//busca o nome do medico pelo CRM
abreconexao();

$sql = "Select nome_med FROM medico WHERE crm=".$res->crm;
$query = pg_query($sql);
$cont = pg_affected_rows($query);
if($cont > 0){
        while($tbl = pg_fetch_object($query)){
            $nome_med= $tbl->nome_med;            
        }
    }
fechaconexao();
?>  

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>IMPRIMR AGENDA MEDICA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>        
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/calendario.js"></script>      
        <script type="text/javascript" src="js/valida_cad_agenda.js"></script>        
           
   </head>
    <body>
        <div id="agenda"> 
             
        <form id="form_agenda" name="form_agenda" method="POST" action="index.php?p=processa">
            <input type="hidden" name="operacao"        value="alt_agenda">
            <input type="hidden" name="nome"            value="<?php echo $res->crm;?>">
            <input type="hidden" name="especialidade"   value="<?php echo $res->especialidade;?>">
            <input type="hidden" name="mes"             value="<?php echo date('m',strtotime($res->dt));?>">
            <input type="hidden" name="ano"             value="<?php echo date('Y',strtotime($res->dt));?>">
            <fieldset name="agenda">
                <legend>IMPRIMR AGENDA MEDICA</legend>
                                
                <label>NOME DO MEDICO:*</label>
                <input type="text" name="n" size="20" id="n"  value="<?php echo $res->crm."/".$nome_med; ?>" readonly>
                <br/><br/>
                        
                <label>ESPECIALIDADE:*</label>
                <input type="text" name="especialidade" size="20" id="especialidade"  value="<?php echo $res->especialidade; ?>" readonly>
                
                <br/><br/>
                
                <label>HORARIO REFERENTE AO MES:*</label>
                <input type="text" name="m" size="20" id="m"  value="<?php echo date('m',strtotime($res->dt))."/".date('Y',strtotime($res->dt)); ?>" readonly>
                <br/><br/>
                <?php
                
                $marc=0;
                            $j=0;
                            $k=0;
                            $mat = array();
                            $vesp = array();
                            $not = array();
                            $qtde1 = count($dia);                           
                            for($i=0; $i<32;$i++){                                
                              $qtde = 0;
                              $k=0;
                              $n=0;
                              $x=0;
                              unset($mat);//limpa array
                              unset($vesp);
                              unset($not);
                              for($j=0; $j<$qtde1;$j++){
                                if($dia[$i][$j] != 0){
                                    $marc=1;                                    
                                    if($dia[$i][$j] > "07:00:00" && $dia[$i][$j] < "13:00:00" ){
                                        $mat[$k] = $dia[$i][$j];  
                                        $k++;
                                    }
                                    else if($dia[$i][$j] >= "13:00:00" && $dia[$i][$j] < "18:00:00" ){
                                        $vesp[$n] = $dia[$i][$j];
                                        $n++;
                                    }
                                    else if($dia[$i][$j] >= "18:00:00" && $dia[$i][$j] < "22:10:00" ){
                                        $not[$x] = $dia[$i][$j];
                                        $x++;
                                    } 
                                    
                                 }//FIM DO IF  
                                    
                                }//FIM DO FOR COM J
                                if($marc == 1){
                                    echo "<hr>"; 
                                    $marc=0;                                    
                                    echo "Dia: ".$i;   
                                    echo"<a href='rel/imp/imp_agendamento.php?crm=".$cod."&espec=".$espec."&dia=".$i."&mes=".$mes."&ano=".$ano."&i=MAPA DE ATENDIMENTO AMBULATORIAL'><img src='icons/impressora.png' width='30' height='25'></a>";
                                    $cal[] = $i; 
                                    $qtde = count($mat);
                                    if($qtde > 0){
                                        echo"<BR>MATUTINO: <BR>";
                                         for($k=0; $k<$qtde;$k++){
                                             $data = new DateTime($mat[$k]);
                                             echo" / ".$data->format('H:i');
                                         }
                                    }
                                    echo"<br>";
                                    $qtde = 0;
                                    $qtde = count($vesp);
                                    if($qtde > 0){
                                        echo"<BR>VESPERTINO: <BR>";
                                         for($k=0; $k<$qtde;$k++){
                                             $data = new DateTime($vesp[$k]);
                                             echo" / ".$data->format('H:i');
                                         }
                                    }
                                    echo"<br>";
                                    $qtde = 0;
                                    $qtde = count($not);
                                    if($qtde > 0){
                                        echo"<BR>NOTURNO: <BR>";
                                         for($k=0; $k<$qtde;$k++){
                                             $data = new DateTime($not[$k]);
                                             echo" / ".$data->format('H:i');
                                         }
                                    } 
                                } 
                            }//FIM DO FOR COM I
                            echo "<hr>";
                 ?>                  
                <br/><br/>                             
                <?php
                reset($cal);
                foreach($cal as $v)          // CHECKBOX FOI POSSIVEL FAZER                      
                {
                    echo '<input type="hidden" name="dados[]" value="'.  $v .'" />';
                }
                ?>
                <?php
                    if($mes < date('m') && $ano <= date('Y')){//SE O MES ACABOU NÃO E POSSIVEL ALTERAR A AGENDA. ESSA É A FUNÇÃO DESSE IF
                        echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";                  
                    }
                    else{
                        echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";                            
                    }
                ?>
                
                
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
