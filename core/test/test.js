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