$(document).ready(function () {
    console.log("test");
    
    var User_Name = $('#user_name').text();
    $.ajax({
        type: "POST",
        url: "select_class_output.php",
        data: {
            User_Name: User_Name
        },

        success: function (response) {
            var courseData = JSON.parse(response);
            console.log(courseData);
            for (var i = 0; i < courseData.length; i++) {
                console.log(courseData[i]);
                var timeArray = courseData[i].Time.split(',');
                console.log(timeArray);
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

