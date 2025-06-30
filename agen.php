<?php
   
    require_once "conexao.bd.php";
    require_once "agenda_contatos.php";
    require_once "agenda.php";

class CadastroRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto($dados)
    {
        return new dados($dados['agenda_id'],
            $dados['agenda_nome'],
            $dados['agenda_telefone'],
            $dados['agenda_email'],
            $dados['agenda_data_nascimento']
           );
    }

    public function buscarTodos()
    {
        $sql= "SELECT * FROM agenda_contatos ";
        $statement= $this->pdo->query($sql);
        $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

         $todosOsDados = array_map(function ($agenda){
            return $this->formarObjeto($agenda);
        },$dados);

        return  $todosOsDados;
    }

    public function deletar(int $agenda_id)
    {
        $sql="DELETE FROM agenda_contatos WHERE agenda_id=?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $agenda_id);
        $statement->execute();
    }

    public function salvar(dados $cadastro)
        {
        $sql = "INSERT INTO agenda_contatos (agenda_nome,agenda_telefone,agenda_email,agenda_data_nascimento) VALUES (?,?,?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $cadastro->getNome());
        $statement->bindValue(2, $cadastro->getTelefone());
        $statement->bindValue(3, $cadastro->getEmail());
        $statement->bindValue(4, $cadastro->getNascimento());
        $statement->execute();
    }

    public function atualizar(dados $cadastro)
{
    $sql = "UPDATE agenda_contatos SET agenda_nome = ?, agenda_telefone = ?, agenda_email = ?, agenda_data_nascimento = ? WHERE agenda_id = ?";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(1, $cadastro->getNome());
    $statement->bindValue(2, $cadastro->getTelefone());
    $statement->bindValue(3, $cadastro->getEmail());
    $statement->bindValue(4, $cadastro->getNascimento());
    $statement->bindValue(5, $cadastro->getId());
    
    $statement->execute();
}

 public function buscar(int $agenda_id)
    {
        $sql = "SELECT * FROM agenda_contatos WHERE agenda_id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $agenda_id);
        $statement->execute();

        $dados = $statement->fetch(PDO::FETCH_ASSOC);

        return $this->formarObjeto($dados);
    }
}
