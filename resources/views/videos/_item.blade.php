<td width='10'>
    @{{ video.id }}
</td>
<td>
    <a href='videos/@{{ video.id }}/edit'>@{{ video.title }}</a>
</td>
<td>
    <span class="tag" ng-repeat="tag in video.tags">@{{ tag.text }}</span>
</td>
