

<?php
require_once "conexao.bd.php";      
require_once "agenda.php";          
require_once "agen.php";            

$cadastroRepositorio = new CadastroRepositorio($pdo);

if (isset($_POST['buscar_edicao'])) {
    $cad = $cadastroRepositorio->buscar((int) $_POST['agenda_id']);
    echo json_encode([
        'agenda_id'              => $cad->getId(),
        'agenda_nome'            => $cad->getNome(),
        'agenda_telefone'        => $cad->getTelefone(),
        'agenda_email'           => $cad->getEmail(),
        'agenda_data_nascimento' => $cad->getNascimento(),
    ]);
    exit;
}

if (!empty($_POST['editar']) && !empty($_POST['agenda_id'])) {
    $dados = new dados(
        $_POST['agenda_id'],
        $_POST['agenda_nome'],
        $_POST['agenda_telefone'],
        $_POST['agenda_email'],
        $_POST['agenda_data_nascimento']
    );
    $cadastroRepositorio->atualizar($dados);
    echo "sucesso";
    exit;
}

if (isset($_POST['excluir'])) {
    $cadastroRepositorio->deletar((int) $_POST['excluir']);
    echo "sucesso";
    exit;
}

if (isset($_POST['cadastre'])) {
   $data_formatada = !empty($_POST['agenda_data_nascimento']) ? $_POST['agenda_data_nascimento'] : null;
    
    $cadastro = new dados(
        null,
        $_POST['agenda_nome'],
        $_POST['agenda_telefone'],
        $_POST['agenda_email'],
        $data_formatada
    );
    $cadastroRepositorio->salvar($cadastro);
    echo "sucesso";
    exit;
}
$lista = $cadastroRepositorio->buscarTodos();
$result = array_map(function($cadastro){
    return [
      'agenda_id'              => $cadastro->getId(),
      'agenda_nome'            => $cadastro->getNome(),
      'agenda_telefone'        => $cadastro->getTelefone(),
      'agenda_email'           => $cadastro->getEmail(),
      'agenda_data_nascimento' => $cadastro->getNascimento(),
    ];
}, $lista);
echo json_encode($result);
exit;
