<?php
include "../includes/dash.php";
// $u = new Usuario;
session_start();
// if ($_SESSION['nome_usuario']){
// //    echo "Bem-Vindo "  . $_SESSION['nome_usuario'];
// }else{
//     unset($_SESSION['id_usuario']);
//     unset($_SESSION['nome_usuario']);
//     session_destroy();
//     header("location:../index.php");
//     exit;
// }
if (!isset($_SESSION)) session_start();


if(!isset($_SESSION['nome_usuario'])){
    // Destrói a sessão por segurança
   session_destroy();
   // Redireciona o visitante de volta pro login
   header("location:../index.php"); exit; 
}

?>
<style>
button {
    display: inline-block;
    height: 55px;
    width: 500px;
    margin: 20px;
    border-radius: 20px;
    border: 1px solid #F2F2F2;
    font-size: 16pt;
    padding: 10px 20px;
    margin-top: -6%;
    background-color: #170F50;
    color: #F2F2F2;
    outline: none;
    cursor: pointer;
    font-family: Cambria;
}

div.container {
    justify-content: center;
    align-items: center;
    flex-direction: co;

}

div.container div#botoes {
    padding-top: 180px;
}

div.col-lg-12 {
    padding: 10px;
    justify-content: center;
    align-items: center;
    /*flex-direction: collo;*/
    /*display: grid;*/
    /*margin-top: 20%;*/
    /*margin-left: 9%;*/
}

h2 {
    color: #606060;
    font-size: 20pt;
    font-family: Cambria;
    font-weight: bold;
    text-align: center;
    margin-top: 10%;
    text-transform: uppercase;
}
</style>


<body>
    <div class="container">
        <!-- <p style="text-transform: initial; font-weight: normal;">Olá <?php echo $_SESSION['nome_usuario']; ?></p> -->
        <h2>Olá <?php echo $_SESSION['nome_usuario']; ?>, Bem-vindo a plataforma de gestão da App de Jogo do ISSM</h2>
        <div class="d-flex justify-content-center" id="botoes">

            <button type="submit" name="btn challenge" class="btn-primary" id="btnchall">Challenges</button>
            <button type="submit" name="btn studentes" class="btn-primary" id="btnstudet"
                onclick="location.href='studety.php'">Estudantes</button>
        </div>
    </div>
    <script>
    let button = document.querySelector('div button#btnchall')
    button.addEventListener("click", () => {
        location.href = "challenge.php"
    })
    </script>

</body>

</html>