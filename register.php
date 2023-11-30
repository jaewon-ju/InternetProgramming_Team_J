<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];

    if ($role == 'student') {
        header("Location: student_register.php");
        exit();
    } elseif ($role == 'teacher') {
        header("Location: teacher_register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>회원가입</title>
</head>
<body>
    <h2>회원가입</h2>
    <p>회원가입할 역할을 선택하세요:</p>
    <form action="register.php" method="post">
        <input type="radio" id="student" name="role" value="student" checked>
        <label for="student">학생</label>
        <input type="radio" id="teacher" name="role" value="teacher">
        <label for="teacher">선생님</label><br>
        <input type="submit" value="다음으로">
    </form>
</body>
</html>
