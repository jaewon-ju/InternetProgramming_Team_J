<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher 페이지</title>
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

        .data-control-button, .make-file-button {
            width: 200px;
            height: 200px;
            color: black;
            cursor: pointer;
            font-size: 30px;
            font-weight: bolder;
            border: none;
            border-radius: 4px;
            margin: 0 10px;
            display: flex; /* 추가: 세로 정렬을 위해 flex 속성 추가 */
            flex-direction: column; /* 추가: 세로 방향으로 정렬 */
            align-items: center; /* 추가: 가로 방향으로 중앙 정렬 */
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .data-control-button {
            background: url('image1.png') no-repeat;
            background-size: contain;
        }

        .make-file-button {
            background: url('image2.jpg') no-repeat;
            background-size: contain;
        }

        .data-control-button:hover, .make-file-button:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

    <div class="button-container">
        <!-- 데이터 관리 버튼 -->
        <form action="data_control.php" method="post">
            <input class="data-control-button" type="submit" value="데이터 관리">
        </form>

        <!-- 자료 제작 버튼 -->
        <form action="make_file.php" method="post">
            <input class="make-file-button" type="submit" value="자료 제작">
        </form>
    </div>

</body>
</html>
