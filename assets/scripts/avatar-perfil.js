$('document').ready(function(){

	$('#avatar-perfil').on('click',function(){
		$('#upload-a').click();
	});

	$('.upload-btn').css('display','none');

	(function($) {
	    $.fn.checkFileType = function(options) {
	        var defaults = {
	            allowedExtensions: [],
	            success: function() {},
	            error: function() {}
	        };
	        options = $.extend(defaults, options);
	        return this.each(function() {
	            $(this).on('change', function() {
	                var value = $(this).val(),
	                    file = value.toLowerCase(),
	                    extension = file.substring(file.lastIndexOf('.') + 1);
	                if ($.inArray(extension, options.allowedExtensions) == -1) {
	                    options.error();
	                    $(this).focus();
	                } else {
	                    options.success();
	                }
	            });
	        });
	    };
	})(jQuery);

	$(function() {
    	$('#upload-a').checkFileType({
	        allowedExtensions: ['png', 'jpg'],
	        success: function(data) {
				$('#submit-a').click();
	        },
	        error: function() {
	            alert('Tipo de archivo no permitido');
	        }
	    });
	});

	// $('#submit-a').click();

});