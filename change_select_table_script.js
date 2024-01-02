// 控制現在顯示查詢課表還是最愛等等的表格
$(document).ready(function () {
    console.log("ready");
    var User_Name = $('#user_name').text();
    $("#selectionClass").show();
    $("#selectionClassButton").css("background-color", "#805a94");
    $("#nowSelectionClass").hide();
    $("#favorSelectionClass").hide();

    $("#selectionClassButton, #nowSelectionClassButton, #favorSelectionClassButton").click(function () {
  
      var target = $(this).attr("id");
      if (target == "selectionClassButton") {
        $("#selectionClass").show();
        $("#nowSelectionClass").hide();
        $("#favorSelectionClass").hide();

        $("#selectionClassButton").css("background-color", "#805a94");
        $("#nowSelectionClassButton").css("background-color", "#ab77c5");
        $("#favorSelectionClassButton").css("background-color", "#ab77c5");
      } else if (target == "nowSelectionClassButton"){
        console.log("nowSelectionClass");
        $("#selectionClass").hide();
        $("#nowSelectionClass").show();
        $("#favorSelectionClass").hide();

        $("#selectionClassButton").css("background-color", "#ab77c5");
        $("#nowSelectionClassButton").css("background-color", "#805a94");
        $("#favorSelectionClassButton").css("background-color", "#ab77c5");
  
        $.ajax({
          type: "POST",
          url: "select_class_output.php",
          data: {
              User_Name: User_Name
          },
  
          success: function (response) {
            displayResults2(response);
          },
          error: function (error) {
            console.error("Error:", error);
          },
        });
  
        function displayResults2(response) {
        var tableHTML =
            '<table id ="nowCourse" border="1"><thead><tr><th style="width: 35px;">刪除</th><th>課號</th><th>課名</th><th>開課系所</th><th>班級</th><th>老師</th><th>學分   </th><th>課程類型</th><th>開課時間</th></tr></thead><tbody>';
        var courseData = JSON.parse(response);
        for (var i = 0; i < courseData.length; i++) {
            tableHTML += "<tr>";
            tableHTML +=
            '<label><td style="width: 35px;"><input type="checkbox" name="selectedCourses[]" value="' +
            courseData[i].Course_ID +
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
      }
      else if (target == "favorSelectionClassButton"){
        $("#selectionClass").hide();
        $("#nowSelectionClass").hide();
        $("#favorSelectionClass").show();

        $("#selectionClassButton").css("background-color", "#ab77c5");
        $("#nowSelectionClassButton").css("background-color", "#ab77c5");
        $("#favorSelectionClassButton").css("background-color", "#805a94");
        console.log("favorSelectionClass");
        $.ajax({
          type: "POST",
          url: "favor_class_output.php",
          data: {
              User_Name: User_Name
          },
  
          success: function (response) {
            displayResults3(response);
          },
          error: function (error) {
            console.error("Error:", error);
          },
        });
  
        function displayResults3(response) {
        var tableHTML =
            '<table id ="nowCourse" border="1"><thead><tr><th style="width: 35px;">最愛</th><th>課號</th><th>課名</th><th>開課系所</th><th>班級</th><th>老師</th><th>學分   </th><th>課程類型</th><th>開課時間</th></tr></thead><tbody>';
        var courseData = JSON.parse(response);
        for (var i = 0; i < courseData.length; i++) {
            tableHTML += "<tr>";
            tableHTML +=
            '<label><td style="width: 35px;"><input type="checkbox" name="selectedCourses[]" value="' +
            courseData[i].Course_ID +
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
      }
    });
  });