$(document).ready(function () {
  $("#course, #teacher, #time ,#course_id, #sport,#generalEducation").hide();
  $("#department").show();
  // 監聽選擇框變化事件
  $("#options").change(function () {
    // 獲取選擇框的值
    var selectedOption = $(this).val();

    // 隱藏所有的 span
    $(
      "#department, #course, #teacher, #time ,#course_id, #sport,#generalEducation"
    ).hide();

    // 根據選擇的值顯示相應的 span
    if (selectedOption === "Dept_Name") {
      $("#department").show();
    } else if (selectedOption === "Course_Name") {
      $("#course").show();
    } else if (selectedOption === "Teacher_Name") {
      $("#teacher").show();
    } else if (selectedOption === "Time") {
      $("#time").show();
    } else if (selectedOption === "Course_ID") {
      $("#course_id").show();
    } else if (selectedOption === "Sport") {
      $("#sport").show();
    } else if (selectedOption === "GeneralEducation") {
      $("#generalEducation").show();
    }
    // 可以根據需要添加其他條件
  });
});

// 進行查詢
$(document).ready(function () {

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
        },

        success: function (response) {
          displayResults(response);
        },
        error: function (error) {
          console.error("Error:", error);
        },
      });
    } else {
      $.ajax({
        type: "POST",
        url: "query_courses.php",
        data: { queryType: queryType, queryValue: queryValue },

        success: function (response) {
          displayResults(response);
        },
        error: function (error) {
          console.error("Error:", error);
        },
      });
    }

    function displayResults(response) {
      var tableHTML =
        '<table id ="nowCourse" border="1"><thead><tr><th style="width: 35px;">選擇</th><th>課號</th><th>課名</th><th>開課系所</th><th>班級</th><th>老師</th><th>學分</th><th>課程類型</th><th>開課時間</th></tr></thead><tbody>';
      var courseData = JSON.parse(response);
      for (var i = 0; i < courseData.length; i++) {
        tableHTML += "<tr>";
        tableHTML +=
          '<label><td style="width: 35px;"><input type="checkbox" name="selectedCourses[]" value="' +
          courseData[i].Course_ID +
          '"></td></label>';
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

// 控制現在顯示查詢課表還是最愛等等的表格
$(document).ready(function () {
  var User_Name = $('#user_name').text();
  $("#selectionClass").show();
  $("#selectionClassButton").css("background-color", "#805a94");
  $("#nowSelectionClass").hide();
  $("#selectionClassButton, #nowSelectionClassButton").click(function () {

    var target = $(this).attr("id");
    if (target == "selectionClassButton") {
      $("#selectionClass").show();
      $("#nowSelectionClass").hide();
      $("#selectionClassButton").css("background-color", "#805a94");
      $("#nowSelectionClassButton").css("background-color", "#ab77c5");
    } else {
      $("#selectionClass").hide();
      $("#nowSelectionClass").show();

      $("#selectionClassButton").css("background-color", "#ab77c5");
      $("#nowSelectionClassButton").css("background-color", "#805a94");

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
          '"></td></label>';
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
  });
});

// export PDF
function start() {
  document.getElementById("exportButton").addEventListener("click", () => {
    let table = document.getElementById("classTable");

    const width = table.offsetWidth;
    const height = table.offsetHeight;

    let printWindow = window.open("", "", `width=${width}, height=${height}`);

    printWindow.document.write("<html><head><title>Print Table</title>");
    printWindow.document.write("</head><body></body></html>");
    printWindow.document.close();

    printWindow.document.body.innerHTML = `
            <style>
            html, body {
                margin: 0;
                padding: 10px;
            }

            table, th, td {
                border: 1px solid;
            }
            body {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            table {
                width: 100%;
                height: auto;
                border-collapse: collapse;
            }
            </style>
            <table>
                ${table.innerHTML}
            </table>
        `;

    printWindow.focus();
    printWindow.print();
    printWindow.close();
  });
}

window.addEventListener("load", start, false);
