<!DOCTYPE html>
<html>
<head>
    <style>
        /* 기존의 스타일 시트 */

        .page-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Nunito', sans-serif;
            background-color: #f7f7f7;
        }

        .cute-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cute-message {
            font-size: 24px;
            color: #FF6347;
            margin-bottom: 20px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .cute-button {
            background-color: #FF7F50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition-duration: 0.4s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* 마우스 호버 효과 */
        .cute-button:hover {
            background-color: #FF6347;
        }
    </style>
</head>
<body>
<div class="page-container">

<div class="cute-container">
    <div class="cute-message">
            <?php
       
            session_start(); // 세션 시작
            
            // 데이터베이스 연결 정보
            $servername = "localhost"; // MySQL 서버 주소
            $username = "phpadmin"; // MySQL 사용자명
            $password = "phpadmin"; // MySQL 비밀번호
            $dbname = "goods"; // 사용할 데이터베이스 이름
            
            // 데이터베이스 연결 생성
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // 연결 확인
            if ($conn->connect_error) {
                die("데이터베이스 연결 실패: " . $conn->connect_error);
            }
            if(isset($_POST['nickname'])) {
                $nickname = $_POST['nickname'];
            }
            
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_answer"])) {
                $correct_answer = $_SESSION['word']['meaning'];
                $user_answer = $_POST["user_answer"];
                $word = $_SESSION['word']['word'];
                
                
                // 두 문자열의 유사성 비교 (유사도가 일정 이상이면 정답으로 처리)
                similar_text($correct_answer, $user_answer, $similarity);

                // 일정 유사도 이상일 경우 정답 처리
                $is_correct = ($similarity >= 70) ? 1 : 0; // 예시로 유사도 70% 이상으로 설정

            
                // 점수 계산 (맞으면 1점, 틀리면 0점)
                $score = ($is_correct === 1) ? 1 : 0;
            
                // 문제와 답 기록
                $word_id = $_SESSION['word']['word'];
                // 문제 푼 시간 기록
                $touch_time = date('Y-m-d H:i:s');
            
                $sql_insert = "INSERT INTO quiz_answers (word, user_answer, correct_answer, is_correct, score, touch_time, nickname) 
                               VALUES ('$word', '$user_answer', '$correct_answer', '$is_correct', '$score', '$touch_time', '$nickname')";
            
                if ($conn->query($sql_insert) === TRUE) {
                    if ($is_correct) {
                        echo "정답입니다! (+".$score. ")<br>";
                        echo "\"$correct_answer\"<br>";
                        // 정답인 경우 추가적인 처리를 할 수 있습니다.
                    } else {
                        echo "틀렸습니다. 정답은 \"$correct_answer\"입니다.<br>";
                        echo "(+$score)";
                        // 틀린 경우 처리를 할 수 있습니다.
                    }
                } else {
                    echo "오류: " . $sql_insert . "<br>" . $conn->error;
                }
            } else {
                echo "올바른 요청이 아닙니다.";
            }
            
            // 데이터베이스 연결 종료
            $conn->close();
            ?>
            
        </div>
        <form method="post" action="word_quiz.php">
            <input type="submit" value="다음 문제" class="cute-button">
        </form>
    </div>
</div>
</body>
</html>