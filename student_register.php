<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'student';

    $sql = "INSERT INTO users (name, student_id, username, password, role) VALUES ('$name', '$student_id', '$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        // 회원가입이 완료되면 로그인 페이지로 이동
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>학생 회원가입</title>
</head>
<body>
    <h2>학생 회원가입</h2>
    <form action="student_register.php" method="post">
        <label for="name">이름:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="student_id">학번:</label>
        <input type="text" id="student_id" name="student_id" required><br>
        <label for="username">아이디:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="가입">
    </form>
</body>
</html>
