<div ng-controller="SidebarManageNotebooksController" class="modal fade modal-manage-list" id="modalManageNotebooks" tabindex="-1" role="dialog" aria-labelledby="modalManageNotebooksLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalManageNotebooksLabel">
                    [[Lang::get('keywords.manage_notebooks')]]
                </h4>
            </div>
            <div class="modal-body">
                <div class="manage-list-content">
                    <div class="row" ng-repeat="item in modalList | orderBy:'title':reverse" pw-on-finish-render="ngRepeatFinished">
                        <div class="col-sm-10">
                            <a class="line" href="#" data-name="title" data-type="text" data-pk="{{item.id}}">{{item.title}}</a>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-xs btn-danger" ng-click="deleteItem(item.id)"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" ng-click="addNotebook();">[[Lang::get('notebooks.title_new_notebook')]]</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.close')]]</button>
            </div>
        </div>
    </div>
</div>
