<?php
include "../includes/studety.php";
require_once '../includes/user.php';
$u = new Usuario;
session_start();
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

    if(!isset($_SESSION['nome_usuario'])){
         // Destrói a sessão por segurança
        session_destroy();
        // Redireciona o visitante de volta pro login
        header("location:../index.php"); exit; 
    }

?>
<style>
div.col-sm-4 {
    margin-top: 10px;
    color: #606060;
    padding: 10px;
}

div.col-md-9 h2 {
    text-transform: uppercase;
    font-size: 17px;
    font-family: Cambria;
}

nav.navbar {
    background-color: #E4A72C !important;
    box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.192);
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

div.col-lg-12 div.col-sm-4 {
    /*border: solid 1px red;*/
    margin-left: 52rem;
    /*align-items:left;*/
}

div.col-lg-12 div.col-sm-4 a {
    margin-left: 310px;
    color: rgba(0, 0, 0, 0.25);
}

div.col-lg-12 div.col-sm-4 a:hover {
    color: #170F50;
    outline: none;
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
        <h2>Dados dos Estudantes</h2>

        <div class="col-sm-4">
            <a href="../reports/studety.php" target="_blank" title="Gerar Relatorio">Gerar Relatório</a>
        </div>
    </div>

    <div class="container-fluid" style="background-color: whitesmoke;height: auto;">

        <br><br><br>
        <div class="col-lg-18">
            <table id="resquesting" class="display" style="width:100%">
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
                        <td><?php echo$row["nome_aluno"] ." ". $row["apelido_aluno"]; ?></td>
                        <td><?php echo$row["email_aluno"];?></td>
                        <td><?php echo$row["numero_telefone"];?></td>
                        <td><?php echo$row["escola_aluno"];?></td>
                        <td><?php echo$row["nome_nivel"];?></td>
                        <td><?php echo$row["ano_aluno"];?></td>
                        <td><?php echo$row["data_nasc_aluno"];?></td>
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
    // const input = document.getElementById('txtBusca');
    // const trs = [...document.querySelectorAll('#lista tbody tr')];

    // input.addEventListener('input', () => {
    //     const search = input.value.toLowerCase();
    //     trs.forEach(el => {
    //         const matches = el.textContent.toLowerCase().includes(search);
    //         el.style.display = matches ? 'block' : 'none';
    //     });
    // });
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