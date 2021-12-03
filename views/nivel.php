<?php
require_once '../includes/user.php';
$u = new Usuario;

    if (isset($_POST['numero_nivel_jogo']) && isset($_POST['nome_challenge']) ){
        $id=$_POST['id'];
        $nome=$_POST['nome_challenge'];
        $data=$u->niveis($id);
        echo json_encode($data);
    }

//    if (isset($_POST['chall'])){
//        $id=$_POST['chall'];
//        $this->conectar();
//        global $pdo;
//        $sql =$pdo->prepare("DELETE FROM `tb_challenges` WHERE id_challenge =:del");
//        $sql->bindValue(":del",$id,PDO::PARAM_INT);
//        $sql->execute();
//        return true;
//    }

    if (isset($_POST['njogo']) && isset($_POST['nomech'])){
        $id=$_POST['nivel'];
        $nome=$_POST['nomech'];
        $data=$u->search($id);
        echo json_encode($data);

    }

    if(isset($_POST['nivelp']) && isset($_POST['nivelr']) && isset($_POST['nivel_do_jogo'])){
    $perguntas = $_POST['nivelp'];
    $respostas = $_POST['nivelr'];
    $nivel_id_jogo = $_POST['nivel_do_jogo'];
//      echo $nivel_id_jogo;
    //   $nivel_id_jogo=null

        $u->conectar();
//        echo "teste";
        global $pdo;


            $query1 = $pdo->prepare("DELETE rp.* FROM tb_responta rp INNER JOIN tb_pergunta pr ON rp.id_pergunta=pr.id_pergunta INNER JOIN tb_nivel_jogo nj ON pr.id_nivel_jogo=nj.id_nivel_jogo WHERE nj.id_nivel_jogo=$nivel_id_jogo");
            $delete=$query1->execute();
            if ($delete==1){
                $query2 =$pdo->prepare("DELETE pr.* FROM tb_pergunta pr INNER JOIN tb_nivel_jogo nj ON pr.id_nivel_jogo=nj.id_nivel_jogo WHERE nj.id_nivel_jogo=$nivel_id_jogo");
                $query2->execute();
            }


        foreach ($perguntas as $key => $pergunta) {
            $array_respostas = explode("\n", trim($respostas[$key]));

//            echo $pergunta . "</br>";
            $sql1 = $pdo->prepare("INSERT INTO tb_pergunta (`id_pergunta`, `pergunta`, `id_nivel_jogo`) VALUES (NULL, :nivelp, :njogo);");
            $sql1->bindValue(':nivelp',$pergunta,PDO::PARAM_STR);
            $sql1->bindValue(':njogo',$nivel_id_jogo);
            $sql1->execute();
            $id=$pdo->lastInsertId();
            foreach ($array_respostas as $resposta_linha) {
                $array_respostas_linha = explode(" | ", $resposta_linha);
                $resposta = $array_respostas_linha[0];
                $correct = $array_respostas_linha[1];
//                echo "Resposta: " . $resposta . " Correct: " . $correct . " </br>";
                $sql2 = $pdo->prepare("INSERT INTO tb_responta (`id_resposta`, `resposta`, `id_pergunta`, `verdadeira_resposta`) VALUES (NULL,:resp , :id, :correc);");
                $sql2->bindValue(":resp", $resposta,PDO::PARAM_STR);
                $sql2->bindValue(":id", $id);
                $sql2->bindValue(":correc", $correct);
                $sql2->execute();

            }

        }
        echo '<script type="text/javascript">';
        echo 'alert("Pergutas e Respostas Submetidas com Sucesso");';
        echo 'window.location.href = "question.php";';
        echo '</script>';

        return true;
      }

?>