<?php require_once("valida_login.php");     valida_login();?>
<?php
$cod = $_GET["cd"];
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
            <input type="hidden" name="operacao" value="alt_usuario">
            <fieldset name="incluir">
                <legend>ALTERAR DADOS DOS USUARIOS</legend>
                <p>SELECIONE AS OPÇÕES</p>
                
                <label>USUARIO Nº:</label>
                <input type="text" name="cd_acesso" size="20" id="cd_acesso"  maxlength="5" value="<?php echo $res->cd_acesso; ?>" readonly>               
                <br/><br/>
                
                <label>NOME COMPLETO:</label>
                <input type="text" name="nome" size="20" id="nome" value="<?php echo $res->nome_acesso; ?>">               
                <br/><br/>
                
                <label>USUARIO:</label>
                <input type="text" name="usuario" size="20" id="usuario" value="<?php echo $res->usuario; ?>">               
                <br/><br/>                
                
                <label>TIPO DE ACESSO:</label>
                <input type="radio" name="tp_acesso" value="ADM" id="tp_acesso" <?php echo $res->tp_acesso == 'ADM' ? 'checked=\"checked\"' : "";?>>ADM
                <input type="radio" name="tp_acesso" value="OPERADOR" id="tp_acesso" <?php echo $res->tp_acesso == 'OPERADOR' ? 'checked=\"checked\"' : "";?>>OPERADOR
                <br><br>       

                <input type="submit" value="ALTERAR" class="botaoForm">
                <br/><br>
                <label><a href="index.php?p=alt_senha_usuario&cod=<?php echo $res->cd_acesso; ?>" id='trocasenha'>TROCA DE SENHA</a></label>
                
                
                
                
                
                
                
            </fieldset>
            
        </form>
          </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
