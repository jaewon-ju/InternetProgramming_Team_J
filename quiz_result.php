<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .return-button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            float: right;
        }

        .return-button:hover {
            background-color: #45a049;
        }

        h1 {
            text-align: center;
        }
        
    </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

$nickname = '이도권';

$sql = "SELECT * FROM quiz_answers WHERE nickname = '$nickname' ORDER BY touch_time DESC LIMIT 10";

$result = $conn->query($sql);
$total_score = 0;

if ($result->num_rows > 0) {
    echo "<h1>퀴즈 결과</h1>";
    echo "<table>
              <tr>
                  <th>문제</th>
                  <th>사용자 답안</th>
                  <th>정답</th>
                  <th>정답 여부</th>
                  <th>점수</th>
                  <th>풀이 시간</th>
                  <th>닉네임</th>
              </tr>";

    while ($row = $result->fetch_assoc()) {
        $total_score += $row["score"];
        echo "<tr>";
        echo "<td>" . $row["word"] . "</td>";
        echo "<td>" . $row["user_answer"] . "</td>";
        echo "<td>" . $row["correct_answer"] . "</td>";
        echo "<td>" . ($row["is_correct"] ? 'O' : 'X') . "</td>";
        echo "<td>" . $row["score"] . "</td>";
        echo "<td>" . $row["touch_time"] . "</td>";
        echo "<td>" . $row["nickname"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    echo "<p style='text-align: center;'>총 점수 : $total_score</p>";
    $select_query = "SELECT * FROM user_score WHERE nickname='$nickname'";
    $select_result = $conn->query($select_query);

    if($select_result->num_rows > 0) {
        $update_query = "UPDATE user_score SET correct_answers = '$total_score' WHERE nickname = '$nickname'";
        if($conn->query($update_query) === TRUE) {
            $rank_sql = "SELECT 
                        nickname, 
                        correct_answers,
                        (SELECT COUNT(*) + 1 FROM user_score AS u2 WHERE u2.correct_answers > u1.correct_answers) AS rank
                    FROM 
                        user_score AS u1
                    ORDER BY 
                        correct_answers DESC";

        $rank_result = $conn->query($rank_sql);

        if ($rank_result->num_rows > 0) {
            while ($row = $rank_result->fetch_assoc()) {
                if ($row['nickname'] === $nickname) {
                    echo "<p style='text-align: center;'>$nickname 의 순위는 " . $row['rank'] . "등입니다.</p>";
                    break;
                }
            }
        }
    } else {
        echo "<p style='text-align: center;'>스코어 저장 중 오류가 발생했습니다: " . $conn->error . "</p>";
    }
        } else {
    $insert_score_sql = "INSERT INTO user_score(nickname, correct_answers) VALUES('$nickname', '$total_score')";
    if ($conn->query($insert_score_sql) === TRUE) {
        // 순위 쿼리
        $rank_sql = "SELECT 
                        nickname, 
                        correct_answers,
                        (SELECT COUNT(*) + 1 FROM user_score AS u2 WHERE u2.correct_answers > u1.correct_answers) AS rank
                    FROM 
                        user_score AS u1
                    ORDER BY 
                        correct_answers DESC";

        $rank_result = $conn->query($rank_sql);

        if ($rank_result->num_rows > 0) {
            while ($row = $rank_result->fetch_assoc()) {
                if ($row['nickname'] === $nickname) {
                    echo "<p style='text-align: center;'>$nickname 의 순위는 " . $row['rank'] . "등입니다.</p>";
                    break;
                }
            }
        }
    } else {
        echo "<p style='text-align: center;'>스코어 저장 중 오류가 발생했습니다: " . $conn->error . "</p>";
    }
}
    
} else {
    echo "<p style='text-align: center;'>해당하는 데이터가 없습니다.</p>";
}
$conn->close();
?>
<a href="word_quiz_main.php?reset_count=true" class="return-button">초기화면</a>
<a href="quiz_ranking.php" class="rank-button">순위</a>
<style>
    .rank-button {
                background-image: url('trophy_icon.png');
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
            </style>
</body>
</html>
