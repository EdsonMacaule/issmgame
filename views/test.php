<?php
session_start();
if ($_SESSION['nome_usuario']){
}else{
    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome_usuario']);
    session_destroy();
    header("location:../index.php");
    exit;
}
include "../includes/studety.php";
require_once '../includes/user.php';
$u = new Usuario;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <title>SGPI - gerenciamos os seus pedidos</title>
    <script>
    $(document).ready(function() {
        $('#resquesting').DataTable({
            "language": {
                "search": "Pesquisar:",
                "Next": "Próximo",
                "lengthMenu": "Mostrar _MENU_ por página",
                "zeroRecords": "Nada foi encontrado - desculpe",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhuma requisição disponivel",
                "infoFiltered": "(filtered from _MAX_ total records)"

            },
        });


    });
    </script>
</head>

<body>
    <nav>
        <ul>
            <li id="voltar">
                <a href="dashboard.php">Voltar</a>
            </li>
            <li id="sidebar_sair">
                <a href="../index.php">Sair</a>
            </li>
        </ul>
    </nav>
    <div class="wrapper-table">

        <div class="table-title">
            <h2>Dados dos Estudantes</h2>
        </div>
        <div class="links">
            <a href="../reports/studety.php" target="_blank" title="Gerar Relatorio">Gerar Relatório</a>
        </div>
    </div>

    <div class="container-fluid" style="background-color: whitesmoke;height: auto;">
        <br>

        <br><br><br>
        <div class="col-lg-18">
            <table id="resquesting" class="display responsive nowrap" style="width:98%">
                <thead>
                    <tr>
                        <th>Nome Completo</th>
                        <th>Email</th>
                        <th>Nº/telefone</th>
                        <th>Instituição de Ensino</th>
                        <th>Nível Académico</th>
                        <th>Ano de Frequência</th>
                        <th>Data de Nascimento</th>
                    </tr>
                    <?php $result = $u->studety(); ?>
                </thead>
                <tbody>
                    <?php $con=1; foreach ($result as $row): ?>
                    <tr>
                        <td data-search><?php echo$row["nome_aluno"] ." ". $row["apelido_aluno"]; ?></td>
                        <td data-search><?php echo$row["email_aluno"];?></td>
                        <td data-search><?php echo$row["numero_telefone"];?></td>
                        <td data-search><?php echo$row["escola_aluno"];?></td>
                        <td data-search><?php echo$row["nome_nivel"];?></td>
                        <td data-search><?php echo$row["ano_aluno"];?></td>
                        <td data-search><?php echo$row["data_nasc_aluno"];?></td>
                    </tr>
                    <?php $con++; endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nome Completo</th>
                        <th>Email</th>
                        <th>Nº/telefone</th>
                        <th>Instituição de Ensino</th>
                        <th>Nível Académico</th>
                        <th>Ano de Frequência</th>
                        <th>Data de Nascimento</th>
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

    <script>
    const input = document.getElementById('txtBusca');
    const trs = [...document.querySelectorAll('#lista tbody tr')];

    input.addEventListener('input', () => {
        const search = input.value.toLowerCase();
        trs.forEach(el => {
            const matches = el.textContent.toLowerCase().includes(search);
            el.style.display = matches ? 'block' : 'none';
        });
    });
    </script>

    <!-- <script type="text/javascript">
    $(document).ready(function() {
        $('.edit_btn').click(function(e) {
            e.preventDefault();

            var pedidos = $(this).attr('id_pedido');
            var dados = $(this).attr('nome_estado');
            var prio = $(this).attr('prioridade');

            document.getElementById("pedido_id").value = pedidos;
            document.getElementById("update_estado").value = dados;
            document.getElementById("estado_id").value = dados;
            document.getElementById("prioridade_id").value = prio;


        });

        $('#update_form').click(function(e) {
            e.preventDefault();
            // alert('Ola Macaule');
            var estado = $('#update_estado').val();
            var pedido = $('#pedido_id').val();
            var last_status = $('#estado_id').val();
            var prioridade = $('#prioridade_id').val();
            // alert(pedido);

            if (estado != last_status) {
                $.ajax({
                    type: 'POST',
                    // dataType: 'json',
                    url: "status.php",
                    // async: true,
                    data: {
                        'update_form': true,
                        update_estado: estado,
                        id_prioridade: prioridade,
                        pedido_id: pedido,
                    },
                    success: function(data) {
                        // console.log(data);
                        $('.alert-success').show();
                        $('.alert-error').hide();
                        location.href = "home.php";
                    }

                });

            } else {
                $('.alert-error').show();
            }



        });

    });
    </script> -->

</body>

</html>