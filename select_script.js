$(document).ready(function () {
    // 將事件監聽器附加到 checkbox 上
    $('#selectionClass').on('change', 'input[type="checkbox"]', function () {
      if ($(this).is(':checked')) {
        var currentRow = $(this).closest('tr');
        console.log(currentRow);
  
        var Course_ID = currentRow.find('td:eq(1)').text(); 
        var Course_Name = currentRow.find('td:eq(2)').text(); 
        var Dept_Name = currentRow.find('td:eq(3)').text();
        var Grade = currentRow.find('td:eq(4)').text();
        var Teacher_Name = currentRow.find('td:eq(5)').text();
        var Credit = currentRow.find('td:eq(6)').text();
        var Class_Type = currentRow.find('td:eq(7)').text();
        var Time = currentRow.find('td:eq(8)').text();
        var User_Name = $('#user_name').text();

  
        console.log('課程 ID：' + Course_ID);
        console.log('課程名稱：' + Course_Name);
        console.log('系所：' + Dept_Name);
        console.log('年級：' + Grade);
        console.log('老師：' + Teacher_Name);
        console.log('學分：' + Credit);
        console.log('課程類型：' + Class_Type);
        console.log('時間：' + Time);
        console.log('使用者：' + User_Name);
  
        
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
    });
  });