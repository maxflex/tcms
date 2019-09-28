(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module("Egecms", ['ngSanitize', 'ngResource', 'ngAnimate', 'ui.bootstrap', 'angular-ladda', 'angularFileUpload', 'angucomplete-alt', 'ngDrag', 'ngAnimate', 'thatisuday.ng-image-gallery', 'ng-sortable', 'uiCropper', 'ngTagsInput', 'ui.sortable']).config([
    '$compileProvider', function($compileProvider) {
      return $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|chrome-extension|sip):/);
    }
  ]).filter('cut', function() {
    return function(value, wordwise, max, nothing, tail) {
      var lastspace;
      if (nothing == null) {
        nothing = '';
      }
      if (!value) {
        return nothing;
      }
      max = parseInt(max, 10);
      if (!max) {
        return value;
      }
      if (value.length <= max) {
        return value;
      }
      value = value.substr(0, max);
      if (wordwise) {
        lastspace = value.lastIndexOf(' ');
        if (lastspace !== -1) {
          if (value.charAt(lastspace - 1) === '.' || value.charAt(lastspace - 1) === ',') {
            lastspace = lastspace - 1;
          }
          value = value.substr(0, lastspace);
        }
      }
      return value + (tail || '…');
    };
  }).filter('hideZero', function() {
    return function(item) {
      if (item > 0) {
        return item;
      } else {
        return null;
      }
    };
  }).directive('convertToNumber', function() {
    return {
      require: 'ngModel',
      link: function(scope, element, attrs, ngModel) {
        ngModel.$parsers.push(function(val) {
          return parseInt(val, 10);
        });
        return ngModel.$formatters.push(function(val) {
          if (val || val === 0) {
            return '' + val;
          } else {
            return '';
          }
        });
      }
    };
  }).run(function($rootScope, $q) {
    $rootScope.dataLoaded = $q.defer();
    $rootScope.frontendStop = function(rebind_masks) {
      if (rebind_masks == null) {
        rebind_masks = true;
      }
      $rootScope.frontend_loading = false;
      $rootScope.dataLoaded.resolve(true);
      if (rebind_masks) {
        return rebindMasks();
      }
    };
    $rootScope.range = function(min, max, step) {
      var i, input;
      step = step || 1;
      input = [];
      i = min;
      while (i <= max) {
        input.push(i);
        i += step;
      }
      return input;
    };
    $rootScope.toggleEnum = function(ngModel, status, ngEnum, skip_values, allowed_user_ids, recursion) {
      var ref, ref1, ref2, status_id, statuses;
      if (skip_values == null) {
        skip_values = [];
      }
      if (allowed_user_ids == null) {
        allowed_user_ids = [];
      }
      if (recursion == null) {
        recursion = false;
      }
      if (!recursion && (ref = parseInt(ngModel[status]), indexOf.call(skip_values, ref) >= 0) && (ref1 = $rootScope.$$childHead.user.id, indexOf.call(allowed_user_ids, ref1) < 0)) {
        return;
      }
      statuses = Object.keys(ngEnum);
      status_id = statuses.indexOf(ngModel[status].toString());
      status_id++;
      if (status_id > (statuses.length - 1)) {
        status_id = 0;
      }
      ngModel[status] = statuses[status_id];
      if (indexOf.call(skip_values, status_id) >= 0 && (ref2 = $rootScope.$$childHead.user.id, indexOf.call(allowed_user_ids, ref2) < 0)) {
        return $rootScope.toggleEnum(ngModel, status, ngEnum, skip_values, allowed_user_ids, true);
      }
    };
    $rootScope.toggleEnumServer = function(ngModel, status, ngEnum, Resource) {
      var status_id, statuses, update_data;
      statuses = Object.keys(ngEnum);
      status_id = statuses.indexOf(ngModel[status].toString());
      status_id++;
      if (status_id > (statuses.length - 1)) {
        status_id = 0;
      }
      update_data = {
        id: ngModel.id
      };
      update_data[status] = status_id;
      return Resource.update(update_data, function() {
        return ngModel[status] = statuses[status_id];
      });
    };
    $rootScope.formatDateTime = function(date) {
      return moment(date).format("DD.MM.YY в HH:mm");
    };
    $rootScope.formatDate = function(date, full_year) {
      if (full_year == null) {
        full_year = false;
      }
      if (!date) {
        return '';
      }
      return moment(date).format("DD.MM.YY" + (full_year ? "YY" : ""));
    };
    $rootScope.dialog = function(id) {
      $("#" + id).modal('show');
    };
    $rootScope.closeDialog = function(id) {
      $("#" + id).modal('hide');
    };
    $rootScope.ajaxStart = function() {
      ajaxStart();
      return $rootScope.saving = true;
    };
    $rootScope.ajaxEnd = function() {
      ajaxEnd();
      return $rootScope.saving = false;
    };
    $rootScope.findById = function(object, id) {
      return _.findWhere(object, {
        id: parseInt(id)
      });
    };
    $rootScope.total = function(array, prop, prop2) {
      var sum;
      if (prop2 == null) {
        prop2 = false;
      }
      sum = 0;
      $.each(array, function(index, value) {
        var v;
        v = value[prop];
        if (prop2) {
          v = v[prop2];
        }
        return sum += v;
      });
      return sum;
    };
    $rootScope.deny = function(ngModel, prop) {
      return ngModel[prop] = +(!ngModel[prop]);
    };
    return $rootScope.formatBytes = function(bytes) {
      if (bytes < 1024) {
        return bytes + ' Bytes';
      } else if (bytes < 1048576) {
        return (bytes / 1024).toFixed(1) + ' KB';
      } else if (bytes < 1073741824) {
        return (bytes / 1048576).toFixed(1) + ' MB';
      } else {
        return (bytes / 1073741824).toFixed(1) + ' GB';
      }
    };
  });

}).call(this);

