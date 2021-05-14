$('form.ajax').on('submit', function() {
    let points = document.getElementsByClassName('points');
    let test_id = document.getElementById('test_id').value
    let data = [];
    
    for(let i = 0; i < points.length; i++){
        let student_test_answer = points[i].id;
        let point = points[i].value;

        data.push({"student_test_answer" : student_test_answer, "points" : point});
    }
   
    $.ajax({
        method: 'POST',
        url: "submitPoints.php",
        data: {arr: data},
        success: function(){
        }
        
    })

    setTimeout(()=>{
        window.location.href = '../listStudents/listStudents.php?test_id=' + test_id;

    },1000);

    return false;
});