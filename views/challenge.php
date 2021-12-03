<?php
require_once '../includes/user.php';
$u = new Usuario;
include "../includes/chall.php";

session_start();

if (!isset($_SESSION)) session_start();


if(!isset($_SESSION['nome_usuario'])){
    // Destrói a sessão por segurança
   session_destroy();
   // Redireciona o visitante de volta pro login
   header("location:../index.php"); exit; 
}
?>

<body>
    <nav>
        <ul>
            <li id="qst">
                <a href="question.php">Criar Perguntas</a>
            </li>
            <li id="voltar">
                <a href="dashboard.php">Voltar</a>
            </li>
            <li id="sidebar_sair">
                <a href="../index.php">Sair</a>
            </li>
        </ul>
    </nav>

    <div id="content-search">
        <!--        <h2>Submeter Challenges Por Nível Académico</h2>-->
        <div id="search-flex" class="search">
            <form action="challenge.php" method="get" id="search-form">
                <label for="cards">Escolha o nível Académico</label>
                <?php $result = $u->nivelacad(); ?>
                <select name="academico" id="nivel">
                    <?php foreach ($result as $row): ?>
                    <option class="optionnivel" value="<?php echo $row["id_nivel_acad"];?>">
                        <?php echo $row["nome_nivel"]; ?></option><?php endforeach; ?>
                </select>
                <label for="cards">Escolha o
                    Challenge</label><?php $result = $u->challenges(); ?>
                <select name="chall" id="challenge">
                    <?php foreach ($result as $row): ?>
                    <option class="optionchall" value="<?php echo $row["id_challenge"];?>">
                        <?php echo $row["nome_challenge"];?></option><?php endforeach; ?>
                </select>
                <select name="estado" id="estado">
                    <option value="1" selected>Aberto</option>
                    <option value="0">Fechado</option>
                </select>
                <button type="submit" class="pesquisar" value="search">Pesquisar</button>
            </form>
            <form action="" method="post" id="myCoolForm">
                <button type="submit" class="submeter" name="submeter" value="submeter">Submeter</button>
                <button type="submit" class="actualizar" name="actualizar"
                    onClick='return confirmSubmit()'>Actualizar</button>
            </form>
        </div>
        <form action="" method="post" id="myUpdateForm">
            <input type="text" name="nome_challenge" class="actual" placeholder="Edita o nome do challenge">
            <button type="submit" value="update" name="update" class="update"
                onClick='return confirmUpdate()'>Editar</button>
        </form>
    </div>

    <div id="content-flex">
        <h2>Cadastro de Challenges</h2>
        <form method="post" action="" id="myCadForm">
            <input required type="text" name="nome" placeholder="Digite o nome do Challenge">
            <label for="estado">Selecione o Estado</label>
            <select name="estado" id="estado">
                <option value="1">Aberto</option>
                <option value="0" selected>Fechado</option>
            </select>
            <button id="adicionar_challenge">Cadastrar</button>

        </form>
    </div>

    <?php

    if (isset($_POST['update'])){
        $id_challenge = $_GET['chall'];
        $nome_challenge = $_POST['nome_challenge'];
        if (!empty($id_challenge)){
            $u->conectar();
            $u->upchallenge($nome_challenge,$id_challenge);
            echo "Editado com Sucesso";
        }else{
            ?>
    <div class="msg-erro">
        Selecione o Campo Challenge
    </div>
    <?php
        }
    }

    if (isset($_POST['actualizar'])){
        $id_challenge = $_GET['chall'];
        $estado = $_GET['estado'];
        if (!empty($id_challenge)){
            $u->conectar();
            $u->actualizarchall($id_challenge,$estado);
            echo "Actualizado com Sucesso";
        }else{
            ?>
    <div class="msg-erro">
        Selecione o Campo Challenge
    </div>
    <?php
        }
    }

    // submeter challenge por nivel
    if (isset($_POST['submeter'])){
        $id_nivel_acad = $_GET['academico'];
        $id_challenge = $_GET['chall'];
        if (!empty($id_nivel_acad) && !empty($id_challenge)){
            $u->conectar();
            $u->addchallenge($id_nivel_acad,$id_challenge);
            echo "Submetido com Sucesso";
        }else{
            ?>
    <div class="msg-erro">
        Selecione todos so Campos
    </div>
    <?php
        }
    }
//verificar se clicou no botao
if(isset($_POST['nome']))
{
    $nome_challenge = addslashes($_POST['nome']);
    $estado = addslashes($_POST['estado']);
//    $id_nivel_acad = $_GET['academico'];
//    $id_challenge = $_GET['chall'];
    //verificar se esta preenchido
    if (!empty($nome_challenge) && !empty($estado)){
    $u->conectar();
    if ($u->msgErro==""){
        $u->challenge($nome_challenge,$estado);
//        $u->addchallenge($id_nivel_acad,$id_challenge);
        echo "Challenge Cadastrado com Sucesso";

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
        Preencha todos Campos
    </div>
    <?php
    }
}
?>
    <div class="alerta"></div>
    <hr>
    <div class="title">
        <h2> Challenges Cadastrados </h2>
    </div>
    <div class="flex-chall">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nome do Challenges</th>
                <th id="estado">Estado</th>
            </tr>
            <?php
   $result = $u->listar();?>
            <tbody>
                <?php $con=1; foreach ($result as $row): ?>
                <tr class='clickable-row' data-href="chstatus.php?id=<?php echo $row["id_challenge"]; ?>">
                    <td><?php echo $con; ?> </td>
                    <td><?php echo $row["nome_challenge"]; ?></td>
                    <td id="estado"><?php echo $row["estado"]? 'Aberto' : 'Fechado'; ?></td>
                </tr>

                <?php $con++; endforeach;?>
            </tbody>

        </table>
    </div>
    <script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

    });

    function confirmSubmit() {
        var agree = confirm(
            "Tens certeza que desejas mudar o estado do challenge? Sim, certifique-se que selecionou o Challenge certo! "
        );
        if (agree)
            return true;
        else
            return false;
    }

    function confirmUpdate() {
        var agree = confirm(
            "Tens certeza que desejas editar o nome do challenge? Sim, certifique-se que selecionou o Challenge certo! "
        );
        if (agree)
            return true;
        else
            return false;
    }
    </script>
</body>

</html>