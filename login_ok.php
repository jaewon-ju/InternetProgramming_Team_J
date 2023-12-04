<?php
session_start();

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableCreationSQL = "
CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(255) PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher') DEFAULT 'student'
)";

// 테이블 생성 쿼리 실행
if ($conn->query($tableCreationSQL) === TRUE) {
    echo "테이블이 성공적으로 생성되었습니다.";
} else {
    echo "테이블 생성 오류: " . $conn->error;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['u_id'];
    $password = $_POST['pwd'];
    $role = $_POST['role'];

    $sql = "SELECT id, username, password, role FROM users WHERE id = '$id' AND role = '$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: main.php");
            exit();
        } else {
            echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.'); window.location.href = 'login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.'); window.location.href = 'login.php';</script>";
        exit();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>로그인</title>
</head>
<body>
    <h2>로그인</h2>
    <form action="login.php" method="post">
        <label for="id">아이디:</label>
        <input type="text" id="id" name="id" required><br>
        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required><br>

        <!-- 학생과 선생님 선택 옵션 추가 -->
        <label for="role">역할 선택:</label>
        <select id="role" name="role" required>
            <option value="student">학생</option>
            <option value="teacher">선생님</option>
        </select><br>

        <input type="submit" value="로그인">
    </form>
    <p>계정이 없으신가요? <a href="register.php">회원가입</a></p>
</body>
</html>
