<a ng-show="item.is_section" ng-class="{'invisible': !item.items.length}" class="pointer" style='margin-right: 3px'><i  class="pointer fa" ng-class="{'fa-plus': controller_scope.isCollapsed(item), 'fa-minus': !controller_scope.isCollapsed(item)}" ng-click="controller_scope.toggleCollapse(item)" aria-hidden="true"></i></a>
<a ng-class="{'price-section': item.is_section, 'price-section-item': !item.is_section}" href='prices/@{{ item.is_section ? ""  : "positions/" }}@{{ item.model.id }}/edit'>
    @{{ item.model.name }} <a style='margin-left: 5px' ng-show='!item.is_section' class='show-on-hover pointer copiable' data-clipboard-text="@{{ item.model.name }}">копировать</a>
</a>
<a ng-show='item.is_section' href='prices/@{{ item.model.id }}/positions/create' style='margin-left: 20px'>+ позиция</a>
<a ng-show='item.is_section' href='prices/@{{ item.model.id }}/create' style='margin-left: 5px'>+ раздел</a>
<span class="pull-right" ng-show="!item.is_section && item.model.price" style='width: 700px; white-space: nowrap'>
    от @{{ item.model.price | number }} руб.<span ng-show="item.model.unit">/@{{ findById(Units, item.model.unit).title }}</span>
    <span style='margin-left: 10px'>
        <span class="tag" ng-repeat="tag in item.model.tags">@{{ tag.text }}</span>
    </span>
</span>
<div class="price-divider"></div>
<ul ui-sortable='sortableOptions' ng-model="item.items" ng-hide="controller_scope.isCollapsed(item)">
    <li ng-repeat="item in item.items" class='price-item-@{{ $parent.$id }}'>
        <price-item item='item'></price-item>
    </li>
</ul>
