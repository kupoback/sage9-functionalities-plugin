// eslint-disable-next-line no-undef
if ( typeof acf !== 'undefined' ) {
// eslint-disable-next-line no-undef
	acf.fields.text_counter = acf.field.extend( {
		type: 'text',
		events: {
			'input input': 'change_count',
		},
		change_count( e ) {
			const $max = e.$el.attr( 'maxlength' );
			if ( typeof ( $max ) === 'undefined' || e.$el.closest( '.acf-input' ).find( '.count' ).length === 0 ) {
				return;
			}
			const $value = e.$el.val();
			const $length = $value.length;
			e.$el.closest( '.acf-input' ).find( '.count' ).text( $length );
		},

	} );
}

// eslint-disable-next-line no-undef
if ( typeof acf !== 'undefined' ) {
	// eslint-disable-next-line no-undef
	acf.fields.textarea_counter = acf.field.extend( {
		type: 'textarea',

		events: {
			'input textarea': 'change_count',
		},

		change_count( e ) {
			const $max = e.$el.attr( 'maxlength' );
			if ( typeof ( $max ) === 'undefined' ) {
				return;
			}
			const $value = e.$el.val();
			const $length = $value.length;
			e.$el.closest( '.acf-input' ).find( '.count' ).text( $length );
		},

	} );
}
