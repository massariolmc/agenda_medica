$(document).ready( function() {
	$("#form_marc_hora").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			prontuario:{
				required: true, /* Campo obrigatório */
                                digits:true,     /* Só aceita numero */
                                minlength:5
                                
			},
                        especialidade:{
				required: true, /* Campo obrigatório */
                                
			},                        
                        mes:{
				required: true, /* Campo obrigatório */
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                       prontuario:{
				required: "Preencha o campo <u>Prontuario</u>",
                                digits: "Preencha o campo <u>Prontuario</u> apenas com numeros",
                                minlength:"O campo não contém 5 caracteres"
                                
			},
                        especialidade:{
				required: "Escolha uma opção no campo <u>Especilidade</u>"
                                
			},
                        
                        mes:{
				required: "Escolha o campo <u>MES</u>"
                                
			}
                        
                        
		}
	});
});
