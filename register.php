<?php
// 회원가입 처리 로직을 추가해야 합니다.

// 예시로 사용할 데이터베이스 연결 설정
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");


$tableCreationSQL = "CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(255) PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher') DEFAULT 'student'
)";

$conn->query($tableCreationSQL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $id = $_POST['id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $same_id_sql = "SELECT id FROM users WHERE id='$id'";
    $sql = "INSERT INTO users (id, username, password, role) VALUES ('$id', '$username', '$password', '$role')";

    $result = $conn->query($same_id_sql);

    // 중복된 아이디가 존재하면 회원가입 처리를 하지 않음
    if ($result->num_rows > 0) {
        echo "<script>alert('이미 사용중인 아이디입니다.'); window.location.href = 'register.php';</script>";
        exit();
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('회원가입이 완료되었습니다.'); window.location.href = 'login.php';</script>";
        exit();
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }

    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>회원가입</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .register-form {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
        }

        .register-form h2 {
            text-align: center;
            color: #333;
        }

        .register-form form {
            display: flex;
            flex-direction: column;
        }

        .register-form label {
            margin-bottom: 5px;
            color: #555;
        }

        .register-form input {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .register-form button {
            width: 100%;
            padding: 10px;
            margin-top:15px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .register-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-form">
            <h2>회원가입</h2>
            <form action="register.php" method="post">
                <label for="username">이름:</label>
                <input type="text" id="username" name="username" required>

                <label for="id">사용자 ID:</label>
                <input type="text" id="id" name="id" required>

                <label for="password">비밀번호:</label>
                <input type="password" id="password" name="password" required>

                <label for="role">역할 선택:</label>
                <select id="role" name="role" required>
                    <option value="student">학생</option>
                    <option value="teacher">선생님</option>
                </select>

                <button type="submit">회원가입</button>
            </form>
        </div>
    </div>
</body>
</html>

