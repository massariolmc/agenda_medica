<?php require_once("valida_login.php");     valida_login();?>
<?php
$cod = $_GET["cod"];
$i = $_GET["i"];

require_once("classes/usuarios.class.php");
$usuario = new usuarios();
$usuario->extras_select = "WHERE cd_acesso=".$cod;
    $usuario->selecionaTudo($usuario);
    $res = $usuario->retornaDados();   
    $cont = $usuario->linhasafetadas; 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CADASTRAR USUARIO</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>     
        <script type="text/javascript" src="js/valida_cad_usuario.js"></script>
        
        
    </head>
    <body>
        <div id="cadastra"> 
             
        <form id="form_usuario" name="form_usuario" method="POST" action="processa.php">
            <input type="hidden" name="operacao" value="alt_senha_usuario">
            <fieldset name="incluir">
                <legend>ALTERAR SENHA DO USUARIO</legend>
                                
                
                <input type="hidden" name="cd_acesso" size="20" id="cd_acesso"  maxlength="5" value="<?php echo $res->cd_acesso; ?>">               
                <input type="hidden" name="nome" size="20" id="nome" value="<?php echo $res->nome_acesso; ?>">                               
                <input type="hidden" name="tp_acesso" value="<?php echo $res->tp_acesso;?>" id="tp_acesso" >
                
                <label>USUARIO:</label>
                <input type="text" name="usuario" size="20" id="usuario" value="<?php echo $res->usuario; ?>">                             
                <br/><br>
                   
                <label>NOVA SENHA</label><input type="password" name="n_senha" size="20" id="n_senha" maxlength="10"><BR><br>
                <label>CONFIRMA SENHA</label><input type="password" name="conf_senha" size="20" id="conf_senha" maxlength="10">                
                
                <br/><br>
                
                <input type="submit" value="ALTERAR SENHA" class="botaoForm">
                
                
                
                
                
            </fieldset>
            
        </form>
          </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
