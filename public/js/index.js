/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/index.js":
/*!*******************************!*\
  !*** ./resources/js/index.js ***!
  \*******************************/
/***/ (() => {

var total_cart = 0; //Handle call to backend and generate preference.

document.getElementById("checkout-btn").addEventListener("click", function () {
  $('#checkout-btn').attr("disabled", true);
  var orderData = {
    quantity: document.getElementById("quantity").value,
    description: document.getElementById("product-description").innerHTML,
    price: document.getElementById("unit-price").innerHTML
  };
  $(".shopping-cart").fadeOut(500);
  setTimeout(function () {
    $(".payment-method").show(500).fadeIn();
    document.getElementById("item-credit-card").addEventListener("click", function () {
      $(".payment-method").fadeOut(500);
      setTimeout(function () {
        $(".payment-credit-card").show(500).fadeIn();
        $("#alertPaymentCC").html('');
        getInstallments();
      }, 500);
    });
    document.getElementById("item-boleto").addEventListener("click", function () {
      $(".payment-method").fadeOut(500);
      setTimeout(function () {
        $(".payment-boleto").show(500).fadeIn();
      }, 500);
    });
    document.getElementById("item-pix").addEventListener("click", function () {
      $(".payment-method").fadeOut(500);
      setTimeout(function () {
        $(".payment-pix").show(500).fadeIn();
      }, 500);
    });
  }, 500);
});

function updatePrice() {
  var quantity = document.getElementById("quantity").value;
  var unitPrice = document.getElementById("unit-price").innerHTML;
  var amount = parseInt(unitPrice) * parseInt(quantity);
  $("#cart-total").html("R$ " + amount);
  $(".summary-price").html("R$ " + unitPrice);
  $(".summary-quantity").html(quantity);
  $(".summary-total").html("R$ " + amount);
  total_cart = amount;
}

document.getElementById("quantity").addEventListener("change", updatePrice);
updatePrice();
document.getElementById("go-back-cart").addEventListener("click", function () {
  $(".payment-method").fadeOut(500);
  setTimeout(function () {
    $(".shopping-cart").show(500).fadeIn();
  }, 500);
  $('#checkout-btn').attr("disabled", false);
});
$('.go-to-back-pm').on('click', function () {
  $(".payment-".concat($(this).attr('pm'))).fadeOut(500);
  setTimeout(function () {
    $(".payment-method").show(500).fadeIn();
  }, 500);
});

function getInstallments() {
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
      'Accept': 'application/json'
    },
    data: formData,
    error: function error(response) {
      $("#alertPaymentCC").html("<div class=\"alert alert-danger\">".concat(response.responseJSON.message, "</div>"));
    },
    success: function success(response) {
      $('#installments').html('');
      response.forEach(function (element) {
        $('#installments').append("<option value=\"".concat(element.amount, "\">").concat(element.amount, " x de R$ ").concat(element.value, "</option>"));
      });
    }
  });
}

$("#form-credit-card").submit(function (event) {
  event.preventDefault(); //essencial para executar o antifraude

  if (window.dftp) {
    dftp.profile(sendPaymentCardData);
  } else {
    sendPaymentCardData();
  }
});

function sendPaymentCardData() {
  postPayment("#form-credit-card", 'credit_card', ".payment-credit-card", "#alertPaymentCC");
}

$("#form-boleto").submit(function (event) {
  event.preventDefault();
  postPayment("#form-boleto", "boleto", ".payment-boleto", "#alertPaymentBo");
});
$("#form-pix").submit(function (event) {
  event.preventDefault();
  postPayment("#form-pix", "pix", ".payment-pix", "#alertPaymentPix");
});

function postPayment(divForm, payment_method, divLoading, divAlert) {
  divLoading = "".concat(divLoading, " .box-content");
  var formData = new FormData($(divForm)[0]);

  if (payment_method == 'credit_card') {
    formData.append('attempt_reference', CloudfoxAntifraud.getAttemptReference());
    console.log(CloudfoxAntifraud.getAttemptReference());
  }

  formData.append('amount', total_cart);
  formData.append('payment_method', payment_method);
  $.ajax({
    method: "POST",
    url: '/payment',
    processData: false,
    cache: false,
    contentType: false,
    dataType: "json",
    headers: {
      'Accept': 'application/json'
    },
    crossDomain: false,
    data: formData,
    beforeSend: function beforeSend() {
      $(divLoading).loading({
        message: '...',
        start: true
      });
      $('.btn-finish').removeAttr('disabled');
    },
    error: function error(response) {
      $(divLoading).loading('stop');
      $('.btn-finish').removeAttr('disabled');
      console.log(response);
      $(divAlert).html("<div class=\"alert alert-danger\">".concat(response.responseJSON.message, "</div>"));
    },
    success: function success(data) {
      $(divLoading).loading('stop');
      $('.btn-finish').removeAttr('disabled');
      console.log(data.response);

      if (data.status == 'error') {
        $(divAlert).html("<div class=\"alert alert-danger\">".concat(data.message, "</div>"));
      } else {
        $('.btn-finish').hide();

        switch (payment_method) {
          case 'pix':
            $(divAlert).html("<div class=\"alert alert-success\">Qrcode gerado com sucesso!</div>");
            $('#qrcode_img').html("<img src=\"".concat(data.response.pix.qrcode_image, "\" class=\"rounded\" alt=\"...\">"));
            $('#qrcode').val(data.response.pix.qrcode);
            $('#qrcode').removeAttr('disabled');
            break;

          case 'boleto':
            $(divAlert).html("<div class=\"alert alert-success\">Boleto gerado com sucesso!</div>");
            setTimeout(function () {
              $(divLoading).fadeOut(500);
              $(".payment-confirmation").show(500).fadeIn();
              $('#message_confirmation').html("<h3>Linha digit\xE1vel boleto</h3><h1>".concat(data.response.boleto.digitable_line, "</h1><br/>\n                            <a href=\"").concat(data.response.boleto.link, "\" class=\"btn btn-success\" target=\"blank\">Baixar</a>"));
            }, 1000);
            break;

          case 'credit_card':
            $(divAlert).html("<div class=\"alert alert-success\">Pagamento com cart\xE3o realizado com sucesso!</div>");
            setTimeout(function () {
              $(divLoading).fadeOut(500);
              $(".payment-confirmation").show(500).fadeIn();
              $('#message_confirmation').html("<h1>Pagamento com cartão de crédito realizado com sucesso!</h1>");
            }, 1000);
            break;
        }
      }
    }
  });
}

/***/ }),

/***/ "./resources/css/index.css":
/*!*********************************!*\
  !*** ./resources/css/index.css ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/index": 0,
/******/ 			"css/index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/index"], () => (__webpack_require__("./resources/js/index.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/index"], () => (__webpack_require__("./resources/css/index.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;