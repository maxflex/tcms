<div class="row mb" ng-show="FormService.model.id">
  <div class="col-sm-12">
      <div style='display: flex'>
          @if ($type == 'rectangle')
              <div ng-repeat="photo in FormService.model.photos" ng-click="PhotoService.edit($index)"
                    style="background-image: url(@{{ photo.cropped ? 'photos/cropped/' + photo.cropped : 'img/icons/nocropped.png'}})"  class="photo img-preview-rectangle"></div>
          @else
              <img ng-repeat="photo in FormService.model.photos" class="photo {{ $type }}" ng-click="PhotoService.edit($index)"
                src="@{{ photo.cropped ? 'photos/cropped/' + photo.cropped : 'img/icons/nocropped.png'}}">
          @endif

        <div class="add-photo {{ $type }}" onclick="$('#fileupload').click()" ng-show="FormService.model.photos.length < {{ $max }}">
            добавить фото
        </div>
      </div>
      <input type="file" name="photo" id="fileupload" style='display: none'/ data-url="upload">
  </div>
</div>

<div class="modal modal-fullscreen" tabindex="-1" data-backdrop="static" id='change-photo'>
    <div class="modal-dialog" style="width: 80%; height: 90%; margin: 3% auto">
        <div class="modal-content" style="height: 100%; padding: 15px; display: flex">
            <div class="image-col-left">
                <ui-cropper image="PhotoService.image" result-image="PhotoService.cropped_image"
                    area-type="{{ $type }}" aspect-ratio="PhotoService.aspect_ratio" methods="PhotoService.methods"
                    area-init-size="{{ $size }}" area-min-relative-size="{{ $size }}" result-image-size="'max'" result-image-quality="1"></ui-cropper>
            </div>
            <div class="img-preview-wrapper">
                {{-- <div style='margin-bottom: 15px'>
                    <div class="form-group">
                        @if ($type == 'rectangle')
                            <div style='background-image: url(@{{ PhotoService.cropped_image }})'  class="img-preview-rectangle"></div>
                        @else
                            <img ng-src="@{{ PhotoService.cropped_image }}" class="img-preview {{ $type }}" />
                        @endif
                    </div>
                </div> --}}
                <div style='margin-bottom: 15px'>
                    @{{ PhotoService.getSelectedPhoto().file_size }}
                </div>
                <button class="btn btn-primary" style='margin-bottom: 15px; width: 200px; box-sizing: border-box;' ng-click="PhotoService.crop()" ng-disabled="PhotoService.cropping">@{{ PhotoService.cropping ? 'сохранение...' : 'сохранить' }}</button>
                <button class="btn btn-primary" style='margin-bottom: 15px; width: 200px; box-sizing: border-box;' ng-click="PhotoService.delete()">удалить</button>
                <button class="btn btn-primary" style='margin-bottom: 15px; width: 200px; box-sizing: border-box;' ng-click="PhotoService.closeModal()">закрыть</button>
                <div style='width: 220px'>
                    <label style='color: black !important'>
                        <input type="checkbox" name="checkbox" value="value" ng-click="PhotoService.toggleAscpectRatio()"> фиксация пропорции
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
