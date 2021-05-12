function toggleButton(){
    var allToggles = $('.test-active').map(function(){
        $(this).change(function(){
            var test_id = $(this).next().val()
            if ($(this).is(':checked')){
                var data = {'test_id' : test_id, 'active' : 1};
                $.ajax({
                    
                    method: 'POST',
                    url: "dashboard.php",
                    data: data,
                    success: function(){} 
                });
    
            }else{
                var data = {'test_id' : test_id, 'active' : 0};
                $.ajax({
                    
                    method: 'POST',
                    url: "dashboard.php",
                    data: data,
                    success: function(){}
                });
            }
        })
    }).get();
    
}

toggleButton();