import DataTable from 'datatables.net-dt'
import { ajax } from 'jquery';
$(document).ready(function(){
  let table = new DataTable('#myTable');
  
  $("#botao-cadastrar").click(function() {
    table= carregarDados();
    console.log("cara",table)
  })
  ajax({
    url:"agenda_contatos.php"
  })
});

$(document).ready(function(){
  carregarDados();

  $("#botao-cadastrar").click(function(bcad) {
    bcad.preventDefault();

    var dados = {
      agenda_id: $("#agenda_id").val() || null,
      agenda_nome: $("#agenda_nome").val(),
      agenda_telefone: $("#agenda_telefone").val(),
      agenda_email: $("#agenda_email").val(),
      agenda_data_nascimento: $("#agenda_data_nascimento").val()
    };

    if (dados.agenda_id) {
      dados.editar = true;
    }else{
        dados.cadastre = true;
    }

    console.log('dados:', dados);
    $.ajax({
      url: "agenda_contatos.php",
      type: "POST",
      data: dados,
      success: function(response) {
        alert("sucesso");
        limpa();
        carregarDados();
      },
      error: function() {
        alert("Erro");
      }
    });
});

$("tbody").on("click", ".botao-editar", function () {
    var id = $(this).data("id");
    $.ajax({
      url: "agenda_contatos.php",
      type: "POST",
      data: { buscar_edicao: 'true', agenda_id: id },
      dataType: 'json',
      success: function (data) {
        $("#agenda_id").val(data.agenda_id);
        $("#agenda_nome").val(data.agenda_nome);
        $("#agenda_telefone").val(data.agenda_telefone);
        $("#agenda_email").val(data.agenda_email);
        $("#agenda_data_nascimento").val(data.agenda_data_nascimento);
      },
      error: function () {
        alert("erro dados para edição");
      }
    });
  });

$("tbody").on("click", ".botao-excluir", function () {
    if (!confirm("Tem certeza que deseja excluir?")) return;
    var id = $(this).data("id");
    $.ajax({
      url: "agenda_contatos.php",
      type: "POST",
      data: { excluir: id},
      success: function () {
        alert("Contato excluído com sucesso");
        carregarDados();
      },
      error: function() {
        alert("Erro ao excluir os dados");
      }
    });
  });
  
  function NovaLinha(item) {
    var linha = $("<tr>");
    linha.append($("<td>").text(item.agenda_nome));
    linha.append($("<td>").text(item.agenda_telefone));
    linha.append($("<td>").text(item.agenda_email));
    linha.append($("<td>").text(item.agenda_data_nascimento));

    var btnE = $("<button>")
      .text("Editar")
      .addClass("botao-editar")
      .attr("data-id", item.agenda_id);
    var btnX = $("<button>")
      .text("Excluir")
      .addClass("botao-excluir")
      .attr("data-id", item.agenda_id);

    

    linha.append($("<td>").append(btnE).append(" ").append(btnX));
    return linha;
  }

function carregarDados() {
    $.ajax({
      url: 'agenda_contatos.php',
      type: 'POST',
      dataType: 'json',
      success: function (data) {
        console.log('click',data)
        var tbody = $("tbody").empty();
        data.forEach(item => tbody.append(NovaLinha(item)));
      },
      error: function () {
        alert('Erro ao carregar os dados.');
      }
    });
  }
  function limpa() {
    $("#agenda_id, #agenda_nome, #agenda_telefone, #agenda_email, #agenda_data_nascimento").val("");
  }
   
});