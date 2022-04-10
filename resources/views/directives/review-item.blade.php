<div>
    <div ng-if="model.hasOwnProperty('items')">
        <div>
            <div class="fake-td" ng-style="{'padding-left': ( level + 1 ) * 30 + 'px'}">
                <input type='checkbox' class="mass-tags-checkbox" ng-click="controller_scope.checkGroup(model)" ng-checked="model.is_checked" />
                <div class="id-cell">@{{ model.id }}</div>
                <i class="fa text-success" ng-class="{
                    'fa-folder-open': model.items.length > 0,
                    'fa-folder': model.items.length === 0,
                }" aria-hidden="true"></i>
                @{{ model.name }}
            </div>
            <div ng-repeat="item in model.items">
                <review-item model="item" level="level + 1"></review-item>
            </div>
        </div>
    </div>
    <div ng-if="!model.hasOwnProperty('items')">
        <table class="table" style='margin: 0'>
            <tr>
                <td ng-style="{'padding-left': ( level + 1 ) * 30 + 'px'}" style='width: 26px; position: relative'>
                    <input type='checkbox' class="mass-tags-checkbox"
                        ng-checked="controller_scope.isChecked(model)"
                        ng-click="controller_scope.check(model)" />
                </td>
                @include('reviews._item')
            </tr>
        </table>
    </div>
</div>
