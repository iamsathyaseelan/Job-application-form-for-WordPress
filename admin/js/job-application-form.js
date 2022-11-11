/**
 * Code contains all stuffs related to admin
 *
 * @package Job_Application_Form
 */

(function ($, data) {
	'use strict';
	$(
		function () {
			$( document ).on(
				'submit',
				'form',
				function (e) {
					var $form = $( this );
					var bulk_action = $form.find( 'select[name="action"]' ).val();
					if (bulk_action == "delete") {
						if (confirm( job_application_form_localize_script.i18n.alert_bulk_delete )) {
							return true;
						} else {
							e.preventDefault();
						}
					}
				}
			);
			$( document ).on(
				'click',
				'.row-actions .delete a',
				function (e) {
					if (confirm( job_application_form_localize_script.i18n.alert_delete )) {
						return true;
					} else {
						e.preventDefault();
					}
				}
			);
		}
	);
})( jQuery, job_application_form_localize_script );
