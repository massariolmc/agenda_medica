$(document).ready( function() {
	$("#login").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        usuario:{
				required: true, /* Campo obrigatório */
                                
			},
                        senha:{
				required: true, /* Campo obrigatório */
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        usuario:{
				required: "Preencha o campo <u>Nome</u>"
                                
			},
                        senha:{
				required: "Preencha o campo <u>Senha</u>"
                                
			}
                        
                        
		}
	});
});
