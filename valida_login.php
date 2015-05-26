<?php 
require_once("conecta.php");
function logar($login,$s){
            abreconexao();
            $sql = "SELECT * FROM usuarios WHERE usuario='".$login."'";
            $query = pg_query($sql);
            $cont = pg_affected_rows($query); 
            if($cont > 0){
                while($tbl = pg_fetch_object($query)){
                    $password= $tbl->senha;
                }
                    if($s != $password){
                        echo"SENHA NÃO CONFERE. POR FAVOR DIGITE NOVAMENTE.";
                        echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
                        exit();
                    }
                    else{
                        session_start();
                        $_SESSION['nome_usuario'] = $login;
                        $_SESSION['senha_usuario'] = $s;                        
                         header('Location: index.php?p=adm');
                    }
            }
            else{
                echo"ESSE LOGIN NÃO EXISTE.";
                echo "<p><br><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
                exit();
            }
        fechaconexao();
   }
   
function valida_login(){
       session_start();
       if(isset($_SESSION["nome_usuario"])){
           $login = $_SESSION["nome_usuario"];
       }
       if(isset($_SESSION["senha_usuario"])){
           $senha = $_SESSION["senha_usuario"];
       }       
       
       if(!(empty($login) OR empty($senha))){
           abreconexao();
            $sql = "SELECT * FROM usuarios WHERE usuario='".$login."'";
            $query = pg_query($sql);
            $cont = pg_affected_rows($query); 
            if($cont > 0){
                while($tbl = pg_fetch_object($query)){
                    $password= $tbl->senha;
                }
            
           
                if($senha != $password){
                  unset($_SESSION["nome_usuario"]);
                  unset($_SESSION["senha_usuario"]);
                  header ('Location: index_login.php');
                }
            }
            else{
                 unset($_SESSION["nome_usuario"]);
                 unset($_SESSION["senha_usuario"]);
                 header ('Location: index_login.php');
            }
    }
    
       
    else{ 
       header ('Location: index_login.php');
    }
   fechaconexao();
   }
//OBS: CRIEI UMA PAGINA PARA O LOGOUT, ESTA FUNÇÃO NÃO ESTOU USANDO   
function logout(){
       session_start();
       $_SESSION = array();
       session_destroy();       
       header ('Location: index_login.php');
   }
   fechaconexao();
?>
