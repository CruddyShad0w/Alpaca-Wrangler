/* global $*/
/*

*/
let submit_count = 0;
$("document").ready(function() {
    
   $("#submitButton").click(
       function(){
           console.log('submit');
            $.ajax({
                    type: "POST",
                    url: "backend.php",
                    dataType: "json",
                    data: {
                        'user_data': 'true',
                        'base_url' : $("#base_url :selected").val(),
                        'username' : $("#key").val(), 
                        'password' : $("#secret").val(),

                    },
                    success: function(data, stats) {
                        console.log('success')
                        
                        
                    },
                    error: function(data, stats) {
                        console.log(stats)
                        console.log(data)
                        console.log('error in restapi')

                    }
                })
                 
                $.ajax({
                    type: "GET",
                    url: "backend.php",
                    dataType: "html",
                    data: {
                        'ticker':'get_ticker',
                    },
                    success: function(data, stats) {
                        console.log('success')
                        $("#banner").html(data);
                        
                    },
                    error: function(data, stats) {
                        console.log(stats)
                        console.log(data)
                        console.log('error in restapi')

                    }
                })

                $.ajax({
                    type: "GET",
                    url: "backend.php",
                    dataType: "html",
                    data: {
                        'account_details':'details',
                    },
                    success: function(data, stats) {
                        console.log('success')
                        
                        $("#account_details").append(data);
                        submit_count = submit_count + 1;
                        
                        
                        
                        
                    },
                    error: function(data, stats) {
                        console.log(stats)
                        console.log(data)
                        console.log('error in restapi')

                    }
                })
                $.ajax({
                    type: "GET",
                    url: "backend.php",
                    dataType: "html",
                    data: {
                        'cards': 'get_cards',
                    },
                    success: function(data, stats) {
                        console.log('success')
                        $("#cards").html(data);
                        
                    },
                    error: function(data, stats) {
                        console.log(stats)
                        console.log(data)
                        console.log('error in restapi')

                    }
                })
               
        return false;
       })
       
})
