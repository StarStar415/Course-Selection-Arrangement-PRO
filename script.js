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