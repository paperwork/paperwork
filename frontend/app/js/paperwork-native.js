window.paperworkNative = {
	callbacks: {
		api: {
			get: null,
			post: null,
			put: null,
			delete: null
		}
	},
	menu: {
		get: function() {
			return [
				{
					id: 'menu-item-file',
					sub: [
						{
							id: 'menu-item-file-sub-new_note'
						},
						{
							id: 'menu-item-file-sub-new_notebook'
						},
						{
							id: 'menu-item-file-sub-new_collection'
						}
					]
				},
				{
					id: 'menu-item-edit',
					sub: [
						{
							id: 'menu-item-edit-sub-edit_note'
						},
						{
							id: 'menu-item-edit-sub-edit_notes'
						},
						{
							id: 'menu-item-edit-sub-move_note'
						},
						{
							id: 'menu-item-edit-sub-delete_note'
						},
						{
							id: 'menu-item-edit-sub-edit_notebook'
						},
						{
							id: 'menu-item-edit-sub-delete_notebook'
						}
					]
				}
			];
		},
		trigger: function(_id) {
			angular.element('#' + _id).trigger('click');
		}
	}
};