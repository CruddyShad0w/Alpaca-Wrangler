/* global $*/
/*

*/
function account_details() {
    $.ajax({
        type: "GET",
        url: "backend.php",
        dataType: "html",
        data: {
            'account_details': 'details',
        },
        success: function(data, stats) {
            console.log('success')
            $("#account_details").append(data);

        },
        error: function(data, stats) {
            console.log(stats)
            console.log(data)
            console.log('error in restapi: account_details()')
        }
    })
}

function update_ticker() {
    $.ajax({
        type: "GET",
        url: "backend.php",
        dataType: "html",
        data: {
            'ticker': 'get_ticker'
        },
        success: function(data, stats) {
            console.log('success')
            $("#banner").html(data);

        },
        error: function(data, stats) {
            console.log(stats)
            console.log(data)
            console.log('error in restapi: update_ticker()')

        }
    })
}

function update_cards_large(){
    $.ajax({
        type: "GET",
        url: "backend.php",
        dataType: "html",
        data: {
                'cards': 'large',
        },
        success: function(data, stats) {
            console.log('success')
            $("#cards").html(data);

        },
        error: function(data, stats) {
            console.log(stats)
            console.log(data)
            console.log('error in restapi: update_cards_large()')

        }
    })
}

function update_cards_small(){
    $.ajax({
        type: "GET",
        url: "backend.php",
        dataType: "html",
        data: {
                'cards': 'small',
        },
        success: function(data, stats) {
            console.log('success')
            $("#cards").html(data);

        },
        error: function(data, stats) {
            console.log(stats)
            console.log(data)
            console.log('error in restapi: update_cards_small()')

        }
    })
}



$("document").ready(function() {

    $("#updateButton").click(

        function() {
            if ($("#update_type :selected").val() === "ticker") {
                $('#currentValue, #buyingPower, #dayTrader, #tradingBlocked').remove();

                update_ticker()
                account_details();
            }
            else if ($("#update_type :selected").val() === "large") {

                update_cards_large()
            }
            else if ($("#update_type :selected").val() === "small") {

                update_cards_small()
            }

            return false;

        })

    $("#submitButton").click(
        function() {
            console.log('submit');
            $('.card').remove();
            $.ajax({
                type: "POST",
                url: "backend.php",
                dataType: "json",
                data: {
                    'user_data': 'true',
                    'base_url': $("#base_url :selected").val(),
                    'username': $("#key").val(),
                    'password': $("#secret").val(),

                },
                success: function(data, stats) {
                    console.log('success')
                },
                error: function(data, stats) {
                    console.log(stats)
                    console.log(data)
                    console.log('error in restapi: Post log in information')
                }
            })

            account_details()
            update_ticker()

            return false;
        })

})
