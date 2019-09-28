<td style='width: 41px'>
    @{{ model.id }}
</td>
<td width='300'>
    <a target="_blank" href='reviews/@{{ model.id }}/edit'>@{{ model.signature || 'не указано' }}</a>
</td>
<td width='150'>
    @{{ model.date }}
</td>
<td width='150'>
    оценка @{{ model.score || 'не установлена' }}
</td>
<td width='150'>
    @{{ model.published ? 'опубликован' : 'не опубликован' }}
</td>
<td>
    <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
</td>
