// 進行查詢
// 透過不同的選擇有不同的輸入丟給後端
// 判斷當前搜尋到的課程有沒有被選過，選過就要打勾
$(document).ready(function () {
    var User_Name = $('#user_name').text();
    $("#queryButton").click(function () {
      queryCourses();
    });
    function queryCourses() {
      var queryType = $("#options").val();
      var queryValue;
      var queryGrade;
  
      if (queryType === "Dept_Name") {
        queryValue = $("#dept_select").val();
        queryGrade = $("#grade_select").val();
      } else if (queryType === "Course_Name") {
        queryValue = $("#course_name").val();
      } else if (queryType === "Teacher_Name") {
        queryValue = $("#teacher_name").val();
      } else if (queryType === "Time") {
        queryValue = $("#time_options1").val();
        if ($("#time_options2").val() < 10) {
          queryValue = queryValue + 0 + $("#time_options2").val();
        } else queryValue += $("#time_options2").val();
      } else if (queryType === "Course_ID") {
        queryValue = $("#course_id_in").val();
      } else if (queryType === "Sport") {
        queryType = "Course_Name";
        queryValue = $("#sport_select").val();
      } else if (queryType === "GeneralEducation") {
        queryType = "Course_Name";
        queryValue = $("#generalEducation_select").val();
      }
      console.log(queryValue);
      if(queryValue == undefined || queryValue == null || queryValue == ""){
        alert("輸入不可為空!!");
        return;
      }
      if (queryType == "Dept_Name") {
        if (queryGrade == "all") {
          queryGrade = "";
        }
        $.ajax({
          type: "POST",
          url: "query_courses_dept.php",
          data: {
            queryType: queryType,
            queryValue: queryValue,
            queryGrade: queryGrade,
            User_Name: User_Name
          },
  
          success: function (response) {
            displaySelectResults(response);
            console.log("test");
          },
          error: function (error) {
            console.error("Error:", error);
          },
        });
      } else {
        $("#selectionClass").html("");
        $.ajax({
          type: "POST",
          url: "query_courses.php",
          data: { 
            queryType: queryType, 
            queryValue: queryValue ,
            User_Name: User_Name
          },
  
          success: function (response) {
            console.log(response);
            displaySelectResults(response);
          },
          error: function (error) {
            console.error("Error:", error);
          },
        });
      }
  
      function displaySelectResults(response) {
        var tableHTML =
          '<table id ="nowCourse" border="1"><thead><tr><th style="width: 40px;">選擇</th><th style="width: 60px;">最愛</th><th>課號</th><th>課名</th><th>開課系所</th><th>班級</th><th>老師</th><th>學分</th><th>課程類型</th><th>開課時間</th></tr></thead><tbody>';
        var courseData = JSON.parse(response);
        var checkCourseData;
        for (var i = 0; i < courseData.length; i++) {
          tableHTML += "<tr>";
          console.log(courseData[i].Course_ID);
          console.log(User_Name);
          $.ajax({
            type: "POST",
            url: "query_courses_user.php",
            data: { 
              Course_ID: courseData[i].Course_ID ,
              Grade: courseData[i].Grade,
              User_Name: User_Name
            },
    
            success: function (checkResponse) {
              checkCourseData = JSON.parse(checkResponse);
              console.log(checkCourseData);
              if(checkCourseData.length != 0){
                $('input[name="selectedCourses[]"][value="' + checkCourseData[0].Course_ID + checkCourseData[0].Grade +'"]').prop('checked', true);
              }
            },
            error: function (error) {
              console.error("Error:", error);
            },
          });

          $.ajax({
            type: "POST",
            url: "query_courses_favor.php",
            data: { 
              Course_ID: courseData[i].Course_ID ,
              Grade: courseData[i].Grade,
              User_Name: User_Name
            },
    
            success: function (checkResponse) {
              checkCourseData = JSON.parse(checkResponse);
              console.log(checkCourseData);
              if(checkCourseData.length != 0){
                $('input[name="selectedCourses[]"][value="' + checkCourseData[0].Course_ID + checkCourseData[0].Grade +'favor"]').prop('checked', true);
              }
            },
            error: function (error) {
              console.error("Error:", error);
            },
          });

          tableHTML +=
          '<label><td class="selectCourse" style="width: 60px;"><input  type="checkbox" name="selectedCourses[]" value="' +
          courseData[i].Course_ID + courseData[i].Grade +
          '"></td></label>';
          tableHTML += "<td class='favorCourse'><input type='checkbox'  name='selectedCourses[]' value='" + courseData[i].Course_ID + courseData[i].Grade + "favor'></td>";
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
  
        $("#selectionClass").html(tableHTML);
      }
  
    }
  });