angular.module 'Egecms'
    .directive 'plural', ->
        restrict: 'E'
        scope:
            count: '='      # кол-во
            type: '@'       # тип plural age | student | ...
            noneText: '@'   # текст, если кол-во равно нулю
        templateUrl: 'directives/plural'
        controller: ($scope, $element, $attrs, $timeout) ->
            $scope.textOnly = $attrs.hasOwnProperty('textOnly')
            $scope.hideZero = $attrs.hasOwnProperty('hideZero')

            $scope.when =
                'file': ['файл', 'файла', 'файлов']
                'folder': ['папка', 'папки', 'папок']
                'age': ['год', 'года', 'лет']
                'student': ['ученик', 'ученика', 'учеников']
                'minute': ['минуту', 'минуты', 'минут']
                'hour': ['час', 'часа', 'часов']
                'day': ['день', 'дня', 'дней']
                'meeting': ['встреча', 'встречи', 'встреч']
                'score': ['балл', 'балла', 'баллов']
                'rubbles': ['рубль', 'рубля', 'рублей']
                'lesson': ['занятие', 'занятия', 'занятий']
                'client': ['клиент', 'клиента', 'клиентов']
                'mark': ['оценки', 'оценок', 'оценок']
                'request': ['заявка', 'заявки', 'заявок']
                'hour': ['час', 'часа', 'часов']
                'photo': ['фотография', 'фотографии', 'фотографий']
                'position': ['позиция', 'позиции', 'позиций']
                'section': ['секция', 'секции', 'секций']
                'will_be_updated': ['обновлена', 'обновлено', 'обновлено']
