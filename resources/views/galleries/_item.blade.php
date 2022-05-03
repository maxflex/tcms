<td style='width: 41px'>
    @{{ model.id }}
</td>
<td width='400'>
    <a href='galleries/@{{ model.id }}/edit'>@{{ model.name || 'имя не указано' }}</a>
</td>
<td width='200'>
    <img ng-show='model.has_photo' src='/img/gallery/@{{model.id}}.jpg?version=@{{model.version}}' style='height: 50px'>
    <div ng-show='!model.has_photo' class="no-photo-small">нет фото</div>
</td>
<td width='300'>
    <span ng-if="!model.master_id" class="text-gray">мастер не указан</span>
    <a ng-if='model.master_id > 0' href='masters/@{{ model.master_id }}/edit'>
            @{{ (model.master.last_name || model.master.first_name || model.master.middle_name) ? (model.master.last_name + ' ' + model.master.first_name[0] + '. ' + model.master.middle_name[0] + '.') : 'имя не указано' }}
    </a>
</td>
<td>
    <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
</td>
