// - - - - - - - - - - -  Misc  - - - - - - - - - - - 

window.addEventListener('load', function() {
	FastClick.attach(document.body);
}, false);
document.addEventListener("touchstart", function(){}, true);


// - - - - - - - - - - -  Dropzone file upload  - - - - - - - - - - - 


// - - - - - - - - - - -  Dropzone file upload  - - - - - - - - - - - 
// http://www.dropzonejs.com/
// http://www.dropzonejs.com/#server-side-implementation

// Disable autodiscovery 
Dropzone.autoDiscover = false;


$(document).ready(function(){




// BANNER IMG UPLOAD
$("#banner-upload").dropzone({
	paramName: "file",
	maxFilesize: 10,
	uploadMultiple: false,
	parallelUploads: 1,
	maxFiles: 1,
	createImageThumbnails: true,
	thumbnailWidth: null,
	thumbnailHeight: null,
	clickable: true,
	addRemoveLinks: true,
	dictDefaultMessage: "Drop banner image here to upload",
	acceptedFiles: "image/*",
	accept: function(file, done) {
		console.log("uploaded");
		done();
	},
	init: function() {
		this.on("addedfile", function() {
			if (this.files[1]!=null){
				this.removeFile(this.files[0]);
			}
		});
	}
});




// - - - - - - - - - - -  Prevent empty anchors to anchor  - - - - - - - - - - - 
$("a[href='#']").click(function() {
	event.preventDefault();
});



// - - - - - - - - - - -  Nanobar (loading bar)  - - - - - - - - - - - 
// https://github.com/jacoborus/nanobar/
var nanobar = new Nanobar( {
	classname: 'my-class',
	id: 'my-id',
	target: document.getElementById('progress')
});
nanobar.go(100);

// - - - - - - - - - - -  Headroom (sticky header)  - - - - - - - - - - - 
//http://wicky.nillia.ms/headroom.js/
var header = document.querySelector("header");
var headroom = new Headroom(header, {
	tolerance: {
		down : 10,
		up : 10
	},
	offset : 70,
	onPin : function() {
		$('.sticky .content').addClass('navstick');
	},
	onUnpin : function() {
		$('.sticky .content').addClass('navstick');
	},
	onTop : function() {
		$('.sticky .content').removeClass('navstick');
	},
		onNotTop : function() {
		$('.sticky .content').addClass('navstick');
	},
});
headroom.init();




// - - - - - - - - - - -  Collapsable lists  - - - - - - - - - - - 
// https://github.com/cferdinandi/houdini
houdini.init({
	callbackOpen: function ( content, toggle ) {
		if ($('.ui.sticky').length) {
			setTimeout(function(){ 
				$('.ui.sticky').sticky('refresh'); 
			}, 200);
		}
	},
	callbackClose: function ( content, toggle ) {
		// if ($('.ui.sticky').length) {
		// 	setTimeout(function(){ 
		// 		$('.ui.sticky').sticky('refresh'); 
		// 	}, 200);
		// }
	}
});




// - - - - - - - - - - -  Tags input  - - - - - - - - - - - 
// https://github.com/k-ivan/Tags

//var tags = new Tags('#tags'); 





// - - - - - - - - - - -  Input symbol counter  - - - - - - - - - - - 
if ($('input[maxlength], textarea[maxlength]').length) {
	$('input[maxlength], textarea[maxlength]').each(function( index ) {
		var max_length = $(this).attr('maxlength');
		$(this).parent().prepend('<span class="counter">' + max_length + '</span>');
		var counter_span = $(this).parent().find('.counter');

		$(this).keyup(function() {
			var text_length = $(this).val().length;
			var text_remaining = max_length - text_length;
			counter_span.html(text_remaining);
		});
	});
}


// - - - - - - - - - - -  Text ad preview update  - - - - - - - - - - - 
if ($('.update_ad_preview').length) {
	$('.update_ad_preview').each(function( index ) {
		$(this).keyup(function() {
			var field_value = ($(this).val() == '') ? $(this).attr('placeholder') : $(this).val()
			var act_field = '.txt_' + $(this).attr('id');
			$('#txt_ad_preview ' + act_field).html(field_value);
		});
	});
}




// - - - - - - - - - - -  Autocomplete input — comma sperated values - - - - - - - - - - - 
// https://leaverou.github.io/awesomplete/
if ($('.autocomplete').length) {
	new Awesomplete('input[data-multiple]', {
		filter: function(text, input) {
			return Awesomplete.FILTER_CONTAINS(text, input.match(/[^,]*$/)[0]);
		},
		replace: function(text) {
			var before = this.input.value.match(/^.+,\s*|/)[0];
			this.input.value = before + text + ", ";
		}
	});
}



// 

$(document).on('click', "a.epin", function(e) {
	alert("OH WOW");
	event.preventDefault();
	event.stopPropagation();

});



// close list item
//houdini.closeContent( $(this).parents('.itm').find('.collapse-toggle').attr('href') );
//$(this).parents('.itm').find('.active').removeClass('active');

// cancel message button
$(document).on('click', "#messages .cancel", function(e) {
	$(this).parents('.itm').find('.message-reply').removeClass('show-reply');
	$(this).parents('.itm').find('.message-footer').removeClass('hide-footer');
});


// Read unread messages 
$(document).on('click', "#messages .unread .collapse-toggle", function(e) {
	console.log("remove unread class");
	$(this).parents('.unread').removeClass('unread');
});


// Display reply window
$(document).on('click', ".message-footer .reply", function(e) {

	console.log("Reply");
	$(this).parents('.itm').find('.message-reply').addClass('show-reply');
	$(this).parents('.itm').find('.message-footer').addClass('hide-footer');

	setTimeout(function() {
		$('.collapse.active').find('textarea').focus();
	}, 50);

});



// - - - - - - - - - - -  Mobile burger  - - - - - - - - - - - 
$(document).on('click', "a.nav-toggle", function(e) {
	e.preventDefault();
	$(this).toggleClass('cross');
	$('body').toggleClass('noscroll');
	$('header').toggleClass('show_nav');
	$('.mask').toggleClass('show-mask');
});

// $(document).on('click', "a.close-modal, .mask-show", function(e) {
// 	$('.modal').removeClass('modal-show');
// 	$('.modal-mask').removeClass('mask-show');
// 	$('body').removeClass('noscroll');
// });



// - - - - - - - - - - -  Dismiss or Close "Welcome message"  - - - - - - - - - - - 

$(document).on('click', ".welcome-message .btn.dismiss, .welcome-message .close", function(e) {
	console.log("Welcome message removed!");
	$('.welcome-message').addClass('hide-message');
});



// - - - - - - - - - - -  Input error sample  - - - - - - - - - - - 

modal_error = function(e) {
	$('.lean-modal.show-modal').addClass('modal-error');
	setTimeout(function(e){ 
		$('.lean-modal.show-modal').removeClass('modal-error');
	}, 600);

};

$(document).on('click', "#login .confirm", function(e) {
	if ($('#login #password').val() == '') {
		event.preventDefault();
		$('#login #password').addClass('input-error');
		modal_error();
	}
	else {
		$('#login #password').removeClass('input-error');
	}
	if ($('#login #email').val() == '') {
		event.preventDefault();
		$('#login #email').addClass('input-error');
		modal_error();
	}
		else {
		$('#login #email').removeClass('input-error');
	}
});


// - - - - - - - - - - -  Notification  - - - - - - - - - - - 

var notify = function(e) {
	var msg = '<div class="text-ct"><div>'+ e +'</div></div><div></div>';
	var notification = $(msg).appendTo('#notification .ct');
	setTimeout(function(e){ 
		notification.addClass('show');
	}, 10);
	var hide_notify;
	clearTimeout(hide_notify);
	hide_notify = setTimeout(function(e){ 
		$(notification).addClass('hide');
	}, 1500);
//e.clearSelection();
};



// - - - - - - - - - - -  Range slider  - - - - - - - - - - - 
// http://ionden.com/a/plugins/ion.rangeSlider/en.html
$(function () {
	$(".user-count").ionRangeSlider({
		hide_min_max: true,
		keyboard: true,
		min: 0,
		max: 1000,
		type: 'single',
		step: 1,
		grid: true
	});
});



// - - - - - - - - - - -  Hide alerts password  - - - - - - - - - - - 
$('.alert .close').on('click', function() {
	$(this).parents('.alert').addClass('dismissed');
});


// - - - - - - - - - - -  Sticky - - - - - - - - - - - 
$('.ui.sticky').sticky({
	context: '#context',
	observeChanges: true
});


// - - - - - - - - - - -  Treeview - - - - - - - - - - - 
$('.treeview').treeView();

//CollapsibleLists.apply();



// - - - - - - - - - - -  Phone input - - - - - - - - - - - 
$("#phone").intlTelInput();

// - - - - - - - - - - -  Show / hide password  - - - - - - - - - - - 
$('.js-pass-show').on('click', function() {
	$(this).toggleClass('view');
	var $type = $(this).prev('input.input-password').is('[type=password]') ? 'text' : 'password';
	$(this).prev('input.input-password').attr('type', $type);

});


// - - - - - - - - - - -  Copy to clipboard - - - - - - - - - - - 

var clipboard_btn = new Clipboard('.copy', {
	target: function(trigger) {
		return trigger.previousElementSibling;
	}
});

clipboard_btn.on('success', function(e) {
	notify("Copied to clipboard!");
});




// - - - - - - - - - - -  Lean modal  - - - - - - - - - - - 
$.fn.extend({
	leanModal: function() {
		var container = $('#modals');
		window.onhashchange = function(e) {
			if (window.location.hash) {
				close_all_modals();
				if (window.location.hash && $(window.location.hash+'.lean-modal').length) {
					open_modal(window.location.hash);
				}
			}
			else {
				close_all_modals();
			}
		}
		return this.each(function() {
			if (window.location.hash && $(window.location.hash+'.lean-modal').length) {
				open_modal(window.location.hash);
			}
			$(this).click(function() {
				close_all_modals();
				open_modal($(this).attr("href"));
			});
			$('.close-modal, #lean-mask').on('click', function(e) {
				close_all_modals();
				history.pushState("", document.title, window.location.pathname);
				event.preventDefault();
			});
		});
		function open_modal(modal_id) {
			$(document.body).addClass('noscroll');
			container.addClass('show-modals');
			$(modal_id).addClass('show-modal in').removeClass('out');
			setTimeout(function() {
				$('.lean-modal').removeClass('in');
			}, 600);
		}
		function close_modal(modal_id) {
			$(document.body).removeClass('noscroll');
			container.removeClass('show-modals');
			$(modal_id).addClass('out').removeClass('show-modal in');
			setTimeout(function() {
				$('.lean-modal').removeClass('out');
			}, 600);
		}
		function close_all_modals() {
			close_modal();
			$('.show-modal').addClass('out').removeClass('show-modal in');
		}
	}
});

$("a[rel*=leanModal]").leanModal();




// - - - - - - - - - - -  Agree with terms  - - - - - - - - - - - 
$(document).on('click', ".button.agree", function(e) {
	document.getElementById("signup-agree").checked = true;
	$('.button.confirm').removeClass('disabled');
});

$(document).on('click', ".button.disagree", function(e) {
	document.getElementById("signup-agree").checked = false;
	$('.button.confirm').addClass('disabled');
});

$('#signup-agree').change(function(){
	this.checked ? $('.button.confirm').removeClass('disabled') : $('.button.confirm').addClass('disabled');
});






// - - - - - - - - - - -  List js  - - - - - - - - - - - 
// http://listjs.com/

// Tutorials filter
var tutorials_list = new List('tutorials', {
	valueNames: [ 'category' ]
});


// Filter buttons
$(document).on('click', "#tutorials .list-filter a", function(event) {
	//event.preventDefault();
	var url = $(this).attr('href');
	var hash = url.substring(url.indexOf("#")+1);
	tutorials_list.search(hash);
	$(this).parent().find('.active').removeClass('active');
	$(this).addClass('active');

});


// 		function active_filter(e) {
// 						var url = window.location.hash;
// 	var hash = url.substring(url.indexOf("#")+1);
// 	tutorials_list.search(hash);
// 	$('.list-filter').find('.active').removeClass('active');
// 	$('.list-filter a[href="' + window.location.hash + '"]').addClass('active');
// 		}





// if (window.location.hash && $('.list-filter a[href="' + window.location.hash + '"]').length) {
// active_filter();

// }

// window.onhashchange = function(e) {
// if (window.location.hash) {
// 	if (window.location.hash && $('.list-filter a[href="' + window.location.hash + '"]').length) {
// active_filter();

// 	}
// }
// else {
// 				history.pushState("", document.title, window.location.pathname);

// }
// }




// Convert date values to timestamps and add data attr to ev_date
// !!!! SHOULD BE DONE BY PHP
var oldest_timestamp_in_list = moment($('#table-list .ev_date.date').html()).unix();
var oldest_date;
$('#table-list .ev_date.date, #messages .ev_date.date').each(function( index ) {
	var ev_date_val = $(this).html();
	var ev_timestamp = moment(ev_date_val).unix();
	$(this).attr('data-timestamp', ev_timestamp);

	if (oldest_timestamp_in_list >= ev_timestamp) {
		oldest_timestamp_in_list = ev_timestamp;
		oldest_date = $(this).html();
		date_from_value = moment(oldest_date).unix();
	}
	console.log('%c!!! TIMESTAMP SHOULD BE ADDED BY PHP !!!', 'color: red; font-weight: bold;', ev_timestamp);
});


if ($('#table-list, #messages').length) {

// Table list init
if ($('.finance.table-list').length) {
	var table_list = new List('table-list', {
		valueNames: [ 'id', { attr: 'data-timestamp', name: 'ev_date' }, 'amount', 'description' ]
	});
}


// promotions list init
if ($('.promotions.table-list').length) {
	var table_list = new List('table-list', {
		valueNames: [ 'name', 'size', 'description' ]
	});
}



// Table list init
if ($('.advertising.table-list').length) {
	var table_list = new List('table-list', {
		valueNames: [ 'id', { attr: 'data-timestamp', name: 'ev_date' }, 'amount', 'description' ]
	});
}

// Mail list init
if ($('#messages').length) {
	var table_list = new List('messages', {
		valueNames: [ 'name', 'subject', 'message-body', { attr: 'data-timestamp', name: 'ev_date' } ]
	});
}


table_list.on('updated', function(list) {
	if (list.matchingItems.length > 0) {
		$('.no-result').removeClass('showit');
	} else {
		$('.no-result').addClass('showit');
	}
});

// - - - - - - - - - - -  DATEPICKER (rome js) with list.js range filtering  - - - - - - - - - - - 
// https://bevacqua.github.io/rome/

var date_from_value= moment(oldest_date).unix();
var date_to_value = moment().format('YYYY-MM-DD');

if ($('#date_from').length) {

	rome(date_from, {
		dateValidator: rome.val.beforeEq(date_to),
		time: false,
		inputFormat: "YYYY-MM-DD",
		weekStart: 1,
		initialValue: moment(oldest_date).format('YYYY-MM-DD'),
		min: moment(oldest_date).format('YYYY-MM-DD'),
		max: moment().format('YYYY-MM-DD'),
	}).on('data', function (value) {
		date_from_value = moment(value).unix();
		console.log('Changed FROM!', 'Value', value, 'Timestamp', date_from_value);
		console.log(date_from_value, date_to_value);
		updateTableList(value);


	});
}

if ($('#date_to').length) {
	rome(date_to, {
		dateValidator: rome.val.afterEq(date_from),
		time: false,
		inputFormat: "YYYY-MM-DD",
		weekStart: 1,
		initialValue: moment().format('YYYY-MM-DD'),
		min: moment(oldest_date).format('YYYY-MM-DD'),
		max: moment().format('YYYY-MM-DD'),
	}).on('data', function (value) {
		date_to_value = moment(value).unix();
		console.log('Changed TO!', 'Value', value, 'Timestamp', date_to_value);
		console.log(date_from_value, date_to_value);
		updateTableList(value);
	});
}
}

var updateTableList = function(value){
	table_list.filter(function(item) {
		return(item.values().ev_date >= date_from_value) && (item.values().ev_date) <= date_to_value;
	});
};

});


