angular.module('Egecms')
    .value 'Published', [
        {id:0, title: 'не опубликовано'},
        {id:1, title: 'опубликовано'},
    ]
    .value 'Scores', [
        {id:1, title: '1'},
        {id:2, title: '2'},
        {id:3, title: '3'},
        {id:4, title: '4'},
        {id:5, title: '5'},
        {id:6, title: '6'},
        {id:7, title: '7'},
        {id:8, title: '8'},
        {id:9, title: '9'},
        {id:10, title: '10'},
    ]
    .value 'Checked', ['не проверено', 'проверено']
    .value 'UpDown', [
        {id: 1, title: 'вверху'},
        {id: 2, title: 'внизу'},
    ]
    .value 'Units', [
        {id: 1, title: 'изделие'},
        {id: 2, title: 'штука'},
        {id: 3, title: 'сантиметр'},
        {id: 4, title: 'пара'},
        {id: 5, title: 'метр'},
        {id: 6, title: 'дм²'},
        {id: 7, title: 'см²'},
        {id: 8, title: 'мм²'},
        {id: 9, title: 'элемент'},    ]
    .value 'LogTypes',
        create: 'создание'
        update: 'обновление'
        delete: 'удаление'
        authorization: 'авторизация'
        url: 'просмотр URL'
