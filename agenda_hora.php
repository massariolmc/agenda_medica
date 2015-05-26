<?php require_once("valida_login.php");     valida_login();?>
<?php
include("verifica_agendamento.php");

// TESTE SE O USUARIO SELECIONOU OS DIAS, CASO ELE TEM QUE VOLTAR E SELECIONAR.
$cal   = $_POST["cal"];
if(empty($cal)){
    echo"SELECIONE OS DIAS PARA AGENDAMENTO DESTE MÊS.";
    echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
    exit();
}
else{
$nome = $_POST["nome"];//AQUI É O CRM
$mes   = $_POST["mes"];
$espec   = $_POST["especialidade"];

verifica($nome,$cal,$mes,$espec);
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
        <script type="text/javascript" src="js/horario_padrao_agenda.js"></script>   


    </head>
    <body>
        <div id="agenda"> 
             
        <form id="form_agenda" name="form_agenda" method="POST" action="index.php?p=agenda_hora_confirma" >
            
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
                /*
                echo"<a href='#' value = 'todos' id='selecionarTodos'>Selecionar todos</a><br>";
                echo"<a href='#'  id='Matutino'>Selecionar todos matutinos</a><br>";
                echo"<a href='#'  id='Vespertino'>Selecionar todos vespertinos</a><br>";
                 */ 
                 
                 
                echo "<br>";echo "<br>";
                       if (!empty($cal)) {                
                            $qtd = count($cal);
                            for ($i = 0; $i < $qtd; $i++) {
                                echo "Dia: ".$cal[$i];//imprime o item corrente
                                echo"&nbsp;<input type='button' name='hora_padrao' value='07h:20m as 11h:20m' onclick='insereTexto(".$cal[$i].")'; >";                                
                                echo"<br>";
                                echo"<label>Início do Atendimento</label>";
                                echo"<br>";
                                echo"<input type='text' class='hora_ag'  name='".$cal[$i]."hora_i' size='2' id='".$cal[$i]."hora_i'>hh:mm"; 
                                echo"<br><br>";                                
                                echo"<label>Fim do Atendimento</label>";
                                echo"<br>";
                                echo"<input type='text' class='hora_ag' name='".$cal[$i]."hora_f' size='2' id='".$cal[$i]."hora_f'>hh:mm";
                                echo"<br><br>";
                                echo"<label>Intervalo em minutos</label>";
                                echo"<br>";
                                echo"<input type='text' class='hora_ag' name='".$cal[$i]."interv' size='2' id='".$cal[$i]."interv'>min";
                                echo"<br><br>";
                                echo"<hr>";
                               
                                echo"<br>";
                                
                            }
                       }   
                
                ?> 
                                                
                
                <input type="submit" id="enviar" value="ENVIAR" class="botaoForm" >
                <input type="reset" value="LIMPAR" class="botaoForm">
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
