<div class="row mb">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'название тега', 'model' => 'text', 'attributes' =>[
            'ng-keyup' => "checkExistance('url', \$event)"
        ]])
    </div>
</div>
@if (isset($id))
<div class="row mb" ng-if="FormService.model.id">
    <div class="col-sm-12">
        <p style='display: inline-block; font-weight: bold; margin-top: 30px'>Массовое редактирование:</p>
        <p>
            <a href="{{ route('galleries.tag', compact('id')) }}">Галерея</a>
        </p>
        <p>
            <a href="{{ route('reviews.tag', compact('id')) }}">Отзывы</a>
        </p>
        <p>
            <a href="{{ route('prices.tag', compact('id')) }}">Прайс-лист</a>
        </p>
    </div>
</div>
@endif
