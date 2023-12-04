<title>로그인</title>

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
<style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
    }

    div {
      display: flex;
      align-items: center;
      justify-content: space-around;
      flex-direction: row;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 1000px;
      max-height: 500px;
    }

    /* Add styles for the image */
    img {
        max-width: 500px;
        max-height: 500px;
        margin: 0px 0px;
        object-fit:cover;
        border-radius: 5px;
      }

    form {
      margin: 0px 0px;
      width: 50%;
      height: 500px;
      max-height: 500px;
      border-radius: 5px;
      color: #fff;
    }
    fieldset{
      height: 100%;
      border: none;
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      align-items: center;
      border-radius: 5px;
    }
    p {
      width: 80%;
      align-items: center;
      display: flex;
      justify-content: center;
      height: 80px;
    }
    .ID, .PW {
        width: 100%; /* 조절하고 싶은 크기로 변경 */
        height: 100px;
        font-size: 40px;
        padding: 10px; /* 내부 여백 설정 */
        box-sizing: border-box; /* padding이나 border가 크기에 포함되도록 설정 */
        border-radius: 5px;
        border: none;
      }
    /* Add any additional styles you need */
      input[type="radio"] {
      width: 20px; /* 크기 조절 */
      height: 20px; /* 크기 조절 */
      border-radius: 50%; /* 동그란 형태로 만들기 */
      margin-right: 10px; /* 라디오 버튼 사이 간격 조절 */
    }
    input[type="radio"]:checked {
      accent-color: black; /* 선택된 경우 배경색 변경 */
    }

    label {
      font-size: 30px;
      margin-right: 10px;
      color: black;
    }
    /* Add styles for checked radio buttons */
    .role_select{
      background-color: white;
      border-radius: 5px;
    }
    span {
      font-size: 30px;
      color: black;
    }
    button {
      height: 60%;
      width: 40%;
      border-radius: 5px;
      margin: 40px 0px;
      font-size: 30px;
      background-color: white;
      border: none;
    }
    button:hover {
  background-color: #fff; /* hover 시 배경색 변경 */
  color: #C0C0C0; /* hover 시 텍스트 색상 변경 */
  cursor: pointer; /* 마우스 커서를 손가락 모양으로 변경 */
}
    .btn_wrap{
      display: flex;
      justify-content: space-around;
    }

</style>


</head>
<body>
<div>
  <img src="./CSS/login_image.jpeg" alt="로그인 이미지">
  <form name="login_form" action="login_ok.php" method="post" onsubmit="return login_check()">
      <fieldset>
        <p class = "role_select">
          <input type="radio" id="role.student" name="role" value="student" checked>
          <label for="student" class="radio_bnt">학생</label>
          <input type="radio" id="role.teacher" name="role" value="teacher">
          <label for="teacher" class="radio_bnt">선생님</label><br>
        </p>
        <p>
          <input class = "ID" type="text" name="u_id" id="u_id" class="u_id" autofocus placeholder="ID">
          <br>
          <span class="err_id"></span>
        </p>
        <p>
          <input class = "PW" type="password" name="pwd" id="pwd" class="pwd" placeholder="PASSWORD">
          <br>
          <span class="err_pwd"></span>
        </p>
        <p class="btn_wrap">
          <button type="button" class="btn" onclick="location.href='./register.php'">회원가입</button>
          <button type="submit" class="btn">로그인</button>
        </p>
      </fieldset>
    </form>
</div>
</body>