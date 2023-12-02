<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Control</title>
    <link rel="stylesheet" href="./CSS/choose_button_style.css">
</head>
<body>
    <div class="header">
        <h1>관리자 페이지</h1>
    </div>
    <div class="button-container">
        <!-- 영단어 관리 버튼 -->
        <form action="control_word.php" method="post">
            <input class="control-word-button" type="submit" value ="">
            <div class="button-text">영단어 관리</div>
        </form>

        <!-- 모의고사 지문 관리 버튼 -->
        <form action="control_passage.php" method="post">
            <input class="control-passage-button" type="submit" value="">
            <div class="button-text">모의고사 지문 관리</div>
        </form>
    </div>
    <div class="footer">
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
    </div>
</body>
</html>
