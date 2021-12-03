<?php
//instaciado a classe
require_once 'includes/user.php';
require_once 'includes/head.php';
$u = new Usuario;
?>

<body>
    <div id="form-group">
        <h1>Faça o seu Login</h1>
        <form method="POST">
            <input type="email" placeholder="Usuário" name="email">
            <input type="password" placeholder="Senha" name="senha">
            <input type="submit" name="login" id="login" value="ACESSAR">
        </form>
    </div>
    <?php
    if(isset($_POST['email'])){
        $email_admin = $_POST['email'];
        $password_admin = $_POST['senha'];
        if (!empty($email_admin) && !empty($password_admin)){
            $u->conectar();
            if ($u->msgErro==""){
            if($u->login($email_admin,$password_admin)){
                header("location:views/dashboard.php");
            }else{
                ?>
    <div class="msg-erro">
        Email e/ou Senha invalidos!
    </div>
    <?php
            }
         }else{
                ?>
    <div class="msg-erro">
        <?php echo "Erro: ".$u->msgErro; ?>
    </div>
    <?php
            }
        }else{
            ?>
    <div class="msg-erro">
        Preencha todos so Campos
    </div>
    <?php
        }
    }
    ?>
</body>

</html>