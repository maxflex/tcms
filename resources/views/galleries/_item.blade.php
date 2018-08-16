<td width='10'>
    @{{ model.id }}
</td>
<td width='400'>
    <a href='@{{ template.table }}/@{{ model.id }}/edit'>@{{ model.name || 'имя не указано' }}</a>
</td>
<td width='200'>
    <img ng-show='model.has_photo' src='/img/gallery/@{{model.id}}.jpg' style='height: 50px'>
    <div ng-show='!model.has_photo' class="no-photo-small">нет фото</div>
</td>
<td width='150'>
    @{{ model.image_size }}
</td>
<td width='150'>
    @{{ model.file_size }}
</td>
<td>
    <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
</td>
