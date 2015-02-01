<div ng-controller="MessageBoxController" class="modal fade" id="modalMessageBox" tabindex="-1" role="dialog" aria-labelledby="modalMessageBoxLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			[[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">[[Lang::get('keywords.close')]]</span></button>
				<h4 class="modal-title" id="modalMessageBoxLabel">
					{{ modalMessageBox.title }}
				</h4>
			</div>
			<div class="modal-body">
				{{ modalMessageBox.content }}
			</div>
			<div class="modal-footer">
				<button ng-repeat="button in modalMessageBox.buttons" type="button" class="btn {{ button.class ? button.class : 'btn-default' }}" data-dismiss="{{ button.isDismiss ? 'modal' : '' }}" ng-click="onClick(button.id)">{{ button.label }}</button>
			</div>
			[[ Form::close() ]]
		</div>
	</div>
</div>
