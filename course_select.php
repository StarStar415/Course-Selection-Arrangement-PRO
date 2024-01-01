<?php session_start(); ?>
<html>

<head>
    <title>Course Select</title>
    <style type="text/css">
        @import "style.css";
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>

    <h1>學途~啟航!</h1>



    <div id="container">
        <div id="left">
            <h2>選課</h2>
            <div id=select_type>
                <span id="query">想要查詢：
                    <select name="options" id="options">
                        <option value="Dept_Name" selected>系所</option>
                        <option value="Course_Name">課程名稱</option>
                        <option value="Course_ID">課號</option>
                        <option value="Teacher_Name">老師</option>
                        <option value="Time">時間</option>
                        <option value="Sport">體育</option>
                        <option value="GeneralEducation">通識</option>
                    </select>
                </span>
                <span id="department">系所：
                    <select name="options" id="dept_select">
                        <?php
                        //--------這裡記得要改成自己的--------
                        $user = 'root';
                        $password = '123';
                        //--------------------------------
                        try {
                            //--------這裡記得要改成自己的--------
                            $db = new PDO('mysql:host=localhost;dbname=databaseproject;charset=utf8;port=3307', $user, $password);
                            //--------------------------------

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
                    <select name="options" id="grade_select">
                        <option value="all">全部</option>
                        <option value="1">一年級</option>
                        <option value="2">二年級</option>
                        <option value="3">三年級</option>
                        <option value="4">四年級</option>
                    </select>
                </span>
                <span id="course">課名：
                    <input type="text" name="course_name" id="course_name">
                </span>
                <span id="course_id">課號：
                    <input type="text" name="course_id_in" id="course_id_in">
                </span>
                <span id="teacher">老師：
                    <input type="text" name="teacher_name" id="teacher_name">
                </span>
                <span id="time">時間：
                    <select name="options" id="time_options1">
                        <option value="1">星期一</option>
                        <option value="2">星期二</option>
                        <option value="3">星期三</option>
                        <option value="4">星期四</option>
                        <option value="5">星期五</option>
                        <option value="6">星期六</option>
                        <option value="7">星期日</option>
                    </select>

                    <select name="options" id="time_options2">
                        <?php
                        for ($i = 1; $i <= 14; $i++) {
                            echo "<option value='{$i}'>第{$i}節</option>";
                        }
                        ?>
                    </select>
                </span>
                <span id="sport">類型：
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

                <span id="generalEducation">類型：
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
                <span id="submit">
                    <button id="queryButton" class="btn">查詢</button>
                </span>
            </div>
            <br>
            <div>
                <span class="tab" id="selectionClassButton">查詢結果</span>
                <span class="tab" id="nowSelectionClassButton">目前課表</span>

            </div>
            <div id="selectionClass">
            </div>
            <div id="nowSelectionClass">
            </div>
            <br>
            <button id="exportButton">Export to PDF</button>
        </div>

        <div id="right">
            <h2>目前課表</h2>
            <table id="classTable" class="table table-bordered border-secondary table-responsive">
                <thead>
                    <tr>
                        <th scope="col">時間</th>
                        <th scope="col">星期一</th>
                        <th scope="col">星期二</th>
                        <th scope="col">星期三</th>
                        <th scope="col">星期四</th>
                        <th scope="col">星期五</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>08:20</td>
                        <td id="101"></td>
                        <td id="201"></td>
                        <td id=" 301"></td>
                        <td id=" 401"></td>
                        <td id="501"></td>
                    </tr>
                    <tr>
                        <td>09:20</td>
                        <td id="102"></td>
                        <td id="202"></td>
                        <td id="302"></td>
                        <td id="402"></td>
                        <td id="502"></td>
                    </tr>
                    <tr>
                        <td>10:20</td>
                        <td id="103"></td>
                        <td id="203"></td>
                        <td id="303"></td>
                        <td id="403"></td>
                        <td id="503"></td>
                    </tr>
                    <tr>
                        <td>11:15</td>
                        <td id="104"></td>
                        <td id="204"></td>
                        <td id="304"></td>
                        <td id="404"></td>
                        <td id="504"></td>
                    </tr>
                    <tr>
                        <td>12:10</td>
                        <td id="105"></td>
                        <td id="205"></td>
                        <td id="305"></td>
                        <td id="405"></td>
                        <td id="505"></td>
                    </tr>
                    <tr>
                        <td>13:10</td>
                        <td id="106"></td>
                        <td id="206"></td>
                        <td id="306"></td>
                        <td id="406"></td>
                        <td id="506"></td>
                    </tr>
                    <tr>
                        <td>14:10</td>
                        <td id="107"></td>
                        <td id="207"></td>
                        <td id="307"></td>
                        <td id="407"></td>
                        <td id="507"></td>
                    </tr>
                    <tr>
                        <td>15:10</td>
                        <td id="108"></td>
                        <td id="208"></td>
                        <td id="308"></td>
                        <td id="408"></td>
                        <td id="508"></td>
                    </tr>
                    <tr>
                        <td>16:05</td>
                        <td id="109"></td>
                        <td id="209"></td>
                        <td id="309"></td>
                        <td id="409"></td>
                        <td id="509"></td>
                    </tr>
                    <tr>
                        <td>17:30</td>
                        <td id="110"></td>
                        <td id="210"></td>
                        <td id="310"></td>
                        <td id="410"></td>
                        <td id="510"></td>
                    </tr>
                    <tr>
                        <td>18:30</td>
                        <td id="111"></td>
                        <td id="211"></td>
                        <td id="311"></td>
                        <td id="411"></td>
                        <td id="511"></td>
                    </tr>
                    <tr>
                        <td>19:25</td>
                        <td id="112"></td>
                        <td id="212"></td>
                        <td id="312"></td>
                        <td id="412"></td>
                        <td id="512"></td>
                    </tr>
                    <tr>
                        <td>20:20</td>
                        <td id="113"></td>
                        <td id="213"></td>
                        <td id="313"></td>
                        <td id="413"></td>
                        <td id="513"></td>
                    </tr>
                    <tr>
                        <td>21:15</td>
                        <td id="114"></td>
                        <td id="214"></td>
                        <td id="314"></td>
                        <td id="414"></td>
                        <td id="514"></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>


</body>

</html>