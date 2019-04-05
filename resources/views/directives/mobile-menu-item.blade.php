<div>
    <div ng-show='item.is_link' class='mobile-menu-title flex-items-center'>
        <a href='{{ config('app.web-url') }}@{{ item.extra }}' target="_blank" class='bold'>@{{ item.title }}</a>
        <a class='pointer table-small show-on-hover'
            style='margin-left: 8px'
            ng-click='controller_scope.openDialog(item)'>изменить</a>
        <a class='pointer table-small show-on-hover'
            style='margin-left: 8px'
            ng-click='controller_scope.remove(item.id)'>удалить</a>
    </div>
    <div ng-show='!item.is_link'>
        <div class='mobile-menu-title'>
            <div class='flex-items-center'>
                <b>@{{ item.title }}</b>
                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px'
                    ng-click='controller_scope.openDialog({menu_id: item.id})'>добавить</a>
                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px'
                    ng-click='controller_scope.openDialog(item)'>изменить</a>
                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px'
                    ng-click='controller_scope.remove(item.id)'>удалить</a>
            </div>
            <div ng-if="item.extra" class='mobile-menu-extra'>@{{ item.extra }}</div>
        </div>
        <ul ui-sortable='sortableOptions' ng-model="item.children">
            <li ng-repeat="item in item.children" class='menu-item-@{{ $parent.$id }}'>
                <mobile-menu-item item='item'></mobile-menu-item>
            </li>
        </ul>
    </div>
</div>
