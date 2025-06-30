<?php
class dados{
private ?int $agenda_id;
private string $agenda_nome;
private int $agenda_telefone;
private string $agenda_email;
private string $agenda_data_nascimento;

public function __construct(?int $agenda_id, string $agenda_nome, int $agenda_telefone, string $agenda_email, string $agenda_data_nascimento)
{
    $this->agenda_id = $agenda_id;
    $this->agenda_nome = $agenda_nome;
    $this->agenda_telefone =$agenda_telefone;
    $this->agenda_email =$agenda_email;
    $this->agenda_data_nascimento =$agenda_data_nascimento;

}
    public function getId(){
        return $this->agenda_id;
    }

    public function getNome(){
        return $this->agenda_nome;
    }

     public function getTelefone(){
        return $this->agenda_telefone;
    }

     public function getEmail(){
        return $this->agenda_email;
    }

     public function getNascimento(){
        return $this->agenda_data_nascimento;
    }
}
?>
