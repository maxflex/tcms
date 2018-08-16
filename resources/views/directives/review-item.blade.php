<div>
    <div ng-if="model.hasOwnProperty('items')">
        <div>
            <div class="fake-td" ng-style="{'padding-left': level * 30 + 'px'}">
                <div class="id-cell">@{{ model.id }}</div>
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
                <td ng-style="{'padding-left': level * 30 + 'px'}" style='width: 26px; position: relative'>
                    <input type='checkbox' class="mass-tags-checkbox"
                        ng-checked="controller_scope.isChecked(model)"
                        ng-click="controller_scope.check(model)" />
                </td>
                @include('reviews._item')
            </tr>
        </table>
    </div>
</div>
