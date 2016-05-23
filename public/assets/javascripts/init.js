$(document).ready(function(){
	/*
     * Ajax Setup
     */
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	/*
     * Initial
     */
	setTimeout(function() {
		$('#wraper').addClass('in');
		$('#loader').fadeOut(500);
	}, 10);

	$('body').on('show.bs.modal', '.modal', function() {
		//$(this).removeClass('modal-open')
	})
	.on('hidden.bs.modal', '.modal', function () {
		$(this).removeClass('modal-open')
		$(this).removeData('bs.modal');
		$(this).find('.modal-content').html('<div class="loader-circle"><div class="loader-line-mask"><div class="loader-line"></div></div></div>');
	});

	/*
     * bootstrap-select
     */
	if ($('.selectpicker').length > 0)
	{
		$('.selectpicker').selectpicker();
	}

	/*
     * Dropdown Menu
     */
    if ($('.dropdown').length > 0) {

    	//Propagate
    	$('body').on('click', '.dropdown.open .dropdown-menu', function(e){
    		e.stopPropagation();
    	});

    	$('.dropdown').on('shown.bs.dropdown', function (e) {
    		if($(this).attr('data-animation')) {
    			$animArray = [];
    			$animation = $(this).data('animation');
    			$animArray = $animation.split(',');
    			$animationIn = 'animated '+$animArray[0];
    			$animationOut = 'animated '+ $animArray[1];
    			$animationDuration = ''

    			if (!$animArray[2]) {
    				$animationDuration = 500; //if duration is not defined, default is set to 500ms
    			}
    			else {
    				$animationDuration = $animArray[2];
    			}

    			$(this).find('.dropdown-menu').removeClass($animationOut)
    			$(this).find('.dropdown-menu').addClass($animationIn);
    		}
    	});

    	$('.dropdown').on('hide.bs.dropdown', function (e) {
    		if($(this).attr('data-animation')) {
    			e.preventDefault();
    			$this = $(this);
    			$dropdownMenu = $this.find('.dropdown-menu');
    			$dropdownMenu.addClass($animationOut);
    			setTimeout(function(){
    				$this.removeClass('open')
    			}, $animationDuration);
    		}
    	});
    }
});
