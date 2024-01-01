$(document).ready(function () {
    // 將事件監聽器附加到 checkbox 上
    $('#selectionClass').on('change', 'input[type="checkbox"]', function () {
        
        var currentRow = $(this).closest('tr');
        var Course_ID = currentRow.find('td:eq(1)').text(); 
        var Course_Name = currentRow.find('td:eq(2)').text(); 
        var Dept_Name = currentRow.find('td:eq(3)').text();
        var Grade = currentRow.find('td:eq(4)').text();
        var Teacher_Name = currentRow.find('td:eq(5)').text();
        var Credit = currentRow.find('td:eq(6)').text();
        var Class_Type = currentRow.find('td:eq(7)').text();
        var Time = currentRow.find('td:eq(8)').text();
        var User_Name = $('#user_name').text();
        if ($(this).is(':checked')) {
            console.log("insert");
            console.log(currentRow);

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
                console.log(response);
            },
            error: function (error) {
                console.error('錯誤：', error);
            }
            });
        }
        else{
            console.log("delete");
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
            },
            error: function (error) {
                console.error('錯誤：', error);
            }
            });
        }
    });
  });