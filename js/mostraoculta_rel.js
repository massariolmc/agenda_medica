$(document).ready(function(){//FUNÇÃO QUE EXIBE OU OCULTA ALGUMAS DIV'S
   
        $('#medico').hide();
        $('#especialidade').hide();
   
        $('input[name=rel]:radio').click(function() {

        if($(this).val()=="2" || $(this).val()=="5" || $(this).val()=="8") {
        $('#medico').show();
        $('#especialidade').hide();
        }
        else if($(this).val()=="3" || $(this).val()=="6" || $(this).val()=="9") {
        $('#especialidade').show();
        $('#medico').hide();
        }
        else {
        $('#medico').hide();
        $('#especialidade').hide();
        
        }

        });
    });