(function() {
  Vue.config.devtools = true;

  $(document).ready(function() {
    var viewVue;
    $('#searchModalOpen').click(function() {
      var delayFunction;
      $('#searchModal').modal({
        keyboard: true
      });
      delayFunction = function() {
        return $('#searchQueryInput').focus();
      };
      setTimeout(delayFunction, 500);
      $($('body.modal-open .row')[0]).addClass('blur');
      return false;
    });
    $('#searchModal').on('hidden.bs.modal', function() {
      var delayFnc;
      delayFnc = function() {
        return $('.blur').removeClass('blur');
      };
      return setTimeout(delayFnc, 500);
    });
    return viewVue = new Vue({
      el: '#searchModal',
      data: {
        lists: [],
        links: {},
        results: -1,
        active: 0,
        query: '',
        oldquery: '',
        all: 0,
        loading: false
      },
      methods: {
        loadData: _.debounce(function() {
          return this.$http.post('api/search', {
            query: this.query
          }).then((function(_this) {
            return function(success) {
              var i, item, j, k, len, len1, ref, ref1, results;
              _this.loading = false;
              _this.active = 0;
              _this.all = 0;
              _this.lists = [];
              if (success.body.results > 0) {
                _this.results = success.body.results;
                if (success.body.variables.length > 0) {
                  ref = success.body.variables;
                  for (i = j = 0, len = ref.length; j < len; i = ++j) {
                    item = ref[i];
                    console.log(item);
                    item.type = 'variable';
                    _this.all++;
                    _this.links[_this.all] = 'variables/' + item.id + '/edit';
                    item.link = _this.links[_this.all];
                    _this.lists.push(item);
                  }
                }
                if (success.body.pages.length > 0) {
                  ref1 = success.body.pages;
                  results = [];
                  for (i = k = 0, len1 = ref1.length; k < len1; i = ++k) {
                    item = ref1[i];
                    item.type = 'page';
                    _this.all++;
                    _this.links[_this.all] = 'pages/' + item.id + '/edit';
                    item.link = _this.links[_this.all];
                    results.push(_this.lists.push(item));
                  }
                  return results;
                }
              } else {
                _this.active = 0;
                _this.all = 0;
                _this.lists = [];
                return _this.results = 0;
              }
            };
          })(this), (function(_this) {
            return function(error) {
              _this.active = 0;
              _this.all = 0;
              _this.lists = [];
              return _this.results = 0;
            };
          })(this));
        }, 150),
        scroll: function() {
          return $('#searchResult').scrollTop((this.active - 4) * 30);
        },
        getStateClass: function(state) {
          var obj;
          obj = {};
          obj["tutor-state-" + state] = true;
          return obj;
        },
        keyup: function(e) {
          var url;
          if (e.code === 'ArrowUp') {
            e.preventDefault();
            if (this.active > 0) {
              this.active--;
            }
            this.scroll();
          } else if (e.code === 'ArrowDown') {
            e.preventDefault();
            if (this.active < this.results) {
              this.active++;
            }
            if (this.active > 4) {
              this.scroll();
            }
          } else if (e.code === 'Enter' && this.active > 0) {
            url = this.links[this.active];
            window.location = url;
          } else {
            if (this.query !== '') {
              if (this.oldquery !== this.query && this.query.length > 2) {
                this.loadData();
              }
              this.oldquery = this.query;
            } else {
              this.active = 0;
              this.all = 0;
              this.lists = [];
              this.results = -1;
            }
          }
          return null;
        }
      }
    });
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').controller('EquipmentIndex', function($scope, $attrs, $timeout, IndexService, Equipment, FolderService) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      IndexService.init(Equipment, $scope.current_page, $attrs, {
        folder: $scope.folder
      });
      return FolderService.init($scope.template["class"], $scope.folder, IndexService, Equipment);
    });
  }).controller('EquipmentForm', function($scope, $attrs, $timeout, FormService, Equipment, PhotoService, FolderService, Tag) {
    var hexToDec;
    bindArguments($scope, arguments);
    $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
    angular.element(document).ready(function() {
      FolderService.init($scope.template["class"]);
      FormService.init(Equipment, $scope.id, $scope.model);
      if (!FormService.model.id && $.cookie('equipment_folder_id')) {
        FormService.model.folder_id = $.cookie('equipment_folder_id');
      }
      PhotoService.init(FormService, 'Equipment', $scope.id);
      $scope.align_preview = 'right';
      return $('#color-picker').colorpicker({
        hexNumberSignPrefix: false
      });
    });
    $scope.getContrast = function() {
      var c;
      c = hexToDec(FormService.model.color);
      if ((c.r * 0.299 + c.g * 0.587 + c.b * 0.114) > 186) {
        return 'white';
      } else {
        return 'black';
      }
    };
    return hexToDec = function(hex) {
      var result;
      result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
      if (result) {
        return {
          r: parseInt(result[1], 16),
          g: parseInt(result[2], 16),
          b: parseInt(result[3], 16)
        };
      } else {
        return null;
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('FaqIndex', function($scope, $rootScope, $attrs, $timeout, Faq, FaqGroup) {
    var dragEnd, l, moveToGroup, updatePositions;
    l = function(e) {
      return console.log(e);
    };
    angular.element(document).ready(function() {
      return $(document).scroll(function(event) {
        if ($(document).scrollTop() + $(window).height() === $(document).height()) {
          $(document).scrollTop($(document).height() - 50);
          return l('scrolled back');
        }
      });
    });
    $scope.$watchCollection('dnd', function(newVal) {
      return l($scope.dnd);
    });
    bindArguments($scope, arguments);
    updatePositions = function(group_ids) {
      if (!_.isArray(group_ids)) {
        group_ids = [group_ids];
      }
      return angular.forEach(group_ids, function(group_id) {
        var group;
        group = $rootScope.findById($scope.groups, group_id);
        return angular.forEach(group.faq, function(faq, index) {
          return Faq.update({
            id: faq.id,
            position: index
          });
        });
      });
    };
    dragEnd = function() {
      return $scope.dnd = {};
    };
    $scope.sortableFaqConf = {
      animation: 150,
      group: {
        name: 'variable',
        put: 'variable'
      },
      fallbackTolerance: 5,
      onUpdate: function(event) {
        return updatePositions($scope.dnd.group_id);
      },
      onAdd: function(event) {
        var faq_id;
        faq_id = $scope.dnd.faq_id;
        if ($scope.dnd.group_id && $scope.dnd.faq_id && ($scope.dnd.group_id !== $scope.dnd.old_group_id)) {
          if ($scope.dnd.group_id === -1) {
            return FaqGroup.save({
              faq_id: $scope.dnd.faq_id
            }, function(response) {
              $scope.groups.push(response);
              moveToGroup($scope.dnd.faq_id, response.id, $scope.dnd.old_group_id, true);
              return dragEnd();
            });
          } else if ($scope.dnd.group_id) {
            moveToGroup($scope.dnd.faq_id, $scope.dnd.group_id, $scope.dnd.old_group_id);
            return updatePositions([$scope.dnd.group_id, $scope.dnd.old_group_id]);
          }
        }
      },
      onEnd: function(event) {
        if ($scope.dnd.group_id !== -1) {
          return dragEnd();
        }
      }
    };
    $scope.dragOver = function(group) {
      if ($scope.dnd.type !== 'group') {
        return $scope.dnd.group_id = group.id;
      }
    };
    $scope.sortableGroupConf = {
      animation: 150,
      handle: '.group-title',
      dragClass: 'dragging-group',
      onUpdate: function(event) {
        return angular.forEach($scope.groups, function(group, index) {
          group.position = index;
          return FaqGroup.update({
            id: group.id,
            position: index
          });
        });
      },
      onStart: function(event) {
        return $scope.dnd.type = 'group';
      },
      onEnd: function(event) {
        return $scope.dnd = {};
      }
    };
    $scope.dnd = {};
    moveToGroup = function(faq_id, group_id, old_group_id, copy_item) {
      var faq, group_from, group_to;
      if (copy_item == null) {
        copy_item = false;
      }
      Faq.update({
        id: faq_id,
        group_id: group_id
      });
      group_from = _.find($scope.groups, {
        id: old_group_id
      });
      faq = _.clone(findById(group_from.faq, faq_id));
      faq.group_id = group_id;
      group_from.faq = removeById(group_from.faq, faq_id);
      group_to = _.find($scope.groups, {
        id: group_id
      });
      if (copy_item) {
        return group_to.faq.push(faq);
      } else {
        faq = $rootScope.findById(group_to.faq, faq_id);
        return faq.group_id = group_id;
      }
    };
    $scope.removeGroup = function(group) {
      return bootbox.confirm("Вы уверены, что хотите удалить группу «" + group.title + "»", function(response) {
        var new_group_id;
        if (response === true) {
          FaqGroup.remove({
            id: group.id
          });
          new_group_id = (_.max(_.without($scope.groups, group), function(group) {
            return group.position;
          })).id;
          if (group.faq) {
            angular.forEach(group.faq, function(faq) {
              return moveToGroup(faq.id, new_group_id, faq.group_id, true);
            });
            updatePositions(new_group_id);
          }
          return $scope.groups = removeById($scope.groups, group.id);
        }
      });
    };
    return $scope.onEdit = function(id, event) {
      return FaqGroup.update({
        id: id,
        title: $(event.target).text()
      });
    };
  }).controller('FaqForm', function($scope, $attrs, $timeout, FormService, AceService, Faq) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      return FormService.init(Faq, $scope.id, $scope.model);
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('GalleryIndex', function($scope, $attrs, $timeout, $http, IndexService, Gallery, FolderService) {
    var clearChangePrice;
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      IndexService.init(Gallery, $scope.current_page, $attrs, {
        folder: $scope.folder
      });
      return FolderService.init($scope.template["class"], $scope.folder, IndexService, Gallery);
    });
    clearChangePrice = function() {
      $scope.change_price = {
        type: '1',
        unit: '1',
        value: null,
        folder_id: FolderService.current_folder_id
      };
      return $timeout(function() {
        return $('.selectpicker').selectpicker('refresh');
      });
    };
    $scope.changePriceDialog = function() {
      clearChangePrice();
      if (!$scope.rows_affected) {
        $scope.changePrice(true);
      }
      return $('#change-price-modal').modal('show');
    };
    return $scope.changePrice = function(get_rows_affected) {
      if (get_rows_affected == null) {
        get_rows_affected = false;
      }
      ajaxStart();
      $scope.changing_price = true;
      $scope.change_price.get_rows_affected = get_rows_affected;
      return $http.post('api/galleries/change', $scope.change_price).then(function(response) {
        ajaxEnd();
        $scope.changing_price = false;
        if (get_rows_affected) {
          return $scope.rows_affected = response.data;
        } else {
          $('#change-price-modal').modal('hide');
          return notifySuccess($scope.rows_affected + ' обновлено');
        }
      });
    };
  }).controller('GalleryForm', function($scope, $attrs, $timeout, FormService, Gallery, PhotoService, Tag, FolderService) {
    bindArguments($scope, arguments);
    $scope.version = makeId();
    angular.element(document).ready(function() {
      FolderService.init($scope.template["class"]);
      FormService.init(Gallery, $scope.id, $scope.model);
      if (!FormService.model.id && $.cookie('gallery_folder_id')) {
        FormService.model.folder_id = $.cookie('gallery_folder_id');
      }
      return PhotoService.init(FormService, 'Gallery', $scope.id);
    });
    $scope.preview = function() {
      return window.open(("/img/gallery/" + FormService.model.id + ".jpg?v=") + makeId(), '_blank');
    };
    $scope.edit = function() {
      return FormService.edit(function() {
        return $scope.version = makeId();
      });
    };
    $scope.editOrUpload = function(photo_number) {
      if (photo_number > FormService.model.photos.length) {
        return $('#fileupload').click();
      } else {
        return PhotoService.edit(parseInt(photo_number) - 1);
      }
    };
    $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
    $scope.getTotalPrice = function() {
      var total_price;
      total_price = 0;
      [1, 2, 3, 4, 5, 6].forEach(function(i) {
        var price;
        price = parseInt(FormService.model["price_" + i]);
        if (price) {
          return total_price += price;
        }
      });
      return total_price;
    };
    return $scope.$watch('FormService.model.count', function(newVal, oldVal) {
      $scope.size = {
        w: 2200,
        h: 1100
      };
      $scope.size.w = $scope.size.w / newVal;
      $scope.ratio = $scope.size.w / $scope.size.h;
      return $('#fileupload').bind('fileuploadsubmit', (function(_this) {
        return function(e, data) {
          return data.formData = {
            id: FormService.model.id,
            type: 'Gallery',
            count: FormService.model.count
          };
        };
      })(this));
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('HeaderIndex', function($rootScope, $scope, $timeout, $http, LogTypes) {
    bindArguments($scope, arguments);
    return $scope.save = function() {
      ajaxStart();
      return $http.post('/api/header', {
        header: $scope.header
      }).then(function() {
        return ajaxEnd();
      });
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('LoginCtrl', function($scope, $http) {
    var loadImage;
    loadImage = function() {
      var img;
      $scope.image_loaded = false;
      img = new Image;
      img.addEventListener("load", function() {
        $('body').css({
          'background-image': "url(" + $scope.wallpaper.image_url + ")"
        });
        $scope.image_loaded = true;
        $scope.$apply();
        return setTimeout(function() {
          return $('#center').removeClass('animated').removeClass('fadeIn').removeAttr('style');
        }, 2000);
      });
      return img.src = $scope.wallpaper.image_url;
    };
    angular.element(document).ready(function() {
      var login_data;
      loadImage();
      $('input[autocomplete="off"]').each(function() {
        var id, input;
        input = this;
        id = $(input).attr('id');
        $(input).removeAttr('id');
        return setTimeout(function() {
          return $(input).attr('id', id);
        }, 2000);
      });
      $scope.l = Ladda.create(document.querySelector('#login-submit'));
      login_data = $.cookie("login_data");
      if (login_data !== void 0) {
        login_data = JSON.parse(login_data);
        $scope.login = login_data.login;
        $scope.password = login_data.password;
        $scope.sms_verification = true;
        return $scope.$apply();
      }
    });
    $scope.enter = function($event) {
      if ($event.keyCode === 13) {
        return $scope.checkFields();
      }
    };
    $scope.goLogin = function() {
      return $http.post('login', {
        login: $scope.login,
        password: $scope.password,
        code: $scope.code
      }).then(function(response) {
        if (response.data === true) {
          $.removeCookie('login_data');
          location.reload();
        } else if (response.data === 'sms') {
          $scope.in_process = false;
          $scope.l.stop();
          $scope.sms_verification = true;
          $.cookie("login_data", JSON.stringify({
            login: $scope.login,
            password: $scope.password
          }), {
            expires: 1 / (24 * 60) * 2,
            path: '/'
          });
        } else {
          $scope.in_process = false;
          $scope.l.stop();
          $scope.error = "Неправильная пара логин-пароль";
        }
        return $scope.$apply();
      });
    };
    return $scope.checkFields = function() {
      $scope.l.start();
      $scope.in_process = true;
      return $scope.goLogin();
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('LogsIndex', function($rootScope, $scope, $timeout, $http, LogTypes) {
    var load;
    bindArguments($scope, arguments);
    $rootScope.frontend_loading = true;
    $scope.$watch('search.table', function(newVal, oldVal) {
      if ((newVal && oldVal) || (oldVal && !newVal)) {
        return $scope.search.column = null;
      }
    });
    $scope.toJson = function(data) {
      return JSON.parse(data);
    };
    $scope.refreshCounts = function() {
      return $timeout(function() {
        $('.selectpicker option').each(function(index, el) {
          $(el).data('subtext', $(el).attr('data-subtext'));
          return $(el).data('content', $(el).attr('data-content'));
        });
        return $('.selectpicker').selectpicker('refresh');
      }, 100);
    };
    $scope.filter = function() {
      $.cookie("logs", JSON.stringify($scope.search), {
        expires: 365,
        path: '/'
      });
      $scope.current_page = 1;
      return $scope.pageChanged();
    };
    $scope.keyFilter = function(event) {
      if (event.keyCode === 13) {
        return $scope.filter();
      }
    };
    $timeout(function() {
      $scope.search = $.cookie("logs") ? JSON.parse($.cookie("logs")) : {};
      load($scope.page);
      return $scope.current_page = $scope.page;
    });
    $scope.pageChanged = function() {
      $rootScope.frontend_loading = true;
      load($scope.current_page);
      return paginate('logs', $scope.current_page);
    };
    return load = function(page) {
      var params;
      params = '?page=' + page;
      return $http.get("api/logs" + params).then(function(response) {
        console.log(response);
        $scope.counts = response.data.counts;
        $scope.data = response.data.data;
        $scope.logs = response.data.data.data;
        $rootScope.frontend_loading = false;
        return $scope.refreshCounts();
      });
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('MastersIndex', function($scope, $attrs, IndexService, Master) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      return IndexService.init(Master, $scope.current_page, $attrs);
    });
  }).controller('MastersForm', function($scope, $attrs, $timeout, $http, FormService, Master, Photo, Tag, PhotoService) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      FormService.init(Master, $scope.id, $scope.model);
      return PhotoService.init(FormService, 'Master', $scope.id);
    });
    $scope.selectedReviewIds = {};
    $scope.changeMasterId = null;
    $scope.openChangeMasterDialog = function() {
      return $('#change-master-dialog').modal('show');
    };
    $scope.getSelectedReviewIds = function() {
      var ids;
      ids = [];
      Object.entries($scope.selectedReviewIds).forEach(function(entry) {
        if (entry[1] === true) {
          return ids.push(entry[0]);
        }
      });
      return ids;
    };
    $scope.changeReviewMaster = function() {
      return $http.post('/api/reviews/mass-update', {
        ids: $scope.getSelectedReviewIds(),
        payload: {
          master_id: $scope.changeMasterId
        }
      }).then(function(response) {
        notifySuccess($scope.getSelectedReviewIds().length + ' отзывов успешно обновлено');
        $('#change-master-dialog').modal('hide');
        $scope.getSelectedReviewIds().forEach(function(reviewId) {
          var index;
          index = $scope.FormService.model.reviews.findIndex(function(e) {
            return e.id === reviewId;
          });
          return $scope.FormService.model.reviews.splice(index, 1);
        });
        $scope.FormService.model.reviews;
        $scope.selectedReviewIds = {};
        return $scope.$apply();
      });
    };
    return $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
  });

}).call(this);

(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module('Egecms').controller('MobileMenuIndex', function($rootScope, $scope, $timeout, $http, Menu) {
    var loadData;
    bindArguments($scope, arguments);
    $scope.sections = null;
    $scope.dialogItem = {};
    loadData = function() {
      ajaxStart();
      return $http.get('api/menu-sections?type=' + $scope.type).then(function(r) {
        $scope.sections = r.data;
        return ajaxEnd();
      });
    };
    $timeout(function() {
      $scope.collapsedMobileMenu = $.cookie("collapsedMobileMenu") ? JSON.parse($.cookie("collapsedMobileMenu")) : [];
      $scope.collapsedMobileMenuSection = $.cookie("collapsedMobileMenuSection") ? JSON.parse($.cookie("collapsedMobileMenuSection")) : [];
      return loadData();
    });
    $scope.openDialog = function(item, id) {
      if (item == null) {
        item = {};
      }
      if (id == null) {
        id = 'menu-item-dialog';
      }
      $scope.dialogItem = _.clone(item);
      $scope.dialogItem.type = $scope.type;
      return $('#' + id).modal('show');
    };
    $scope.save = function() {
      if ($scope.dialogItem.id) {
        Menu.update($scope.dialogItem, function(r) {
          return loadData();
        });
      } else {
        Menu.save($scope.dialogItem, function(r) {
          return loadData();
        });
      }
      return $('#menu-item-dialog').modal('hide');
    };
    $scope.remove = function(id) {
      return bootbox.confirm('Вы уверены, что хотите удалить пункт меню?', function(result) {
        if (result === true) {
          return Menu.remove({
            id: id
          }, function(r) {
            return loadData();
          });
        }
      });
    };
    $scope.removeSection = function(id) {
      return bootbox.confirm('Вы уверены, что хотите удалить раздел?', function(result) {
        if (result === true) {
          return $http["delete"]('api/menu-sections/' + id).then(function(r) {
            return loadData();
          });
        }
      });
    };
    $scope.saveSection = function() {
      if ($scope.dialogItem.id) {
        $http.put('api/menu-sections/' + $scope.dialogItem.id, $scope.dialogItem).then(function(r) {
          return loadData();
        });
      } else {
        $http.post('api/menu-sections', $scope.dialogItem).then(function(r) {
          return loadData();
        });
      }
      return $('#menu-section-dialog').modal('hide');
    };
    $scope.sortableOptions = {
      update: function(event, ui) {
        return $timeout(function() {
          return $scope.sections.forEach(function(section, index) {
            return section.items.forEach(function(item, index) {
              return Menu.update({
                id: item.id,
                position: index
              });
            });
          });
        });
      },
      items: '.menu-item',
      axis: 'y',
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999
    };
    $scope.sortableOptionsSections = {
      update: function(event, ui) {
        return $timeout(function() {
          return $scope.sections.forEach(function(section, index) {
            return $http.put('api/menu-sections/' + section.id, {
              position: index
            });
          });
        });
      },
      items: '.menu-section',
      axis: 'y',
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999
    };
    $scope.toggleCollapse = function(item) {
      var id;
      id = item.id;
      if (indexOf.call($scope.collapsedMobileMenu, id) >= 0) {
        $scope.collapsedMobileMenu = _.without($scope.collapsedMobileMenu, id);
      } else {
        $scope.collapsedMobileMenu.push(id);
      }
      return $.cookie("collapsedMobileMenu", JSON.stringify($scope.collapsedMobileMenu), {
        expires: 365,
        path: '/'
      });
    };
    $scope.isCollapsed = function(item) {
      var ref;
      return ref = item.id, indexOf.call($scope.collapsedMobileMenu, ref) >= 0;
    };
    $scope.toggleCollapseSection = function(item) {
      var id;
      id = item.id;
      if (indexOf.call($scope.collapsedMobileMenuSection, id) >= 0) {
        $scope.collapsedMobileMenuSection = _.without($scope.collapsedMobileMenuSection, id);
      } else {
        $scope.collapsedMobileMenuSection.push(id);
      }
      return $.cookie("collapsedMobileMenuSection", JSON.stringify($scope.collapsedMobileMenuSection), {
        expires: 365,
        path: '/'
      });
    };
    return $scope.isCollapsedSection = function(item) {
      var ref;
      return ref = item.id, indexOf.call($scope.collapsedMobileMenuSection, ref) >= 0;
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('PagesIndex', function($scope, $attrs, $timeout, IndexService, Page, Published, FolderService) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      IndexService.init(Page, $scope.current_page, $attrs, {
        folder: $scope.folder
      });
      return FolderService.init($scope.template["class"], $scope.folder, IndexService, Page);
    });
  }).controller('PagesForm', function($scope, $http, $attrs, $timeout, FormService, AceService, Page, Published, UpDown, PageItem, Tag, FolderService) {
    var bindFileUpload, empty_useful;
    bindArguments($scope, arguments);
    empty_useful = {
      text: null,
      page_id_field: null
    };
    $scope.copy = function() {
      ajaxStart();
      return $http.post('api/pages/copy', {
        id: $scope.id
      }).then(function(response) {
        console.log(response);
        return redirect("pages/" + response.data + "/edit");
      });
    };
    angular.element(document).ready(function() {
      FolderService.init($scope.template["class"]);
      FormService.init(Page, $scope.id, $scope.model);
      if (!FormService.model.id && $.cookie('page_folder_id')) {
        FormService.model.folder_id = $.cookie('page_folder_id');
      }
      FormService.dataLoaded.promise.then(function() {
        if (!FormService.model.useful || !FormService.model.useful.length) {
          FormService.model.useful = [angular.copy(empty_useful)];
        }
        return ['html', 'html_mobile', 'seo_text'].forEach(function(field) {
          return AceService.initEditor(FormService, 15, "editor--" + field);
        });
      });
      FormService.beforeSave = function() {
        ['html', 'html_mobile', 'seo_text'].forEach(function(field) {
          return FormService.model[field] = AceService.getEditor("editor--" + field).getValue();
        });
        if (FormService.model.items) {
          return FormService.model.items.forEach(function(item, index) {
            if (!item.href_page_id) {
              item.href_page_id = null;
            }
            item.position = index;
            return PageItem.update({
              id: item.id
            }, item, function() {
              return console.log('updated');
            }, function() {
              ajaxEnd();
              return notifyError('Несуществующий номер раздела');
            });
          });
        }
      };
      return bindFileUpload();
    });
    $scope.generateUrl = function(event) {
      return $http.post('/api/translit/to-url', {
        text: FormService.model.keyphrase
      }).then(function(response) {
        FormService.model.url = response.data;
        return $scope.checkExistance('url', {
          target: $(event.target).closest('div').find('input')
        });
      });
    };
    $scope.checkExistance = function(field, event) {
      return Page.checkExistance({
        id: FormService.model.id,
        field: field,
        value: FormService.model[field]
      }, function(response) {
        var element;
        element = $(event.target);
        if (response.exists) {
          FormService.error_element = element;
          return element.addClass('has-error').focus();
        } else {
          FormService.error_element = void 0;
          return element.removeClass('has-error');
        }
      });
    };
    $scope.checkUsefulExistance = function(field, event, value) {
      return Page.checkExistance({
        id: FormService.model.id,
        field: field,
        value: value
      }, function(response) {
        var element;
        element = $(event.target);
        if (!value || response.exists) {
          FormService.error_element = void 0;
          return element.removeClass('has-error');
        } else {
          FormService.error_element = element;
          return element.addClass('has-error').focus();
        }
      });
    };
    $scope.addUseful = function() {
      return FormService.model.useful.push(angular.copy(empty_useful));
    };
    $scope.addLinkDialog = function() {
      $scope.link_text = AceService.editor.getSelectedText();
      return $('#link-manager').modal('show');
    };
    $scope.search = function(input, promise) {
      return $http.post('api/pages/search', {
        q: input
      }, {
        timeout: promise
      }).then(function(response) {
        return response;
      });
    };
    $scope.searchSelected = function(selectedObject) {
      $scope.link_page_id = selectedObject.originalObject.id;
      return $scope.$broadcast('angucomplete-alt:changeInput', 'page-search', $scope.link_page_id.toString());
    };
    $scope.addLink = function() {
      var link;
      link = "<a href='[link|" + $scope.link_page_id + "]'>" + $scope.link_text + "</a>";
      $scope.link_page_id = void 0;
      $scope.$broadcast('angucomplete-alt:clearInput');
      AceService.editor.session.replace(AceService.editor.selection.getRange(), link);
      return $('#link-manager').modal('hide');
    };
    $scope.$watch('FormService.model.station_id', function(newVal, oldVal) {
      return $timeout(function() {
        return $('#sort').selectpicker('refresh');
      });
    });
    $scope.sortableOptions = {
      handle: ".photo-dashed",
      items: ".page-item-draggable",
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      containment: "parent",
      tolerance: "pointer"
    };
    $scope.addService = function() {
      return PageItem.save({
        page_id: FormService.model.id
      }, function(response) {
        return FormService.model.items.push(response);
      });
    };
    $scope.removeService = function(item) {
      PageItem["delete"]({
        id: item.id
      });
      return FormService.model.items = _.filter(FormService.model.items, function(i) {
        return i.id !== item.id;
      });
    };
    $scope.uploadSvg = function(item) {
      console.log(item);
      $scope.selected_item = item;
      return $timeout(function() {
        return $('#fileupload').click();
      });
    };
    $scope.togglePublished = function() {
      FormService.model.published = !FormService.model.published;
      return FormService.model.published = FormService.model.published ? 1 : 0;
    };
    $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
    return bindFileUpload = function() {
      return $('#fileupload').fileupload({
        maxFileSize: 10000000,
        send: function() {
          return NProgress.configure({
            showSpinner: true
          });
        },
        progress: function(e, data) {
          return NProgress.set(data.loaded / data.total);
        },
        always: function() {
          NProgress.configure({
            showSpinner: false
          });
          return ajaxEnd();
        },
        done: (function(_this) {
          return function(i, response) {
            $scope.selected_item.file = response.result;
            $scope.$apply();
            return console.log(response.result);
          };
        })(this)
      });
    };
  });

}).call(this);

(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module('Egecms').controller('PaymentsIndex', function($scope, $attrs, $timeout, $http, IndexService, Payment, UserService, Checked) {
    var getTotal;
    bindArguments($scope, arguments);
    $(window).on('keydown', function(e) {
      if (e.which === 8) {
        return $scope.removeSelectedPayments();
      }
    });
    $('#import-button').fileupload({
      start: function() {
        return ajaxStart();
      },
      always: function() {
        return ajaxEnd();
      },
      done: function(i, response) {
        notifySuccess("<b>" + response.result + "</b> импортировано");
        return $scope.filter();
      },
      error: function(response) {
        console.log(response);
        return notifyError(response.responseJSON);
      }
    });
    angular.element(document).ready(function() {
      $timeout(function() {
        return $('.selectpicker').selectpicker('refresh');
      }, 1000);
      $scope.search = $.cookie("payments") ? JSON.parse($.cookie("payments")) : {
        addressee_id: '',
        source_id: '',
        expenditure_id: '',
        type: ''
      };
      $scope.selected_payments = [];
      $scope.tab = 'payments';
      return IndexService.init(Payment, $scope.current_page, $attrs);
    });
    $scope.filter = function() {
      $.cookie("payments", JSON.stringify($scope.search), {
        expires: 365,
        path: '/'
      });
      IndexService.current_page = 1;
      return IndexService.pageChanged();
    };
    $scope.keyFilter = function(event) {
      if (event.keyCode === 13) {
        return $scope.filter();
      }
    };
    $scope.selectPayment = function(payment) {
      var ref;
      if (ref = payment.id, indexOf.call($scope.selected_payments, ref) >= 0) {
        return $scope.selected_payments = _.without($scope.selected_payments, payment.id);
      } else {
        return $scope.selected_payments.push(payment.id);
      }
    };
    $scope.removeSelectedPayments = function() {
      if ($scope.selected_payments.length) {
        return bootbox.confirm("Вы уверены, что хотите удалить <b>" + $scope.selected_payments.length + "</b> платежей?", function(response) {
          if (response === true) {
            ajaxStart();
            return $.post('api/payments/delete', {
              ids: $scope.selected_payments
            }).then(function(response) {
              $scope.selected_payments = [];
              $scope.filter();
              return ajaxEnd();
            });
          }
        });
      }
    };
    $scope.getExpenditure = function(id) {
      var expenditure;
      id = parseInt(id);
      expenditure = null;
      $scope.expenditures.forEach(function(e) {
        if (expenditure) {
          return;
        }
        return e.data.forEach(function(d) {
          if (d.id === id) {
            expenditure = d;
          }
        });
      });
      return expenditure;
    };
    $scope.addPaymentDialog = function(payment) {
      if (payment == null) {
        payment = false;
      }
      $scope.modal_payment = _.clone(payment || $scope.fresh_payment);
      return $('#payment-stream-modal').modal('show');
    };
    $scope.savePayment = function() {
      var func;
      $scope.adding_payment = true;
      if (!$scope.modal_payment.date) {
        $('#payment-date').focus();
        notifyError("укажите дату");
        return;
      }
      if (!$scope.modal_payment.source_id) {
        notifyError("укажите источник");
        return;
      }
      if (!$scope.modal_payment.addressee_id) {
        notifyError("укажите адресат");
        return;
      }
      if (!$scope.modal_payment.expenditure_id) {
        notifyError("укажите статью");
        return;
      }
      if (!$scope.modal_payment.purpose) {
        $('#payment-purpose').focus();
        notifyError("укажите назначение");
        return;
      }
      func = $scope.modal_payment.id ? Payment.update : Payment.save;
      return func($scope.modal_payment, function(response) {
        $scope.adding_payment = false;
        $('#payment-stream-modal').modal('hide');
        return $scope.filter();
      });
    };
    $scope.clonePayment = function(payment) {
      var new_payment;
      new_payment = _.clone(payment);
      delete new_payment.id;
      delete new_payment.created_at;
      delete new_payment.updated_at;
      delete new_payment.user_id;
      return $scope.addPaymentDialog(new_payment);
    };
    $scope.deletePayment = function() {
      return Payment["delete"]({
        id: $scope.modal_payment.id
      }, function(response) {
        $('#payment-stream-modal').modal('hide');
        return $scope.filter();
      });
    };
    $scope.editPayment = function(model) {
      $scope.modal_payment = _.clone(model);
      return $('#payment-stream-modal').modal('show');
    };
    $scope.formatStatDate = function(date) {
      return moment(date + '-01').format('MMMM');
    };
    $scope.loadStats = function() {
      if ($scope.tab !== 'stats') {
        return;
      }
      $scope.stats_loading = true;
      ajaxStart();
      return $http.post('api/payments/stats', $scope.search_stats).then(function(response) {
        ajaxEnd();
        $scope.stats_loading = false;
        if (response.data) {
          $scope.stats_data = response.data.data;
          $scope.expenditure_data = response.data.expenditures;
          return $timeout(function() {
            return $scope.totals = getTotal();
          });
        } else {
          return $scope.stats_data = null;
        }
      });
    };
    return getTotal = function() {
      var total;
      total = {
        "in": 0,
        out: 0,
        sum: 0
      };
      $.each($scope.stats_data, function(year, data) {
        return data.forEach(function(d) {
          total["in"] += parseFloat(d["in"]);
          total.out += parseFloat(d.out);
          return total.sum += parseFloat(d.sum);
        });
      });
      return total;
    };
  }).controller('PaymentForm', function($scope, FormService, Payment) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      FormService.init(Payment, $scope.id, $scope.model);
      return FormService.prefix = '';
    });
  }).controller('PaymentSourceIndex', function($scope, $attrs, $timeout, IndexService, PaymentSource) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      return IndexService.init(PaymentSource, $scope.current_page, $attrs);
    });
    return $scope.sortableOptions = {
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      tolerance: "pointer",
      axis: 'y',
      containment: "parent",
      update: function(event, ui) {
        return $timeout(function() {
          return IndexService.page.data.forEach(function(model, index) {
            return PaymentSource.update({
              id: model.id,
              position: index
            });
          });
        });
      }
    };
  }).controller('PaymentSourceForm', function($scope, FormService, PaymentSource) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      FormService.init(PaymentSource, $scope.id, $scope.model);
      return FormService.prefix = 'payments/';
    });
  }).controller('PaymentExpenditureIndex', function($scope, $attrs, $timeout, IndexService, PaymentExpenditure, PaymentExpenditureGroup) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      return $scope.groups = PaymentExpenditureGroup.query();
    });
    $scope.onEdit = function(id, event) {
      return PaymentExpenditureGroup.update({
        id: id,
        name: $(event.target).text()
      });
    };
    $scope.removeGroup = function(group) {
      return bootbox.confirm("Вы уверены, что хотите удалить группу «" + group.name + "»", function(response) {
        if (response === true) {
          return PaymentExpenditureGroup.remove({
            id: group.id
          }, function() {
            return $scope.groups = PaymentExpenditureGroup.query();
          });
        }
      });
    };
    $scope.sortableOptions = {
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      tolerance: "pointer",
      axis: 'y',
      containment: "parent",
      update: function(event, ui, data) {
        return $timeout(function() {
          return $scope.groups.forEach(function(group) {
            return group.data.forEach(function(model, index) {
              return PaymentExpenditure.update({
                id: model.id,
                position: index
              });
            });
          });
        });
      }
    };
    return $scope.sortableGroupOptions = {
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      tolerance: "pointer",
      axis: 'y',
      containment: "parent",
      items: ".item-draggable",
      update: function(event, ui, data) {
        return $timeout(function() {
          return $scope.groups.forEach(function(group, index) {
            return PaymentExpenditureGroup.update({
              id: group.id,
              position: index
            });
          });
        });
      }
    };
  }).controller('PaymentExpenditureForm', function($scope, $timeout, FormService, PaymentExpenditure, PaymentExpenditureGroup) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      FormService.init(PaymentExpenditure, $scope.id, $scope.model);
      return FormService.prefix = 'payments/';
    });
    $scope.changeGroup = function() {
      if (FormService.model.group_id === -1) {
        FormService.model.group_id = '';
        return $('#new-group').modal('show');
      }
    };
    return $scope.createNewGroup = function() {
      $('#new-group').modal('hide');
      return PaymentExpenditureGroup.save({
        name: $scope.new_group_name
      }, function(response) {
        $scope.new_group_name = '';
        $scope.groups.push(response);
        FormService.model.group_id = response.id;
        return $timeout(function() {
          return $('.selectpicker').selectpicker('refresh');
        });
      });
    };
  }).controller('PaymentAccount', function($scope, $http, $timeout) {
    var load;
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      return $timeout(function() {
        $scope.source_id = 4;
        $scope.current_page = 1;
        return load(1);
      });
    });
    $scope.pageChanged = function() {
      load($scope.current_page);
      return paginate('account', $scope.current_page);
    };
    return load = function(page) {
      ajaxStart();
      return $http.post('api/account', {
        page: page,
        source_id: $scope.source_id
      }).then(function(response) {
        ajaxEnd();
        return $scope.data = response.data;
      });
    };
  }).controller('PaymentRemainders', function($scope, $http, $timeout) {
    var load;
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {});
    $scope.filterChanged = function() {
      $scope.current_page = 1;
      return load(1);
    };
    $scope.pageChanged = function() {
      load($scope.current_page);
      return paginate('payments/remainders', $scope.current_page);
    };
    return load = function(page) {
      ajaxStart();
      return $http.post('api/payments/remainders', {
        page: page,
        source_id: $scope.source_id
      }).then(function(response) {
        ajaxEnd();
        return $scope.data = response.data;
      });
    };
  });

}).call(this);

