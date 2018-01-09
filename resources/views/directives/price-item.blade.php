<a ng-show="item.is_section" ng-class="{'invisible': !item.items.length}" class="pointer" style='margin-right: 3px'><i  class="pointer fa" ng-class="{'fa-plus': controller_scope.isCollapsed(item), 'fa-minus': !controller_scope.isCollapsed(item)}" ng-click="controller_scope.toggleCollapse(item)" aria-hidden="true"></i></a>
<span ng-class="{'price-section': item.is_section, 'price-section-item': !item.is_section}">
    <span style='margin-right: 5px' ng-show='!item.is_section' class='link-like show-on-hover pointer copiable' data-clipboard-text="@{{ item.model.name }}"><i class="fa fa-clipboard" aria-hidden="true"></i></span>
    <a href='prices/@{{ item.is_section ? ""  : "positions/" }}@{{ item.model.id }}/edit'>@{{ item.model.name | cut:false:40 }}</a>
</span>
<a class='show-on-hover' ng-show='item.is_section' href='prices/@{{ item.model.id }}/positions/create' style='margin-left: 20px'>+ позиция</a>
<a class='show-on-hover' ng-show='item.is_section' href='prices/@{{ item.model.id }}/create' style='margin-left: 5px'>+ раздел</a>
<span class="pull-right" ng-show="!item.is_section && item.model.price" style='width: 700px; white-space: nowrap'>
    <span style='display: inline-block; width: 175px; font-size: 10px'>от @{{ item.model.price | number }} руб.<span ng-show="item.model.unit">/@{{ findById(Units, item.model.unit).title }}</span></span>
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
