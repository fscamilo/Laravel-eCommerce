function modalShow(target = this, callback = false){
    document.body.querySelector(".modal-window[data-modal='"+target.getAttribute('data-modal')+"']").classList.add('toggled');
    document.getElementById("modal-overlay").classList.add('toggled');

    if(callback){
        callback.name(callback.data);
    }
}

function modalHide(){
    document.getElementById("modal-overlay").classList.remove("toggled");
    const modals = document.getElementsByClassName('modal-window');
    for(let i = 0; i < modals.length; i++){
        modals.item(i).classList.remove("toggled");
    }
}

function productDel(data){
    document.getElementById("product-delete-yes").setAttribute('href', '/admin/products/delete/' + data.id);
}

if($('.modal-toggle').length > 0){

    // Modal Active
    const products = document.getElementsByClassName("modal-toggle");
    for(let c = 0; c < products.length; c++){
        let productId = products.item(c).getAttribute('data-id');
        products.item(c).addEventListener("click", e=>modalShow(e.target, {name: productDel, data : {id : productId}}));
    }

}

// Modal Inactive
if($('.modal-overlay').length > 0){
    document.getElementById("modal-overlay").addEventListener("click", modalHide);
}

if($('.product-delete-no').length > 0){
    document.getElementById("product-delete-no").addEventListener("click", modalHide);
}

// On page load
$(document).ready(function(){

    // Product Importer - Read csv locally on upload and preview data in tables
    $('.products-upload').on('change', function(ev){
        const parent = $(ev.target).closest('fieldset').children('table').children('tbody');
        const reader = new FileReader();
        const removeHeaders = $(ev.target).closest('fieldset').find('input[name="removeHeaders"]:checked').val();
        const cols = $(ev.target).closest('fieldset').find('table').data('cols');
        let dataErrors = false;
        let returnVal = '';
        reader.readAsText(ev.target.files[0]);
        reader.onload = function (e) {
            let output = '';

            let newLineChar = e.target.result.indexOf('\r\n') > -1 ? '\r\n' : false;
            if(!newLineChar){
                newLineChar = e.target.result.indexOf('\r') > -1 ? '\r' : '\n';
            }
            let rows = e.target.result.split(newLineChar);

            // remove first row of table headers if radio button is true
            if(removeHeaders == 'true'){
                rows.shift();
            }

            rows.forEach(function(row){
                // check row isnt empty
                if(row[0] !== ',' && row[0].length > 0){
                    const cells = row.split(',').filter(x => x.length > 0);

                    // check row cell count is what was expected
                    if(cells.length !== cols){
                        dataErrors = true;
                        return false;
                    };

                    output += '<tr>';
                    cells.forEach(function(cell){
                        if(cell.length > 1){
                            output += '<td>';
                            output += cell;
                            output += '</td>';
                        }
                    });
                    output += '</tr>';
                }
                
            });

            if(dataErrors){
                returnVal += '<div class="importer-result importer-invalid">';
                returnVal += '<p>Some of the data does not match the required format. Please update the data to the above CSV format.</p>';
            }
            else{
                returnVal += '<div class="importer-result importer-valid">';
                returnVal += '<p>The data format is valid. Please double check the preview data above before importing.</p>';
            }

            returnVal += '</div>'

            $('.importer-result').remove();
            $(ev.target).closest('fieldset').append(returnVal);
            $(parent).empty().append(output);
        }

    });

});

// Logout Toggle
$('body').click(function(e){

    if(e.target.id == 'navbarDropdown'){
        $('.dropdown-menu').toggleClass('show');
    }
    else{
        $('.dropdown-menu').removeClass('show');
    }
});


