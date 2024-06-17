<?php
function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $dataNascimento = $_POST['dataNascimento'];
    $idade = $_POST['idade'];
    $cpf = $_POST['cpf'] . $_POST['digitoVerificador'];
    $projetosExperiencia = $_POST['projetosExperiencia'];

    if (!validarCPF($cpf)) {
        echo "<!DOCTYPE html>";
        echo "<html lang='pt-br'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Erro no Cadastro</title>";
        echo "</head>";
        echo "<body>";
        echo "<h1>CPF inválido.</h1>";
        echo "</body>";
        echo "</html>";
        exit;
    }

    $dados = "Nome: $nome\n";
    $dados .= "Sobrenome: $sobrenome\n";
    $dados .= "Data de Nascimento: $dataNascimento\n";
    $dados .= "Idade: $idade\n";
    $dados .= "CPF: $cpf\n";
    $dados .= "Projetos e Experiência:\n$projetosExperiencia\n";

    $arquivo = "curriculos/" . $cpf . ".txt";
    file_put_contents($arquivo, $dados);

    echo "<!DOCTYPE html>";
    echo "<html lang='pt-br'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Cadastro Realizado</title>";
        echo "</head>";
        echo "<body>";
        echo "<h1>Cadastro realizado com sucesso!</h1>";
        echo "</body>";
        echo "</html>";
    }
?>
