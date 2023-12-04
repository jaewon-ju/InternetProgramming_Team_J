<?php
session_start();

// 예시로 사용할 데이터베이스 연결 설정
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm'])) {
        if ($_POST['confirm'] === 'yes') {
            // "네"를 선택한 경우 회원 탈퇴 처리
            $id = $_SESSION['user_id'];
            $sql = "DELETE FROM users WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {
                // 탈퇴 성공 후 로그아웃 및 메시지 전송
                session_unset();
                session_destroy();
                $message = "회원 탈퇴가 완료되었습니다.";
                echo "<script>alert('$message'); window.location.href = 'main.php';</script>";
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // "이전으로"를 선택한 경우 main.php로 이동
            header("Location: main.php");
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
    <title>회원 탈퇴</title>
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

        .withdrawal-form {
            text-align: center;
        }

        h2 {
            color: #333;
        }

        p {
            margin: 10px 0;
            color: #666;
        }

        form{
            display:flex;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
            width: 150px;
            font-size: 14px;
        }

        button.yes {
            background-color: #dc3545;
            color: #fff;
        }

        button.yes:hover {
            background-color: #c82333;
        }

        button.no {
            background-color: #007BFF;
            color: #fff;
        }

        button.no:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="withdrawal-form">
            <h2>회원 탈퇴</h2>
            <p>회원을 탈퇴하시겠습니까?</p>
            <form action="" class = "form" method="post">
                <button type="submit" class = "no" name="confirm" value="no">이전으로</button>
                <button type="submit" class = "yes" name="confirm" value="yes">네, 탈퇴합니다.</button>
            </form>
        </div>
    </div>
</body>
</html>
