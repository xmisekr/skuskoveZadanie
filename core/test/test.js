$(document).ready(function() {
    var questions = document.getElementsByClassName("pairQuestion"); 
    var answers = document.getElementsByClassName("pairAnswer"); 
    
    jsPlumb.ready(function() {
        var j = jsPlumb.getInstance({
            Container:"plumb"
            
        });
                          
        var endpointOptions = { isSource:true, connector: ["Straight"] };
        for (let i = 0; i < questions.length; i++){
            var endpoint = jsPlumb.addEndpoint(questions[i].id, endpointOptions);
        }

        var endpointOptions = { isTarget:true};
        for (let i = 0; i < answers.length; i++){
            var endpoint = jsPlumb.addEndpoint(answers[i].id, endpointOptions);
        }
       
    });      
});

function submitPairQuestions(){
    var student_test_id = document.getElementById('student_test_id').value;
    var connections = jsPlumb.getConnections();
    var formData = $(this).serializeArray();
  
    for (let i = 0; i < connections.length; i++){
        for(let j = 0; j < pairQuestions.length; j++){
            if(connections[i]['sourceId'] == pairQuestions[j]['value']){

                let studentAnswer = connections[i]['targetId'];
                let questionId = JSON.stringify(pairQuestions[j]['id']);
                formData.push({"student_test_id": student_test_id, "question_id": questionId, "student_answer": studentAnswer});
            }
            
        }
        
    }
    console.log(formData);

    $.ajax({
        method: 'POST',
        url: "submitTest.php",
        data: {arr: JSON.stringify(formData)},
        success: function(){
        }
        
    
    })
   
}

var submit = document.getElementById('submit');
submit.addEventListener('click', ()=>{
    submitPairQuestions();
})


