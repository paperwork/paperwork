	<div class="form-group">
		<label for="qrcode">QR Code:</label>
		<div id="qrcode">
			[[QrCode::size(400)->generate(PaperworkHelpers::generateClientQrCodeJson())]]
		</div>
		<p class="help-block">[[ Lang::get('messages.user.settings.client.scan') ]]</p>
	</div>
