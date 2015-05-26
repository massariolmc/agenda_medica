
<?php
        function le_arquivo($arq,$saram){
        
//        $arquivo = 'CONTRIB_21112014.csv';
	$arquivo = $arq;

        //cria um array que receberá os dados importados do arquivo txt
        $arquivoArr = array();
        
        //aqui é enviado para função fopen o endereço do arquivo e a instrução 'r' que indica 'somente leitura' e coloca o ponteiro no começo do arquivo
        $arq = fopen($arquivo, 'r');
        
        //variável armazena o total de linhas importadas
        $total_linhas_importadas = 0;
        
        //a função feof retorna true (verdadeiro) se o ponteiro estiver no fim do arquivo aberto
        //a negação do retorno de feof indicada pelo caracter "!" do lado esquerdo da função faz com 
        //que o laço percorra todas as linhas do arquivo até fim do arquivo (eof - end of file)
        while(!feof($arq)){
                
                //retorna a linha do ponteiro do arquivo                        
                $conteudo = fgets($arq);

                //transforma a linha do ponteiro em uma matriz de string, cada uma como substring de string formada a partir do caracter ';'
                $linha = explode(';', $conteudo);
                
                //array recebe as substring contidas na matriz carregada na variável $linha 
                $arquivoArr[$total_linhas_importadas] = $linha;

                //incremente a variável que armazena o total de linhas importadas
                $total_linhas_importadas++;
        }       
       $i=0;
       $j=0;
       $k=0;
       $var = array();
                        
               if($arquivo == "CONTRIB.csv" || $arquivo == "upload/CONTRIB.csv"){ 
                    foreach($arquivoArr as $linha): 
                                
                                         foreach($linha as $campo):
                                                 if($campo == $saram)
                                                     $j=1;
                                                 if($j==1 && $i==3){
                                                     $var[] = $campo; 
                                                 }
                                                 //if($j==1 && $i==11){
                                                 //    $var[] = $campo;
                                                 //}
                                                 if($j==1 && $i==17){
                                                     $var[] = $campo;
                                                 }
                                                 if($j==1 && $i==19){
                                                     $var[] = $campo;
                                                 }
                                                 $i++;
                                         endforeach; 
                                         $i = 0;
                                         $j = 0;
                        endforeach;
               }
               else{
                   foreach($arquivoArr as $linha): 
                                
                                         foreach($linha as $campo):
                                                 if($campo == $saram)
                                                     $j=1;
                                                 if($j==1 && $i==2){
                                                     $var[] = $campo; 
                                                 }
                                                 //if($j==1 && $i==4){
                                                 ///    $var[] = $campo;
                                                 //}
                                                 if($j==1 && $i==6){
                                                     $var[] = $campo;
                                                 }
                                                 if($j==1 && $i==7){
                                                     $var[] = $campo;
                                                 }
                                                 $i++;
                                         endforeach; 
                                         $i = 0;
                                         $j = 0;
                        endforeach;
               }
 return $var;       
                       
        //imprime a quantidade de linhas importadas
        //echo "<br/> Quantidade de linhas importadas = ".$total_linhas_importadas;
}//FIM DA FUNÇÃO

function imprimir($var,$saram){
    $cont = 0;
    $cont = count($var);
    
    if($cont == 0)
    echo"Você não possui dependentes";

else{
        $i = 0;
        $c = 2;
        $cores = array("#2E82FF","#FFFFFF");  
        $tabela = "<table border='1' cellspacing='0' cellpadding='5'>
                    
                            
                            <th>SARAM</th>                            
                            <th>NOME</th>
                            <th>DT NASC</th>
                            <th>".utf8_decode("SITUAÇÃO/TIPO DE DEPENDENCIA")."</th>
                            ";
                                       
        $return = "$tabela";        
        
        
            $index = $c % 2;
            $c++;
            $cor = $cores[$index];            
            $return.= '<tr bgcolor="'.$cor.'">';                     
            $return.= "<td align=center>" . utf8_encode($saram) . "</td>";   
            foreach($var as $aux):
                if($i == 3){
                    $return.= "</tr>";
                    $index = $c % 2;
                    $c++;
                    $cor = $cores[$index];            
                    $return.= '<tr bgcolor="'.$cor.'">';  
                    $return.= "<td align=center>" . utf8_encode($saram) . "</td>"; 
                    $return.= "<td align=center>" . utf8_encode($aux) . "</td>";
                    $i = 0;
                }
                else {   
                    if(is_numeric($aux))
                        if($aux >= 100) $return.= "<td align=center>AMH</td>";
                        else $return.= "<td align=center>AMHC</td>";
                    else
                        $return.= "<td align=center>" . utf8_encode($aux) . "</td>";
                }
                    
                $i++;
            endforeach;
            
            $return.= "</tr>";
            $cont--;
        
        echo $return.="</table>";
}
}

?>

