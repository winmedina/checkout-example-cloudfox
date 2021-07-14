var total_cart = 0;

//Handle call to backend and generate preference.
document.getElementById("checkout-btn").addEventListener("click", function() {
    $('#checkout-btn').attr("disabled", true);
    
    var orderData = {
        quantity: document.getElementById("quantity").value,
        description: document.getElementById("product-description").innerHTML,
        price: document.getElementById("unit-price").innerHTML
    };

    $(".shopping-cart").fadeOut(500);
    setTimeout(() => {
        $(".payment-method").show(500).fadeIn();

        document.getElementById("item-credit-card").addEventListener("click", function() {
            $(".payment-method").fadeOut(500);
            setTimeout(() => {
                $(".payment-credit-card").show(500).fadeIn();
                $("#alertPaymentCC").html('');
                getInstallments();
            }, 500);
        }); 

        document.getElementById("item-boleto").addEventListener("click", function() {
            $(".payment-method").fadeOut(500);
            setTimeout(() => {
                $(".payment-boleto").show(500).fadeIn();
            }, 500);
        });
        
        document.getElementById("item-pix").addEventListener("click", function() {
            $(".payment-method").fadeOut(500);
            setTimeout(() => {
                $(".payment-pix").show(500).fadeIn();
            }, 500);
        });
             
    }, 500);

    
});
  
function updatePrice() {
    let quantity = document.getElementById("quantity").value;
    let unitPrice = document.getElementById("unit-price").innerHTML;
    let amount = parseInt(unitPrice) * parseInt(quantity);
  
    $("#cart-total").html("R$ " + amount);
    $(".summary-price").html("R$ " + unitPrice);
    $(".summary-quantity").html(quantity);
    $(".summary-total").html("R$ " + amount);

    total_cart = amount;
}

document.getElementById("quantity").addEventListener("change", updatePrice);

updatePrice();  
  
document.getElementById("go-back-cart").addEventListener("click", function() {
    $(".payment-method").fadeOut(500);
    setTimeout(() => {
        $(".shopping-cart").show(500).fadeIn();
    }, 500);
    $('#checkout-btn').attr("disabled", false);  
});

$('.go-to-back-pm').on('click',function(){
    $(`.payment-${$(this).attr('pm')}`).fadeOut(500);
    setTimeout(() => {        
        $(".payment-method").show(500).fadeIn();
    }, 500);    
});

function getInstallments(){

    var formData = new FormData();
    formData.append('amount', total_cart);

    $.ajax({
        method: "POST",
        url: '/installments',
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        headers: {            
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        },           
        data:formData,            
        error: function (response) {              
            console.log(response.responseJSON);            
            $("#alertPaymentCC").html(`<div class="alert alert-danger">${response.responseJSON.message}</div>`);
        },            
        success: function (response) {                
            console.log(response);
            $('#installments').html('');
            response.forEach(element => {
                $('#installments').append(`<option value="${element.amount}">${element.amount} x de R$ ${element.value}</option>`);            
            });
        }
    }); 
}

$( "#form-credit-card" ).submit(function( event ) {
    event.preventDefault();
    if (window.dftp) {
        dftp.profile(sendPaymentCardData);
    } else {
        sendPaymentCardData();
    }
});

function sendPaymentCardData(){
    var formData = new FormData($("#form-credit-card")[0]);
    formData.append('attempt_reference', CloudfoxAntifraud.options.attemptReference);
    formData.append('amount', total_cart);
    formData.append('payment_method', 'credit_card');
    
    $.ajax({
        method: "POST",
        url: '/payment',
        processData: false,
        cache: false,
        contentType: false,
        dataType: "json",
        headers: {                    
            'Accept': 'application/json',
        },   
        crossDomain:false,         
        data: formData,            
        beforeSend: function () {                
            $(".payment-credit-card").loading({message: '...',start:true});
            $('.btn-finish').removeAttr('disabled');
        },
        error: function (response) {                                    
            $(".payment-credit-card").loading('stop');
            $('.btn-finish').removeAttr('disabled');
        },            
        success: function (response) {                
            $(".payment-credit-card").loading('stop');
            $('.btn-finish').removeAttr('disabled');
            if(response.status=='error'){
                $("#alertPaymentCC").html(`<div class="alert alert-danger">${response.message}</div>`);
            }else{
                $("#alertPaymentCC").html(`<div class="alert alert-success">${response.message}</div>`);
            }
            console.log(response);
        }
    }); 
}

