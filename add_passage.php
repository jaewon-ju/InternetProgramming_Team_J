<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Passage</title>
    <style>
    html{
        height: 100%;
    }
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: auto;
    }

    .form-container {
        position: relative;
        overflow: auto;
    }

    form {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 500px; /* 원하는 폭으로 조절 */
        text-align: center;
    }

    h2 {
        width: 100%;
        font-size: 70px;
        text-align: center;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input,
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        overflow: auto;
    }

    input[type="submit"] {
        background-color: #007BFF;
        color: #fff;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    footer {
            width : 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px; /* 수정된 부분: margin-top 추가 */
            bottom: 0;
        }
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");

// 테이블 생성 (모의고사 지문)
$sql_create_exam_texts = "CREATE TABLE IF NOT EXISTS exam_texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year INT NOT NULL,
    month INT NOT NULL,
    grade INT NOT NULL,
    number INT NOT NULL,
    passage TEXT NOT NULL,
    interpret TEXT NOT NULL
)";
$conn->query($sql_create_exam_texts);

// 폼에서 데이터를 받아와서 모의고사 지문 추가 또는 업데이트 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST['year']) &&
    isset($_POST['month']) &&
    isset($_POST['grade']) &&
    isset($_POST['number']) &&
    isset($_POST['passage']) &&
    isset($_POST['interpret'])) {

    $year = $_POST['year'];
    $month = $_POST['month'];
    $grade = $_POST['grade'];
    $number = $_POST['number'];
    $passage = $_POST['passage'];
    $interpret = $_POST['interpret'];

    // 중복 여부 확인을 위한 쿼리
    $checkDuplicateQuery = "SELECT COUNT(*) as count FROM exam_texts WHERE year = $year AND grade = $grade AND month = $month AND number = '$number'";
    $duplicateResult = $conn->query($checkDuplicateQuery);
    $duplicateCount = $duplicateResult->fetch_assoc()['count'];

    if ($duplicateCount > 0) {
        //CRUD: U
        // 중복된 경우 UPDATE 쿼리 수행
        $stmt = $conn->prepare("UPDATE exam_texts SET passage = ?, interpret = ? WHERE year = ? AND grade = ? AND month = ? AND number = ?");
        $stmt->bind_param("ssiiis", $passage, $interpret, $year, $grade, $month, $number);
        $stmt->execute();
        echo "<script>alert('중복된 지문이 업데이트되었습니다.');</script>";
    } else {
        //CRUD: C
        // 중복이 아닌 경우 INSERT 쿼리 수행
        $stmt = $conn->prepare("INSERT INTO exam_texts (year, month, grade, number, passage, interpret) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisss", $year, $month, $grade, $number, $passage, $interpret);
        $stmt->execute();
        echo "<script>alert('" . $year . "년 고" . $grade . " " . $month . "월 모의고사 " . $number . "번이 데이터베이스에 추가되었습니다.');</script>";
    }
    $stmt->close();
}

// 데이터베이스 연결 종료
$conn->close();
?>
<div class="form-container">
<h2>모의고사 지문 추가</h2>

<form action="add_passage.php" method="post">
    <label for="year">시행 연도</label>
    <input type="number" name="year" required>

    <label for="month">시행 월</label>
    <input type="number" name="month" required>

    <label for="grade">학년</label>
    <input type="number" name="grade" required>

    <label for="number">문제 번호</label>
    <input type="text" name="number" required>

    <label for="passage">원문</label>
    <textarea name="passage" rows="4" required></textarea>

    <label for="interpret">해석</label>
    <textarea name="interpret" rows="4" required></textarea>

    <input type="submit" value="추가">
</form>
</div>

<footer>
    <p>개인정보처리 방침 | 연락처 | 이름 등등</p>
    <a href="teacher.php" style = "color: white">처음으로 돌아가기</a>
    <p>&copy; 2023 Your Website</p>
</footer>
</body>
</html>
