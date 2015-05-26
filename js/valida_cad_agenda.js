$(document).ready( function() {
	$("#form_agenda").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        nome:{
				required: true, /* Campo obrigatório */
                                
			},
                        especialidade:{
				required: true, /* Campo obrigatório */
                                
			},
                        mes:{
				required: true, /* Campo obrigatório */
                                
			},
                        comp:{
				required: true, /* Campo obrigatório */
                                
			},
                        hora_ag:{
                                required: true, 
                        }
                        
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        nome:{
				required: "Preencha o campo <u>Nome</u>"
                                
			},
                        especialidade:{
				required: "Escolha uma opção no campo <u>Especilidade</u>"
                                
			},
                        mes:{
				required: "Preencha o campo <u>MES</u>"
                                
			},
                         comp:{
				required: "Preencha o campo <u>CONFIRMAR CONSULTA</u>"
                                
			},
                        hora_ag:{
				required: "O campo não esta preencido."
                                
			}
                                       
		}
	});
        
});

$(document).ready(function(){

$("#enviar").click(function(e){

	// bloqueando envio do form
	e.preventDefault();
		
	var erros = 0;
		
	// verifica se ha campos vazios
        //$("#form_agenda input").each(function(){
	$(".hora_ag").each(function(){//hora_ag é a class para validar se input='text' dos horarios não estão vazios
			
		// conta erros
		$(this).val() == "" ? erros++ : "";
			
	});
		
	// verifica se ha erros
	if(erros > 0 ){
				 
		alert("Existe(em) campo(os) vazio(os) neste fomulário");
				
    }else{
		//return true;	
		$("#form_agenda").submit()
	}		
			
	});

});

