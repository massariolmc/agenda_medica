$(document).ready( function() {
	$("#form_especialidade").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        
                        especialidade:{
				required: true, /* Campo obrigatório */
                                minlength: 5
                                
			},
                        espec:{
				required: true, /* Campo obrigatório */
                                minlength: 5
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                       
                        especialidade:{
				required: "Escolha uma opção no campo <u>Especilidade</u>",
                                minlength: "O campo nome deve conter no mínimo 5 caracteres."
                                
                                
			},
                        espec:{
				required: "Digite o nome da <u>Especilidade</u>",
                                minlength: "O campo nome deve conter no mínimo 5 caracteres."
                                
			}
                        
                        
		}
	});
});
