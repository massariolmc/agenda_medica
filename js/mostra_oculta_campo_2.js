$(document).ready(function(){//FUNÇÃO QUE EXIBE OU OCULTA ALGUMAS DIV'S
   
        $('#env_pront').hide();
        $('#env_nome').hide();
   
        $('input[name=opcao]:radio').click(function() {

        if($(this).val()=="prontuario") {
        $('#env_pront').show();
        $('#env_nome').hide();
        
        } 
        else if($(this).val()=="nome") {
        $('#env_nome').show();
        $('#env_pront').hide();
        
        }
        else {
        $('#env_pront').hide();
        $('#env_nome').hide();
        
        }

        });
    });
