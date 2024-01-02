// 初始 load 頁面的時候就會去資料庫尋找當前使用者有選擇甚麼課程並顯示在右方課表
$(document).ready(function () {
    var User_Name = $('#user_name').text();
    $.ajax({
        type: "POST",
        url: "select_class_output.php",
        data: {
            User_Name: User_Name
        },

        success: function (response) {
            var courseData = JSON.parse(response);
            for (var i = 0; i < courseData.length; i++) {
                var timeArray = courseData[i].Time.split(',');
                for(var j = 0; j < timeArray.length; j++){
                    $("#" + timeArray[j]).append('<span id="'+courseData[i].Course_ID+courseData[i].Grade+'">' + courseData[i].Course_ID + "<br>" + courseData[i].Course_Name + "<br>" + courseData[i].Teacher_Name + '</span>');
                }
            }
        },
        error: function (error) {
          console.error("Error:", error);
        },
    });
});

