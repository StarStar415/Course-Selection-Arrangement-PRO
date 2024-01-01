<html>

<head>
    <title>Course Select Login</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
        @import url("login_style.css");
    </style>
    <script src="login.js"></script>
    <script>
        $('.message a').click(function() {
            $('form').animate({
                height: "toggle",
                opacity: "toggle"
            }, "slow");
        });
    </script>
</head>

<body>

    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
    <div class="container  d-flex justify-content-center">
        <div class="row">
            <div class="col">
                <div class="login-page">
                    <div class="form">

                        <form class="register-form" id="register-form">
                            <input type="text" placeholder="username" id="register-username" />
                            <input type="password" placeholder="password" id="register-password" />
                            <input type="text" placeholder="email" id="register-email" />
                            <button id="register-account-btn">create</button>
                            <p class="message">Already registered? <a href="#" id="registerLoginBtn">Sign In</a></p>
                        </form>

                        <form class="login-form" id="login-form">
                            <input type="text" placeholder="username" id="loginUsername" />
                            <input type="password" placeholder="password" id="loginPassword" />
                            <button class="btn" id="loginBtn">login</button>
                            <p class="message">Not registered? <a href="#" id="createButton">Create an account</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>