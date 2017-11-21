<div class="row mb">
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'логин', 'model' => 'login'])
    </div>
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'пароль', 'model' => 'new_password', 'attributes' => [
            'type' => 'password'
        ]])
    </div>
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'телефон', 'model' => 'phone', 'attributes' => [
            'ng-phone' => true
        ]])
    </div>
</div>
<div class="row mbl">
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'фамилия', 'model' => 'last_name'])
    </div>
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'имя', 'model' => 'first_name'])
    </div>
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'отчество', 'model' => 'middle_name'])
    </div>
</div>
<div class="row">
    <div class="col-sm-12 flex-items">
        <div style='width: 200px'>
            Страница «Пользователи»
        </div>
        <div>
            <div class="switch">
                <input id="cmn-toggle-1" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-click='toggleRights(2)' ng-checked='allowed(2)'>
                <label for="cmn-toggle-1"></label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 flex-items">
        <div style='width: 200px'>
            Страница «Логи»
        </div>
        <div>
            <div class="switch">
                <input id="cmn-toggle-3" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-click='toggleRights(3)' ng-checked='allowed(3)'>
                <label for="cmn-toggle-3"></label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 flex-items">
        <div style='width: 200px'>
            Страница «Счёт»
        </div>
        <div>
            <div class="switch">
                <input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-click='toggleRights(4)' ng-checked='allowed(4)'>
                <label for="cmn-toggle-4"></label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 flex-items">
        <div style='width: 200px'>
            Страница «Платежи»
        </div>
        <div>
            <div class="switch">
                <input id="cmn-toggle-5" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-click='toggleRights(5)' ng-checked='allowed(5)'>
                <label for="cmn-toggle-5"></label>
            </div>
        </div>
    </div>
</div>
<div class="row mb">
    <div class="col-sm-12 flex-items">
        <div style='width: 200px'>
            Заблокирован
        </div>
        <div>
            <div class="switch">
                <input id="cmn-toggle-2" class="cmn-toggle cmn-toggle-round-flat red" type="checkbox" ng-click='toggleRights(1)' ng-checked='allowed(1)'>
                <label for="cmn-toggle-2"></label>
            </div>
        </div>
    </div>
</div>
@include('modules.photocrop', ['size' => '{w: 666, h: 1000}', 'type' => 'square', 'max' => 1])
