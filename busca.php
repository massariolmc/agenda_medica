<?php
$i = $_GET["i"];//IDENTIFICA QUAL BUSCA VAI FAZER EX:PACIENTE,MEDICO,USUARIO OU ESPECIALIDADE

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
        <script type="text/javascript" src="j10750s/jquery.validate.js"></script>               
        <script type="text/javascript" src="js/valida_busca.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>          
        
    </head>
    <body>
        
        <div id="busca">
                 
          <input type="hidden" name="op" id="op" value="<?php echo $i;?>"> <!-- INFORMA QUE TIPO DE BUSCA VAI REALIZAR -->  
          <label>BUSCA INFORMAÇÕES: <?php echo strtoupper($i);?>S</label><br><br>
          <fieldset>  
           <?php
                if(empty($login) && $i == "paciente" )//busca, todos os pacientes
                    echo "<legend>DIGITE O PRONTUARIO:</legend>";
                else if (!empty($login) && $i == "paciente" )
                    echo "<legend>DIGITE PARTE DO NOME OU PRONTUARIO:</legend>";
                
                else if($i == "agenda" || $i == "medico"){//busca todos os medicos e as agendas dos medicos
                    echo "<legend>DIGITE PARTE DO NOME DO MEDICO OU CRM:</legend>";
                }
                else if($i == "consultas")//esses consultas é da marcação das consultas, é consultar as marcações existentes
                    echo "<legend>DIGITE O PRONTUARIO:</legend>";       //altera todas as consultas tbm
                else
                    echo "<legend>DIGITE PARTE DO NOME:</legend>";                        
                ?>
              
              <label></label>
                <?php if(!empty($login) ) echo"<input type='text' name='env_nome' size='20' id='env_nome' onkeypress=\"if(event.keyCode == 13) getDados('busca');\" placeholder='Digite parte do nome'>";//esse funciona quando esta logado, CAMPO GENERICO PARA VARIAS BUSCAS
                       //esse else apenas funciona para o usuario atualizar seus dados Ssem estar logado
                        else if(empty($login) && $i == "paciente") echo"<input type='text' name='env_nome' size='20' id='env_nome' onkeypress=\"if(event.keyCode == 13){var nome = document.getElementById('env_nome').value; javascript:window.location.href='index.php?p=alt_cad_pac_sem_login&y='+nome;}\" placeholder='Digite seu prontuario...'>";
                        else{
                            echo"<input type='text' name='env_nome' size='20' id='env_nome' onkeypress=\"if(event.keyCode == 13) getDados('busca');\" placeholder='Digite o prontuario...'>";//CAMPO PARA VERIFICAR AS MARCAÇÕES DAS CONSULTAS SEM ESTAR LOGADO
                        }
                    ?> 
              
              <!--  <input type="text" name="env_nome" size="20" id="env_nome" onkeypress="if(event.keyCode == 13) getDados('busca');" placeholder="Digite parte do nome"> -->
                
                
                <?php 
                if($i != "agenda" && $i != "consultas" && !empty($login)){
                       echo"<a id='busca' href='index.php?p=pagina&op=".$i."'>Listar tudo</a>";
                       echo "<input type='hidden' name='ano' id='ano' value='00'>";
                }
                
                else if(empty($login)&& $i == "paciente"){//ESSE IF É APENAS PARA TELA PRINCIPAL SEM ESTAR LOGADO PARA ATUALIZAR OS DADOS
                   echo "<input type='hidden' name='ano' id='ano' value='00'>";
                    //echo"ANO:";
                    //echo"<input type='text' size='1' id='ano' name='ano' value='".date('Y')."'>";
                }
                else if(empty($login) && $i == "agenda"){//ESSE IF É APENAS PARA TELA PRINCIPAL SEM ESTAR LOGADO PARA ATUALIZAR OS DADOS
                    
                    echo"ANO:";
                    echo"<input type='text' size='1' id='ano' name='ano' value='".date('Y')."'>";
                }
                
                else
                {
                    
                    echo"ANO:";
                    echo"<input type='text' size='1' id='ano' name='ano' value='".date('Y')."'>";
                   
                    
                }
                
                ?>
                
                <br><br>
                <?php
                        if(!empty($login)) echo"<input type='button' name ='procurar' value='ENVIAR' class='botaoForm' onclick=\"getDados('busca');\">";//GENERICO PARA VARIAS BUSCAS, esse funciona quando esta logado
                       //esse else apenas funciona para o usuario atualizar seus dados
                        elseif (empty($login) && $i == "paciente") echo"<input type='button' name ='procurar' value='ENVIAR' class='botaoForm' onclick=\"{var nome = document.getElementById('env_nome').value; javascript:window.location.href='index.php?p=alt_cad_pac_sem_login&y='+nome;}\" placeholder='Digite seu prontuario'>";
                        
                        else{
                            echo"<input type='button' name ='procurar' value='ENVIAR' class='botaoForm' onclick=\"getDados('busca');\">";//BOTAO PARA VERIFICAR AS MARCAÇÕES DAS CONSULTAS SEM ESTAR LOGADO
                        }
                ?>
               <!-- <input type="button" name ="procurar" value="ENVIAR" class="botaoForm" onclick="getDados('busca');"> -->   
                                
          </fieldset>  
            
        </div>
        <hr/>

            <h2>Resultados da pesquisa:</h2>
            <div id="Resultado"></div>
            <hr>
                
    </body>
</html>


