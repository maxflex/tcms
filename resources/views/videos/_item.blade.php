<td width='10'>
    @{{ model.id }}
</td>
<td>
    <a href='videos/@{{ model.id }}/edit'>@{{ model.title }}</a>
</td>
<td>
    <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
</td>
