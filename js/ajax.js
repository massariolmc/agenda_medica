/**
  * Função para criar um objeto XMLHTTPRequest
  */
 function CriaRequest() {
     try{
         request = new XMLHttpRequest();        
     }catch (IEAtual){
         
         try{
             request = new ActiveXObject("Msxml2.XMLHTTP");       
         }catch(IEAntigo){
         
             try{
                 request = new ActiveXObject("Microsoft.XMLHTTP");          
             }catch(falha){
                 request = false;
             }
         }
     }
     
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
 }
 
 /**
  * Função para enviar os dados
  */
 function getDados(valor) {
     
     if(valor == "busca"){
     // Declaração de Variáveis
     var vt        = document.getElementById("op").value;
     var nome     = document.getElementById("env_nome").value;
     var result   = document.getElementById("Resultado");
     var an        = document.getElementById("ano").value;//vale apenas para agenda
     var xmlreq   = CriaRequest();
     
     // Exibi a imagem de progresso
     result.innerHTML = "AGUARDE...";
    
     // Iniciar uma requisição
         xmlreq.open("GET", "./procurar_ajax.php?env_nome=" + nome + "&op=" + vt + "&ano=" + an, true);   
    
     }
     
     else if(valor == "cad_paciente"){
          // Declaração de Variáveis
     var vt        = document.getElementById("prontuario").value;
     //var nome     = document.getElementById("env_nome").value;
     var result   = document.getElementById("nprontuario");
     var xmlreq   = CriaRequest();
     
     // Exibi a imagem de progresso
     result.innerHTML = "AGUARDE...";

     
     // Iniciar uma requisição
     xmlreq.open("GET", "./validar_ajax.php?env_nome=" + vt, true);     
     }
     
     else if(valor == "calendario"){
          // Declaração de Variáveis
     
     var vt        = document.getElementById("mes").value;     
     var result   = document.getElementById("Resultado");
     var xmlreq   = CriaRequest();
     
     // Exibi a imagem de progresso
     result.innerHTML = "AGUARDE...";

     
     // Iniciar uma requisição
     xmlreq.open("GET", "./calendario_ajax.php?env_nome=" + vt + "&op=" + valor, true);//procura no calendario qual mes estamos     
     }
     
     else if(valor == "verifica_calendario"){
          // Declaração de Variáveis
     
     var mes    = document.getElementById("mes").value;      
     var espec  = document.getElementById("especialidade").value;      
     var medico = document.getElementById("medico").value; 
     var result = document.getElementById("Resultado");
     var dia    = "dia";
     var xmlreq = CriaRequest();
     
     // Exibi a imagem de progresso
     result.innerHTML = "AGUARDE...";

     
     // Iniciar uma requisição
     xmlreq.open("GET", "./verifica_consulta.php?mes=" + mes + "&espec=" + espec + "&medico=" + medico + "&op=" + dia, true);//procura no calendario qual mes estamos     
     }
     
              
     else{
         
     }
     
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
         
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
             
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }




