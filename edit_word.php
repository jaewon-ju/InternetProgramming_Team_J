<?php
session_start();

$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['turn']) && isset($_GET['word']) && isset($_GET['meaning'])) {
    $wordId = $_GET['turn'];
    $editedWord = $_GET['word'];
    $editedMeaning = $_GET['meaning'];

    // 단어와 뜻 업데이트 쿼리
    $updateQuery = "UPDATE english_word SET word = '$editedWord', meaning = '$editedMeaning' WHERE turn = $wordId";

    if ($conn->query($updateQuery) === TRUE) {
        echo "단어가 성공적으로 업데이트되었습니다.";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // 리디렉션을 통해 control_word_search.php로 자동 이동
    echo '<script>window.location.href = "control_word.php";</script>';
}

$conn->close();
?>