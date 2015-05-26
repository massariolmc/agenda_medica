$(document).ready( function() {
	$("#form_busca").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        opcao:{
				required: true, /* Campo obrigatório */
                                
                                
			},
                        env_pront:{
				required: true, /* Campo obrigatório */
                                digits:true     /* Só aceita numero */
                                
			},
                        env_nome:{
				required: true, /* Campo obrigatório */
                                minlength: 3
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        opcao:{
				required: "Preencha o campo"
                                
			},
                        env_pront:{
				required: "Preencha o campo <u>Prontuario</u>",
                                digits: "Preencha o campo <u>Prontuario</u> com numeros"
                                
			},
                        env_nome:{
				required: "Preencha o campo <u>Nome</u>",
                                 minlength: "O campo nome deve conter no mínimo 3 caracteres."
                                
			}
                        
                        
		}
	});
});
