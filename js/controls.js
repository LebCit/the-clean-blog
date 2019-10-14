/* 
 * File controls.js
 * 
 * Access Theme Customizer Controls for a better user experience.
 */

(function (api) {

	api.bind('ready', function () {

		// Send a previewed-device message from the Customizer to the Previewer.
		function sendPreviewedDevice() {
			api.previewer.send( 'previewed-device', api.previewedDevice.get() );
		}
		// Send the initial previewed device when preview is ready.
		api.previewer.bind( 'ready', sendPreviewedDevice );
		// Send the previewed device whenever it changes.
		api.previewedDevice.bind( sendPreviewedDevice );

		// Send a pane-visible message from the Customizer to the Previewer.
		function sendPaneVisible() {
			api.previewer.send( 'pane-visible', api.state( 'paneVisible' ).get() );
		}
		// Send the pane visibility whenever it changes.
		api.state( 'paneVisible' ).bind( sendPaneVisible );

	});

})(wp.customize);