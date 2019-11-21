<td style='width: 41px'>
    @{{ gallery.id }}
</td>
<td width='400'>
    <a href='galleries/@{{ gallery.id }}/edit'>@{{ gallery.name || 'имя не указано' }}</a>
</td>
<td width='200'>
    <img ng-show='gallery.has_photo' src='/img/gallery/@{{gallery.id}}.jpg' style='height: 50px'>
    <div ng-show='!gallery.has_photo' class="no-photo-small">нет фото</div>
</td>
<td width='300'>
    <span ng-if="!gallery.master_id" class="text-gray">мастер не указан</span>
    <a ng-if='gallery.master_id > 0' href='masters/@{{ gallery.master_id }}/edit'>
            @{{ (gallery.master.last_name || gallery.master.first_name || gallery.master.middle_name) ? (gallery.master.last_name + ' ' + gallery.master.first_name[0] + '. ' + gallery.master.middle_name[0] + '.') : 'имя не указано' }}
    </a>
</td>
<td>
    <span class="tag" ng-repeat="tag in gallery.tags">@{{ tag.text }}</span>
</td>
