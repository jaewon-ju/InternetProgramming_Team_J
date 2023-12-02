<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자료 제작</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh; 
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            text-align: center;
            overflow: auto;
            position: relative;
        }


        label {
            display: inline-block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100px;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            overflow: auto;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        div {
            width : 100%;
            border: 1px solid black;
            margin-bottom: 1px;
            float: left;
        }
        .save-form {
            width : 100%;
            background-color: rgba(0, 0, 0, 0.1);
            color: #fff;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            padding: 0px 0px; 
            text-align: center;
            justify-content: center;
        }

        .save-form:hover {
            background-color: #0056b3;
        }

        .container {
            border: none;
            text-align: center;
            justify-content: center;
            display: flex;
            flex-direction :column;
        }
        table {
            text-align: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<?php
session_start();
//주의사항 -> 디렉토리의 쓰기 권한을 켜주셔야 합니다.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['num_of_passages'])) {
        $_SESSION['num_of_passages'] = $_POST['num_of_passages'];
        $numOfPassages = $_POST['num_of_passages'];

        // 시행 연도, 대상 학년, 시행 월, 문제 번호를 저장할 배열 초기화
        $passagesData = [];

        // 사용자로부터 시행 연도, 대상 학년, 시행 월, 문제 번호를 입력받는 폼 생성
        echo '<form action="" method="post">';
        for ($i = 1; $i <= $numOfPassages; $i++) {
            echo "<h3>지문 $i</h3>";
            echo '<label for="year_' . $i . '">시행 연도:</label>';
            echo '<input type="number" name="year_' . $i . '" required>';

            echo '<label for="grade_' . $i . '">대상 학년:</label>';
            echo '<input type="number" name="grade_' . $i . '" required>';

            echo '<label for="month_' . $i . '">시행 월:</label>';
            echo '<input type="number" name="month_' . $i . '" required>';

            echo '<label for="number_' . $i . '">문제 번호:</label>';
            echo '<input type="text" name="number_' . $i . '" required>';

            echo '<br>';
        }

        echo '<input type="submit" value="자료 제작">';
        echo '</form>';
    } else if (isset($_SESSION['num_of_passages']) && isset($_POST['year_1']) && isset($_POST['grade_1']) && isset($_POST['month_1']) && isset($_POST['number_1'])) {
        // 데이터베이스 연결 설정
        $servername = "localhost";
        $username = "phpadmin";
        $password = "phpadmin";
        $dbname = "goods";

        // 데이터베이스 연결
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");
        // 연결 확인
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // 가져올 데이터의 개수
        $numOfPassages = $_SESSION['num_of_passages'];
        
        // 데이터베이스에서 지문과 해석을 가져오기
        for ($i = 1; $i <= $numOfPassages; $i++) {
            $year = $_POST["year_$i"];
            $grade = $_POST["grade_$i"];
            $month = $_POST["month_$i"];
            $number = $_POST["number_$i"];

            //CRUD: R
            $sql = "SELECT passage, interpret FROM exam_texts WHERE year = $year AND grade = $grade AND month = $month AND number = '$number'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $passagesData[] = $row;
            }
        }

        // 데이터베이스 연결 종료
        $conn->close();

        // 가져온 데이터 출력
        if (empty($passagesData)) {
            echo '<script>';
            echo 'alert("No data found for any passages");';
            echo 'window.location.href = "teacher.php";';
            echo '</script>';
        } else {
            echo '<div class="container"><table border="1">';
            echo '<tr><th>지문</th><th>해석</th></tr>';
        
            foreach ($passagesData as $index => $data) {
                echo '<tr>';
                echo '<td>' . nl2br($data['passage']) . '</td>';
                echo '<td>' . nl2br($data['interpret']) . '</td>';
                echo '</tr>';
            }
            $_SESSION['passagesData'] = $passagesData;
            echo '</table>';
            echo '<form action="" method="post" class="save-form">';
            echo '자료의 이름: <input type="text" name="filename" required><br>';
            echo '<input type="submit" name="save_to_file" value="자료 저장">';
            echo '</form></div class="container">';
        }

    } else if (isset($_POST['save_to_file'])){
            // 파일명 생성 (예: data_20231123.txt)
            $filename = $_POST['filename'] . 'TEXT.txt';

            // 파일 열기 또는 생성 (쓰기 모드)
            $file = fopen($filename, "w+");
            if ($file === false) {
                die('Error opening file for writing');
            }
            $passagesData = $_SESSION['passagesData'];
            // 데이터를 파일에 쓰기
            foreach ($passagesData as $data) {
                fwrite($file, $data['passage'] . "\n\n");
                fwrite($file, $data['interpret'] . "\n\n\n");
            }
        
            // 파일 닫기
            fclose($file);
            
            //추가 자료 만들기 -- 순서배열과 단어빈칸 문제 자료
            $newFilename1 = $_POST['filename'] . '순서배열.txt';
            $newFile1 = fopen($newFilename1, "w+");
            if ($newFile1 === false) {
                die('Error opening file for writing');
            }

            
            $sentences = [];
            foreach ($passagesData as $index => $data) {
                $paragraphs = explode("\n", $data['passage']); // 문장을 \n으로 나누어 배열에 저장
                shuffle($paragraphs); // 각 지문의 문장을 셔플

                // 각 지문의 번호를 초기화
                $sentenceNumber = 1;

                foreach ($paragraphs as $paragraph) {
                    if (!empty(trim($paragraph))) {
                        $sentences[] = '(' . $sentenceNumber . ') ' . $paragraph . "\n"; // 각 문장을 배열에 저장
                        $sentenceNumber++;
                    }
                }
                $sentences[] = "\n\n";
            }

            // 번호를 붙여서 파일에 쓰기
            foreach ($sentences as $sentence) {
                fwrite($newFile1, $sentence);
            }
            
            fclose($newFile1);

            // 두 번째 새 파일 생성 ($_POST['filename'] . '단어빈칸.txt')
            $newFilename2 = $_POST['filename'] . '단어빈칸.txt';
            $newFile2 = fopen($newFilename2, "w+");
            if ($newFile2 === false) {
                die('Error opening file for writing');
            }
            
            foreach ($passagesData as $data) {
                $paragraphs = explode("\n", $data['passage']);
                $interpretParagraphs = explode("\n", $data['interpret']);
        
                foreach ($paragraphs as $index => $paragraph) {
                    if (!empty(trim($paragraph))) {
                        $words = explode(" ", $paragraph);
                        $hiddenWords = [];
        
                        foreach ($words as $word) {
                            // 각 단어에서 40%의 확률로 단어를 밑줄로 바꿈
                            $hiddenWords[] = (rand(1, 100) <= 40) ? '_____' : $word;
                        }
        
                        $hiddenParagraph = implode(" ", $hiddenWords) . "\n";
                        fwrite($newFile2,$hiddenParagraph);
                        $sentenceNumber++;
                    }
                }
        
                foreach ($interpretParagraphs as $index => $interpretParagraph) {
                    if (!empty(trim($interpretParagraph))) {
                        fwrite($newFile2, $interpretParagraph . "\n");
                    }
                }
                fwrite($newFile2, "\n\n");
            }
            fclose($newFile2);
            // teacher.php로 리다이렉션
            header("Location: teacher.php");
            exit(); // 리다이렉션 이후 코드 실행 방지
    } else {
        // 사용자에게 numOfPassages를 입력받는 폼 표시
        echo '
        <form action="" method="post">
            <label for="num_of_passages">제작할 자료의 지문 수:</label>';
        echo '<input type="number" name="num_of_passages" required>';
    
        echo '<input type="submit" value="계속">';
        echo '</form>';
    } 
}
?>

</body>
</html>