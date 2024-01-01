$(document).ready(function () {
  //點擊註冊按鈕
  $("#createButton").click(function (e) {
    $("#login-form").hide();
    $("#register-form").show(200);
  });
  //點擊註冊頁面中的登入按鈕
  $("#registerLoginBtn").click(function (e) {
    $("#register-form").hide();
    $("#login-form").show(200);
  });

  //註冊按鈕
  $("#register-account-btn").click(function (e) {
    let username = $("#register-username").val();
    let password = $("#register-password").val();
    let email = $("#register-email").val();
    // console.log(username, password, email);
    if (username.length === 0 || password.length === 0 || email.length === 0) {
      alert("請輸入帳號密碼");
      return;
    }
    //檢查電子郵件格式
    if (!ValidateEmail(email)) return;
    $.ajax({
      type: "POST",
      url: "registerAccount.php",
      data: {
        username: username,
        password: password,
        email: email,
      },
      success: function (response) {
        alert("註冊帳號成功");
        document.getElementById("register-username").value = "";
        document.getElementById("register-password").value = "";
        document.getElementById("register-email").value = "";
        //轉換回登入頁面
        $("#register-form").hide();
        $("#login-form").show(200);
      },
      error: function (error) {
        alert("註冊帳號失敗，帳號已存在");
      },
    });
  });

  $("#loginBtn").click(function (e) {
    let username = $("#loginUsername").val();
    let password = $("#loginPassword").val();

    if (username.length === 0 || password.length === 0) {
      alert("請檢查輸入");
      return;
    }

    $.ajax({
      type: "POST",
      url: "loginAccount.php",
      data: {
        username: username,
        password: password,
      },
      success: function (response) {
        alert("登入成功");
        document.getElementById("loginUsername").value = "";
        document.getElementById("loginPassword").value = "";
        //切換至主畫面
        window.location.href = "course_select.php";
      },
      error: function (error) {
        alert("登入失敗，請檢查輸入");
      },
    });
  });
});

// window.addEventListener("load", start, false);

//檢查電子郵件格式
function ValidateEmail(mail) {
  let emailRule =
    /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
  if (emailRule.test(mail)) {
    return true;
  }
  alert("請檢查電子郵件格式是否正確");
  return false;
}
