$(document).ready( function() {
	$("#form_usuario").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        nome:{
				required: true, /* Campo obrigatório */
                                minlength: 5
                                
			},
                        usuario:{
				required: true, /* Campo obrigatório */
                                minlength: 4
                                
			},
                        senha:{
				required: true, /* Campo obrigatório */
                                
			},
                        tp_acesso:{
				required: true, /* Campo obrigatório */
                                
			},
                        n_senha:{
				required: true, /* Campo obrigatório */
                                
			},
                        conf_senha:{
				required: true, /* Campo obrigatório */
                                equalTo: "#n_senha"
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        nome:{
				required: "Preencha o campo <u>Nome</u>",
                                minlength: "O campo nome deve conter no mínimo 5 caracteres."
                                
			},
                        usuario:{
				required: "Preencha o campo <u>Usuario</u>",
                                minlength: "O campo nome deve conter no mínimo 4 caracteres."
                                
			},
                        senha:{
				required: "Preencha o campo <u>Senha</u>"
                                
			},
                        tp_acesso:{
				required: "Preencha o campo <u>Tipo de acesso</u>"
                                
			},
                        n_senha:{
				required: "Preencha o campo <u>Nova Senha</u>"
                                
			},
                        conf_senha:{
				required: "Preencha o campo <u>Confirma Senha</u>",
                                equalTo: "O campo confirmação de senha deve ser identico ao campo senha."
                                
			}
                        
                        
		}
	});
});
