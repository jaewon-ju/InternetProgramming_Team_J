<?php
session_start();


// 예시로 사용할 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pre_password = $_POST['pre_password'];
    $new_password = password_hash($_POST['new_password'],PASSWORD_DEFAULT);
    $id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $username = $_SESSION['username'];

    $sql = "UPDATE users SET password = '$new_password' WHERE id = '$id'";
    $sql2 = "SELECT * FROM users WHERE id = '$id'";
    
   
        $result = $conn->query($sql2);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($pre_password, $row['password'])) {
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('비밀번호가 변경되었습니다.'); window.location.href = 'main.php';</script>";
                    exit();
                } else {

                }    
            } else {
                echo "<script>alert('비밀번호가 일치하지 않습니다.'); window.location.href = 'change_password.php';</script>";
                exit();
            }
         
    }
    

    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 변경</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        .change-password-form {
            text-align: center;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0;
            color: #666;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border-radius: 8px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="change-password-form">
            <h2>비밀번호 변경</h2>
            <form action="change_password.php" method="post">
                <label for="pre_password">현재 비밀번호</label>
                <input type="password" id="pre_password" name="pre_password" required>

                <label for="new_password">새로운 비밀번호</label>
                <input type="password" id="new_password" name="new_password" required>

                <button type="button" class="back-button" onclick="window.location.href='main.php'">이전으로</button>
                <button type="submit">비밀번호 변경</button>
            </form>
        </div>
    </div>
</body>
</html>

