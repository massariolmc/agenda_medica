$(document).ready(function(){//FUNÇÃO QUE EXIBE OU OCULTA ALGUMAS DIV'S
   
        $('#div_cid').hide();
   
        $('input[name=comp]:radio').click(function() {

        if($(this).val()=="1") {
        $('#div_cid').show();
        
        } 
        else if($(this).val()=="0"){
        $('#div_cid').hide();
        
        }

        });
    });
