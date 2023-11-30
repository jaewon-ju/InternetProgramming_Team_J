<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Control</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        .control-word-button, .control-passage-button {
            width: 300px;
            height: 200px;
            color: black;
            cursor: pointer;
            font-size: 30px;
            font-weight: bolder;
            border: none;
            border-radius: 4px; 
            margin: 0px 30px;
            align-items: center; /* 추가: 가로 방향으로 중앙 정렬 */
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .control-word-button:hover, .control-passage-button:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

    <div class="button-container">
        <!-- 영단어 관리 버튼 -->
        <form action="control_word.php" method="post">
            <input class="control-word-button" type="submit" value="영단어 관리">
        </form>

        <!-- 모의고사 지문 관리 버튼 -->
        <form action="control_passage.php" method="post">
            <input class="control-passage-button" type="submit" value="모의고사 지문 관리">
        </form>
    </div>

</body>
</html>
