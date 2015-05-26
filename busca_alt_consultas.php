<?php
$i = $_GET["i"];

include_once 'classes/especialidade.class.php';
$esp = new especialidade();
$esp->extras_select = "ORDER BY especialidade ASC";
$esp->selecionaTudo($esp);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BUSCA</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />          
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>         
        <script type="text/javascript" src="js/calendario.js"></script> 
        <script type="text/javascript" src="js/jquery.validate.js"></script>               
        <script type="text/javascript" src="js/valida_marc_consulta.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>
        
        <script type="text/javascript">//SCRIPT QUE FAZ COMBOBOX
    $(document).ready(function(){
        $("select[name=especialidade]").change(function(){
            $("select[name=medico]").html('<option value="0">Carregando...</option>');
            $.post("lista_medico.php",
                  {estado:$(this).val()},
                  function(valor){
                     $("select[id=medico]").html(valor);
                  }
                  )
             });
    });
    </script>
        
    </head>
    <body>
        <div id="busca">
            
       <form id="form_marc_consulta" name="form_marc_consulta" method="POST" action="<?php if($i == "alt_cad_consultas")echo "index.php?p=alt_cad_consultas"; else if ($i == "cancelar_consultas") echo"index.php?p=cancelar_consultas"; else if ($i == "alt_cancelar_consultas") echo"index.php?p=alt_cancelar_consultas"; else if ($i == "alt_confirmar_consultas") echo"index.php?p=alt_confirmar_consultas";else echo"index.php?p=confirmar_consultas"; ?>">
            <fieldset name="incluir">
                <legend><?php if($i == "alt_cad_consultas")echo "ALTERAR "; else if($i == "cancelar_consultas") echo"CANCELAR ";else if($i == "alt_cancelar_consultas") echo"ALTERAR CANCELAR "; else if($i == "alt_confirmar_consultas") echo"ALTERAR CONFIRMAR ";else echo"CONFIRMAR ";?>CONSULTA</legend>
                <p>INSERA OS DADOS:</p>           
                <?php if($i == "alt_cad_consultas" || $i == "cancelar_consultas" || $i == "alt_cancelar_consultas" || $i == "alt_confirmar_consultas"){ 
                echo"<label>DIGITE O PRONTUARIO*:</label>";                                            
                echo"<input type='text' name='prontuario' size='20' id='prontuario' maxlength='5' onkeypress=\"if(event.keyCode == 13) getDados('busca');\" placeholder='Digite o prontuario...'>";
                echo"<br/><br>";
                }
                ?>        
                
                <label>ESPECIALIDADE:*</label>
                <select name="especialidade" id="especialidade">
                    <option value="" selected="selected">SELECIONAR</option>
                    <?php   while($res = $esp->retornaDados()){
                                echo "<option value='".$res->especialidade."'>".$res->especialidade."</option>";                   
                            }                   
                    ?>
                </select><br/><br>
                
                
                <label>SELECIONA O MEDICO:*</label>
                <select name="medico" id="medico">
                    <option value="" selected="selected">SELECIONAR</option>                    
                    
                </select>
                <br/><br>       
                <?php
                if($i == "alt_cad_consultas"){
                   echo"
                       <label>DATA DA CONSULTA:</label>                                            
                        <input type='text' name='calendario' size='7' id='calendario'>
                        <br><br>
                
                        <label>REMARCAR - SELECIONE O MES:*</label>
                        <select name='mes' id='mes' onchange=\"getDados('verifica_calendario');\"> 
                        <option value='' selected='selected'>SELECIONAR</option>
                        <option value='01'>JANEIRO</option>
                        <option value='02'>FEVEREIRO</option>
                        <option value='03'>MARÇO</option>
                        <option value='04'>ABRIL</option>
                        <option value='05'>MAIO</option>
                        <option value='06'>JUNHO</option>
                        <option value='07'>JULHO</option>
                        <option value='08'>AGOSTO</option>
                        <option value='09'>SETEMBRO</option>
                        <option value='10'>OUTUBRO</option>
                        <option value='11'>NOVEMBRO</option>
                        <option value='12'>DEZEMBRO</option>
                        </select>
                        <br/><br/>
                
                        <div id='Resultado'></div>
                        <br/><br/>
                        <input type='submit' value='ENVIAR' class='botaoForm'>                
                        <br/><br/>
                    ";                    
                }
                else{
                   echo"<label>DATA DA CONSULTA:</label>                                            
                     <input type='text' name='calendario' size='7' id='calendario'>                       
                     <br/><br/>
                     <input type='submit' value='ENVIAR' class='botaoForm'>
                     <br/><br/>
                 ";}               
                
                ?>                          
            </fieldset>
            
        </form>
          </div>              
               
    </body>
</html>


