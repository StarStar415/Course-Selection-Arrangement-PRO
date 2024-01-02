<?php session_start(); ?>
<html>

<head>
    <title>Course Select</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <style type="text/css">
        @import "style.css";
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="change_select_bar_script.js"></script>
    <script src="export_pdf_script.js"></script>
    <script src="query_course_script.js"></script>
    <script src="select_script.js"></script>
    <script src="show_table_script.js"></script>
    <script src="change_select_table_script.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
    <script>
        function handleLogout() {
            console.log("logout");
            $.ajax({
                type: "POST",
                url: "session_remove.php",
                success: function(response) {
                    console.log(response);
                    alert("登出成功");
                    window.location.href = "loginPage.php";
                },
                error: function(error) {
                    console.log(error);
                },
            });
        }

        function sendToMail() {
            console.log("send to mail");

            let username = document.getElementById("user_name").innerText;
            let data = document.getElementById('right').innerHTML;
            console.log(data);
            $.ajax({
                type: "POST",
                url: "sendPDF.php",
                data: {
                    username: username.trim(),
                    data: data
                },
                success: function(response) {
                    console.log(response);
                    alert("寄送成功");
                },
                error: function(error) {
                    console.log(error);
                    alert("寄送失敗");
                },
            });
        }
    </script>
    <?php
    if (isset($_SESSION['username'])) {
        $currentUsername = $_SESSION['username'];
        echo '<h1>學途~啟航!<span id="user_block"><span id="user_img" ><img src="img/user.png" alt="User"></span><span id="user_name"> ' . $currentUsername . '</span>&nbsp;&nbsp;<span><button id="logoutButton" class="btn" onclick="handleLogout()" >登出</button></span></span></h1>';
    } else {
        echo '<h1>學途~啟航!</h1>';
    }
    ?>



    <div id="container">
        <div id="left">
            <h2>選課</h2>
            <div id="select_type" width=500 style="width: 500px">
                <span id="query">查詢：
                    <select name="options" id="options" style="width: 400px">
                        <option value="Dept_Name" selected>系所</option>
                        <option value="Course_Name">課程名稱</option>
                        <option value="Course_ID">課號</option>
                        <option value="Teacher_Name">老師</option>
                        <option value="Time">時間</option>
                        <option value="Sport">體育</option>
                        <option value="GeneralEducation">通識</option>
                    </select>

                </span>
                <span id="department" style="width: 550px;line-height: 4">系所：
                    <select name="options" id="dept_select" style="width: 296px">
                        <?php
                        //--------這裡記得要改成自己的--------
                        $user = 'root';
                        $password = 'D223084117980141';
                        //--------------------------------
                        try {
                            $db = new PDO('mysql:host=localhost;dbname=final_project;charset=utf8', $user, $password);

                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                            $query = ("select distinct Dept_Name from class");
                            $stmt = $db->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $rowCount = $stmt->rowCount();

                            if ($rowCount > 0) {
                                foreach ($result as $row) {
                                    echo "<option value='{$row["Dept_Name"]}'>{$row["Dept_Name"]}</option>";
                                }
                            } else {
                                echo "<option value=''>No options available</option>";
                            }

                            $db = null;
                        } catch (PDOException $e) {

                            print "ERROR!:" . $e->getMessage();
                            die();
                        }
                        ?>
                    </select>
                    <select name="options" id="grade_select" width=100 style="width: 100px">
                        <option value="all">全部</option>
                        <option value="1">一年級</option>
                        <option value="2">二年級</option>
                        <option value="3">三年級</option>
                        <option value="4">四年級</option>
                    </select>
                </span>
                <span id="course" style="width: 550px;line-height: 4">課名：
                    <input type="text" name="course_name" id="course_name" style="width: 400px;height: 38px">
                </span>
                <span id="course_id" style="width: 550px;line-height: 4">課號：
                    <input type="text" name="course_id_in" id="course_id_in" style="width: 400px;height: 38px">
                </span>
                <span id="teacher" style="width: 550px;line-height: 4">老師：
                    <input type="text" name="teacher_name" id="teacher_name" style="width: 400px;height: 38px">
                </span>
                <span id="time" style="width: 550px;line-height: 4">時間：
                    <select name="options" id="time_options1" style="width: 165px">
                        <option value="1">星期一</option>
                        <option value="2">星期二</option>
                        <option value="3">星期三</option>
                        <option value="4">星期四</option>
                        <option value="5">星期五</option>
                        <option value="6">星期六</option>
                        <option value="7">星期日</option>
                    </select>

                    <select name="options" id="time_options2" style="width: 165px">
                        <?php
                        for ($i = 1; $i <= 14; $i++) {
                            echo "<option value='{$i}'>第{$i}節</option>";
                        }
                        ?>
                    </select>
                </span>
                <span id="sport" style="width: 550px;line-height: 4">類型：
                    <select name="options" id="sport_select">
                        <option value="網球">網球</option>
                        <option value="桌球">桌球</option>
                        <option value="籃球">籃球</option>
                        <option value="排球">排球</option>
                        <option value="游泳">游泳</option>
                        <option value="羽球">羽球</option>
                        <option value="瑜珈">瑜珈</option>
                        <option value="健美">健美</option>
                        <option value="潛水">潛水</option>
                        <option value="帆船">帆船</option>
                        <option value="獨木舟">獨木舟</option>
                        <option value="橄欖球">橄欖球</option>
                        <option value="太極拳">太極拳</option>
                        <option value="重量訓練">重量訓練</option>
                        <option value="肌力雕塑">肌力雕塑</option>
                        <option value="有氧舞蹈">有氧舞蹈</option>
                        <option value="SUP風浪板">SUP風浪板</option>
                        <option value="健康體適能">健康體適能</option>
                        <option value="體育特別班">體育特別班</option>
                    </select>
                </span>

                <span id="generalEducation" style="width: 550px;line-height: 4">類型：
                    <select name="options" id="generalEducation_select">
                        <option value="(歷史)">歷史</option>
                        <option value="(人格)">人格</option>
                        <option value="(科技)">科技</option>
                        <option value="(美學)">美學</option>
                        <option value="(自然)">自然</option>
                        <option value="(全球)">全球</option>
                        <option value="(經典)">經典</option>
                        <option value="(民主)">民主</option>
                        <option value="【人文探索】">人文探索</option>
                        <option value="【跨域永續】">跨域永續</option>
                        <option value="【科技創新】">科技創新</option>
                        <option value="【社會脈動】">社會脈動</option>
                    </select>
                </span>
                <br>
                <span id="submit" style="display: flex;justify-content: center;">
                    <button id="queryButton" class="btn" style="width: 400">查詢</button>
                </span>
            </div>
            <br>
            <div class="selection">
                <nav class="selectionClass">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="selectionClassButton" data-bs-toggle="tab" data-bs-target="#nav-selectionClassButton" type="button" role="tab" aria-controls="nav-selectionClassButton" aria-selected="true" style="color:#ffffff">查詢結果</button>
                        <button class="nav-link" id="nowSelectionClassButton" data-bs-toggle="tab" data-bs-target="#nav-nowSelectionClassButton" type="button" role="tab" aria-controls="nav-nowSelectionClassButton" aria-selected="true" style="color:#000000">目前課表</button>
                        <button class="nav-link" id="favorSelectionClassButton" data-bs-toggle="tab" data-bs-target="#nav-favorSelectionClassButton" type="button" role="tab" aria-controls="nav-favorSelectionClassButton" aria-selected="true" style="color:#000000">最愛課程</button>
                        <div class="total"><br><span class="totalCreditText" id="totalCreditText" >目前總學分：</span><span class="totalCredit" id="totalCredit"></span></div>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="selectionClass" role="tabpanel" aria-labelledby="nav-selectionClassButton-tab" style="margin: 0px"></div>
                    <div class="tab-pane fade" id="nowSelectionClass" role="tabpanel" aria-labelledby="nav-nowSelectionClassButton-tab" style="margin: 0px"></div>
                    <div class="tab-pane fade" id="favorSelectionClass" role="tabpanel" aria-labelledby="nav-favorSelectionClassButton-tab" style="margin:0px"></div>
                </div>
            </div>
            <br><br>
            <span id="functionButton">
                <button id="exportButton">Export to PDF</button>
                <button id="emailButton" onclick="sendToMail()">Send to Email</button>
            </span>

        </div>

        <div id="right">
            <h2>目前課表</h2>
            <table id="classTable" style='  width: 100%;height: auto;border-collapse: collapse;border: 1px solid; table-layout: fixed;'>
                <thead>
                    <tr style='border: 1px solid;'>
                        <th style='border: 1px solid;padding: 8px;text-align: center;'>時間</th>
                        <th style='border: 1px solid;padding: 8px;text-align: center;'>星期一</th>
                        <th style='border: 1px solid;padding: 8px;text-align: center;'>星期二</th>
                        <th style='border: 1px solid;padding: 8px;text-align: center;'>星期三</th>
                        <th style='border: 1px solid;padding: 8px;text-align: center;'>星期四</th>
                        <th style='border: 1px solid;padding: 8px;text-align: center;'>星期五</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>08:20</td>
                        <td style='border: 1px solid;padding: 8px;text-align: center;' id="101"></td>
                        <td style='border: 1px solid;padding: 8px;text-align: center;' id="201"></td>
                        <td style='border: 1px solid;padding: 8px;text-align: center;' id=" 301"></td>
                        <td style='border: 1px solid;padding: 8px;text-align: center;' id=" 401"></td>
                        <td style='border: 1px solid;padding: 8px;text-align: center;' id="501"></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>09:20</td>
                        <td id="102" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="202" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="302" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="402" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="502" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>10:20</td>
                        <td id="103" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="203" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="303" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="403" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="503" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>11:15</td>
                        <td id="104" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="204" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="304" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="404" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="504" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>12:10</td>
                        <td id="105" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="205" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="305" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="405" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="505" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>13:10</td>
                        <td id="106" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="206" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="306" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="406" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="506" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>14:10</td>
                        <td id="107" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="207" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="307" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="407" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="507" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>15:10</td>
                        <td id="108" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="208" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="308" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="408" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="508" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>16:05</td>
                        <td id="109" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="209" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="309" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="409" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="509" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>17:30</td>
                        <td id="110" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="210" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="310" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="410" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="510" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>18:30</td>
                        <td id="111" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="211" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="311" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="411" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="511" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>19:25</td>
                        <td id="112" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="212" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="312" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="412" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="512" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>20:20</td>
                        <td id="113" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="213" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="313" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="413" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="513" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                    <tr style='border: 1px solid;'>
                        <td style='border: 1px solid;padding: 8px;text-align: center;'>21:15</td>
                        <td id="114" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="214" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="314" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="414" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                        <td id="514" style='border: 1px solid;padding: 8px;text-align: center;'></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>


</body>

</html>