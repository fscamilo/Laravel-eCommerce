/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

function modalShow() {
  var target = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this;
  var callback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  document.body.querySelector(".modal-window[data-modal='" + target.getAttribute('data-modal') + "']").classList.add('toggled');
  document.getElementById("modal-overlay").classList.add('toggled');

  if (callback) {
    callback.name(callback.data);
  }
}

function modalHide() {
  document.getElementById("modal-overlay").classList.remove("toggled");
  var modals = document.getElementsByClassName('modal-window');

  for (var i = 0; i < modals.length; i++) {
    modals.item(i).classList.remove("toggled");
  }
}

function productDel(data) {
  document.getElementById("product-delete-yes").setAttribute('href', '/admin/products/delete/' + data.id);
}

if ($('.modal-toggle').length > 0) {
  // Modal Active
  var products = document.getElementsByClassName("modal-toggle");

  var _loop = function _loop(c) {
    var productId = products.item(c).getAttribute('data-id');
    products.item(c).addEventListener("click", function (e) {
      return modalShow(e.target, {
        name: productDel,
        data: {
          id: productId
        }
      });
    });
  };

  for (var c = 0; c < products.length; c++) {
    _loop(c);
  }
} // Modal Inactive


if ($('.modal-overlay').length > 0) {
  document.getElementById("modal-overlay").addEventListener("click", modalHide);
}

if ($('.product-delete-no').length > 0) {
  document.getElementById("product-delete-no").addEventListener("click", modalHide);
} // On page load


$(document).ready(function () {
  // Product Importer - Read csv locally on upload and preview data in tables
  $('.products-upload').on('change', function (ev) {
    var parent = $(ev.target).closest('fieldset').children('table').children('tbody');
    var reader = new FileReader();
    var removeHeaders = $(ev.target).closest('fieldset').find('input[name="removeHeaders"]:checked').val();
    var cols = $(ev.target).closest('fieldset').find('table').data('cols');
    var dataErrors = false;
    var returnVal = '';
    reader.readAsText(ev.target.files[0]);

    reader.onload = function (e) {
      var output = '';
      var newLineChar = e.target.result.indexOf('\r\n') > -1 ? '\r\n' : false;

      if (!newLineChar) {
        newLineChar = e.target.result.indexOf('\r') > -1 ? '\r' : '\n';
      }

      var rows = e.target.result.split(newLineChar); // remove first row of table headers if radio button is true

      if (removeHeaders == 'true') {
        rows.shift();
      }

      rows.forEach(function (row) {
        // check row isnt empty
        if (row[0] !== ',' && row[0].length > 0) {
          var cells = row.split(',').filter(function (x) {
            return x.length > 0;
          }); // check row cell count is what was expected

          if (cells.length !== cols) {
            dataErrors = true;
            return false;
          }

          ;
          output += '<tr>';
          cells.forEach(function (cell) {
            if (cell.length > 1) {
              output += '<td>';
              output += cell;
              output += '</td>';
            }
          });
          output += '</tr>';
        }
      });

      if (dataErrors) {
        returnVal += '<div class="importer-result importer-invalid">';
        returnVal += '<p>Some of the data does not match the required format. Please update the data to the above CSV format.</p>';
      } else {
        returnVal += '<div class="importer-result importer-valid">';
        returnVal += '<p>The data format is valid. Please double check the preview data above before importing.</p>';
      }

      returnVal += '</div>';
      $('.importer-result').remove();
      $(ev.target).closest('fieldset').append(returnVal);
      $(parent).empty().append(output);
    };
  });
}); // Logout Toggle

