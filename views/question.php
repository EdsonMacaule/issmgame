<?php
require_once '../includes/user.php';
$u = new Usuario;
include '../includes/question.php';
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

            <li id="voltar">
                <a href="challenge.php">Voltar</a>
            </li>
            <li id="sidebar_sair">
                <a href="../index.php">Sair</a>
            </li>
        </ul>
    </nav>
    <div class="row-title">
        <h2>Perguntas e Respostas do Challenge</h2>
    </div>
    <div class="content-questio">
        <!--iniciando os select option para adicionar perguntas-->
        <div class="search">
            <form action="question.php" method="get" id="search-form">
                <label for="cards">Escolha o nivel Academico</label>
                <?php $result = $u->nivelacad(); ?>
                <select name="academico" id="nivel">
                    <?php foreach ($result as $row): ?>
                    <option class="optionnivel" value="<?php echo $row["id_nivel_acad"];?>">
                        <?php echo $row["nome_nivel"]; ?></option><?php endforeach; ?>
                </select>
                <label for="cards">Escolha o nivel do
                    Jogo</label><?php $id=isset($_GET['jogo']) ? $_GET['jogo'] : $result[0]['id_nivel_acad']  ;   $result = $u->niveis($id); ?><select
                    name="jogo" id="njogo">
                    <?php foreach ($result as $row): ?>
                    <option class="optionjogo" value="<?php echo $row["numero_nivel_jogo"];?>">
                        <?php echo $row["numero_nivel_jogo"];?></option><?php endforeach; ?>
                </select>
                <label for="cards">Escolha o
                    Challenge</label><?php $id=isset($_GET['chall']) ? $_GET['chall'] : 0; $result = $u->niveis($id); ?>
                <select name="chall" id="challenge">
                    <?php foreach ($result as $row): ?>
                    <option class="optionchall" value="<?php echo $row["id_challenge"];?>">
                        <?php echo $row["nome_challenge"];?></option><?php endforeach; ?>
                </select>
                <button type="submit" class="pesquisar" value="search">Pesquisar</button>
            </form>
        </div>
    </div>
    <!--fim dos select option para adicionar perguntas-->
    <!--Clonando formulario de perguntas-->
    <div class="content-row" id="content-row">
        <div id="question_clone" style="display: none">
            <div class="flex-row">
                <div class="form-group purple-border">
                    <input type="text" name="nivelp[]" placeholder="Escreva a Pergunta">
                    <textarea class="form-control" name="nivelr[]" placeholder="Escreva as respostas"
                        rows="4"></textarea>
                    <button type="button" class="Remover_Pergunta">Remover</button>
                </div>
            </div>
        </div>
        <form action="nivel.php" method="post" id="submit-form">
            <?php if (isset($_GET['academico']) && isset($_GET['jogo']) && isset($_GET['chall'])){ $result = $u->getAllPosts($_GET['academico'],$_GET['jogo'],$_GET['chall']); ?>
            <?php foreach ($result['niveis_jogo'] as $value):?>
            <div class="flex-row">
                <div class="form-group purple-border">
                    <input type="text" name="nivelp[]" value="<?php echo $value['pergunta']?>"
                        placeholder="Escreva a Pergunta">
                    <p></p>
                    <textarea class="form-control" name="nivelr[]" placeholder="Escreva as respostas"
                        rows="4"><?php foreach ($value['resposta'] as $item){ echo $item['res'] ." | ".$item['correct'] ."&#13;&#10;";} ?></textarea>
                    <button type="button" class="Remover_Pergunta" style="visibility: hidden">Remover</button>
                </div>
            </div>
            <?php endforeach;  ?>
            <div id="question"></div>
            <input type="text" name="nivel_do_jogo" value="<?php echo $result["id_nivel_jogo"]?>"
                style="padding-left: 10%; margin-left: 30%;visibility: hidden">
            <?php } ?>
            <button type="button" id="Adicionar_Pergunta">Adicionar Pergunta</button>
            <button type="submit" class="submeter_form" value="adicionar">Submeter Formulario</button>
        </form>
    </div>
    <!--Fim do clone formulario de perguntas-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        //
        // $("#content-row").on("click",".optionnivel",function (){
        //     var id = $('#nivel').val();
        //
        //
        //     alert(id);
        // });

        $("#nivel").on('change', function() {
            var id = $('#nivel').val();
            //alert(id);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'nivel.php',
                async: true,
                data: {
                    id: id,
                    numero_nivel_jogo: 1,
                    nome_challenge: 'nome'
                },
                success: function(data) {
                    //var response = JSON.parse(response);
                    //alert(data.resposta);
                    //pegando os dados pelo select
                    $("#njogo").html("");
                    for (var i = 0; i < data.length; i++) {
                        $("#njogo").append("<option class='optionjogo' value='" + data[i]
                            .numero_nivel_jogo + "'>" + data[i].numero_nivel_jogo +
                            "</option>");
                    }
                    $("#challenge").html("");
                    for (var i = 0; i < data.length; i++) {
                        $("#challenge").append("<option class='optionchall' value='" + data[
                                i].id_challenge + "'>" + data[i].nome_challenge +
                            "</option>");
                    }

                    //console.log(data);
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    alert(msg);
                },
            });

        });
        //Clonando a div e torna-la dinamica
        $("#Adicionar_Pergunta").click(function() {
            var cloneDiv = $("#question_clone > div").clone();
            //alert("teste");
            $("#question").append(cloneDiv);

        });
        // remover a div replicada pelo botao
        $("#question").on("click", ".Remover_Pergunta", function() {
            $(this).closest(".flex-row").remove();

        });

    });
    </script>

</body>

</html>