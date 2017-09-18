<a class="price-section" href='prices/@{{ item.id }}/edit'>@{{ item.name }}</a>
<a style='font-size: 12px; cursor: pointer; margin-left: 5px' ng-click="controller_scope.changePriceDialog(item.id)">изменить цену</a>
<ul>
    <li ng-repeat="item in item.sections">
        <price-item item='item'></price-item>
    </li>
    <li ng-repeat='position in item.positions' class='price-position'>
        <div>
            <a href='prices/positions/@{{ position.id }}/edit'>@{{ position.name }}</a>
        </div>
        <div ng-show='position.price'>
            @{{ position.price }} руб.
        </div>
        <div ng-show='position.unit'>
            @{{ position.unit }}
        </div>
    </li>
    <li>
        добавить <a href='prices/@{{ item.id }}/create'>раздел</a> или <a href='prices/@{{ item.id }}/positions/create'>позицию</a>
    </li>
</ul>
