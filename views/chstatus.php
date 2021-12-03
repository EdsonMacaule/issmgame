<?php
require_once '../includes/user.php';
$u = new Usuario;
include ('../includes/main.php');
session_start();

if (!isset($_SESSION)) session_start();


if(!isset($_SESSION['nome_usuario'])){
    // Destrói a sessão por segurança
   session_destroy();
   // Redireciona o visitante de volta pro login
   header("location:../index.php"); exit; 
}
?>

<style>
nav.navbar {
    background-color: #E4A72C !important;
    box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.192);
    position: relative;
}

div#navbarNav {
    display: flex;
    padding-bottom: 10px;
}

nav.navbar div#navbarNav ul.navbar-nav div#voltar {
    margin-right: 0.5mm;
    /*border: solid 1px red;*/
}

nav.navbar div#navbarNav ul.navbar-nav div#sidebar_sair {
    /*margin-top: 0%;*/
    margin-left: 52rem;
    /*border: solid 1px red;*/
}

nav.navbar div#navbarNav ul.navbar-nav div#voltar li.nav-item a.navbar-brand {
    margin-right: 90px;
    color: rgba(0, 0, 0, 0.25);
}

nav.navbar div#navbarNav ul.navbar-nav div#voltar li.nav-item a.navbar-brand:hover {
    color: white;
}

nav.navbar div#navbarNav ul.navbar-nav div#sidebar_sair li.nav-item a.navbar-brand {
    margin-left: 90px;
    color: rgba(0, 0, 0, 0.25);
}

nav.navbar div#navbarNav ul.navbar-nav div#sidebar_sair li.nav-item a.navbar-brand:hover {
    color: white;
}

div.col-lg-12 h2 {
    padding-top: 30px;
    text-transform: uppercase;
    font-size: 20px;
    font-family: Cambria;
    text-align: center;
}

div.col-lg-12 {
    padding: 10px;
}
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <div class="col-sm-2" id="voltar">
                        <li class="nav-item">
                            <a class="navbar-brand" href="dashboard.php">Voltar</a>
                        </li>
                    </div>
                    <div class="col-sm-2" id="sidebar_sair">
                        <li class="nav-item">
                            <a class="navbar-brand" href="../index.php">Sair</a>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <div class="col-lg-12">
        <h2>Dados do Challenge</h2>
    </div>
    <!--        <div class="links">-->
    <!--            <a href="../reports/challengestatus.php" title="Gerar Relatorio">Gerar Relatorio</a>-->
    <!--        </div>-->
    <div class="container-fluid" style="background-color: whitesmoke;height: auto;">

        <br><br><br>
        <div class="col-lg-18">
            <table id="resquestings" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="width:10%;">Nivel do Jogo</th>
                        <th>Pontuação</th>
                        <th>Nome do Estudate</th>
                        <th>Nome do Challenge</th>
                        <th>Data&Hora</th>
                    </tr>
                </thead>
                <?php $result = $u->challenge_status('id');
            //var_dump($result);
            ?>
                <tbody>
                    <?php foreach ($result as $row): ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $row["numero_nivel_jogo"] ?></td>
                        <td><?php echo $row["pontuacao"] ?></td>
                        <td><?php echo $row["nome_aluno"] ." ". $row["apelido_aluno"] ?></td>
                        <td><?php echo $row["nome_challenge"] ?></td>
                        <td><?php echo $row["data"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nivel do Jogo</th>
                        <th>Pontuação</th>
                        <th>Nome do Estudate</th>
                        <th>Nome do Challenge</th>
                        <th>Data&Hora</th>
                    </tr>
                </tfoot>
            </table>
            <br><br>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</body>

</html>