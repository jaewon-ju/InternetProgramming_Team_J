<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>영어 단어 관리</title>
</head>
<body>
    <h1>영어 단어 관리</h1>

    <h2>단어 검색</h2>
    <form method="get" action="word_control_search.php">
        <input type="text" name="search_word" placeholder="검색할 단어 또는 뜻">
        <button type="submit">검색</button>
    </form>

    <h2>단어 추가</h2>
    <form method="post">
        <input type="text" name="new_word" placeholder="추가할 단어">
        <input type="text" name="meaning" placeholder="뜻 추가">
        <button type="submit" name="add_word">추가</button>
    </form>
<?php
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['add_word'])) {
    $newWord = $_POST['new_word'];
    $meaning = $_POST['meaning'];

    $insertQuery = "INSERT INTO english_word (word, meaning) VALUES ('$newWord', '$meaning')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<p>단어가 성공적으로 추가되었습니다.</p>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<form method="post" action="control_word.php">
            <input type="submit" value="관리">
        </form>
</body>
</html>