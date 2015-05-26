<?php require_once("valida_login.php");     valida_login();?>
<?php
include("calendario.php"); 
include_once 'classes/medico.class.php';
$medico = new medicos();
$medico->extras_select = "WHERE situacao=1 ORDER BY nome_med ASC";
$medico->selecionaTudo($medico);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CADASTRAR AGENDA MEDICA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>        
        <script type="text/javascript" src="js/calendario.js"></script>      
        <script type="text/javascript" src="js/valida_cad_agenda.js"></script> 
        <script type="text/javascript" src="js/ajax.js"></script>
        <script type="text/javascript" src="js/marcacheckbox.js"> </script>
        
    
    <script type="text/javascript">//SCRIPT QUE FAZ COMBOBOX
    $(document).ready(function(){
        $("select[name=nome]").change(function(){
            $("select[name=especialidade]").html('<option value="0">Carregando...</option>');
            $.post("lista_especialidade.php",
                  {estado:$(this).val()},
                  function(valor){
                     $("select[name=especialidade]").html(valor);
                  }
                  )
             });
    });
    </script> 
       
    </head>
    <body>
        <div id="agenda"> 
             
        <form id="form_agenda" name="form_agenda" method="POST" action="index.php?p=agenda_hora">
            <!--<input type="hidden" name="operacao" value="cad_agenda">-->
            <fieldset name="agenda">
                <legend>AGENDA DOS MEDICOS</legend>
                                
                <label>NOME DO MEDICO:*</label>                
                <select name="nome" id="nome">
                <option value="" selected="selected">SELECIONAR</option>             
                <?php
                //TODO ESSE ALGORITMO E PARA NÃO REPETIR NOMES NA HORA DE MOSTRAR NO SELECT
                $array = array();
                $aux2 = array();
                $arraynome = array();
                    while ($res = $medico->retornaDados()) {
                              $array[] = $res->crm;
                              $arraynome[] = $res->nome_med;
                    }
                              $aux = 0;
                              $marc = 0;
                              $qtde = count($array);                              
                              for($i=0; $i<$qtde; $i++){
                                  $aux2[] = $array[$i];
                                  if($aux == 0){
                                      echo "<option value='".$array[$i]."'>".$arraynome[$i]."</option>";
                                       $aux = 1;
                                  }
                                  else{
                                      $qtde2 = count($aux2)-1;                                      
                                      for($j=0; $j<$qtde2;$j++){
                                         if($array[$i] == $aux2[$j]){
                                            $marc = 1;
                                        }                                      
                                      }
                                      if($marc == 0){
                                          echo "<option value='".$array[$i]."'>".$arraynome[$i]."</option>";                                        
                                      }
                                      $marc = 0;
                                  }
                              }                
                ?>  
                </select>
                <br/><br/>
                        
                <label>ESPECIALIDADE:*</label>
                <select name="especialidade" id="especialidade">                    
                    <option value="" selected="selected">SELECIONAR</option>
                    
                </select>
                <br/><br/>
                
                <label>MES:*</label>
                <select name="mes" id="mes" onchange="getDados('calendario');">
                    <option value="" selected="selected">SELECIONAR</option>
                    <option value="01">JANEIRO</option>
                    <option value="02">FEVEREIRO</option>
                    <option value="03">MARÇO</option>
                    <option value="04">ABRIL</option>
                    <option value="05">MAIO</option>
                    <option value="06">JUNHO</option>
                    <option value="07">JULHO</option>
                    <option value="08">AGOSTO</option>
                    <option value="09">SETEMBRO</option>
                    <option value="10">OUTUBRO</option>
                    <option value="11">NOVEMBRO</option>
                    <option value="12">DEZEMBRO</option>
                </select>
                <br/><br/>
                
                <label>CALENDARIO:</label><br>
                
                <div id="Resultado"></div>
                 <a href="#" id="selecionarTodos">Selecionar todos.</a>                   
                <br/><br/>                             
                
                <input type="submit" value="ENVIAR" class="botaoForm">
                <input type="reset" value="LIMPAR" class="botaoForm">
                
                
            </fieldset>
            
        </form>
          </div>
        
    </body>
</html>
