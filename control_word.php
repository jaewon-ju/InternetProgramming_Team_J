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
if (isset($_POST['add_word']) && !isset($_SESSION['form_processed'])) {
    // 단어를 데이터베이스에 추가하는 코드를 여기에 작성하세요.
    $newWord = $_POST['new_word'];
        $meaning = $_POST['meaning'];

        $insertQuery = "INSERT INTO english_word (word, meaning) VALUES ('$newWord', '$meaning')";
    
        if ($conn->query($insertQuery) === TRUE) {
            echo "단어 추가 완료";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    // 폼이 처리되었음을 표시하기 위해 세션 변수 설정
    $_SESSION['form_processed'] = true;

    // 단어 추가 후, 반복적인 제출을 방지하기 위해 같은 페이지로 리디렉션
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit(); // 리디렉션 후 스크립트 종료
}
// Count the total number of words in the table
$countQuery = "SELECT COUNT(*) as total_words FROM english_word";
$countResult = $conn->query($countQuery);
$totalWords = 0;
if ($countResult && $countResult->num_rows > 0) {
    $row = $countResult->fetch_assoc();
    $totalWords = $row['total_words'];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>영어 단어 관리</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], button {
            padding: 8px;
            margin-right: 10px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>영어 단어 관리</h1>

    <h2>단어 검색 (총 단어 개수: <?php echo $totalWords; ?>개)</h2>
    <form method="get" action="control_word_search.php">
        <input type="text" name="search_word" placeholder="검색할 단어 또는 뜻">
        <button type="submit">검색</button>
    </form>

    <h2>단어 추가</h2>
    <form method="post">
        <input type="text" name="new_word" placeholder="추가할 단어">
        <input type="text" name="meaning" placeholder="뜻 추가">
        <button type="submit" name="add_word">추가</button>
    </form>
    
    <form method="post" action="control_data.php">
        <input type="submit" value="관리" style="padding: 8px 15px; background-color: #28a745; color: white; border: none; cursor: pointer;">
    </form>



</body>
</html>
