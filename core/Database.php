<?php


class Database
{

    private $db = 'jaketa';
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $pdo;

    //================================================================
    // FUNÇÃO DE CONEXÃO COM O BANCO DE DADOS
    public function __construct()
    {
        try {

            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);

            return $this->pdo;
        } catch (PDOException $e) {

            return false;
        }
    }

    //================================================================
    // FUNÇÃO PARA CADASTRAR UM USUARIO MEDIANTE A CHAVE DE SEGURANÇA
    public function cad_user($chave, $login, $senha)
    {
        $key = '1234';

        if ($chave == $key) {

            $cmd = $this->pdo->prepare("INSERT INTO users(user,senha)VALUES(:l, :s)");
            $cmd->bindValue(":l", $login);
            $cmd->bindValue(":s", $senha);
            $cmd->execute();

            header("location: ../index.php");
            exit;
        }
    }
    //================================================================
    // FUNÇÃO DE AUTENTICAÇÃO DE LOGIN
    public function login($login, $senha)
    {
        //BUSCA TODOS OS USUARIOS CADASTRADOS NO BANCO DE DADOS
        $cmd = $this->pdo->prepare("SELECT * FROM users WHERE user = :l AND senha = :s");
        $cmd->bindValue(":l", $login);
        $cmd->bindValue(":s", $senha);
        $cmd->execute();

        $cmd->fetchAll(PDO::FETCH_ASSOC);

        if ($cmd->rowCount() > 0) {
            //SE ENCONTRAR O USUARIO NO BANCO DARA ACESSO AO DASHBOARD     
            header("location: views/dashboard.php");
        } else if ($cmd->rowCount() <= 0) {
            // SE NÃO EMITIRA UM ALERTA
            echo '<br>';
            echo '<div id="alertDiv" class="alert alert-danger" role="alert" style="text-align:center">';
            echo 'USUÁRIO OU SENHA INCORRETO, POR FAVOR, TENTE NOVAMENTE';
            echo '</div>';
            echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
            die();
        }
    }
    //================================================================
    //FUNÇÃO PARA CADASTRAR UM PRODUTO
    public function cad_produto($nome, $modelo, $cor, $quantidade, $foto)
    {
        // VERIFICA SE JÁ EXISTE UM ITEM IGUAL CADASTRADO
        $cmd = $this->pdo->prepare("SELECT id, quantidade FROM produtos WHERE nome = :n AND modelo = :m AND cor = :c");
        $cmd->bindValue(':n', $nome);
        $cmd->bindValue(':m', $modelo);
        $cmd->bindValue(':c', $cor);
        $cmd->execute();

        $res = $cmd->fetch(PDO::FETCH_ASSOC);


        if ($res !== false) {
            // SE JÁ EXISTIR, ALTERA APENAS A QUANTIDADE
            $qtd = $res['quantidade'];
            $id = $res['id'];
            $total = $qtd + $quantidade;

            $updateCmd = $this->pdo->prepare("UPDATE produtos SET quantidade = :total WHERE id = :id");
            $updateCmd->bindValue(':total', $total);
            $updateCmd->bindValue(':id', $id);
            $updateCmd->execute();

            echo '<br>';
            echo '<div id="alertDiv" class="alert alert-success" role="alert" style="text-align:center">';
            echo 'PRODUTO CADASTRADO COM SUCESSO !!';
            echo '</div>';
            echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
        } else {
            // SE NÃO EXISTIR, CADASTRA UM NOVO PRODUTO
            $insertCmd = $this->pdo->prepare("INSERT INTO produtos (nome, modelo, cor, quantidade,foto) VALUES (:n, :m, :c, :q, :f)");
            $insertCmd->bindValue(':n', $nome);
            $insertCmd->bindValue(':m', $modelo);
            $insertCmd->bindValue(':c', $cor);
            $insertCmd->bindValue(':q', $quantidade);
            $insertCmd->bindValue(':f', $foto['tmp_name']);

            // Gera um nome único para a foto
            $nomeFoto = uniqid() . '_' . strtolower(trim($foto['name']));

            // Salva a foto na pasta "fotos"
            move_uploaded_file($foto['tmp_name'], 'fotos/' . $nomeFoto);

            $insertCmd->bindValue(':f', $nomeFoto);

            $insertCmd->execute();

            echo '<br>';
            echo '<div id="alertDiv" class="alert alert-success" role="alert" style="text-align:center">';
            echo 'PRODUTO CADASTRADO COM SUCESSO !!';
            echo '</div>';
            echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
        }
    }
    //================================================================

    //FUNÇÃO PARA VER O ESTOQUE DE PRODUTOS
    public function listar_produtos()
    {
        $stmt = $this->pdo->query("SELECT * FROM produtos");
        $produtos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produto = [
                'nome' => $row['nome'],
                'modelo' => $row['modelo'],
                'cor' => $row['cor'],
                'quantidade' => $row['quantidade'],
                'id' => $row['id'],
                'foto' => $row['foto']
            ];
            $produtos[] = $produto;
        }

        return $produtos;
    }
    //================================================================

    // FUNÇAO PARA PESQUISA DE PRODUTOS
    public function buscar_produto($pesquisa)
    {
        $pesquisas = explode(" ", $pesquisa);
        $nome = $pesquisas[0] ?? '';
        $modelo = $pesquisas[1] ?? '';

        $sql = "SELECT * FROM produtos WHERE nome LIKE :name";
        $params = ['name' => "%$nome%"];

        if (!empty($modelo)) {
            $sql .= " AND modelo LIKE :model";
            $params['model'] = "%$modelo%";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //================================================================

    public function saida_produto($nome, $modelo, $cor, $quantidade)
    {
        // VERIFICA SE JÁ EXISTE UM ITEM IGUAL CADASTRADO
        $cmd = $this->pdo->prepare("SELECT id, quantidade FROM produtos WHERE nome = :n AND modelo = :m AND cor = :c");
        $cmd->bindValue(':n', $nome);
        $cmd->bindValue(':m', $modelo);
        $cmd->bindValue(':c', $cor);
        $cmd->execute();

        $res = $cmd->fetch(PDO::FETCH_ASSOC);


        if ($res !== false && $res['quantidade'] > 0) {
            // SE JÁ EXISTIR, ALTERA APENAS A QUANTIDADE
            $qtd = $res['quantidade'];
            $id = $res['id'];
            if($qtd >= $quantidade){

                $total = $qtd - $quantidade;

                $updateCmd = $this->pdo->prepare("UPDATE produtos SET quantidade = :total WHERE id = :id");
                $updateCmd->bindValue(':total', $total);
                $updateCmd->bindValue(':id', $id);
                $updateCmd->execute();

                echo '<br>';
                echo '<div id="alertDiv" class="alert alert-success" role="alert" style="text-align:center">';
                echo 'SAIDA FEITA COM SUCESSO !!';
                echo '</div>';
                echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
            }else{
                echo '<br>';
                echo '<div id="alertDiv" class="alert alert-danger" role="alert" style="text-align:center">';
                echo 'QUANTIDADE MAIOR DO QUE O ESTOQUE !!';
                echo '</div>';
                echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
            }
            
        } else {
            // SE NÃO EXISTIR, CADASTRA UM NOVO PRODUTO
            echo '<br>';
            echo '<div id="alertDiv" class="alert alert-danger" role="alert" style="text-align:center">';
            echo 'NÃO EXISTE PRODUTO PARA SER REMOVIDO !!';
            echo '</div>';
            echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
        }
    }


    //================================================================
    function excluir_produto($id)
    {

        $cmd = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
        $cmd->bindValue(':id', $id);
        $cmd->execute();
    }
    //================================================================

    public function buscar_editar($id){
        $cmd = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
        
    }

    //================================================================
    //FUNÇÃO PARA EDITAR UM PRODUTO
    public function editar_produto($id, $nome, $modelo, $cor, $quantidade, $foto)
    {
       
            // UPDATE DO PRODUTO
            $insertCmd = $this->pdo->prepare("UPDATE produtos SET nome = :n, modelo = :m, cor = :c, quantidade = :q, foto = :f WHERE id = :id");
            $insertCmd->bindValue(':id', $id);
            $insertCmd->bindValue(':n', $nome);
            $insertCmd->bindValue(':m', $modelo);
            $insertCmd->bindValue(':c', $cor);
            $insertCmd->bindValue(':q', $quantidade);
            $insertCmd->bindValue(':f', $foto['tmp_name']);

            // Gera um nome único para a foto
            $nomeFoto = uniqid() . '_' . strtolower(trim($foto['name']));

            // Salva a foto na pasta "fotos"
            move_uploaded_file($foto['tmp_name'], 'fotos/' . $nomeFoto);

            $insertCmd->bindValue(':f', $nomeFoto);

            $insertCmd->execute();

            // echo '<br>';
            // echo '<div id="alertDiv" class="alert alert-success" role="alert" style="text-align:center">';
            // echo 'PRODUTO EDITADO COM SUCESSO !!';
            // echo '</div>';
            // echo '<script>
            //     setTimeout(function() {
            //         document.getElementById("alertDiv").style.display = "none";
            //     }, 4000);
            //   </script>';

        }
    


    //================================================================



} ///fim da classe
