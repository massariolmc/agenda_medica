<?php require_once("valida_login.php");     valida_login();?>
<?php 

$cal   = $_POST["dados"];//DIAS SELECIONADOS
$j=0;
$hora=array();
 for($i=0;$i<32;$i++){
     
     if(!empty($_POST["{$i}hora_i"]) && !empty($_POST["{$i}hora_f"])){
         $hora_i[$j] = $_POST["{$i}hora_i"];         
         $hora_f[$j] = $_POST["{$i}hora_f"];         
         $interv[$j] = $_POST["{$i}interv"];
         $j++;
     }     
}

   
//for($i=0;$i<count($cal);$i++){    
//      echo $hora_i[$i]."<br>";
//        echo $hora_f[$i]."<br>";
//        echo" intervalo ".$interv[$i]."<br>";       
    
//}
$cont_dias = array();
$cont=0;
for($i=0;$i<count($cal);$i++){    
  
$data = new DateTime($hora_i[$i]);//DEFINE O HORARIO
        $hora[$i][] = $data->format('H:i');
        $cont++;
        while($result < $hora_f[$i]){
            $data->add(new DateInterval( "PT{$interv[$i]}M" ));//SOMA HORARIO COM A QTDE DE MINUTOS QUE DESEJA
            $result = $data->format('H:i');//RESULTADO             
            $hora[$i][] = $data->format('H:i');// O $i É O DIA, O OUTRO É A HORA DO DIA           
            $cont++;
        }
        $cont_dias[] = $cont;//QTDE DE HORAS POR DIA 
        $cont=0;
        $result=0;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>AGENDA MEDICA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>        
        <script type="text/javascript" src="js/calendario.js"></script>      
        <script type="text/javascript" src="js/valida_cad_agenda.js"></script> 
        <script type="text/javascript" src="js/marcacheckbox.js"> </script>
                     
    </head>
    <body>
        <div id="agenda"> 
             
        <form id="form_agenda" name="form_agenda" method="POST" action="index.php?p=processa">
            <input type="hidden" name="operacao"        value="cad_agenda">
            <input type="hidden" name="nome"            value="<?php $nome = $_POST["nome"];echo $nome;?>">
            <input type="hidden" name="especialidade"   value="<?php $espec = $_POST["especialidade"];echo $espec;?>">
            <input type="hidden" name="mes"             value="<?php $mes   = $_POST["mes"];echo $mes;?>">
            
            <?php //$cal   = $_POST["cal"];// ESSA ROTINA É NECESSARIO, POIS NÃO E POSSVIEL PASSAR UM ARRAY VIA HIDDEN DIRETAMENTE, SO NO CASO DO     
            foreach($cal as $v)          // CHECKBOX FOI POSSIVEL FAZER                      
            {
             echo '<input type="hidden" name="dados[]" value="'.  $v .'" />';
            }?>
            
            <fieldset name="agenda">
                <legend>AGENDA DOS MEDICOS</legend>
                                
                <label id="agenda">HORARIO DE ATENDIMENTO:*</label>                
                <br><br>               
                <?php
                $crm = $_POST["nome"];
                $espec = $_POST["especialidade"];
                //$cal   = $_POST["cal"];
                $mes   = $_POST["mes"];
                
                require_once 'classes/medico.class.php';
                
                $medico = new medicos();
                $medico->selecionaTudo($medico);
                while ($res = $medico->retornaDados()) {
                    if($res->crm == $crm){
                        echo"HORARIO DO MEDICO(A): ".$res->nome_med."<br>";
                        break;// USEI ESSE BREAK PARA ASSIM QUE ACHAR O NOME SAIR DESSE WHILE, SENÃO VAI REPETIR NOME NO SELECT
                    }
                }                
                
                echo"ESPECIALIDADE: ".$espec."<br>";
                echo" HORARIO REFERENTE AO MÊS ".$mes."/".date("Y");
                echo "<br>";echo "<br>";
                
                echo"<a href='#' value = 'todos' id='selecionarTodos'>Selecionar todos</a><br>";
                echo"<a href='#'  id='Matutino'>Selecionar todos matutinos</a><br>";
                echo"<a href='#'  id='Vespertino'>Selecionar todos vespertinos</a><br>";
                echo"<a href='#'  id='Noturno'>Selecionar todos noturnos</a><br>";
                 
                 $m1 = 0;
                 $v1 = 0;
                 $n1 = 0;
                 
                echo "<br>";echo "<br>";
                       if (!empty($cal)) {                
                            $qtd = count($cal);$u = 5;
                            for ($i = 0; $i < $qtd; $i++) {
                                echo "Dia: ".$cal[$i];//imprime o item corrente
                                echo"<br>";
                                
                                for($k=0;$k<$cont_dias[$i];$k++){
                                              
                                    if(($hora[$i][$k] > "07:00") && ($hora[$i][$k] < "13:00")){
                                        if($m1 == 0){
                                            echo"<BR>MATUTINO: <BR>"; 
                                            echo"<input type='checkbox' class = 'mat' name='hora[]' value='".$cal[$i]."/".$hora[$i][$k]."'>".$hora[$i][$k];
                                            $m1 = 1;
                                        }
                                        else
                                        echo"<input type='checkbox' class = 'mat' name='hora[]' value='".$cal[$i]."/".$hora[$i][$k]."'>".$hora[$i][$k];                                       
                                      
                                    }
                                    if(($hora[$i][$k] >= "13:00") && ($hora[$i][$k] < "18:00")){
                                        if($v1 == 0){
                                            echo"<BR><br>VESPERTINO: <br>";
                                             echo"<input type='checkbox' class = 'ves' name='hora[]' value='".$cal[$i]."/".$hora[$i][$k]."'>".$hora[$i][$k];
                                            $v1 = 1;
                                        }
                                        else
                                        echo"<input type='checkbox' class = 'ves' name='hora[]' value='".$cal[$i]."/".$hora[$i][$k]."'>".$hora[$i][$k];
                              
                                    }
                                    
                                    if(($hora[$i][$k] >= "18:00") && ($hora[$i][$k] < "22:10")){;
                                        if($n1 == 0){
                                            echo"<BR><br>NOTURNO: <BR>";
                                            echo"<input type='checkbox' class = 'not' name='hora[]' value='".$cal[$i]."/".$hora[$i][$k]."'>".$hora[$i][$k];
                                            ;
                                            $n1 = 1;
                                        }  
                                        else
                                        echo"<input type='checkbox' class = 'not' name='hora[]' value='".$cal[$i]."/".$hora[$i][$k]."'>".$hora[$i][$k];
                            
                                    }
                                }                              
                                $m1 = 0;
                                $v1 = 0;
                                $n1 = 0;
                                echo "<HR>";                                
                                 
                            }
                       }   
                       echo "<br>";echo "<br>";
                ?> 
                                                
                <input type="submit" value="ENVIAR" class="botaoForm">
                <input type="reset" value="LIMPAR" class="botaoForm">
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
