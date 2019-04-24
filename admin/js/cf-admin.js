(function ($) {
	'use strict';
	
	let mediaUploader;
	
	$('[data-name="hidden-media"]').each(function () {
		if (this.value) {
			$(this).siblings('.no-value').addClass('hide');
			$(this).siblings('.has-value').removeClass('hide');
		}
		else {
			$(this).siblings('.no-value').removeClass('hide');
			$(this).siblings('.has-value').addClass('hide');
		}
	});
	
	$('#cf_plugin_media-container [data-name="add"], #cf_plugin_media-container [data-name="edit"]').on('click', function (e) {
		let $this = $(this);
		
		e.preventDefault();
		
		mediaUploader.open();
		
		// eslint-disable-next-line no-multi-assign
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title:    'Choose Media',
			button:   {
				text: 'Choose Media'
			},
			multiple: false
		});
		
		mediaUploader.on('select', function () {
			let attachment = mediaUploader.state().get('selection').first().toJSON();
			let thisContainer = $this.parents('#cf_plugin_media-container');
			let dataMedia = $(thisContainer).find('[data-name="media"]');
			let dataHidden = $(thisContainer).find('[data-name="hidden-media"]');
			
			dataHidden.attr('value', attachment.id);
			
			if (thisContainer.find('.image').length !== 0) {
				dataMedia.attr('src', attachment.sizes.thumbnail.url);
				dataMedia.attr('data-src', attachment.sizes.thumbnail.url);
			}
			
			if (thisContainer.find('.file-name').length !== 0) {
				dataMedia.find('span').text(attachment.title);
			}
			
			// Toggle the divs
			thisContainer.children('.no-value').addClass('hide');
			thisContainer.children('.has-value').removeClass('hide');
		});
		mediaUploader.open();
	});
	
	$('[data-name="remove"]').on('click', function (e) {
		let $this = $(this);
		let thisContainer = $this.parents('#cf_plugin_media-container');
		let dataMedia = $(thisContainer).find('[data-name="media"]');
		let dataHidden = $(thisContainer).find('[data-name="hidden-media"]');
		
		e.preventDefault();
		
		if (thisContainer.find('.image').length !== 0) {
			dataMedia.attr('src', '');
			dataMedia.attr('data-src', '');
		}
		
		if (thisContainer.find('.file-name').length !== 0) {
			dataMedia.find('span').text('');
		}
		
		dataHidden.val('');
		
		// Toggle the divs
		thisContainer.children('.no-value').removeClass('hide');
		thisContainer.children('.has-value').addClass('hide');
		
	});
	
})(jQuery);