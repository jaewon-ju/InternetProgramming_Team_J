<?php
session_start();

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
    $username = $_POST['u_id'];
    $password = $_POST['pwd'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // 사용자 역할에 따라 리다이렉트
            header("Location: main.php");
            exit();
        } else {
            echo "비밀번호가 일치하지 않습니다.";
        }
    } else {
        echo "사용자가 존재하지 않습니다.";
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
        <label for="username">아이디:</label>
        <input type="text" id="username" name="username" required><br>
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
