<span class='price-section'>
    <span style='width: 41px; font-weight: normal; display: inline-block'>@{{ item.id }}</span>
    <a href='prices/@{{ item.model.id }}/edit'
        class='menu-title'
        ng-class="{'menu-title_hidden': item.is_hidden}"
    >@{{ (item.name || 'имя не указано') | cut:false:40 }}</a>
</span>
<a class='show-on-hover' href='prices/@{{ item.model.id }}/positions/create' style='margin-left: 20px'>+ позиция</a>
<a class='show-on-hover' href='prices/@{{ item.model.id }}/create' style='margin-left: 5px'>+ раздел</a>
<a class='show-on-hover pointer' ng-click="controller_scope.changePriceDialog(item)" style='margin-left: 5px'>индексация</a>
<a class='show-on-hover pointer' ng-click="controller_scope.hide(item)" style='margin-left: 5px'>
    @{{ item.is_hidden ? 'показать' : 'скрыть' }}
</a>
