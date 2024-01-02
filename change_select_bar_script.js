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