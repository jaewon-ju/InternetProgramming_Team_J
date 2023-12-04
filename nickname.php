<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background-color: #f7f7f7;
        }

        .page-container {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Nunito', sans-serif;
            background-color: #f7f7f7;
        }

        .quiz-description {
            background-color: #fff;
            margin-bottom: 10px;
            border-radius: 10px;
            padding: 20px;
            border: 2px solid #ccc;
        }

        /* 닉네임 입력 폼 스타일 */
        .nickname-form {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nickname-form h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .nickname-form input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 250px;
            font-size: 16px;
            outline: none;
        }

        .nickname-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition-duration: 0.4s;
        }

        .nickname-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .footer {
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="page-container">

    <div class="nickname-form"> <!-- 닉네임 입력 폼 -->
        <h2>퀴즈를 시작하기 전에 닉네임을 입력하세요.</h2>
        <form method="post" action="word_quiz.php">
    <input type="text" name="user_name" placeholder="닉네임을 입력하세요" required>
    <br>
    <input type="submit" value="시작하기">
</form>
    </div>

    <div class="footer">
        <p>&copy; 2023 홈페이지. All rights reserved.</p>
    </div>
</div>

</body>
</html>
