<a ng-class="{'price-section': item.is_section}" href='prices/@{{ item.is_section ? ""  : "positions/" }}@{{ item.model.id }}/edit'>@{{ item.model.name }}</a>
<a ng-show='item.is_section' href='prices/@{{ item.model.id }}/positions/create' class='pull-right'>+ позиция</a>
<a ng-show='item.is_section' href='prices/@{{ item.model.id }}/create' class='pull-right' style='margin-right: 20px'>+ раздел</a>
<div class="price-divider"></div>
<ul ui-sortable='sortableOptions' ng-model="item.items">
    <li ng-repeat="item in item.items" class='price-item-@{{ $parent.$id }}'>
        <price-item item='item'></price-item>
    </li>
</ul>
