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
        $(".container_payment").show(500).fadeIn();

        document.getElementById("item-credit-card").addEventListener("click", function() {
            $(".container_payment").fadeOut(500);
            setTimeout(() => {
                $(".container_payment_credit_card").show(500).fadeIn();
            }, 500);
        }); 
             
    }, 500);

    
      
    // fetch("/create-preference", {
    //         method: "POST",
    //         headers: {
    //             "Content-Type": "application/json",
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         body: JSON.stringify(orderData),
    //   })
    //     .then(function(response) {
    //         return response.json();
    //     })
    //     .then(function(preference) {
    //         createCheckoutButton(preference.id);
    //         $(".shopping-cart").fadeOut(500);
    //         setTimeout(() => {
    //             $(".container_payment").show(500).fadeIn();
    //         }, 500);
    //     })
    //     .catch(function() {
    //         alert("Unexpected error");
    //         $('#checkout-btn').attr("disabled", false);
    //     });
  });
  
  //Handle price update
  function updatePrice() {
    let quantity = document.getElementById("quantity").value;
    let unitPrice = document.getElementById("unit-price").innerHTML;
    let amount = parseInt(unitPrice) * parseInt(quantity);
  
    $("#cart-total").html("R$ " + amount);
    $(".summary-price").html("R$ " + unitPrice);
    $(".summary-quantity").html(quantity);
    $(".summary-total").html("R$ " + amount);
  }

  document.getElementById("quantity").addEventListener("change", updatePrice);

  updatePrice();  
  
  //go back
  document.getElementById("go-back").addEventListener("click", function() {
    $(".container_payment").fadeOut(500);
    setTimeout(() => {
        $(".shopping-cart").show(500).fadeIn();
    }, 500);
    $('#checkout-btn').attr("disabled", false);  
  });
