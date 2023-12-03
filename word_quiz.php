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

        .quiz-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .submit-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 8px;
            transition-duration: 0.4s;
        }

        /* 마우스 호버 효과 */
        .submit-button:hover {
            background-color: #45a049;
            color: white;
        }
        #user_answer {
            width: 300px;
            padding: 10px;
            margin-top: 10px;
            border-radius: 20px; /* 더 둥근 테두리 */
            border: 2px solid #4CAF50; /* 테두리 색상 및 두께 */
            font-size: 16px;
            outline: none; /* 포커스 효과 제거 */
            transition: border-color 0.3s; /* 테두리 색상 전환 애니메이션 */
        }

        #user_answer:focus {
            border-color: #45a049; /* 포커스 시 테두리 색상 변경 */
        }
        .answer-label {
            font-size: 20px;
            color: #4CAF50;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .quiz-count {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 14px;
            color: #555;
        }
        .reset-button,
        .main-button {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border:none;
            color: #fff;
            background-color:#4CAF50;
            border-radius: 40px;
            margin-top: 10px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        
         /* 마우스 호버 효과 */
        .reset-button:hover,
        .main-button:hover {
            background-color: #45a049;
        }

        
        
        /* 페이지 컨테이너 스타일 */
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
            background-color : #fff;
            margin-bottom: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="page-container">
<div class="quiz-description">
        <h3 style="text-align: center; color: #333; margin-bottom: 20px;">Quiz Description</h3>
        <p style="font-size: 18px; text-align: justify; padding: 20px; border: 2px solid #ccc; border-radius: 10px;">
            퀴즈는 총 10문제입니다. 
            ※순위 버튼을 눌러도 초기화가 됩니다.
        </p>
        
    </div>
<?php
session_start(); // 세션 시작

// 문제를 푼 횟수 초기화
if (!isset($_SESSION['quiz_count']) || isset($_POST['reset']) || isset($_POST['rank'])) {
    $_SESSION['quiz_count'] = 0;
}
// 닉네임 로그인 테이블에서 가져오기(현재 단일 설정)
$nickname = isset($_POST['user_name']) ? $_POST['user_name'] : '';
// 문제를 푼 횟수 표시
echo "<div class='quiz-count'>문제를 푼 횟수: (" . $_SESSION['quiz_count'] . "/10)</div>";

if ($_SESSION['quiz_count'] >= 10) {
    // 10문제를 모두 푼 경우 quiz_result.php로 이동
    echo "<form method='post'>";
    echo "<input type='hidden' name='user_name' value='$nickname'>";
    $_SESSION['quiz_count'] = 0;
    $_SESSION['user_nickname'] = $nickname;
    header("Location: quiz_result.php");
    exit();
}


// 데이터베이스 연결 설정
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}


// 랜덤으로 단어 하나 선택
$sql = "SELECT * FROM english_word ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $word = $row["word"];
    $meaning = $row["meaning"];
    $turn = $row["turn"];

    $_SESSION['word'] = [
        'turn' => $turn,
        'word' => $word,
        'meaning' => $meaning
    ];
    // 퀴즈 문제 출력 및 폼 생성
    echo "<div class='quiz-container'>";
    echo "<h2 style='margin-bottom: 20px;'>다음 영어 단어의 뜻은 무엇일까요?</h2>";
    echo "<p style='font-size: 20px;'><strong>단어:</strong> $word</p>";
    
    echo "<form method='post' action='quiz_check.php' style='margin-top: 20px;'>";
    echo "<input type='hidden' name='nickname' value='$nickname'>";
    echo "<input type='hidden' name='correct_answer' value='$meaning'>";
    echo "<label class='answer-label' for='user_answer'>정답: </label>";
    echo "<input type='text' id='user_answer' name='user_answer' required><br>";
    echo "<input type='submit' value='확인' class='submit-button'>";
    echo "<input type='hidden' name='turn' value='$turn'>";
    echo "</form>";
    echo "</div>";
} else {
    echo "단어가 없습니다.";
}

$conn->close();
?>

<form method="post" action="">
    <input type="hidden" name="reset">
    <input type="submit" value="재도전" class="reset-button">
</form>
<a href="word_quiz_main.php?reset_count=true" class="main-button">초기화면</a>
<div class="footer">
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
    </div>

<script>
    // 문제를 푼 횟수 증가
    document.querySelector('.submit-button').addEventListener('click', function() {
        <?php $_SESSION['quiz_count']++; ?>
    });
</script>



</div>

</body>
</html>