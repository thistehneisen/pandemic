// - - - - - - - - - - -  Misc  - - - - - - - - - - - 

window.addEventListener('load', function() {
	FastClick.attach(document.body);
}, false);
document.addEventListener("touchstart", function(){}, true);


$(document).ready(function(){
	$("a[href='#']").click(function(e) {
		e.preventDefault();
});


// - - - - - - - - - - -  Notification  - - - - - - - - - - - 

	var notify_success = function(e) {
		$('.notification').addClass('show');
		setTimeout(function(){ 
		$('.notification').removeClass('show');
		}, 1000);
		e.clearSelection();
	};


// - - - - - - - - - - -  Copy to clipboard  - - - - - - - - - - - 

	var clipboard_color = new Clipboard('.clip-color', {
		text: function(trigger) {
			return trigger.getAttribute('aria-label');
		}
	});
		clipboard_color.on('success', function(e) {
		notify_success(e);
	});

	var clipboard_btn = new Clipboard('.copy', {
    target: function(trigger) {
        return trigger.nextElementSibling;
    }
});
	clipboard_btn.on('success', function(e) {
		notify_success(e);
	});

// - - - - - - - - - - -  Hide alerts password  - - - - - - - - - - - 

$('.alert .close').on('click', function() {
	$(this).parents('.alert').addClass('dismissed');
});

// - - - - - - - - - - -  Show / hide password  - - - - - - - - - - - 

$('.js-pass-show').on('click', function() {
	
	$(this).toggleClass('view');
	
	var $type = $(this).prev('input.input-password').is('[type=password]') ? 'text' : 'password';
	$(this).prev('input.input-password').attr('type', $type);

});

// - - - - - - - - - - -  Collapsable lists  - - - - - - - - - - - 
    houdini.init();

});

