<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 10px;
            font-family: 'Nunito', sans-serif;
            background-color: #f7f7f7;
        }
        .page-container {
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Nunito', sans-serif;
            background-color: #f7f7f7;
            border: 2px solid #ccc; 
            border-radius: 10px; 
            padding: 20px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .quiz-image {
        width: 400px;
        border-radius: 40px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        }
        .user-information {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="page-container">
    <img src="./CSS/english_word.jpeg" alt="Quiz Image" class="quiz-image">

    
        <?php
        session_start(); // 세션 시작

        if (isset($_GET['reset_count']) && $_GET['reset_count'] === 'true') {
            $_SESSION['quiz_count'] = 0;
        }

        ?>
        <a href="#" onClick="startQuiz()" class="start-button">시작</a>
        <a href="quiz_ranking.php" class="rank-button">순위</a>
        <a href="main.php" class="home-button">홈페이지</a>
        <div class="footer">
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
        </div>
        <style>
            /* Styles for the buttons and the quiz heading */
            .start-button{
                display: inline-block;
                padding: 10px 20px;
                text-decoration: none;
                color: #fff;
                border-radius: 5px;
                margin-top: 10px;
                margin-bottom: 30px;
                transition: background-color 0.3s;
                background-color: #45a049; /* Start button color */
            }

            .start-button:hover {
                background-color: #FF6347;
            }

            .rank-button {
                background-image: url('./CSS/trophy_icon.png');
                background-size: cover;
                background-position: center;
                /* 기존의 스타일을 유지하면서 배경 이미지 추가 */
                padding: 30px 20px;
                text-decoration: none;
                color: transparent;
                border-radius: 5px;
                margin-top: 10px;
                transition: background-color 0.3s;
                background-color: #FF6347; /* Ranking button color */
            }

            .rank-button:hover {
                background-color: #FF7F50;
            }
            .home-button {
    display: inline-block;
    padding: 10px 20px;
    text-decoration: none;
    color: #fff;
    border-radius: 25px; /* Circular shape */
    margin-top: 20px; /* Increased top margin */
    transition: background-color 0.3s;
    background-color: #3498db; /* Button color */
    border: 2px solid #2980b9; /* Border color */
}

.home-button:hover {
    background-color: #2980b9;
}

        </style>
        <script>
            function startQuiz() {
                // Create a new URL with quiz_count set to 0
                const url = new URL('nickname.php', window.location.href);
                url.searchParams.set('quiz_count', '0'); // Set quiz_count to 0
                // Redirect to word_quiz.php with quiz_count set to 0
                window.location.href = url.href;
            }
        </script>
    </div>
    
    >
    
</body>
</html>