(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module('Egecms').controller('PricesIndex', function($scope, $attrs, $timeout, $http, PriceSection, PricePosition) {
    var clearChangePrice, getRowsAffected;
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      $http.get('api/prices').then(function(response) {
        return $scope.items = response.data;
      });
      $scope.collapsed_price_sections = $.cookie("collapsed_price_sections") ? JSON.parse($.cookie("collapsed_price_sections")) : [];
      return $timeout(function() {
        return new Clipboard('.copiable');
      }, 1000);
    });
    clearChangePrice = function(section_id) {
      $scope.change_price = {
        type: '1',
        unit: '1',
        section_id: section_id,
        value: null
      };
      return $timeout(function() {
        return $('.selectpicker').selectpicker('refresh');
      });
    };
    getRowsAffected = function(item) {
      var result;
      if (!item.is_section) {
        return 1;
      }
      result = 0;
      item.items.forEach(function(item) {
        return result += getRowsAffected(item);
      });
      return result;
    };
    $scope.changePriceDialog = function(item) {
      clearChangePrice(item.model.id);
      $scope.rows_affected = getRowsAffected(item);
      return $('#change-price-modal').modal('show');
    };
    $scope.changePriceRootDialog = function() {
      var item;
      item = {
        is_section: true,
        items: $scope.items,
        model: {
          id: -1
        }
      };
      return $scope.changePriceDialog(item);
    };
    $scope.changePrice = function() {
      ajaxStart();
      $scope.changing_price = true;
      return $http.post('api/prices/change', $scope.change_price).then(function() {
        return location.reload();
      });
    };
    $scope.toggleCollapse = function(item) {
      var id;
      id = item.model.id;
      if (indexOf.call($scope.collapsed_price_sections, id) >= 0) {
        $scope.collapsed_price_sections = _.without($scope.collapsed_price_sections, id);
      } else {
        $scope.collapsed_price_sections.push(id);
      }
      return $.cookie("collapsed_price_sections", JSON.stringify($scope.collapsed_price_sections), {
        expires: 365,
        path: '/'
      });
    };
    $scope.isCollapsed = function(item) {
      var ref;
      return ref = item.model.id, indexOf.call($scope.collapsed_price_sections, ref) >= 0;
    };
    return $scope.sortableOptions = {
      update: function(event, ui) {
        return $timeout(function() {
          return $scope.items.forEach(function(item, index) {
            var Resource;
            Resource = item.is_section ? PriceSection : PricePosition;
            return Resource.update({
              id: item.model.id,
              position: index
            });
          });
        });
      },
      items: '.price-item-' + $scope.$id,
      axis: 'y',
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999
    };
  }).controller('PricesForm', function($scope, $attrs, $timeout, $http, FormService, PriceSection) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      FormService.init(PriceSection, $scope.id, $scope.model);
      return FormService.redirect_url = 'prices';
    });
  }).controller('PricePositionForm', function($scope, $attrs, $timeout, $http, FormService, PricePosition, Units, Tag) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      FormService.init(PricePosition, $scope.id, $scope.model);
      return FormService.redirect_url = 'prices';
    });
    return $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('ReviewsIndex', function($scope, $attrs, IndexService, Review, FolderService) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      IndexService.init(Review, $scope.current_page, $attrs, {
        folder: $scope.folder
      });
      return FolderService.init($scope.template["class"], $scope.folder, IndexService, Review);
    });
  }).controller('ReviewsForm', function($scope, $attrs, $timeout, FormService, Review, Published, Scores, Tag, FolderService) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      FolderService.init($scope.template["class"]);
      FormService.init(Review, $scope.id, $scope.model);
      if (!FormService.model.id && $.cookie('review_folder_id')) {
        return FormService.model.folder_id = $.cookie('review_folder_id');
      }
    });
    return $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('SearchIndex', function($scope, $attrs, $timeout, IndexService, Page, Published, ExportService) {
    bindArguments($scope, arguments);
    ExportService.init({
      controller: 'pages'
    });
    return angular.element(document).ready(function() {
      return IndexService.init(Page, $scope.current_page, $attrs, false);
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('TagsIndex', function($scope, $attrs, $timeout, IndexService, Tag) {
    bindArguments($scope, arguments);
    $scope.sortableOptions = {
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      tolerance: "pointer",
      axis: 'y',
      update: function(event, ui) {
        return $timeout(function() {
          return IndexService.page.data.forEach(function(model, index) {
            return Tag.update({
              id: model.id,
              position: index
            });
          });
        });
      }
    };
    return angular.element(document).ready(function() {
      return IndexService.init(Tag, $scope.current_page, $attrs);
    });
  }).controller('TagsForm', function($scope, $attrs, $timeout, FormService, Tag) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      FormService.init(Tag, $scope.id, $scope.model);
      return FormService.error_text = "тег уже существует";
    });
    return $scope.checkExistance = function(field, event) {
      return Tag.checkExistance({
        id: FormService.model.id,
        text: FormService.model.text
      }, function(response) {
        var element;
        element = $(event.target);
        if (response.exists) {
          FormService.error_element = element;
          return element.addClass('has-error').focus();
        } else {
          FormService.error_element = void 0;
          return element.removeClass('has-error');
        }
      });
    };
  }).controller('TagsMassEdit', function($scope, $timeout, Tag, Review, Gallery, PricePosition) {
    var Resource;
    bindArguments($scope, arguments);
    Resource = null;
    $timeout(function() {
      switch ($scope["class"]) {
        case 'App\\Models\\Gallery':
          return Resource = Gallery;
        case 'App\\Models\\Review':
          return Resource = Review;
        case 'App\\Models\\PricePosition':
          return Resource = PricePosition;
      }
    });
    $scope.isChecked = function(item) {
      var tag;
      tag = item.tags.find(function(t) {
        return t.id === $scope.tag.id;
      });
      return tag !== void 0;
    };
    return $scope.check = function(item) {
      if ($scope.isChecked(item)) {
        item.tags = item.tags.filter(function(t) {
          return t.id !== $scope.tag.id;
        });
      } else {
        item.tags.push($scope.tag);
      }
      return Resource.update({
        id: item.id
      }, {
        tags: item.tags
      });
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('UsersIndex', function($scope, $attrs, IndexService, User) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      return IndexService.init(User, $scope.current_page, $attrs);
    });
  }).controller('UsersForm', function($scope, $attrs, $timeout, FormService, User, PhotoService) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      FormService.init(User, $scope.id, $scope.model);
      return PhotoService.init(FormService, 'Master', $scope.id);
    });
    $scope.toggleRights = function(right) {
      right = parseInt(right);
      if ($scope.allowed(right)) {
        return FormService.model.rights = _.reject(FormService.model.rights, function(val) {
          return val === right;
        });
      } else {
        return FormService.model.rights.push(right);
      }
    };
    return $scope.allowed = function(right) {
      return FormService.model.rights.indexOf(parseInt(right)) !== -1;
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('VariablesIndex', function($scope, $attrs, $rootScope, $timeout, IndexService, Variable, VariableGroup) {
    var dragEnd, l, moveToGroup, updatePositions;
    l = function(e) {
      return console.log(e);
    };
    angular.element(document).ready(function() {
      return $(document).scroll(function(event) {
        if ($(document).scrollTop() + $(window).height() === $(document).height()) {
          $(document).scrollTop($(document).height() - 50);
          return l('scrolled back');
        }
      });
    });
    $scope.$watchCollection('dnd', function(newVal) {
      return l($scope.dnd);
    });
    bindArguments($scope, arguments);
    updatePositions = function(group_ids) {
      if (!_.isArray(group_ids)) {
        group_ids = [group_ids];
      }
      return angular.forEach(group_ids, function(group_id) {
        var group;
        group = $rootScope.findById($scope.groups, group_id);
        return angular.forEach(group.variable, function(variable, index) {
          return Variable.update({
            id: variable.id,
            position: index
          });
        });
      });
    };
    dragEnd = function() {
      return $scope.dnd = {};
    };
    $scope.sortableVariableConf = {
      animation: 150,
      group: {
        name: 'variable',
        put: 'variable'
      },
      fallbackTolerance: 5,
      onUpdate: function(event) {
        return updatePositions($scope.dnd.group_id);
      },
      onAdd: function(event) {
        var variable_id;
        variable_id = $scope.dnd.variable_id;
        if ($scope.dnd.group_id && $scope.dnd.variable_id && ($scope.dnd.group_id !== $scope.dnd.old_group_id)) {
          if ($scope.dnd.group_id === -1) {
            return VariableGroup.save({
              variable_id: $scope.dnd.variable_id
            }, function(response) {
              $scope.groups.push(response);
              moveToGroup($scope.dnd.variable_id, response.id, $scope.dnd.old_group_id, true);
              return dragEnd();
            });
          } else if ($scope.dnd.group_id) {
            moveToGroup($scope.dnd.variable_id, $scope.dnd.group_id, $scope.dnd.old_group_id);
            return updatePositions([$scope.dnd.group_id, $scope.dnd.old_group_id]);
          }
        }
      },
      onEnd: function(event) {
        if ($scope.dnd.group_id !== -1) {
          return dragEnd();
        }
      }
    };
    $scope.dragOver = function(group) {
      if ($scope.dnd.type !== 'group') {
        return $scope.dnd.group_id = group.id;
      }
    };
    $scope.sortableGroupConf = {
      animation: 150,
      handle: '.group-title',
      dragClass: 'dragging-group',
      onUpdate: function(event) {
        return angular.forEach($scope.groups, function(group, index) {
          group.position = index;
          return VariableGroup.update({
            id: group.id,
            position: index
          });
        });
      },
      onStart: function(event) {
        return $scope.dnd.type = 'group';
      },
      onEnd: function(event) {
        return $scope.dnd = {};
      }
    };
    $scope.dnd = {};
    moveToGroup = function(variable_id, group_id, old_group_id, copy_item) {
      var group_from, group_to, variable;
      if (copy_item == null) {
        copy_item = false;
      }
      Variable.update({
        id: variable_id,
        group_id: group_id
      });
      group_from = _.find($scope.groups, {
        id: old_group_id
      });
      variable = _.clone(findById(group_from.variable, variable_id));
      variable.group_id = group_id;
      group_from.variable = removeById(group_from.variable, variable_id);
      group_to = _.find($scope.groups, {
        id: group_id
      });
      if (copy_item) {
        return group_to.variable.push(variable);
      } else {
        variable = $rootScope.findById(group_to.variable, variable_id);
        return variable.group_id = group_id;
      }
    };
    $scope.removeGroup = function(group) {
      return bootbox.confirm("Вы уверены, что хотите удалить группу «" + group.title + "»", function(response) {
        var new_group_id;
        if (response === true) {
          VariableGroup.remove({
            id: group.id
          });
          new_group_id = (_.max(_.without($scope.groups, group), function(group) {
            return group.position;
          })).id;
          if (group.variable) {
            angular.forEach(group.variable, function(variable) {
              return moveToGroup(variable.id, new_group_id, variable.group_id, true);
            });
            updatePositions(new_group_id);
          }
          return $scope.groups = removeById($scope.groups, group.id);
        }
      });
    };
    return $scope.onEdit = function(id, event) {
      return VariableGroup.update({
        id: id,
        title: $(event.target).text()
      });
    };
  }).controller('VariablesForm', function($scope, $attrs, $timeout, FormService, AceService, Variable) {
    bindArguments($scope, arguments);
    return angular.element(document).ready(function() {
      FormService.init(Variable, $scope.id, $scope.model);
      FormService.dataLoaded.promise.then(function() {
        AceService.initEditor(FormService, 30);
        if (FormService.model.html[0] === '{') {
          return AceService.editor.getSession().setMode('ace/mode/json');
        }
      });
      return FormService.beforeSave = function() {
        return FormService.model.html = AceService.editor.getValue();
      };
    });
  });

}).call(this);

