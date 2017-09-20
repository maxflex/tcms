<a class="list-group-item active">Основное
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
@if (allowed(\App\Service\Rights::EDIT_USERS))
    <a href="users" class="list-group-item">Пользователи</a>
@endif
<a href="pages" class="list-group-item">Страницы</a>
<a href="logout" class="list-group-item">Выход</a>
