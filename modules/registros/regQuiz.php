<?php
session_start();
require "../quiz/Quiz.php";
require "../ranking/Ranking.php";
require "../answer/Answer.php";
require "../alternatives/Alternative.php";
require "../category/Category.php";
require "../question/Question.php";
require "../user/User.php";
require "../../db/MySql.php";
$quiz = new Quiz();
$answer = new Answer();
$alternative = new Alternative();
$category = new Category();
$question = new Question();
$user = new User();
$ranking = new Ranking();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>criar quiz</title>
</head>
<body>
    <form action="" method="post">
        <label for="nomeQuiz">nome do quiz</label>
        <input type="text" name="nomeQuiz" id="">
        <label for="descricaoQuiz">descrição do quiz</label>
        <input type="text" name="descricaoQuiz" id="">
        <label for="tipoQuiz">tipo do quiz</label>
        <select name="tipoQuiz">
            <option value="valor1">formulário</option>
            <option value="valor2">prova </option>
        </select>
        <label for="valorQuiz">valor do quiz</label>
        <input type="number" name="valorQuiz" id="">
        <button type="submit" name="enviar">cadastrar quiz</button>
    </form>
</body>
</html>
<?php
if(isset($_POST["enviar"])){
    $titulo = $_POST["nomeQuiz"];
    $resumo = $_POST["descricaoQuiz"];
    $tipo = $_POST["tipoQuiz"];
    $score = $_POST["valorQuiz"];
    $publish = "data";
    $userId = $_GET["idUsuario"];
    var_dump($userId);
    $quiz->create(["titulo" => $titulo, "resumo" => $resumo, "tipo" => $tipo, "score" => $score, "publish" => $publish, "usuario_idUsuario" => $_SESSION["userId"]]);
    $_SESSION["quizId"] = $quiz->getPdo()->getConn()->lastInsertId();
    $ranking->create(["pontuacao" => 0, "Quiz_idquiz" => $quiz->pdo->getConn()->lastInsertId()]);
    // $lastId = $quiz->getPdo()->getConn()->lastInsertId();
    // $quizId = $quiz->selectById("*", "idQuiz = {$lastId}");
    session_write_close();
    header("location: regQuestion.php?idQuiz=" . $quizId);
}
// $sql = "select id from {$user->getTable()} where nome = {$nomeUser}";
// $idUser = $user->select($sql);
// o usuario (previamente já criado) vai preencher o forms do quiz, o sistema recebe esses parametros e joga no banco de dados para a criação
// SIMULAÇÃO:
// <form> conteudo aqui</form>
// if(isset($_POST[''])){recebe os dados do form
//$titulo = $_POST["];
//$resumo = $_POST[""];
//$tipo = $_POST[""];
// $score = $_POST[""];
// $publish = $_POST[""];
// $idUSer = $_POST[""];
//$quiz->create(["titulo" => $titulo, "resumo" => $resumo, "tipo" => $tipo, "score" => $score, "publish" => $publish, "usuario_idUsuario" => $idUser]);
// header("location: criarPergunta.php");
//}

