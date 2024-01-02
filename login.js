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

  //點擊登入按鈕
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
  //更新密碼
  $("#updateButton").click(function (e) {
    //轉換回修改密碼頁面
    $("#update-form").show(200);
    $("#login-form").hide();
  });
  //修改密碼頁面轉回登入頁面
  $("#updateBackLoginButton").click(function (e) {
    //轉換回登入頁面
    $("#update-form").hide();
    $("#login-form").show(200);
  });
  //按下寄送驗證碼按鈕
  $("#sendMail").click(function (e) {
    let username = $("#updateUsername").val();
    if (username.length === 0) {
      alert("請輸入帳號");
      return;
    }
    $.ajax({
      type: "POST",
      url: "sendMail.php",
      data: {
        username: username,
      },
      success: function (response) {
        alert(response);
      },
      error: function (error) {
        alert("該帳戶不存在");
      },
    });
  });
  //按下更新密碼按鈕
  $("#updateBtn").click(function (e) {
    let validCode = $("#verifyingCode").val();
    let username = $("#updateUsername").val();
    let newPass = $("#newPassword").val();
    let confirmPass = $("#confirmPassword").val();

    if (newPass.length === 0 || confirmPass.length === 0) {
      alert("請輸入密碼");
      return;
    }

    if (newPass != confirmPass) {
      alert("請檢查密碼是否輸入相同");
      return;
    }
    if (validCode.length === 0) {
      alert("請輸入驗證碼");
      return;
    }
    if (username.length === 0) {
      alert("請輸入帳號");
      return;
    }

    $.ajax({
      type: "POST",
      url: "checkValidCode.php",
      data: {
        username: username,
        validCode: validCode,
        password: newPass,
      },
      success: function (response) {
        alert("密碼修改成功");
        document.getElementById("verifyingCode").value = "";
        document.getElementById("updateUsername").value = "";
        document.getElementById("newPassword").value = "";
        document.getElementById("confirmPassword").value = "";
        $("#update-form").hide();
        $("#login-form").show(200);
      },
      error: function (error) {
        console.log(error);
        alert("驗證碼錯誤，請重新輸入");
      },
    });
  });
});

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
