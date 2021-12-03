<?php
Class Usuario {

    //public $pdo;
    public $msgErro="";

//$u->conectar("lifelife_dbgame","51.38.121.199","lifelife_balango","Balango@dev1");
//    public $pdo;

    public function conectar($banco="oneclick_dbgame", $hostname="51.38.118.179", $usuario="oneclick_balango", $senha="Balango@dev1" ){
    global $pdo;
       
try{
    $pdo = new PDO("mysql:dbname=".$banco.";host=".$hostname,$usuario,$senha);
  
    $pdo->query("SET NAMES 'utf8'");
    $pdo->query('SET character_set_connection=utf8');
    $pdo->query('SET character_set_client=utf8');
    $pdo->query('SET character_set_results=utf8');
}catch (PDOException $e){
    $msgErro = $e ->getMessage();
}

    }
    
    public function challenge($nome_challenge,$estado){
        $this->conectar();
        global $pdo;
        //Verificar se ja existe o Challenge cadastrado
        $sql = $pdo->prepare("SELECT id_challenge FROM tb_challenges WHERE nome_challenge = :n");
        $sql->bindValue(":n",$nome_challenge);
        $sql->execute();
        if ($sql->rowCount() >0){
            return false; //challenge cadastrado
        }else{
            //caso nao,cadastrado
            $sql = $pdo->prepare("INSERT INTO tb_challenges (nome_challenge, estado) VALUES (:n, :t)");
            $sql->bindValue(":n", $nome_challenge);
            $sql->bindValue(":t",$estado);
            $sql->execute();
            return true;

        }

    }
    
    public function login($email_admin, $password_admin){
        $this->conectar();
        global $pdo;
        //verificar se o email e senha estao cadastrados
        $sql = $pdo->prepare("SELECT id_admin,nome_admin FROM tb_admin WHERE email_admin = :e AND password_admin = :s");
        $sql->bindValue(":e",$email_admin);
        $sql->bindValue(":s",md5($password_admin));
        $sql->execute();
        if($sql->rowCount() > 0){
            $dados = $sql->fetch();
            session_start();
            //pegando os dados do usuário ao iniciar a sessão
            $_SESSION['id_usuario'] = $dados['id_admin'];
            $_SESSION['nome_usuario'] = $dados['nome_admin'];

            return true; //login feito com sucesso
        }else{
return false; //nao foi possivel fazer o login
        }
    }
    public function listar(){
        $this->conectar();
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM tb_challenges");
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }
    public function studety(){
        $this->conectar();
        global $pdo;
        $sql = $pdo->prepare("SELECT al.*, na.nome_nivel FROM tb_alunos al INNER JOIN tb_nivel_acad na ON na.id_nivel_acad=al.id_nivel_acad ORDER BY al.nome_aluno ASC");
        $sql->execute();
        $result =$sql->fetchAll();
        return $result;
    }
    public function challenge_status($id){
        $this->conectar();
        global $pdo;
        $id=$_GET["id"];
        $sql = $pdo->prepare("SELECT po.pontuacao,al.nome_aluno,al.apelido_aluno,nj.numero_nivel_jogo,ch.nome_challenge,po.data FROM `tb_pontuacao` po INNER JOIN `tb_alunos` al ON po.id_aluno=al.id_aluno INNER JOIN `tb_nivel_jogo` nj ON po.id_nivel_jogo=nj.id_nivel_jogo INNER JOIN `tb_challenges` ch ON po.id_challenge=ch.id_challenge WHERE ch.id_challenge=$id  ORDER BY nj.numero_nivel_jogo DESC,po.pontuacao DESC, po.data DESC");
//        $sql->bindValue(":id", $id,PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }
    public function search($id_nivel_acad){
        $this->conectar();
        global $pdo;
        $sql = $pdo->prepare("SELECT nj.numero_nivel_jogo, ch.nome_challenge FROM `tb_nivel_acad_challenge` nac INNER JOIN `tb_challenges` ch ON nac.id_challenge=ch.id_challenge INNER JOIN `tb_nivel_jogo`nj ON nj.id_nivel_acad_challenge=nac.id_nivel_acad_challenge WHERE nac.id_nivel_acad_challenge=:id");
        $sql->bindValue(":id",$id_nivel_acad);
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }

    public function nivelacad(){
        $this->conectar();
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM `tb_nivel_acad`");
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }

    public  function challenges(){
        $this->conectar();
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM tb_challenges");
        $sql->execute();
        $result = $sql->fetchAll();
        return $result;
    }

    public function niveis($id_nivel_acad){
       $this->conectar();
       global $pdo;
//       $id_nivel_jogo=$_GET['id_nivel_jogo'];
       $sql = $pdo->prepare("SELECT nj.numero_nivel_jogo,ch.id_challenge,nj.id_nivel_jogo ,ch.nome_challenge FROM `tb_nivel_jogo` nj INNER JOIN `tb_nivel_acad_challenge`nac ON nj.id_nivel_acad_challenge=nac.id_nivel_acad_challenge INNER JOIN `tb_challenges` ch ON nac.id_challenge=ch.id_challenge INNER JOIN `tb_nivel_acad` na ON nac.id_nivel_acad=na.id_nivel_acad WHERE na.id_nivel_acad=:id");
       $sql->bindValue(":id",$id_nivel_acad);
       $sql->execute();
       $result = $sql->fetchAll();
       return $result;

    }
    public  function addchallenge($id_nivel_acad, $id_challenge){
        $this->conectar();
        global $pdo;
        $sql = $pdo->prepare("INSERT INTO tb_nivel_acad_challenge (`id_nivel_acad_challenge`, `id_nivel_acad`, `id_challenge`) VALUES (NULL, :id, :chall);");
        $sql->bindValue(":id",$id_nivel_acad,PDO::PARAM_INT);
        $sql->bindValue(":chall",$id_challenge,PDO::PARAM_INT);
        $add=$sql->execute();
        $id=$pdo->lastInsertId();
        $num=1;
        if ($add==1){
            $sql1 = $pdo->prepare("INSERT INTO tb_nivel_jogo (`id_nivel_jogo`, `id_nivel_acad_challenge`, `numero_nivel_jogo`) VALUES (NULL, :id, :num);");
            $sql1->bindValue(":id",$id,PDO::PARAM_INT);
            $sql1->bindValue(":num",$num);
            $sql1->execute();
        }
        return true;
    }

    public function  actualizarchall($id_challenge,$estado){
        $this->conectar();
        global $pdo;
        $sql =$pdo->prepare("UPDATE tb_challenges SET estado=:estd WHERE id_challenge=:chall");
        $sql->bindValue(":chall",$id_challenge,PDO::PARAM_INT);
        $sql->bindValue(":estd",$estado,PDO::PARAM_INT);
        $sql->execute();
        return true;
    }
//    public function seacrhstudety($studety){
//        $this->conectar();
//        global $pdo;
//        $sql=$pdo->prepare("SELECT * FROM tb_alunos al WHERE al.nome_aluno  LIKE '%:nome%' OR al.apelido_aluno LIKE '%:nome%'");
//        $sql->bindValue(":nome",$studety,PDO::PARAM_STR);
//        $sql->execute();
//        $result=$sql->fetchAll();
//        return $result;
//    }
    //SELECT * FROM tb_alunos al WHERE al.nome_aluno  LIKE '%ed%' OR al.apelido_aluno LIKE '%ed%'

    public  function upchallenge($nome_challenge,$id_challenge){
        $this->conectar();
        global $pdo;
        $sql = $pdo->prepare("UPDATE tb_challenges SET nome_challenge=:nome WHERE id_challenge=:chall");
        $sql ->bindValue(":nome",$nome_challenge,PDO::PARAM_STR);
        $sql ->bindValue(":chall",$id_challenge,PDO::PARAM_INT);
        $sql->execute();
        return true;
    }

    public function getAllPosts($id=null, $njogo=null, $id_challenge=null){

        $this->conectar();
        global $pdo;

        $sql =$pdo->prepare("SELECT na.id_nivel_acad, na.nome_nivel, nj.numero_nivel_jogo,nj.id_nivel_jogo, pe.id_pergunta, pe.pergunta, re.resposta, re.verdadeira_resposta FROM tb_responta re INNER JOIN tb_pergunta pe ON pe.id_pergunta = re.id_pergunta INNER JOIN tb_nivel_jogo nj ON nj.id_nivel_jogo = pe.id_nivel_jogo INNER JOIN tb_nivel_acad_challenge nac ON nac.id_nivel_acad_challenge = nj.id_nivel_acad_challenge INNER JOIN tb_nivel_acad na ON na.id_nivel_acad = nac.id_nivel_acad WHERE nac.id_nivel_acad = :nivel AND nj.numero_nivel_jogo = :njogo AND nac.id_challenge = :chall");
        $sql->bindValue(":nivel",$id);
        $sql->bindValue(":njogo",$njogo);
        $sql->bindValue(":chall",$id_challenge);
        $sql->execute();
        $result= $sql->fetchAll(PDO::FETCH_ASSOC);
        $numresults= count($result);

 //        echo "<pre>";
 //        print_r($result);
 //        echo "</pre>";
 //        exit;
 
        
//    $executar_query = mysqli_query($obj->con, $query);
//    $numresults = mysqli_num_rows($executar_query);
//    $id_nivel_acad, $numero_nivel_jogo
//    fetch(PDO::FETCH_ASSOC)
       
         $first = true;
         $counter = 0; //Contador para saber quando for o último registro.
         $niveis_jogo = array(); //Armazena todas as perguntas e respostas de um determinado nível.
         $uma_pergunta=null;
         foreach ($result as $item){
             $correct = $item['verdadeira_resposta'] == 1 ? 1 : 0; //1 - Verdadeira; 0 - Falsa.
 
             if ($first){ //Entra somente no primeiro ciclo.
                 $id_pergunta = $item['id_pergunta']; //Armazena o id da primeira pergunta na variável
                 $respostas = array(); //Aramazena todas as respostas de um determinada pergunta.
                 $cont_resposta = 0; //Numera as respostas. Ex: 1, 2, 3..
                 $cont_pergunta = 0; //Numera as perguntas. Ex: 1, 2, 3..
                 $first = false;
             }
 
             if ($id_pergunta == $item['id_pergunta']){ //Compara id_pergunta com o valor id_pergunta do ciclo.
                 $cont_resposta = $cont_resposta + 1;
                 $respostas[] = array('id' => $cont_resposta, 'res' => $item['resposta'], 'correct' => $correct); //Insere a resposta no array
                 $uma_pergunta = $item['pergunta'];
             }else{
                 $id_pergunta = $item['id_pergunta']; //Atribui novo valor ao id_pergunta
                 $cont_pergunta = $cont_pergunta + 1;
                 $pergunta = array('id' => $cont_pergunta, 'pergunta' => $uma_pergunta, 'resposta' => $respostas); //Cria o array da pergunta
                 $niveis_jogo[$cont_pergunta] = $pergunta; //Insere a pergunta no array nível do jogo
                 $respostas = array(); //Reset array de respostas, porque passa aqui para outra pergunta
                 $cont_resposta = 1;
                 $respostas[] = array('id' => $cont_resposta, 'res' => $item['resposta'], 'correct' => $correct); //Insere a resposta no array na primeira vez depois da troca do id_pergunta
             }
 
             if (++$counter == $numresults) { //Incrementa o contrador e compara com o número de linhas retornadas pela query.
                 //Entra no último registro.
                 $cont_pergunta = $cont_pergunta + 1;
                 $pergunta = array('id' => $cont_pergunta, 'pergunta' => $uma_pergunta, 'resposta' => $respostas); //Cria o array da pergunta
                 $niveis_jogo[$cont_pergunta] = $pergunta; //Insere a pergunta no array nível do jogo
             }
         }
//        echo "<pre>";
//        print_r($niveis_jogo);
//        echo "</pre>";

        if(!isset($result[0]['id_nivel_jogo'])){
//            echo "Estamos Aqui9";
            $sql=$pdo->prepare("SELECT id_nivel_jogo FROM tb_nivel_jogo nj INNER JOIN tb_nivel_acad_challenge nac ON nj.id_nivel_acad_challenge=nac.id_nivel_acad_challenge INNER JOIN tb_nivel_acad na ON nac.id_nivel_acad=na.id_nivel_acad INNER JOIN tb_challenges ch ON nac.id_challenge=ch.id_challenge WHERE nac.id_nivel_acad = :nivel AND nac.id_challenge=:chall");
            $sql->bindValue(":nivel", $id);
            $sql->bindValue(":chall", $id_challenge);
            $sql->execute();
            $resultado= $sql->fetch();
            $result[0]=$resultado;
//            echo $result[0]['id_nivel_jogo'];
//            echo "Estamos Aqui98";
        }

 return array('id_nivel_jogo'=>$result[0]['id_nivel_jogo'], "niveis_jogo"=>$niveis_jogo);
 
         }

 }

?>