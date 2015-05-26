$(document).ready( function() {
	$("#form_paciente").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			prontuario:{
				required: true, /* Campo obrigatório */
                                digits:true,     /* Só aceita numero */
                                minlength: 5
			},                        
                        nome:{
				required: true, /* Campo obrigatório */
                                minlength: 5
                                
			},
                        saram:{
				required: true, /* Campo obrigatório */
                                digits:true,     /* Só aceita numero */
                                minlength: 7
                                
			},
                        dt_nasc:{
				required: true, /* Campo obrigatório */
                                
			},
                        sexo:{
				required: true, /* Campo obrigatório */
                                
			},
                        rua:{
				required: true, /* Campo obrigatório */
                                
			},
                        numero:{
				required: true, /* Campo obrigatório */
                                digits:true
			},
                        bairro:{
				required: true, /* Campo obrigatório */
                                
			},
                        cidade:{
				required: true, /* Campo obrigatório */
                                
			},
                        estado:{
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
                        nome:{
				required: "Preencha o campo <u>Nome</u>",
                                minlength: "O campo nome deve conter no mínimo 5 caracteres."
                                
			},
                        saram:{
				required: "Preencha o campo <u>SARAM</u>",
                                digits: "Preencha o campo <u>SARAM</u> apenas com numeros",
                                minlength:"O campo não contém 7 caracteres"
                                
			},
                        dt_nasc:{
				required: "Preencha o campo <u>Data de Nasc</u>"
                                
			},
                        sexo:{
				required: "Preencha o campo <u>Sexo</u>"
                                
			},
                        rua:{
				required: "Preencha o campo <u>Rua</u>"
                                
			},
                        numero:{
				required: "Preencha o campo <u>Numero</u>",
                                digits:"Preencha o campo <u>Numero</u> apenas com numeros"
			},
                        bairro:{
				required: "Preencha o campo <u>Bairro</u>"
                                
			},
                        cidade:{
				required: "Preencha o campo <u>Cidade</u>"
                                
			},
                        estado:{
				required: "Preencha o campo <u>Estado</u>"
                                
			}
		}
	});
});