$(document).ready(function(){
	let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	$('.increase').click(function(){
		let quantity = $(this).siblings('.quantity');
		if(quantity.val() < 100){
			quantity.val(parseInt(quantity.val()) + 1);
		}
	});

	$('.decrease').click(function(){
		let quantity = $(this).siblings('.quantity');
		if(quantity.val() > 0){
			quantity.val(parseInt(quantity.val()) - 1);
		}
	});

	$('.toggleDisplay').click(function(){
		$('.display-mode').toggleClass('grid-mode');
		$('.product').toggleClass('product-grid');
		$('.product').toggleClass('product-list');
		$(this).toggleClass('fa-table');
		$(this).toggleClass('fa-list');
	});

	$('.addToCart').click(function(){
		let productId = $(this).siblings('.productId').val();
		let quantity = $(this).parent().prev().children('.quantity').val();
		if(quantity <1){return;}

		$.ajax({
			type:'POST',
			url:'/admin',
			data: {_token: CSRF_TOKEN, message:{productId: productId, quantity: quantity}},
			dataType: 'JSON',
 			success:function(data){ 
				$('#basket').html(data.html);
			}
 		});
	});

	$('#basket').on('click', '.remove', function(){
		let basketId = $(this).parent().val();
		$.ajax({
			type:'DELETE',
			url:'/admin',
			data: {_token: CSRF_TOKEN, message:{basketId: basketId}},
			dataType: 'JSON',
 			success:function(data){ 
				$('#basket').html(data.html);
			}
		});
	});

	$('#basket').on('click', '#checkout', function(){
		$.ajax({
			type:'GET',
			url:'/admin/checkout',
 			success:function(result){ 
				if(result.success){
					$('#checkoutDetailContent').html(result.html);
					$('#checkoutDetail').modal();
				}else{
					$('#basketItem'+result.productId).append(result.message);
					$('#placeOrder').prop("disabled",true);
				}
			}
		});
	});

	$('#checkoutDetailContent').on('click', '#placeOrder', function(){
		$.ajax({
			type:'GET',
			url:'/admin/placeorder',
 			success:function(result){ 
				if(result.success){
					$('#checkoutDetailContent').append(result.message);
					$('#basket').html(result.html);
				}else{
					$('#basketItem'+result.productId).append(result.message);
				}
				$('#placeOrder').prop("disabled",true);
			}
		});
	});

	$('.order').on('click', function(){
		let orderId = $(this).children('.orderId').val();

		$.ajax({
			type:'POST',
			url:'/admin/orderDetail',
			data: {_token: CSRF_TOKEN, message:{orderId: orderId}},
			dataType: 'JSON',
 			success:function(data){ 
				$('#orderDetailContent').html(data.html);
			}
		});
		$('#orderDetail').modal();
	});

	$('.driver').on('click', function(){
		let driverId = $(this).children('.driverId').val();

		$.ajax({
			type:'POST',
			url:'/admin/driverDetail',
			data: {_token: CSRF_TOKEN, message:{driverId: driverId}},
			dataType: 'JSON',
 			success:function(data){ 
				$('#driverDetailContent').html(data.html);
			}
		});
		$('#driverDetail').modal();
	});

	$('#searchOrder, #searchDriver').on('keyup search', function() {
        let filter = $(this).val();
        $('.order, .driver').each(function() {
            if ($(this).text().includes(filter)) {
				$(this).find('*').slideDown();
            } else {
                $(this).find('*').slideUp();
            }
        });
	});

	$('.updateOrder').on('click', function() {
		let orderId = $(this).attr('name');
		let driver = $('#driver_' + orderId).val();
		let deliver = $('#delivery-date_' + orderId).val();
		$.ajax({
			type:'POST',
			url:'/admin/order/update',
			data: {_token: CSRF_TOKEN, message:{orderId: orderId, driverId: driver, deliverDate: deliver}},
			dataType: 'JSON',
 			success:function(data){ 
				 alert('Order updated');
			}
		});
	});
	
	$('.updateDelivery').on('click', function() {
		let orderId = $(this).attr('name');
		let status = $('#status_' + orderId).val();
		console.log(status);
		$.ajax({
			type:'POST',
			url:'/admin/order/deliver',
			data: {_token: CSRF_TOKEN, message:{orderId: orderId, status: status}},
			dataType: 'JSON',
 			success:function(data){
				if(data.updated){
					$('#status_' + orderId).prop('disabled', true);
					alert('Order delivered');
				}
			}
		});
	});

	$('#searchCategory, #buttonSearch, #sortProduct').on('change click', function() {
		let categoryId = $('#searchCategory').val();
		let search = $('#searchProduct').val();
		let sort = $('#sortProduct').val();
		$(location).attr('href', '/?categoryId='+categoryId+'&search='+search+'&sort='+sort);
	});

	$('#searchProduct').on('keyup search', function(e) {
		let search = $(this).val();
		if(e.keyCode == 13 || search == ''){
			$('#buttonSearch').click();
		}
	});

	$('.rating-toggle').each(function(){
		let index = $(this).index();
		if($(this).attr('checked')){
			$(this).siblings('i:nth-of-type('+index+')').click();
		}
	});
});

// Icon Rating System 

$('.rating-face').click(function(){
    var clicked = $(this);
    $('.rating-face').removeClass('toggled');
    $('.rating-toggle').attr('checked', false);
    $('.rating-toggle[value='+clicked.attr('data-val')+']').attr('checked', 'checked');
    clicked.addClass('toggled');
    $('.rating-description').removeClass('rating-1 rating-2 rating-3 rating-4 rating-5')
    .addClass('rating-'+clicked.attr('data-val')).html(clicked.attr('data-description'));
});

// Primary delivery address custom checkbox
$('.custom-checkbox').click(function(){
    var clicked = $(this);
    
    if(clicked.hasClass('checked')){
        clicked.removeClass('checked');
        clicked.siblings('input[type=checkbox]').prop('checked', false);
    }
    else{
        $('.custom-checkbox').removeClass('checked');
        $('input[type=checkbox]').prop('checked', false);
        clicked.addClass('checked');
		clicked.siblings('input[type=checkbox]').prop('checked', true);
    }

});

// Update driver dashboard row colours on delivery status change
$('.driver-dash select').on('change', function(){
    const selector = this;

    switch(selector.value) {
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