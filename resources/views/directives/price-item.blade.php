<a class="price-section" href='prices/@{{ item.id }}/edit'>@{{ item.name }}</a>
<a href='prices/@{{ item.id }}/positions/create' class='pull-right'>+ позиция</a>
<a href='prices/@{{ item.id }}/create' class='pull-right' style='margin-right: 20px'>+ раздел</a>
<div class="price-divider"></div>
<ul ui-sortable='sortableOptions' ng-model="item.positions">
    <li ng-repeat="item in item.sections">
        <price-item item='item'></price-item>
    </li>
    <li ng-repeat='position in item.positions' class='price-position-@{{ $parent.$id }}'>
        <a href='prices/positions/@{{ position.id }}/edit'>@{{ position.name }}</a>
        <div class="price-divider"></div>
    </li>
</ul>
