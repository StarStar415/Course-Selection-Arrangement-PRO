$(document).ready(function() {
    $('#course, #teacher, #time').hide();
    $('#department').show();
    // 監聽選擇框變化事件
    $('#options').change(function() {
        // 獲取選擇框的值
        var selectedOption = $(this).val();

        // 隱藏所有的 span
        $('#department, #course, #teacher,#time').hide();

        // 根據選擇的值顯示相應的 span
        if (selectedOption === 'dept') {
            $('#department').show();
        } else if (selectedOption === 'course') {
            $('#course').show();
        }
        else if (selectedOption === 'teacher') {
            $('#teacher').show();
        }
        else if (selectedOption === 'time') {
            $('#time').show();
        }
        // 可以根據需要添加其他條件
    });
});

$(document).ready(function () {
    $("#queryButton").click(function () {
        queryCourses();
    });

    function queryCourses() {
        var courseName = $("#course_name").val();
        $.ajax({
            type: "POST",
            url: "query_courses.php",
            data: { courseName: courseName },

            
            success: function (response) {
                var tableHTML = '<table id ="nowCourse" border="1"><thead><tr><th>課號</th><th>課名</th><th>開課系所</th><th>班級</th><th>老師</th><th>課程類型</th><th>開課時間</th></tr></thead><tbody>';
                var courseData = JSON.parse(response);
                for (var i = 0; i < courseData.length; i++) {
                    console.log(courseData[i]["Course_ID"]);
                    tableHTML += '<tr>';
                    tableHTML += '<td>' + courseData[i].Course_ID + '</td>';
                    tableHTML += '<td>' + courseData[i].Course_Name + '</td>';
                    tableHTML += '<td>' + courseData[i].Dept_Name + '</td>';
                    tableHTML += '<td>' + courseData[i].Grade + '</td>';
                    tableHTML += '<td>' + courseData[i].Teacher_Name + '</td>';
                    tableHTML += '<td>' + courseData[i].Class_Type + '</td>';
                    tableHTML += '<td>' + courseData[i].Time + '</td>';
                    tableHTML += '</tr>';
                }
                
                tableHTML += '</tbody></table>';

                $("#selectionClass").html(tableHTML);
            },
            error: function (error) {
                console.error("Error:", error);
            }
        });
    }
});