<div class="row mb" style='margin-top: 30px' ng-show="FormService.model.id">
  <div class="col-sm-12">
      <div style='display: flex'>
          <img ng-repeat="photo in FormService.model.photos" class="photo" ng-click="PhotoService.edit($index)"
             ng-show="($index + 1) <= FormService.model.count"
            src="@{{ photo.cropped ? 'photos/cropped/' + photo.cropped : 'img/icons/nocropped.png'}}">

        <div class="add-photo" onclick="$('#fileupload').click()" ng-show="FormService.model.photos.length < FormService.model.count">
            добавить фото
        </div>
      </div>
      <input type="file" name="photo" id="fileupload" style='display: none'/ data-url="upload">
  </div>
</div>

<div class="gallery-preview-full">
    <center>
        <a href='/img/gallery/@{{ FormService.model.id }}.png' target="_blank">предпросмотр</a>
    </center>
    <img ng-repeat="photo in FormService.model.photos" ng-show="($index + 1) <= FormService.model.count" style='width: @{{ 100 / FormService.model.count }}%'
      ng-class="{'empty-line-fix': FormService.model.count == 2 && $index == 1}" src="@{{ photo.cropped ? 'photos/cropped/' + photo.cropped : 'img/icons/nocropped.png'}}">
</div>

<div class="modal modal-fullscreen gallery-fullscreen" tabindex="-1" id='change-photo'>
    <div class="modal-dialog" style="width: 80%; height: 90%; margin: 3% auto">
        <div class="modal-content" style="height: 100%; padding: 15px; display: flex">
            <div class="image-col-left">
                <ui-cropper image="PhotoService.image"
                    result-image="PhotoService.cropped_image"
                    area-init-size="size"
                    area-min-relative-size="size"
                    area-type="rectangle"
                    aspect-ratio="ratio"
                    result-image-size="{h: size.h, w: size.w}"
                    result-image-quality=".1"></ui-cropper>
            </div>
            <div class="img-preview-wrapper">
                <div style='margin-bottom: 30px; width: 100%'>
                    <div class="form-group">
                       <img ng-src="@{{ PhotoService.cropped_image }}" style='height: auto; width: 100%'/>
                    </div>
                </div>
                <button class="btn btn-primary full-width" style='margin-bottom: 15px; box-sizing: border-box;' ng-click="PhotoService.crop()" ng-disabled="PhotoService.cropping">@{{ PhotoService.cropping ? 'сохранение...' : 'сохранить' }}</button>
                <button class="btn btn-primary full-width" style='box-sizing: border-box;' ng-click="PhotoService.delete()">удалить</button>
            </div>
        </div>
    </div>
</div>
