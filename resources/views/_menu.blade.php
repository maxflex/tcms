<a class="list-group-item active">Разделы
    <span class="search-icon" id='searchModalOpen'><span class="glyphicon glyphicon-search no-margin-right"></span></span>
</a>
<a href="masters" class="list-group-item">Мастера</a>
<a href="equipment" class="list-group-item">Оборудование</a>
<a href="tags" class="list-group-item">Теги</a>
<a href="reviews" class="list-group-item">Отзывы</a>
<a href="gallery" class="list-group-item">Галерея</a>
<a href="prices" class="list-group-item">Прайс лист</a>
<a class="list-group-item active">Сайт</a>
<a href="variables" class="list-group-item">Переменные</a>
<a href="pages" class="list-group-item">Страницы</a>
<a class="list-group-item active">Настройки</a>
@if (allowed(\Rights::EDIT_USERS))
    <a href="users" class="list-group-item">Пользователи</a>
@endif
@if (allowed(\Rights::LOGS))
    <a href="logs" class="list-group-item">Логи</a>
@endif
@if (allowed(\Rights::ACCOUNT))
    <a href="account" class="list-group-item">Счёт</a>
@endif
@if (allowed(\Rights::PAYSTREAM))
    <a href="payments" class="list-group-item">Платежи</a>
@endif
<a href="logout" class="list-group-item">Выход</a>
