document.addEventListener("visibilitychange", function(){
    
    if (document.visibilityState == "hidden"){
        var teacher_id = document.getElementById('teacher_id').value;
        var name = document.getElementById('student_name').value;
        var surname = document.getElementById('student_surname').value;
        var student = name + ' ' + surname;

        var data = {'teacher_id' : teacher_id, 'student': student};
        $.ajax({
            method: 'POST',
            url: "../notification/saveNotification.php",
            data: data,
            success: function(){
            }
            
        
        })
    }
});