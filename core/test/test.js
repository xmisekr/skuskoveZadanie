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
    

    $.ajax({
        method: 'POST',
        url: "submitTest.php",
        data: {arr: JSON.stringify(formData)},
        success: function(){
            
        }
        
    
    })

   
}

//sends all
$('form.ajax').on('submit', function() {
    submitPairQuestions();
    
    var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};

    that.find('[name]').each(function(index, value) {
        var that = $(this),
            name = that.attr('name'),
            value = that.val();

            if (that.attr('type') != "radio"){
                data[name] = value;
                console.log("hit");

            }else{
                if (that.is(':checked')){
                    data[name] = value;
                }
            }

        
    });

    $.ajax({
        url: url,
        method: type,
        data: data,
        success: function(){}
    });

    return false;
});


