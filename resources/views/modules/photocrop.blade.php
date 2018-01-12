<div class="row mb" ng-show="FormService.model.id">
  <div class="col-sm-12">
      <div style='display: flex'>
          <img ng-repeat="photo in FormService.model.photos" class="photo {{ $type }}" ng-click="PhotoService.edit($index)"
            src="@{{ photo.cropped ? 'photos/cropped/' + photo.cropped : 'img/icons/nocropped.png'}}">

        <div class="add-photo {{ $type }}" onclick="$('#fileupload').click()" ng-show="FormService.model.photos.length < {{ $max }}">
            добавить фото
        </div>
      </div>
      <input type="file" name="photo" id="fileupload" style='display: none'/ data-url="upload">
  </div>
</div>

<div class="modal modal-fullscreen" tabindex="-1" id='change-photo'>
    <div class="modal-dialog" style="width: 80%; height: 90%; margin: 3% auto">
        <div class="modal-content" style="height: 100%; padding: 15px; display: flex">
            <div class="image-col-left">
                <ui-cropper image="PhotoService.image" result-image="PhotoService.cropped_image"
                    area-type="{{ $type }}"
                    area-init-size="{{ $size }}" area-min-relative-size="{{ $size }}" result-image-size="{{ $size }}" result-image-quality="1"></ui-cropper>
            </div>
            <div class="img-preview-wrapper">
                <div style='margin-bottom: 15px'>
                    <div class="form-group">
                       <img ng-src="@{{ PhotoService.cropped_image }}" class="img-preview {{ $type }}" />
                    </div>
                </div>
                <div style='margin-bottom: 15px'>
                    @{{ PhotoService.getSelectedPhoto().file_size }}
                </div>
                <button class="btn btn-primary" style='margin-bottom: 15px; width: 200px; box-sizing: border-box;' ng-click="PhotoService.crop()" ng-disabled="PhotoService.cropping">@{{ PhotoService.cropping ? 'сохранение...' : 'сохранить' }}</button>
                <button class="btn btn-primary" style='width: 200px; box-sizing: border-box;' ng-click="PhotoService.delete()">удалить</button>
            </div>
        </div>
    </div>
</div>
