<?php

function exibe_dados($d){     
    
        require_once("classes/paciente.class.php");
        $adj = new pacientes();
      
        $adj->extras_select = "WHERE cd_prontuario=".$d;
        $adj->selecionaTudo($adj);

        //echo '<pre>';
        //print_r($adj);
        //echo '</pre>';
        $cont = $adj->linhasafetadas;
        
        if ($cont > 0)
        {
            $return = "Prontuario existente";            
        }     
                    
         echo $return;       
         
      
}//FIM DA FUNÇÃO EXIBE_DADOS()
      
$f = $_GET["env_nome"];
if(!empty($f)){   
   
        exibe_dados($f);          
}
else{
   echo "Prontuario em branco";        
}


?>