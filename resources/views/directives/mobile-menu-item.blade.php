<div>
    <div class='mobile-menu-title'>
        <div class='flex-items-center'>
            <a ng-show="item.children.length > 0" class="pointer" style='position: absolute; margin-left: -15px'>
                <i class="pointer fa"
                    ng-class="{
                        'fa-plus': controller_scope.isCollapsed(item),
                        'fa-minus': !controller_scope.isCollapsed(item)
                    }"
                    ng-click="controller_scope.toggleCollapse(item)"
                    aria-hidden="true"
                ></i>
            </a>
            <b ng-show='!item.is_link'>@{{ item.title }}</b>
            <a ng-show='item.is_link' href='{{ config('app.web-url') }}@{{ item.extra }}' target="_blank" class='bold'>@{{ item.title }}</a>
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
        <div ng-if="item.extra && !item.is_link" class='mobile-menu-extra'>@{{ item.extra }}</div>
    </div>
    <ul ui-sortable='sortableOptions' ng-model="item.children" ng-hide="controller_scope.isCollapsed(item)">
        <li ng-repeat="item in item.children" class='menu-item-@{{ $parent.$id }}'>
            <mobile-menu-item item='item'></mobile-menu-item>
        </li>
    </ul>
</div>
