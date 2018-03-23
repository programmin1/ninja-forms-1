/**
 * Ninja Forms Form Block
 *
 * A block for embedding a Ninja Forms form into a post/page.
 */
( function( blocks, i18n, element, components ) {

	var el = element.createElement, // function to create elements
		TextControl = components.TextControl,
        InspectorControls = blocks.InspectorControls, // sidebar controls
        Sandbox = components.Sandbox; // needed to register the block

	// register our block
	blocks.registerBlockType( 'ninja-forms/form', {
		title: 'Ninja Forms',
		icon: 'feedback',
		category: 'common',

		attributes: {
            formID: {
                type: 'integer',
                default: 0
            },
			inputVal: {
            	type: 'string',
				default: 'heyo'
			}
		},

		edit: function( props ) {

        var focus = props.focus;

        var formID = props.attributes.formID;

        var formName = props.attributes.formName;

        var children = [];

        if( ! formID ) formID = ''; // Default.

		function nfOnValueChange( formName ) {
			// props.setAttributes( { formName: formName } );
		}

		function nfFocusClick( event ) {
			var elID = event.target.getAttribute( 'id' );
			var idArray = elID.split( '-' );
			var nfOptions = document.getElementById( 'nf-filter-container-' + idArray[ idArray.length -1 ] );
			nfOptions.style.display = 'block';
		}

		function doIt( event ) {
			props.setAttributes( {
				formID: event.target.getAttribute( 'data-formid' ),
				formName: event.target.innerText
			} );
			var elID = event.target.parentNode.parentNode;
			var idArray = elID.getAttribute( 'id' ).split( '-' );
			var nfOptions = document.getElementById( 'nf-filter-container-' + idArray[ idArray.length -1 ] );
			var inputEl = document.getElementById( 'formFilter-sidebar' );
			inputEl.value = event.target.innerText;
			nfOptions.style.display = 'none';
		}

		function nfHideOptions( event ) {
			var elID = event.target.getAttribute( 'id' );
			var idArray = elID.split( '-' );
			var nfOptions = document.getElementById( 'nf-filter-container-' + idArray[ idArray.length -1 ] );
			nfOptions.style.display = 'none';
		}

		function nfInputKeyUp( event ) {
			var val = event.target.value;
			var filterInputContainer = event.target.parentNode.parentNode;
			filterInputContainer.querySelector( '.nf-filter-option-container' ).style.display = 'block';
			filterInputContainer.style.display = 'block';
			_.each( ninjaFormsBlock.forms, function( form, index ) {
				var liEl = filterInputContainer.querySelector( "[data-formid='" + form.value + "']" );
				if ( 0 <= form.label.toLowerCase().indexOf( val.toLowerCase() ) ) {
					// shows options that DO contain the text entered
					liEl.style.display = 'block';
				} else {
					// hides options the do not contain the text entered
					liEl.style.display = 'none';
				}
			});
		}

		var formItems = [];
		_.each( ninjaFormsBlock.forms, function( form, index ) {
			formItems.push( el( 'li', { className: 'nf-filter-option',
					'data-formid': form.value, onMouseDown: doIt}, form.label ))
		});

		var inputFilterMain = el( 'div', { id: 'nf-filter-input-main',
				className: 'nf-filter-input' },
			el( TextControl, { id: 'formFilter-main',
				placeHolder: 'Select a Form',
				className: 'nf-filter-input-el blocks-select-control__input',
				onChange: nfOnValueChange,
				onClick: nfFocusClick,
				onKeyUp: nfInputKeyUp,
				onBlur: nfHideOptions
			} ),
			el( 'span', { id: 'nf-filter-input-icon-main',
				className: 'nf-filter-input-icon',
				onClick: nfFocusClick,
				dangerouslySetInnerHTML: { __html: '&#9662;' } } ),
			el( 'div', { id: 'nf-filter-container-main',
					className: 'nf-filter-option-container' },
					el( 'ul', null, formItems )
			)
		);

		var inputFilterSidebar = el( 'div', { id: 'nf-filter-input-sidebar',
				className: 'nf-filter-input' },
			el( TextControl, { id: 'formFilter-sidebar',
				placeHolder: 'Select a Form',
				className: 'nf-filter-input-el blocks-select-control__input',
				onChange: nfOnValueChange,
				onClick: nfFocusClick,
				onKeyUp: nfInputKeyUp,
				onBlur: nfHideOptions
			} ),
			el( 'span', { id: 'nf-filter-input-icon-sidebar',
				className: 'nf-filter-input-icon',
				onClick: nfFocusClick,
				dangerouslySetInnerHTML: { __html: '&#9662;' } } ),
			el( 'div', { id: 'nf-filter-container-sidebar',
					className: 'nf-filter-option-container' },
				el( 'ul', null, formItems )
			)
		);

		// Set up the form dropdown in the side bar 'block' settings
        var inspectorControls = el( InspectorControls, {},
	        inputFilterSidebar
            // el( SelectControl, { label: 'Form ID', value: formID, options: ninjaFormsBlock.forms, onChange: onFormChange } )
        );


		/**
		 * Create the div container, add an overlay so the user can interact
		 * with the form in Gutenberg, then render the iframe with form
		 */
		if( '' === formID ) {
			children.push( el( 'div', {style : {width: '100%'}},
				el( 'img', { src: ninjaFormsBlock.block_logo}),
				// el( SelectControl, { value: formID, options: ninjaFormsBlock.forms, onChange: onFormChange }),
				el ( 'div', null, 'Type to Filter'),
				inputFilterMain
			) );
		} else {
			children.push(
				el( 'div', { className: 'nf-iframe-container' },
					el( 'div', { className: 'nf-iframe-overlay' } ),
					el( 'iframe', { src: ninjaFormsBlock.siteUrl + '?nf_preview_form='
						+ formID + '&nf_iframe', height: '0', width: '500', scrolling: 'no' })
				)
			)
		}
		return [
			children,
			!! focus && inspectorControls
        ];
		},

		save: function( props ) {

            var formID = props.attributes.formID;

            if( ! formID ) return '';
			/**
			 * we're essentially just adding a short code, here is where
			 * it's save in the editor
			 *
			 * return content wrapped in DIV b/c raw HTML is unsupported
			 * going forward
			 */
			var returnHTML = '[ninja_forms id=' + parseInt( formID ) + ']';
			return el( 'div', null, returnHTML);
		}
	} );


} )(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element,
	window.wp.components
);
