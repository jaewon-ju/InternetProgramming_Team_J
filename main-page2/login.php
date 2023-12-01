<?php
session_start();

if(isset($_SESSION['login-err']) && $_SESSION['login-err'] > 0){
    if($_SESSION['login-err'] == 1) echo "<script>alert('비밀번호가 올바르지 않습니다.');</script>";
    else echo "<script>alert('사용자가 존재하지 않습니다.');</script>";
    $_SESSION['login-err'] = 0;
}

?>
<title>로그인</title>

<style type="text/css">
  body,select,option,button{font-size:16px}
  input{border:1px solid #999;font-size:14px;padding:5px 10px}
  input,button{vertical-align:middle}
  form{width:320px;margin:auto}
  span{font-size:14px;color:#f00}
  legend{font-size:20px;text-align:center}
  p span{display:block;margin-left:90px}
  button{cursor:pointer}
  .txt{display:inline-block;width:80px}
  .btn{background:#fff;border:1px solid #999;font-size:14px;padding:4px 10px}
  .btn_wrap{text-align:center}
</style>

<script type="text/javascript">
  function login_check(){
  var u_id = document.getElementById("u_id");
  var pwd = document.getElementById("pwd");
  var role_student = document.getElementById("role_student");
  var role_teacher = document.getElementById("role_teacher");

    // role 변수에 선택된 라디오 버튼의 값 할당
    var role;
    if (role_student.checked) {
        role = role_student.value;
    } else if (role_teacher.checked) {
        role = role_teacher.value;
    } else {
        // 선택된 라디오 버튼이 없을 경우에 대한 처리
        alert("계정 유형을 선택해주세요.");
        return false;
    }

  if(u_id.value == ""){
    var err_txt = document.querySelector(".err_id");
    err_txt.textContent = "아이디를 입력하세요.";
    u_id.focus();
    return false;
  };

  var u_id_len = u_id.value.length;
  if( u_id_len < 4 || u_id_len > 12){
    var err_txt = document.querySelector(".err_id");
    err_txt.textContent = "아이디는 4~12글자만 입력할 수 있습니다.";
    u_id.focus();
    return false;
  };

  if(pwd.value == ""){
    var err_txt = document.querySelector(".err_pwd");
    err_txt.textContent = "비밀번호를 입력하세요.";
    pwd.focus();
    return false;
  };

  var pwd_len = pwd.value.length;
  if( pwd_len < 4 || pwd_len > 8){
    var err_txt = document.querySelector(".err_pwd");
    err_txt.textContent = "비밀번호는 4~8글자만 입력할 수 있습니다.";
    pwd.focus();
    return false;
  };

  };
</script>
  
</head>
<body>
  <form name="login_form" action="login_ok.php" method="post" onsubmit="return login_check()">
    <fieldset>
      <legend>로그인</legend>
      <p>
        <label for = "role" class = radio_bnt> 계정 유형</label>
        <input type="radio" id="role.student" name="role" value="student" checked>
        <label for="student">학생</label>
        <input type="radio" id="role.teacher" name="role" value="teacher">
        <label for="teacher">선생님</label><br>
      </p>
      <p>
        <label for="u_id" class="txt">아이디</label>
        <input type="text" name="u_id" id="u_id" class="u_id" autofocus>
        <br>
        <span class="err_id"></span>
      </p>

      <p>
        <label for="pwd" class="txt">비밀번호</label>
        <input type="password" name="pwd" id="pwd" class="pwd">
        <br>
        <span class="err_pwd"></span>
      </p>

      <p class="btn_wrap">
        <button type="button" class="btn" onclick="location.href='./register.php'">회원가입</button>
        <button type="submit" class="btn">로그인</button>
      </p>
    </fieldset>
  </form>
</body>