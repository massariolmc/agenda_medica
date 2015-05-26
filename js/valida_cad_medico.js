$(document).ready( function() {
	$("#form_medico").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        nome:{
				required: true, /* Campo obrigatório */
                                minlength: 5
                                
			},
                        crm:{
				required: true, /* Campo obrigatório */
                                digits:true     /* Só aceita numero */
			},
                        especialidade:{
				required: true, /* Campo obrigatório */
                                
			},
                        espec:{
				required: true, /* Campo obrigatório */
                                
			},
                        dt_nasc:{
				required: true, /* Campo obrigatório */
                                
			},
                        sexo:{
				required: true, /* Campo obrigatório */
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        nome:{
				required: "Preencha o campo <u>Nome</u>",
                                minlength: "O campo nome deve conter no mínimo 5 caracteres."
                                
			},
                        crm:{
				required: "Preencha o campo <u>CRM</u>",
                                digits: "Preencha o campo <u>CRM</u> apenas com numeros"
                        },
                        especialidade:{
				required: "Escolha uma opção no campo <u>Especilidade</u>"
                                
			},
                        espec:{
				required: "Preencha o campo <u>Especialidade</u>"
                                
			},
                        dt_nasc:{
				required: "Preencha o campo <u>Data de Nasc</u>"
                                
			},
                        sexo:{
				required: "Preencha o campo <u>Sexo</u>"
                                
			}
                        
                        
		}
	});
});
