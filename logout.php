<?php
session_start();

// 세션 종료
session_unset();
session_destroy();

// 로그인 페이지로 리다이렉트
header("Location: login.php");
exit();
?>
