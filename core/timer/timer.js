$(document).ready(function(){
    function startCountdown(){
        var myTimer = $('.countdown').startTimer({
    
            onPause: $('.timerpause'),
        
            onReset: $('.timerreset'),
        
            onStart: $('.timerstart')
        
        });
        
        myTimer.trigger('start');
        saveTimer();
        
    }

    function saveTimer(){
        
        setInterval(()=>{
            var id = $('#timer_id').val();
            id = parseInt(id);
        
            var hoursDirty = $('.jst-hours').text();
            var hoursArray = hoursDirty.split(':');
            var hours = parseInt(hoursArray[0]);
        
            var minutesDirty = $('.jst-minutes').text();
            var minutesArray = minutesDirty.split(':');
            var minutes = parseInt(minutesArray[0]);
        
            var secondsDirty = $('.jst-seconds').text();
            var secondsArray = secondsDirty.split(':');
            var seconds = parseInt(secondsArray[0]);
            
            var data = {"id": id, "hours": hours, "minutes": minutes, "seconds": seconds};
            
            $.ajax({
                method: 'POST',
                url: "../timer/timer.php",
                data: data,
                success: function(){
                }
                
            
            })
    
        }, 1000);
    }


    startCountdown();
});