$('body').click(function (e) {
  if (e.target.id == 'navbarDropdown') {
    $('.dropdown-menu').toggleClass('show');
  } else {
    $('.dropdown-menu').removeClass('show');
  }
});
$(document).ready(function () {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $('.increase').click(function () {
    var quantity = $(this).siblings('.quantity');

    if (quantity.val() < 100) {
      quantity.val(parseInt(quantity.val()) + 1);
    }
  });
  $('.decrease').click(function () {
    var quantity = $(this).siblings('.quantity');

    if (quantity.val() > 0) {
      quantity.val(parseInt(quantity.val()) - 1);
    }
  });
  $('.toggleDisplay').click(function () {
    $('.display-mode').toggleClass('grid-mode');
    $('.product').toggleClass('product-grid');
    $('.product').toggleClass('product-list');
    $(this).toggleClass('fa-table');
    $(this).toggleClass('fa-list');
  });
  $('.addToCart').click(function () {
    var productId = $(this).siblings('.productId').val();
    var quantity = $(this).parent().prev().children('.quantity').val();

    if (quantity < 1) {
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/admin',
      data: {
        _token: CSRF_TOKEN,
        message: {
          productId: productId,
          quantity: quantity
        }
      },
      dataType: 'JSON',
      success: function success(data) {
        $('#basket').html(data.html);
      }
    });
  });
  $('#basket').on('click', '.remove', function () {
    var basketId = $(this).parent().val();
    $.ajax({
      type: 'DELETE',
      url: '/admin',
      data: {
        _token: CSRF_TOKEN,
        message: {
          basketId: basketId
        }
      },
      dataType: 'JSON',
      success: function success(data) {
        $('#basket').html(data.html);
      }
    });
  });
  $('#basket').on('click', '#checkout', function () {
    $.ajax({
      type: 'GET',
      url: '/admin/checkout',
      success: function success(result) {
        if (result.success) {
          $('#checkoutDetailContent').html(result.html);
          $('#checkoutDetail').modal();
        } else {
          $('#basketItem' + result.productId).append(result.message);
          $('#placeOrder').prop("disabled", true);
        }
      }
    });
  });
  $('#checkoutDetailContent').on('click', '#placeOrder', function () {
    $.ajax({
      type: 'GET',
      url: '/admin/placeorder',
      success: function success(result) {
        if (result.success) {
          $('#checkoutDetailContent').append(result.message);
          $('#basket').html(result.html);
        } else {
          $('#basketItem' + result.productId).append(result.message);
        }

        $('#placeOrder').prop("disabled", true);
      }
    });
  });
  $('.order').on('click', function () {
    var orderId = $(this).children('.orderId').val();
    $.ajax({
      type: 'POST',
      url: '/admin/orderDetail',
      data: {
        _token: CSRF_TOKEN,
        message: {
          orderId: orderId
        }
      },
      dataType: 'JSON',
      success: function success(data) {
        $('#orderDetailContent').html(data.html);
      }
    });
    $('#orderDetail').modal();
  });
  $('.driver').on('click', function () {
    var driverId = $(this).children('.driverId').val();
    $.ajax({
      type: 'POST',
      url: '/admin/driverDetail',
      data: {
        _token: CSRF_TOKEN,
        message: {
          driverId: driverId
        }
      },
      dataType: 'JSON',
      success: function success(data) {
        $('#driverDetailContent').html(data.html);
      }
    });
    $('#driverDetail').modal();
  });
  $('#searchOrder, #searchDriver').on('keyup search', function () {
    var filter = $(this).val();
    $('.order, .driver').each(function () {
      if ($(this).text().includes(filter)) {
        $(this).find('*').slideDown();
      } else {
        $(this).find('*').slideUp();
      }
    });
  });
  $('.updateOrder').on('click', function () {
    var orderId = $(this).attr('name');
    var driver = $('#driver_' + orderId).val();
    var deliver = $('#delivery-date_' + orderId).val();
    $.ajax({
      type: 'POST',
      url: '/admin/order/update',
      data: {
        _token: CSRF_TOKEN,
        message: {
          orderId: orderId,
          driverId: driver,
          deliverDate: deliver
        }
      },
      dataType: 'JSON',
      success: function success(data) {
        alert('Order updated');
      }
    });
  });
  $('.updateDelivery').on('click', function () {
    var orderId = $(this).attr('name');
    var status = $('#status_' + orderId).val();
    console.log(status);
    $.ajax({
      type: 'POST',
      url: '/admin/order/deliver',
      data: {
        _token: CSRF_TOKEN,
        message: {
          orderId: orderId,
          status: status
        }
      },
      dataType: 'JSON',
      success: function success(data) {
        if (data.updated) {
          $('#status_' + orderId).prop('disabled', true);
          alert('Order delivered');
        }
      }
    });
  });
  $('#searchCategory, #buttonSearch, #sortProduct').on('change click', function () {
    var categoryId = $('#searchCategory').val();
    var search = $('#searchProduct').val();
    var sort = $('#sortProduct').val();
    $(location).attr('href', '/?categoryId=' + categoryId + '&search=' + search + '&sort=' + sort);
  });
  $('#searchProduct').on('keyup search', function (e) {
    var search = $(this).val();

    if (e.keyCode == 13 || search == '') {
      $('#buttonSearch').click();
    }
  });
  $('.rating-toggle').each(function () {
    var index = $(this).index();

    if ($(this).attr('checked')) {
      $(this).siblings('i:nth-of-type(' + index + ')').click();
    }
  });
}); // Icon Rating System 

$('.rating-face').click(function () {
  var clicked = $(this);
  $('.rating-face').removeClass('toggled');
  $('.rating-toggle').attr('checked', false);
  $('.rating-toggle[value=' + clicked.attr('data-val') + ']').attr('checked', 'checked');
  clicked.addClass('toggled');
  $('.rating-description').removeClass('rating-1 rating-2 rating-3 rating-4 rating-5').addClass('rating-' + clicked.attr('data-val')).html(clicked.attr('data-description'));
}); // Primary delivery address custom checkbox

$('.custom-checkbox').click(function () {
  var clicked = $(this);

  if (clicked.hasClass('checked')) {
    clicked.removeClass('checked');
    clicked.siblings('input[type=checkbox]').prop('checked', false);
  } else {
    $('.custom-checkbox').removeClass('checked');
    $('input[type=checkbox]').prop('checked', false);
    clicked.addClass('checked');
    clicked.siblings('input[type=checkbox]').prop('checked', true);
  }
}); // Update driver dashboard row colours on delivery status change

$('.driver-dash select').on('change', function () {
  var selector = this;

  switch (selector.value) {
    case 'delivered':
      $(selector).closest('tr').removeClass('pending rescheduled').addClass('delivered');
      break;

    case 'pending':
      $(selector).closest('tr').removeClass('delivered rescheduled').addClass('pending');
      break;

    case 'rescheduled':
      $(selector).closest('tr').removeClass('pending delivered').addClass('rescheduled');
      break;
  }
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/fernando/Laravel eCommerce/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/fernando/Laravel eCommerce/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });