// checkbox 切換時候要寫入 user_class 資料和刪除 user_class 資料
// 並且新增到右方課表
// 每次都會更新 nowSelect
$(document).ready(function () {
    // 將事件監聽器附加到 checkbox 上
    
    var User_Name = $('#user_name').text();
    console.log(User_Name);
    $.ajax({
        type: 'POST',
        url: 'count_total_credit.php', 
        data: {
            User_Name: User_Name
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.error('錯誤：', error);
        }
        });

    $('#selectionClass, #nowSelectionClass, #favorSelectionClass').on('change', 'input[type="checkbox"]', function () {
        console.log("ouo");
        var id = $(this).closest('[id]').parent().attr('id');
        console.log(id);
        if (id === 'selectionClass') {
            var currentRow = $(this).closest('tr');
            var Course_ID = currentRow.find('td:eq(2)').text();
            var Course_Name = currentRow.find('td:eq(3)').text(); 
            var Dept_Name = currentRow.find('td:eq(4)').text();
            var Grade = currentRow.find('td:eq(5)').text();
            var Teacher_Name = currentRow.find('td:eq(6)').text();
            var Credit = currentRow.find('td:eq(7)').text();
            var Class_Type = currentRow.find('td:eq(8)').text();
            var Time = currentRow.find('td:eq(9)').text();
            console.log('selectionClass 觸發了變更事件');
        } else {
            var currentRow = $(this).closest('tr');
            var Course_ID = currentRow.find('td:eq(1)').text();
            var Course_Name = currentRow.find('td:eq(2)').text(); 
            var Dept_Name = currentRow.find('td:eq(3)').text();
            var Grade = currentRow.find('td:eq(4)').text();
            var Teacher_Name = currentRow.find('td:eq(5)').text();
            var Credit = currentRow.find('td:eq(6)').text();
            var Class_Type = currentRow.find('td:eq(7)').text();
            var Time = currentRow.find('td:eq(8)').text();
            console.log('favorSelectionClass 觸發了變更事件');
        } 
        // 判斷 checkbox 的父元素是否有 class 'favorCourse'
        var isSelectCourse = $(this).closest('td').hasClass('selectCourse');
        var isFavorCourse = $(this).closest('td').hasClass('favorCourse');
        console.log(isSelectCourse);
        console.log(isFavorCourse);
        if (isFavorCourse) {
            if ($(this).is(':checked')) {
                // 將資料寫入 db
                
                $.ajax({
                type: 'POST',
                url: 'insert_favor_course.php', 
                data: {
                    Course_ID: Course_ID,
                    Course_Name: Course_Name,
                    Dept_Name: Dept_Name,
                    Grade: Grade,
                    Teacher_Name: Teacher_Name,
                    Credit: Credit,
                    Class_Type: Class_Type,
                    Time: Time,
                    User_Name: User_Name
                },
                success: function (response) {
                    updateFavorTable();
                },
                error: function (error) {
                    console.error('錯誤：', error);
                }
                });
                $('input[name="selectedCourses[]"][value="' + Course_ID + Grade +'favor"]').prop('checked', true);
            }
            else{
                // 將資料刪除 db
                console.log(currentRow);
                $.ajax({
                type: 'POST',
                url: 'delete_favor_course.php', 
                data: {
                    Course_ID: Course_ID,
                    Grade: Grade,
                    User_Name: User_Name
                },
                success: function (response) {
                    updateFavorTable();
                },
                error: function (error) {
                    console.error('錯誤：', error);
                }
                });
                
                $('input[name="selectedCourses[]"][value="' + Course_ID + Grade +'favor"]').prop('checked', false);
            }
        }
        else{
            
            console.log("select");
            if ($(this).is(':checked')) {
                
                $('input[name="selectedCourses[]"][value="' + Course_ID + Grade +'"]').prop('checked', true);
                console.log("checked");
                // 將資料寫入 db
                $.ajax({
                type: 'POST',
                url: 'insert_course.php', 
                data: {
                    Course_ID: Course_ID,
                    Course_Name: Course_Name,
                    Dept_Name: Dept_Name,
                    Grade: Grade,
                    Teacher_Name: Teacher_Name,
                    Credit: Credit,
                    Class_Type: Class_Type,
                    Time: Time,
                    User_Name: User_Name
                },
                success: function (response) {
                    updateTable();
                },
                error: function (error) {
                    console.error('錯誤：', error);
                }
                });
                
                var timeArray = Time.split(',');
                console.log(timeArray);
                for(var i = 0; i < timeArray.length; i++){
                    $("#" + timeArray[i]).append('<span id="'+Course_ID+Grade+'">' + Course_ID + "<br>" + Course_Name + "<br>" + Teacher_Name + '</span>');
                }
                
            }
            else{
                // 將資料刪除 db
                $('input[name="selectedCourses[]"][value="' + Course_ID + Grade +'"]').prop('checked', false);
                
                console.log(Course_ID);
                console.log(Grade);
                console.log(User_Name);
                console.log("Nochecked");
                console.log(currentRow);
                $.ajax({
                type: 'POST',
                url: 'delete_course.php', 
                data: {
                    Course_ID: Course_ID,
                    Grade: Grade,
                    User_Name: User_Name
                },
                success: function (response) {
                    console.log(response);
                    updateTable();
                },
                error: function (error) {
                    console.error('錯誤：', error);
                }
                });
                // 刪除右方課表
                var timeArray = Time.split(',');
                console.log(timeArray);
                for(var i = 0; i < timeArray.length; i++){
                    $("#" + Course_ID+Grade).text("");
                }
            }
        }
        
        function updateTable(){
            $.ajax({
                type: "POST",
                url: "select_class_output.php",
                data: {
                    User_Name: User_Name
                },
        
                success: function (response) {
                  displayResults(response);
                },
                error: function (error) {
                  console.error("Error:", error);
                },
              });
        }

        function updateFavorTable(){
            $.ajax({
                type: "POST",
                url: "favor_class_output.php",
                data: {
                    User_Name: User_Name
                },
        
                success: function (response) {
                    displayFavorResults(response);
                },
                error: function (error) {
                    console.error("Error:", error);
                },
              });
        }
        

        function displayResults(response) {
        var tableHTML =
            '<table id ="nowCourse" border="1"><thead><tr><th style="width: 35px;">選擇</th><th>課號</th><th>課名</th><th>開課系所</th><th>班級</th><th>老師</th><th>學分   </th><th>課程類型</th><th>開課時間</th></tr></thead><tbody>';
        var courseData = JSON.parse(response);
        for (var i = 0; i < courseData.length; i++) {
            tableHTML += "<tr>";
            tableHTML +=
            '<label><td class="selectCourse" style="width: 35px;"><input type="checkbox" name="selectedCourses[]" value="' +
            courseData[i].Course_ID + courseData[i].Grade +
            '" checked></td></label>';
            tableHTML += "<td>" + courseData[i].Course_ID + "</td>";
            tableHTML += "<td>" + courseData[i].Course_Name + "</td>";
            tableHTML += "<td>" + courseData[i].Dept_Name + "</td>";
            tableHTML += "<td>" + courseData[i].Grade + "</td>";
            tableHTML += "<td>" + courseData[i].Teacher_Name + "</td>";
            
            tableHTML += "<td>" + courseData[i].Credit + "</td>";
            tableHTML += "<td>" + courseData[i].Class_Type + "</td>";
            tableHTML += "<td>" + courseData[i].Time + "</td>";
            tableHTML += "</tr>";
        }
    
        tableHTML += "</tbody></table>";
    
        $("#nowSelectionClass").html(tableHTML);
        }

        function displayFavorResults(response) {
            console.log("favorResults");
            var tableHTML =
                '<table id ="nowCourse" border="1"><thead><tr><th style="width: 35px;">最愛</th><th>課號</th><th>課名</th><th>開課系所</th><th>班級</th><th>老師</th><th>學分   </th><th>課程類型</th><th>開課時間</th></tr></thead><tbody>';
            var courseData = JSON.parse(response);
            for (var i = 0; i < courseData.length; i++) {
                tableHTML += "<tr>";
                tableHTML +=
                '<label><td class="favorCourse" style="width: 35px;"><input type="checkbox" name="selectedCourses[]" value="' +
                courseData[i].Course_ID + courseData[i].Grade +
                '" checked></td></label>';
                tableHTML += "<td>" + courseData[i].Course_ID + "</td>";
                tableHTML += "<td>" + courseData[i].Course_Name + "</td>";
                tableHTML += "<td>" + courseData[i].Dept_Name + "</td>";
                tableHTML += "<td>" + courseData[i].Grade + "</td>";
                tableHTML += "<td>" + courseData[i].Teacher_Name + "</td>";
                
                tableHTML += "<td>" + courseData[i].Credit + "</td>";
                tableHTML += "<td>" + courseData[i].Class_Type + "</td>";
                tableHTML += "<td>" + courseData[i].Time + "</td>";
                tableHTML += "</tr>";
            }
        
            tableHTML += "</tbody></table>";
        
            $("#favorSelectionClass").html(tableHTML);
            }
    });
  });