(function() {
  angular.module('Egecms').controller('VideosIndex', function($scope, $attrs, $timeout, IndexService, Video) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      return IndexService.init(Video, $scope.current_page, $attrs);
    });
    return $scope.sortableOptions = {
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      tolerance: "pointer",
      axis: 'y',
      update: (function(_this) {
        return function(event, ui) {
          return $timeout(function() {
            return IndexService.page.data.forEach(function(model, index) {
              return Video.update({
                id: model.id,
                position: index
              });
            });
          });
        };
      })(this)
    };
  }).controller('VideosForm', function($scope, $attrs, $timeout, FormService, Video, Tag) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      return FormService.init(Video, $scope.id, $scope.model);
    });
    return $scope.loadTags = function(text) {
      return Tag.autocomplete({
        text: text
      }).$promise;
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').value('Published', [
    {
      id: 0,
      title: 'не опубликовано'
    }, {
      id: 1,
      title: 'опубликовано'
    }
  ]).value('Scores', [
    {
      id: 1,
      title: '1'
    }, {
      id: 2,
      title: '2'
    }, {
      id: 3,
      title: '3'
    }, {
      id: 4,
      title: '4'
    }, {
      id: 5,
      title: '5'
    }, {
      id: 6,
      title: '6'
    }, {
      id: 7,
      title: '7'
    }, {
      id: 8,
      title: '8'
    }, {
      id: 9,
      title: '9'
    }, {
      id: 10,
      title: '10'
    }
  ]).value('Checked', ['не проверено', 'проверено']).value('UpDown', [
    {
      id: 1,
      title: 'вверху'
    }, {
      id: 2,
      title: 'внизу'
    }
  ]).value('Units', [
    {
      id: 1,
      title: 'изделие'
    }, {
      id: 2,
      title: 'штука'
    }, {
      id: 3,
      title: 'сантиметр'
    }, {
      id: 4,
      title: 'пара'
    }, {
      id: 5,
      title: 'метр'
    }, {
      id: 6,
      title: 'дм²'
    }, {
      id: 7,
      title: 'см²'
    }, {
      id: 8,
      title: 'мм²'
    }, {
      id: 9,
      title: 'элемент'
    }
  ]).value('LogTypes', {
    create: 'создание',
    update: 'обновление',
    "delete": 'удаление',
    authorization: 'авторизация',
    url: 'просмотр URL'
  });

}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('ngCounterDynamic', function($timeout) {
    return {
      restrict: 'A',
      require: 'ngModel',
      scope: {
        ngModel: '=',
        min: '@',
        max: '@'
      },
      link: function($scope, $element, $attrs) {
        var counter, getInputLengthOnlyAllowed, input, rx, update;
        $($element).append("<span class='input-counter'></span>");
        counter = $($element).find('.input-counter');
        input = $($element).parent().find('textarea, input');
        $scope.text = input.val();
        rx = /[a-zA-Z1-9\[\]\|]/gi;
        update = function() {
          var maxlength;
          maxlength = parseInt($scope.ngModel ? $scope.max : $scope.min);
          counter.html(getInputLengthOnlyAllowed() + "/<span class='text-primary'>" + maxlength + "</span>");
          return input.attr('maxlength', maxlength + ($scope.text.length - getInputLengthOnlyAllowed()));
        };
        getInputLengthOnlyAllowed = function() {
          var m;
          m = $scope.text.match(rx);
          if (m) {
            return $scope.text.length - m.length;
          } else {
            return $scope.text.length;
          }
        };
        $scope.$watch('ngModel', function(newVal, oldVal) {
          return update();
        });
        $timeout(function() {
          return input.trigger('input');
        });
        input.on('input', function(e) {
          $scope.text = $(e.target).val();
          return update();
        });
        return input.on('paste', function(e) {
          $scope.text = e.originalEvent.clipboardData.getData('text');
          return update();
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('ngCounter', function($timeout) {
    return {
      restrict: 'A',
      link: function($scope, $element, $attrs) {
        var counter, input, maxlength;
        $($element).append("<span class='input-counter'></span>");
        counter = $($element).find('.input-counter');
        input = $($element).parent().find('textarea, input');
        maxlength = input.attr('maxlength');
        input.on('keyup', function() {
          return counter.html($(this).val().length + "/<span class='text-primary'>" + maxlength + "</span>");
        });
        return $timeout(function() {
          return input.keyup();
        }, 500);
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('digitsOnly', function() {
    return {
      restricts: 'A',
      require: 'ngModel',
      link: function($scope, $element, $attr, $ctrl) {
        var filter, ref;
        filter = function(value) {
          var new_value;
          if (!value) {
            return void 0;
          }
          new_value = value.replace(/[^0-9]/g, '');
          if (new_value !== value) {
            $ctrl.$setViewValue(new_value);
            $ctrl.$render();
          }
          return value;
        };
        return (ref = $ctrl.$parsers) != null ? ref.push(filter) : void 0;
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('editable', function() {
    return {
      restrict: 'A',
      link: function($scope, $element, $attrs) {
        return $element.on('click', function(event) {
          return $element.attr('contenteditable', 'true').focus();
        }).on('keydown', function(event) {
          var ref;
          if ((ref = event.keyCode) === 13 || ref === 27) {
            event.preventDefault();
            $element.blur();
          }
          if ($element.data('input-digits-only')) {
            if (!(event.keyCode < 57)) {
              return event.preventDefault();
            }
          }
        }).on('blur', function(event) {
          $scope.onEdit($element.attr('editable'), event);
          return $element.removeAttr('contenteditable');
        });
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('galleryItem', function() {
    return {
      restrict: 'E',
      replace: true,
      templateUrl: 'directives/gallery-item',
      scope: {
        model: '=',
        level: '='
      },
      controller: function($scope) {
        return $scope.controller_scope = scope;
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('jumpOnTab', function() {
    return {
      restrict: 'A',
      link: function($scope, $element, $attr) {
        return $element.on('keydown', function(event) {
          var focused_item, next_node, range;
          if (event.keyCode === 9) {
            event.preventDefault();
            next_node = $(event.target).parents('h2').first().find('.' + $attr.jumpOnTab);
            next_node = next_node.trigger('click').trigger('focus');
            focused_item = next_node[0];
            if (focused_item.childNodes.length) {
              range = document.createRange();
              range.setStart(focused_item.childNodes[0], focused_item.innerText.length);
              range.collapse(true);
              window.getSelection().removeAllRanges();
              return window.getSelection().addRange(range);
            }
          }
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('mobileMenuItem', function() {
    return {
      restrict: 'E',
      replace: true,
      templateUrl: 'directives/mobile-menu-item',
      scope: {
        item: '='
      },
      controller: function($scope, $timeout, $rootScope, Menu) {
        $scope.findById = $rootScope.findById;
        $scope.controller_scope = scope;
        return $scope.sortableOptions = {
          update: function(event, ui) {
            return $timeout(function() {
              return $scope.item.children.forEach(function(item, index) {
                return Menu.update({
                  id: item.id,
                  position: index
                });
              });
            });
          },
          items: '.menu-item-' + $scope.$id,
          axis: 'y',
          cursor: "move",
          opacity: 0.9,
          zIndex: 9999
        };
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('ngMulti', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        object: '=',
        model: '=',
        label: '@',
        noneText: '@'
      },
      templateUrl: 'directives/ngmulti',
      controller: function($scope, $element, $attrs, $timeout) {
        $element.selectpicker({
          noneSelectedText: $scope.noneText
        });
        return $scope.$watchGroup(['model', 'object'], function(newVal) {
          if (newVal) {
            return $element.selectpicker('refresh');
          }
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('ngPhone', function($timeout) {
    return {
      restrict: 'A',
      controller: function($scope, $element, $attrs, $timeout) {
        return $timeout(function() {
          return $element.mask("+7 (999) 999-99-99", {
            autoclear: false
          });
        }, 300);
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('orderBy', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        options: '='
      },
      templateUrl: 'directives/order-by',
      link: function($scope, $element, $attrs) {
        var IndexService, local_storage_key, syncIndexService;
        IndexService = $scope.$parent.IndexService;
        local_storage_key = 'sort-' + IndexService.controller;
        syncIndexService = function(sort) {
          IndexService.sort = sort;
          IndexService.current_page = 1;
          return IndexService.loadPage();
        };
        $scope.setSort = function(sort) {
          $scope.sort = sort;
          localStorage.setItem(local_storage_key, sort);
          return syncIndexService(sort);
        };
        $scope.sort = localStorage.getItem(local_storage_key);
        if ($scope.sort === null) {
          return $scope.setSort(0);
        } else {
          return syncIndexService($scope.sort);
        }
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('plural', function() {
    return {
      restrict: 'E',
      scope: {
        count: '=',
        type: '@',
        noneText: '@'
      },
      templateUrl: 'directives/plural',
      controller: function($scope, $element, $attrs, $timeout) {
        $scope.textOnly = $attrs.hasOwnProperty('textOnly');
        $scope.hideZero = $attrs.hasOwnProperty('hideZero');
        return $scope.when = {
          'file': ['файл', 'файла', 'файлов'],
          'folder': ['папка', 'папки', 'папок'],
          'age': ['год', 'года', 'лет'],
          'student': ['ученик', 'ученика', 'учеников'],
          'minute': ['минуту', 'минуты', 'минут'],
          'hour': ['час', 'часа', 'часов'],
          'day': ['день', 'дня', 'дней'],
          'meeting': ['встреча', 'встречи', 'встреч'],
          'score': ['балл', 'балла', 'баллов'],
          'rubbles': ['рубль', 'рубля', 'рублей'],
          'lesson': ['занятие', 'занятия', 'занятий'],
          'client': ['клиент', 'клиента', 'клиентов'],
          'mark': ['оценки', 'оценок', 'оценок'],
          'request': ['заявка', 'заявки', 'заявок'],
          'hour': ['час', 'часа', 'часов'],
          'photo': ['фотография', 'фотографии', 'фотографий'],
          'position': ['позиция', 'позиции', 'позиций'],
          'will_be_updated': ['обновлена', 'обновлено', 'обновлено']
        };
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('Egecms').directive('priceItemTag', function() {
    return {
      restrict: 'E',
      replace: true,
      templateUrl: 'directives/price-item-tag',
      scope: {
        model: '=',
        level: '='
      },
      controller: function($scope, $rootScope, Units) {
        $scope.Units = Units;
        $scope.controller_scope = scope;
        return $scope.findById = $rootScope.findById;
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('priceItem', function() {
    return {
      restrict: 'E',
      templateUrl: 'directives/price-item',
      scope: {
        item: '='
      },
      controller: function($scope, $timeout, $rootScope, PriceSection, PricePosition, Units) {
        $scope.Units = Units;
        $scope.findById = $rootScope.findById;
        $scope.controller_scope = scope;
        return $scope.sortableOptions = {
          update: function(event, ui) {
            return $timeout(function() {
              return $scope.item.items.forEach(function(item, index) {
                var Resource;
                Resource = item.is_section ? PriceSection : PricePosition;
                return Resource.update({
                  id: item.model.id,
                  position: index
                });
              });
            });
          },
          items: '.price-item-' + $scope.$id,
          axis: 'y',
          cursor: "move",
          opacity: 0.9,
          zIndex: 9999
        };
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('reviewItem', function() {
    return {
      restrict: 'E',
      replace: true,
      templateUrl: 'directives/review-item',
      scope: {
        model: '=',
        level: '='
      },
      controller: function($scope) {
        return $scope.controller_scope = scope;
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('search', function() {
    return {
      restrict: 'E',
      templateUrl: 'directives/search',
      scope: {},
      link: function() {
        return $('.search-icon').on('click', function() {
          return $('#search-app').modal('show');
        });
      },
      controller: function($scope, $timeout, $http, Published, FactoryService) {
        bindArguments($scope, arguments);
        $scope.conditions = [];
        $scope.options = [
          {
            title: 'ключевая фраза',
            value: 'keyphrase',
            type: 'text'
          }, {
            title: 'отображаемый URL',
            value: 'url',
            type: 'text'
          }, {
            title: 'title',
            value: 'title',
            type: 'text'
          }, {
            title: 'публикация',
            value: 'published',
            type: 'published'
          }, {
            title: 'h1 вверху',
            value: 'h1',
            type: 'text'
          }, {
            title: 'meta keywords',
            value: 'keywords',
            type: 'text'
          }, {
            title: 'meta description',
            value: 'desc',
            type: 'text'
          }, {
            title: 'предметы',
            value: 'subjects',
            type: 'subjects'
          }, {
            title: 'выезд',
            value: 'place',
            type: 'place'
          }, {
            title: 'метро',
            value: 'station_id',
            type: 'station_id'
          }, {
            title: 'сортировка',
            value: 'sort',
            type: 'sort'
          }, {
            title: 'скрытый фильтр',
            value: 'hidden_filter',
            type: 'text'
          }, {
            title: 'содержание раздела',
            value: 'html',
            type: 'textarea'
          }
        ];
        $scope.getOption = function(condition) {
          return $scope.options[condition.option];
        };
        $scope.addCondition = function() {
          $scope.conditions.push({
            option: 0
          });
          return $timeout(function() {
            return $('.selectpicker').selectpicker();
          });
        };
        $scope.addCondition();
        $scope.selectControl = function(condition) {
          condition.value = null;
          switch ($scope.getOption(condition).type) {
            case 'published':
              return condition.value = 0;
            case 'subjects':
              if ($scope.subjects === void 0) {
                return FactoryService.get('subjects', 'name').then(function(response) {
                  return $scope.subjects = response.data;
                });
              }
              break;
            case 'place':
              if ($scope.places === void 0) {
                return FactoryService.get('places', 'serp').then(function(response) {
                  return $scope.places = response.data;
                });
              }
              break;
            case 'station_id':
              if ($scope.stations === void 0) {
                return FactoryService.get('stations', 'title', 'title').then(function(response) {
                  return $scope.stations = response.data;
                });
              }
              break;
            case 'sort':
              if ($scope.sort === void 0) {
                return FactoryService.get('sort').then(function(response) {
                  return $scope.sort = response.data;
                });
              }
          }
        };
        return $scope.search = function() {
          var search;
          search = {};
          $scope.conditions.forEach(function(condition) {
            return search[$scope.getOption(condition).value] = condition.value;
          });
          if (search.hasOwnProperty('html')) {
            search.html = search.html.substr(0, 200);
          }
          $.cookie('search', JSON.stringify(search), {
            expires: 365,
            path: '/'
          });
          ajaxStart();
          $scope.searching = true;
          return window.location = 'search';
        };
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('ngSelectNew', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        object: '=',
        model: '=',
        noneText: '@',
        label: '@',
        field: '@'
      },
      templateUrl: 'directives/select-new',
      controller: function($scope, $element, $attrs, $timeout) {
        var value;
        if (!$scope.noneText) {
          value = _.first(Object.keys($scope.object));
          if ($scope.field) {
            value = $scope.object[value][$scope.field];
          }
          if (!$scope.model) {
            $scope.model = value;
          }
        }
        $timeout(function() {
          return $element.selectpicker({
            noneSelectedText: $scope.noneText
          });
        }, 100);
        return $scope.$watchGroup(['model', 'object'], function(newVal) {
          if (newVal) {
            return $timeout(function() {
              return $element.selectpicker('refresh');
            });
          }
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('Egecms').directive('ngSelect', function() {
    return {
      restrict: 'E',
      replace: true,
      scope: {
        object: '=',
        model: '=',
        noneText: '@',
        label: '@',
        field: '@'
      },
      templateUrl: 'directives/ngselect',
      controller: function($scope, $element, $attrs, $timeout) {
        if (!$scope.noneText) {
          if ($scope.field) {
            $scope.model = $scope.object[_.first(Object.keys($scope.object))][$scope.field];
          } else {
            $scope.model = _.first(Object.keys($scope.object));
          }
        }
        return $timeout(function() {
          return $($element).selectpicker();
        }, 150);
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {


}).call(this);

(function() {
  var apiPath, countable, updatable;

  angular.module('Egecms').factory('Variable', function($resource) {
    return $resource(apiPath('variables'), {
      id: '@id'
    }, updatable());
  }).factory('VariableGroup', function($resource) {
    return $resource(apiPath('variables/groups'), {
      id: '@id'
    }, updatable());
  }).factory('Page', function($resource) {
    return $resource(apiPath('pages'), {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      },
      checkExistance: {
        method: 'POST',
        url: apiPath('pages', 'checkExistance')
      }
    });
  }).factory('Equipment', function($resource) {
    return $resource(apiPath('equipment'), {
      id: '@id'
    }, updatable());
  }).factory('PriceSection', function($resource) {
    return $resource(apiPath('prices'), {
      id: '@id'
    }, updatable());
  }).factory('PricePosition', function($resource) {
    return $resource(apiPath('prices/positions'), {
      id: '@id'
    }, updatable());
  }).factory('Gallery', function($resource) {
    return $resource(apiPath('galleries'), {
      id: '@id'
    }, updatable());
  }).factory('Photo', function($resource) {
    return $resource(apiPath('photos'), {
      id: '@id'
    }, updatable());
  }).factory('Folder', function($resource) {
    return $resource(apiPath('folders'), {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      },
      tree: {
        method: 'POST',
        url: apiPath('folders', 'tree'),
        isArray: true
      },
      breadcrumbs: {
        method: 'GET',
        url: apiPath('folders', 'breadcrumbs'),
        isArray: true
      }
    });
  }).factory('PageItem', function($resource) {
    return $resource(apiPath('pageitems'), {
      id: '@id'
    }, updatable());
  }).factory('User', function($resource) {
    return $resource(apiPath('users'), {
      id: '@id'
    }, updatable());
  }).factory('AllUser', function($resource) {
    return $resource(apiPath('allusers'), {
      id: '@id'
    }, updatable());
  }).factory('Payment', function($resource) {
    return $resource(apiPath('payments'), {
      id: '@id'
    }, updatable());
  }).factory('PaymentSource', function($resource) {
    return $resource(apiPath('payments/sources'), {
      id: '@id'
    }, updatable());
  }).factory('PaymentExpenditure', function($resource) {
    return $resource(apiPath('payments/expenditures'), {
      id: '@id'
    }, updatable());
  }).factory('PaymentExpenditureGroup', function($resource) {
    return $resource(apiPath('payments/expendituregroups'), {
      id: '@id'
    }, updatable());
  }).factory('Tag', function($resource) {
    return $resource(apiPath('tags'), {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      },
      autocomplete: {
        method: 'GET',
        url: apiPath('tags', 'autocomplete'),
        isArray: true
      },
      checkExistance: {
        method: 'POST',
        url: apiPath('tags', 'checkExistance')
      }
    });
  }).factory('Master', function($resource) {
    return $resource(apiPath('masters'), {
      id: '@id'
    }, updatable());
  }).factory('Review', function($resource) {
    return $resource(apiPath('reviews'), {
      id: '@id'
    }, updatable());
  }).factory('Menu', function($resource) {
    return $resource(apiPath('menu'), {
      id: '@id'
    }, updatable());
  }).factory('Video', function($resource) {
    return $resource(apiPath('videos'), {
      id: '@id'
    }, updatable());
  });

  apiPath = function(entity, additional) {
    if (additional == null) {
      additional = '';
    }
    return ("api/" + entity + "/") + (additional ? additional + '/' : '') + ":id";
  };

  updatable = function() {
    return {
      update: {
        method: 'PUT'
      }
    };
  };

  countable = function() {
    return {
      count: {
        method: 'GET'
      }
    };
  };

}).call(this);

(function() {
  angular.module('Egecms').service('AceService', function() {
    this.editors = {};
    this.initEditor = function(FormService, minLines, id, mode) {
      if (minLines == null) {
        minLines = 30;
      }
      if (id == null) {
        id = 'editor';
      }
      if (mode == null) {
        mode = 'ace/mode/html';
      }
      this.editor = ace.edit(id);
      this.editor.getSession().setMode(mode);
      this.editor.getSession().setUseWrapMode(true);
      this.editor.setOptions({
        minLines: minLines,
        maxLines: 2e308
      });
      this.editor.commands.addCommand({
        name: 'save',
        bindKey: {
          win: 'Ctrl-S',
          mac: 'Command-S'
        },
        exec: function(editor) {
          return FormService.edit();
        }
      });
      return this.editors[id] = this.editor;
    };
    this.getEditor = function(id) {
      if (id == null) {
        id = 'editor';
      }
      return this.editors[id];
    };
    this.show = function(id) {
      if (id == null) {
        id = 'editor';
      }
      this.shown_editor = id;
      return localStorage.setItem('shown_editor', id);
    };
    this.isShown = function(id) {
      if (id == null) {
        id = 'editor';
      }
      if (!localStorage.getItem('shown_editor')) {
        this.show('editor');
      }
      return id === localStorage.getItem('shown_editor');
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('IndexService', function($rootScope) {
    this.filter = function() {
      $.cookie(this.controller, JSON.stringify(this.search), {
        expires: 365,
        path: '/'
      });
      this.current_page = 1;
      return this.pageChanged();
    };
    this.max_size = 10;
    this.init = function(Resource, current_page, attrs, params) {
      if (params == null) {
        params = {};
      }
      $rootScope.frontend_loading = true;
      this.Resource = Resource;
      this.current_page = parseInt(current_page);
      this.controller = attrs.ngController.toLowerCase().slice(0, -5);
      this.search = $.cookie(this.controller) ? JSON.parse($.cookie(this.controller)) : {};
      this.params = params;
      return this.loadPage();
    };
    this.loadPage = function() {
      var p;
      p = {
        page: this.current_page
      };
      if (this.sort !== void 0) {
        p.sort = this.sort;
      }
      if (this.params.folder) {
        p.folder = this.params.folder;
      }
      $.each(this.params, function(key, val) {
        return p[key] = val;
      });
      return this.Resource.get(p, (function(_this) {
        return function(response) {
          _this.page = response;
          return $rootScope.frontend_loading = false;
        };
      })(this));
    };
    this.pageChanged = function() {
      $rootScope.frontend_loading = true;
      this.loadPage();
      return this.changeUrl();
    };
    this["delete"] = function(id, text) {
      return bootbox.confirm("Вы уверены, что хотите удалить " + text + " #" + id + "?", (function(_this) {
        return function(result) {
          if (result === true) {
            return _this.Resource["delete"]({
              id: id
            }, function() {
              return location.reload();
            });
          }
        };
      })(this));
    };
    this.changeUrl = function() {
      return window.history.pushState('', '', this.controller + '?page=' + this.current_page);
    };
    return this;
  }).service('FormService', function($rootScope, $q, $timeout) {
    var beforeSave, modelLoaded, modelName;
    this.init = function(Resource, id, model) {
      this.dataLoaded = $q.defer();
      $rootScope.frontend_loading = true;
      this.Resource = Resource;
      this.saving = false;
      if (id) {
        return this.model = Resource.get({
          id: id
        }, (function(_this) {
          return function() {
            return modelLoaded();
          };
        })(this));
      } else {
        this.model = new Resource(model);
        return modelLoaded();
      }
    };
    modelLoaded = (function(_this) {
      return function() {
        $rootScope.frontend_loading = false;
        return $timeout(function() {
          _this.dataLoaded.resolve(true);
          return $('.selectpicker').selectpicker('refresh');
        });
      };
    })(this);
    beforeSave = (function(_this) {
      return function() {
        if (_this.error_element === void 0) {
          ajaxStart();
          if (_this.beforeSave !== void 0) {
            _this.beforeSave();
          }
          _this.saving = true;
          return true;
        } else {
          $(_this.error_element).focus();
          if (_this.error_text !== void 0) {
            notifyError(_this.error_text);
          }
          return false;
        }
      };
    })(this);
    modelName = function() {
      var l, model_name;
      l = window.location.pathname.split('/');
      model_name = l[l.length - 2];
      if ($.isNumeric(model_name)) {
        model_name = l[l.length - 3];
      }
      return model_name;
    };
    this["delete"] = function(event, callback) {
      if (callback == null) {
        callback = false;
      }
      return bootbox.confirm("Вы уверены, что хотите " + ($(event.target).text()) + " #" + this.model.id + "?", (function(_this) {
        return function(result) {
          if (result === true) {
            beforeSave();
            return _this.model.$delete().then(function() {
              var url;
              if (callback) {
                callback();
                _this.saving = false;
                return ajaxEnd();
              } else {
                url = _this.redirect_url || modelName();
                if (_this.prefix) {
                  url = _this.prefix + url;
                }
                return redirect(url);
              }
            }, function(response) {
              return notifyError(response.data.message);
            });
          }
        };
      })(this));
    };
    this.edit = function(callback) {
      var tags;
      if (callback == null) {
        callback = null;
      }
      if (!beforeSave()) {
        return;
      }
      if (this.model.hasOwnProperty('tags')) {
        tags = this.model.tags;
      }
      console.log('tags 1', tags);
      return this.model.$update().then((function(_this) {
        return function() {
          if (callback !== null) {
            callback();
          }
          _this.saving = false;
          if (tags) {
            _this.model.tags = tags;
          }
          return ajaxEnd();
        };
      })(this), function(response) {
        if (response.data.hasOwnProperty('message')) {
          notifyError(response.data.message);
        } else {
          $.each(response.data, function(index, value) {
            return notifyError(value);
          });
        }
        this.saving = false;
        return ajaxEnd();
      });
    };
    this.create = function() {
      if (!beforeSave()) {
        return;
      }
      return this.model.$save().then((function(_this) {
        return function(response) {
          var url;
          url = _this.redirect_url || modelName() + ("/" + response.id + "/edit");
          if (_this.prefix) {
            url = _this.prefix + url;
          }
          return redirect(url);
        };
      })(this), (function(_this) {
        return function(response) {
          notifyError(response.data.message);
          _this.saving = false;
          ajaxEnd();
          return _this.onCreateError(response);
        };
      })(this));
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('ExportService', function($rootScope, FileUploader) {
    bindArguments(this, arguments);
    this.init = function(options) {
      var onWhenAddingFileFailed;
      this.controller = options.controller;
      this.FileUploader.FileSelect.prototype.isEmptyAfterSelection = function() {
        return true;
      };
      return this.uploader = new this.FileUploader({
        url: this.controller + "/import",
        alias: 'imported_file',
        autoUpload: true,
        method: 'post',
        removeAfterUpload: true,
        onCompleteItem: function(i, response, status) {
          if (status === 200) {
            notifySuccess('Импортировано');
          }
          if (status !== 200) {
            return notifyError(response.message);
          }
        }
      }, onWhenAddingFileFailed = function(item, filter, options) {
        if (filter.name === "queueLimit") {
          this.clearQueue();
          return this.addToQueue(item);
        }
      });
    };
    this["import"] = function(e) {
      e.preventDefault();
      $('#import-button').trigger('click');
    };
    this.exportDialog = function() {
      $('#export-modal').modal('show');
      return false;
    };
    this["export"] = function() {
      window.location = "/" + this.controller + "/export?field=" + this.export_field;
      $('#export-modal').modal('hide');
      return false;
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('FactoryService', function($http) {
    this.get = function(table, select, orderBy) {
      if (select == null) {
        select = null;
      }
      if (orderBy == null) {
        orderBy = null;
      }
      return $http.post('api/factory', {
        table: table,
        select: select,
        orderBy: orderBy
      });
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('FolderService', function($http, $timeout, Folder) {
    var config, getTree;
    this.folders = [];
    this.breadcrumbs = null;
    this.itemSortableOptions = {
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      tolerance: "pointer",
      axis: 'y',
      update: (function(_this) {
        return function(event, ui) {
          return $timeout(function() {
            return _this.IndexService.page.data.forEach(function(model, index) {
              return _this.Resource.update({
                id: model.id,
                position: index
              });
            });
          });
        };
      })(this)
    };
    this.folderSortableOptions = {
      cursor: "move",
      opacity: 0.9,
      zIndex: 9999,
      tolerance: "pointer",
      axis: 'y',
      update: (function(_this) {
        return function(event, ui) {
          return $timeout(function() {
            return _this.folders.forEach(function(model, index) {
              return Folder.update({
                id: model.id,
                position: index
              });
            });
          });
        };
      })(this)
    };
    config = {
      modalId: '#folder-modal'
    };
    this.init = function(modelClass, current_folder_id, IndexService, Resource) {
      this["class"] = modelClass;
      this.current_folder_id = current_folder_id;
      this.current_folder = Folder.get({
        id: current_folder_id
      });
      this.IndexService = IndexService;
      this.Resource = Resource;
      if (current_folder_id) {
        this.breadcrumbs = Folder.breadcrumbs({
          id: current_folder_id
        });
      }
      if (!IndexService) {
        Folder.tree({
          "class": modelClass
        }, (function(_this) {
          return function(response) {
            _this.tree = getTree(response);
            return $timeout(function() {
              return $('.folder-selectpicker').selectpicker('refresh');
            });
          };
        })(this));
      }
      this.folders = Folder.query({
        "class": modelClass,
        current_folder_id: current_folder_id,
        save_visited_folder_id: current_folder_id !== void 0
      }, function() {
        return spRefresh();
      });
      return this.modal = $(config.modalId);
    };
    getTree = function(folders, level, parent_name) {
      var items;
      if (level == null) {
        level = 0;
      }
      if (parent_name == null) {
        parent_name = null;
      }
      items = [];
      folders.forEach((function(_this) {
        return function(item) {
          var name;
          name = '';
          if (parent_name) {
            name += "<span class='subfolders'>" + parent_name + " / </span>";
          }
          name += item.name;
          items.push({
            id: item.id,
            name: name,
            level: level
          });
          if (item.folders) {
            return items = items.concat(getTree(item.folders, level + 1, name));
          }
        };
      })(this));
      return items;
    };
    this.createModal = function() {
      this.popup_folder = {
        name: null
      };
      return this.modal.modal('show');
    };
    this.createOrUpdate = function() {
      this.modal.modal('hide');
      if (this.popup_folder.id) {
        return this.edit();
      } else {
        return this.create();
      }
    };
    this.create = function() {
      return Folder.save({
        "class": this["class"],
        name: this.popup_folder.name,
        folder_id: this.current_folder_id
      }, (function(_this) {
        return function(response) {
          return _this.folders.push(response);
        };
      })(this));
    };
    this.editModal = function() {
      this.popup_folder = this.current_folder;
      return this.modal.modal('show');
    };
    this.edit = function() {
      Folder.update(this.popup_folder);
      this.modal.modal('hide');
      if (this.popup_folder.id) {
        return this.folders.forEach((function(_this) {
          return function(folder, i) {
            if (folder.id === _this.popup_folder.id) {
              return _this.folders[i] = _.clone(_this.popup_folder);
            }
          };
        })(this));
      }
    };
    this["delete"] = function(folder) {
      return bootbox.confirm("Вы уверены, что хотите удалить папку «" + this.current_folder.name + "»?", (function(_this) {
        return function(result) {
          if (result === true) {
            return Folder["delete"]({
              id: _this.current_folder.id
            }, function() {
              return history.back();
            });
          }
        };
      })(this));
    };
    this.isEmpty = function(folder) {
      return !folder.item_count && !folder.folder_count;
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('PhotoService', function($rootScope, $http, $timeout, Photo) {
    this.image = '';
    this.cropped_image = '';
    this.cripping = false;
    this.aspect_ratio = null;
    this.FormService = null;
    this.methods = {};
    this.selected_photo_index = null;
    this.init = (function(_this) {
      return function(FormService, type, id) {
        _this.type = type;
        _this.id = id;
        _this.FormService = FormService;
        return _this.bindFileUpload(type, id);
      };
    })(this);
    this.crop = function() {
      this.cropping = true;
      return $timeout((function(_this) {
        return function() {
          return _this.methods.updateResultImage(function() {
            return $timeout(function() {
              var blob, fd;
              fd = new FormData();
              blob = dataURItoBlob(_this.cropped_image);
              fd.append('cropped_image', blob);
              fd.append('id', _this.getSelectedPhoto().id);
              console.log('blob', blob);
              return $http.post('upload/cropped', fd, {
                transformRequest: angular.identity,
                headers: {
                  'Content-Type': void 0
                }
              }).then(function(response) {
                _this.cropping = false;
                _this.FormService.model.photos[_this.selected_photo_index] = response.data;
                return _this.closeModal();
              }, function(error) {
                _this.cropping = false;
                return notifyError("Ошибка при загрузке");
              });
            });
          });
        };
      })(this));
    };
    this.closeModal = function() {
      return $('#change-photo').modal('hide');
    };
    this.bindFileUpload = function(type, id) {
      return $('#fileupload').fileupload({
        formData: {
          id: id,
          type: type
        },
        send: function() {
          return NProgress.configure({
            showSpinner: true
          });
        },
        progress: function(e, data) {
          return NProgress.set(data.loaded / data.total);
        },
        always: function() {
          NProgress.configure({
            showSpinner: false
          });
          return ajaxEnd();
        },
        done: (function(_this) {
          return function(i, response) {
            if (response.result.hasOwnProperty('error')) {
              notifyError(response.result.error);
              return;
            }
            if (_this.photo_id) {
              _this.FormService.model.photos[_this.selected_photo_index] = response.result;
              _this.image = _this.getSelectedPhoto().original_url;
              delete _this.photo_id;
            } else {
              _this.FormService.model.photos.push(response.result);
              _this.edit(_this.FormService.model.photos.length - 1);
            }
            return $rootScope.$apply();
          };
        })(this)
      });
    };
    this.getSelectedPhoto = function() {
      return this.FormService.model.photos[this.selected_photo_index];
    };
    this.loadNew = function() {
      this.photo_id = this.getSelectedPhoto().id;
      $('#fileupload').bind('fileuploadsubmit', (function(_this) {
        return function(e, data) {
          return data.formData = {
            id: _this.id,
            type: _this.type,
            photo_id: _this.photo_id,
            count: _this.FormService.model.count
          };
        };
      })(this));
      return $('#fileupload').click();
    };
    this.edit = function(index) {
      this.selected_photo_index = index;
      this.image = this.getSelectedPhoto().original_url;
      return $('#change-photo').modal('show');
    };
    this["delete"] = function() {
      Photo["delete"]({
        id: this.getSelectedPhoto().id
      });
      this.FormService.model.photos.splice(this.selected_photo_index, 1);
      return $('#change-photo').modal('hide');
    };
    this.toggleAscpectRatio = function() {
      console.log('aspect ratio');
      if (this.aspect_ratio === null) {
        return this.aspect_ratio = 7 / 4;
      } else {
        return this.aspect_ratio = null;
      }
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('Egecms').service('UserService', function(AllUser, $rootScope, $timeout) {
    var system_user;
    this.users = AllUser.query();
    $timeout((function(_this) {
      return function() {
        return _this.current_user = $rootScope.$$childTail.user;
      };
    })(this));
    system_user = {
      color: '#999999',
      login: 'system',
      id: 0
    };
    this.get = function(user_id) {
      return this.getUser(user_id);
    };
    this.getUser = function(user_id) {
      return _.findWhere(this.users, {
        id: parseInt(user_id)
      }) || system_user;
    };
    this.getLogin = function(user_id) {
      return this.getUser(parseInt(user_id)).login;
    };
    this.getColor = function(user_id) {
      return this.getUser(parseInt(user_id)).color;
    };
    this.getWithSystem = function(only_active) {
      var users;
      if (only_active == null) {
        only_active = true;
      }
      users = this.getAll(only_active);
      users.unshift(system_user);
      return users;
    };
    this.getAll = function(only_active) {
      if (only_active == null) {
        only_active = true;
      }
      if (only_active) {
        return _.filter(this.users, function(user) {
          return user.rights.length && user.rights.indexOf('35') === -1;
        });
      } else {
        return this.users;
      }
    };
    this.toggle = function(entity, user_id, Resource) {
      var new_user_id, obj;
      if (Resource == null) {
        Resource = false;
      }
      new_user_id = entity[user_id] ? 0 : this.current_user.id;
      if (Resource) {
        return Resource.update((
          obj = {
            id: entity.id
          },
          obj["" + user_id] = new_user_id,
          obj
        ), function() {
          return entity[user_id] = new_user_id;
        });
      } else {
        return entity[user_id] = new_user_id;
      }
    };
    this.getBannedUsers = function() {
      return _.filter(this.users, function(user) {
        return user.rights.length && user.rights.indexOf('35') !== -1;
      });
    };
    this.getBannedHaving = function(condition_obj) {
      return _.filter(this.users, function(user) {
        return user.rights.indexOf('35') !== -1 && condition_obj && condition_obj[user.id];
      });
    };
    this.getActiveInAnySystem = function(with_system) {
      var users;
      if (with_system == null) {
        with_system = true;
      }
      users = _.chain(this.users).filter(function(user) {
        return user.rights.indexOf('35') === -1 || user.rights.indexOf('34') === -1;
      }).sortBy('login').value();
      if (with_system) {
        users.unshift(system_user);
      }
      return users;
    };
    this.getBannedInBothSystems = function() {
      return _.chain(this.users).filter(function(user) {
        return user.rights.indexOf('35') !== -1 && user.rights.indexOf('34') !== -1;
      }).sortBy('login').value();
    };
    return this;
  });

}).call(this);

//# sourceMappingURL=app.js.map
