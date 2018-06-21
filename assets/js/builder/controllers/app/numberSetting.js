/**
 * Handles actions related to number field settings.
 *
 * @package Ninja Forms builder
 * @subpackage Fields - Edit Field Drawer
 * @copyright (c) 2015 WP Ninjas
 * @since 3.0
 */
define( [], function() {
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// We don't want the RTE setting to re-render when the value changes.
			nfRadio.channel( 'setting-type-number' ).reply( 'renderOnChange', function(){ return false; } );

			// Respond to requests for field setting filtering.
			nfRadio.channel( 'number' ).reply( 'before:updateSetting', this.updateSetting, this );
		},

		/**
		 * Return either 1 or 0, depending upon the toggle position.
		 *
		 * @since  3.0
		 * @param  Object 			e                event
		 * @param  backbone.model 	fieldModel       field model
		 * @param  string 			name             setting name
		 * @param  backbone.model 	settingTypeModel field type model
		 * @return int              1 or 0
		 */
		updateSetting: function( e, fieldModel, name, settingTypeModel ) {
			var minVal = settingTypeModel.get( 'min_val' );
			var maxVal = settingTypeModel.get( 'max_val' );

			if( 'undefined' != typeof minVal && null !== minVal ){
				if ( e.target.value < minVal ) {
					fieldModel.set('value', minVal);
					e.target.value = minVal;
					// return minVal;
				}
			}

			if( 'undefined' != typeof maxVal && null !== maxVal ){
				if ( e.target.value > maxVal ) {
					fieldModel.set('value', maxVal);
					e.target.value = maxVal;
					// return maxVal;
				}
			}

			return e.target.value;
		}

	});

	return controller;
} );