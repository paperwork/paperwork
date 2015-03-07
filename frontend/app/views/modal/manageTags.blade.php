<div ng-controller="SidebarManageTagsController" class="modal fade modal-manage-list" id="modalManageTags" tabindex="-1" role="dialog" aria-labelledby="modalManageTagsLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalManageTagsLabel">
                    [[Lang::get('keywords.manage_tags')]]
                </h4>
            </div>
            <div class="modal-body">
                <div class="manage-list-content">
                    <div class="row" ng-repeat="tag in modalTags | orderBy:'title':reverse" pw-on-finish-render="ngRepeatFinished">
                        <div class="col-sm-10">
                            <a class="line" href="#" data-name="title" data-type="text" data-pk="{{tag.id}}">{{tag.title}}</a>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-xs btn-danger" ng-click="deleteTag(tag.id)"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.close')]]</button>
            </div>
        </div>
    </div>
</div>
