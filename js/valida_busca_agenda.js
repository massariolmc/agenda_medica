$(document).ready( function() {
	$("#form_busca_agenda").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			             
                        
                        env_nome:{
				required: true, /* Campo obrigatório */
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        
                       
                        env_nome:{
				required: "Preencha o campo <u>Nome</u>"
                                
			}
                        
                        
		}
	});
});
