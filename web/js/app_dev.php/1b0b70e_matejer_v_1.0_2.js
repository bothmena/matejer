var matejerApp = angular.module('matejerApp', ['ui.bootstrap', 'pascalprecht.translate']);
//config
matejerApp
    .config(["$interpolateProvider", function($interpolateProvider){
        "use strict";
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    }])
    .config(['$translateProvider', function($translateProvider) {
        "use strict";
        $translateProvider
        .translations('en', {
            'quick_view': 'Quick View',
            'subscribed': 'Subscribed',
            'unsubscribed': 'Subscribe',
            'liked': 'liked',
            'unliked': 'Like',
            'offer': 'Make Offer',
            'error_title': 'Oops! An Error Occurred...',
            'error_content': 'An internal error occurred , please refresh the page and/or retry.',
            'signFb': 'Sign Up Using Facebook',
            'signGp': 'Sign Up Using Google+',
            'help': 'Help',
            'terms': 'terms and conditions',
            'new_list': 'New [values] List',
            'new_table': 'New [name, value] List',
            'double_name': 'Table',
            'simple_name': 'List',
            'value_ph': 'Specification Value',
            'name_ph': 'Specification Name',
            'group_ph': 'Specs Group Name',
            'add_color': 'Add Color(s)',
            'your_review': 'Your Review',
            'edit_btn': 'Edit',
            'remove_btn': 'Remove',
            'cancel_btn': 'Cancel',
            'remove_edit_m_title': 'Delete Confirmation',
            "item_rm_confirm": "Are you sure you want to delete {[{name}]}?",
            'this_item': 'this item',
            'cat_edit_lckd_tltp': 'Edit mode is locked, click to unlock',
            'cat_edit_ulckd_tltp': 'Edit mode is unlocked, click to lock',
            'share_product': 'Share This Product',
            'abo_image_shop': 'Update your shop logo/cover'
        })
        .translations('fr', {})
        .translations('ar', {});
        $translateProvider.preferredLanguage('en');
        $translateProvider.useSanitizeValueStrategy('escape');
    }])
;
//services
matejerApp
    .service('APIService', ['$http', '$q', '$compile', function($http, $q, $compile){
        "use strict";
        
        function cancel( promise ) {
            if (promise && promise._httpTimeout && promise._httpTimeout.resolve ) {
                promise._httpTimeout.resolve();
            }
        }
        function submitForm(url, data){
            var httpTimeout = $q.defer();
            var request = $http({
                url: url,
                method: 'POST',
                data: data,
                dataType: 'application/json',
                timeout: httpTimeout.promise,
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            var promise = request.then( unwrapResolve );
            promise._httpTimeout = httpTimeout;
            return( promise );
        }
        function getData(method, url){
            var httpTimeout = $q.defer();
            var request = $http({
                method: method,
                url: url,
                dataType: 'application/json',
                timeout: httpTimeout.promise
            });
            var promise = request.then( unwrapResolve );
            promise._httpTimeout = httpTimeout;
            return( promise );
        }
        function isAvailable(url) {
            var httpTimeout = $q.defer();
            var request = $http({
                method: "post",
                url: url,
                timeout: httpTimeout.promise
            });
            var promise = request.then( unwrapResolve );
            promise._httpTimeout = httpTimeout;
            return( promise );
        }
        function unwrapResolve( response ) {
            return( response.data );
        }
        function injectData( injections, element ) {

            $.each(injections, function(key, value){
                if (value.action === 'html') {
                    element.find(value.injectIn).html(value.content);
                }
            });
        }
        function compileInjectData( injections, element, scope ) {

            $.each(injections, function(key, value){

                //noinspection JSUnresolvedVariable
                element.find(value.injectIn).html($compile(value.content)(scope));
            });
        }

        return {
            submitForm: submitForm,
            getData: getData,
            injectData: injectData,
            compileInjectData: compileInjectData,
            isAvailable: isAvailable,
            cancel: cancel
        };

    }])
    .service('UtilService', ['$uibModal', function($uibModal){
        "use strict";
        var userProds;var userShops;
        var shopProds;var shopCats;
        function editUserProds(val, action){
            if(action === 'add') {
                addToArray(val, userProds);
            }
            else if(action === 'remove') {
                removeFromArray(val, userProds);
            }
        }
        function editUserShops(val, action){
            if(action === 'add') {
                addToArray(val, userShops);
            }
            else if(action === 'remove') {
                removeFromArray(val, userShops);
            }
        }
        function addShopProd(val){
            addToArray(val, shopProds);
        }
        function addToArray(value, array){
            if (array.indexOf(value) === -1) {
                array.push(value);
            }
            return array;
        }
        function removeFromArray(value, array){
            var index = array.indexOf(value);
            if (index > -1) {
                array.splice(index, 1);
            }
            return array;
        }
        function setUserData(data){
            userProds = data.userProds;
            userShops = data.userShops;
            shopProds = data.shopProds;
            shopCats = data.shopCats;
        }
        function isOffreable(prodId, catId){
            return (!in_array(prodId, shopProds) && in_array(catId, shopCats));
        }
        function isLiked(prodId){
            return in_array(prodId, userProds);
        }
        function isSubscribed(shopId){
            return in_array(shopId, userShops);
        }
        function fileStyle() {
            $('.input-file-cont input').each(function(){
                var inputId = $(this).attr('id');
                $( '#' + inputId ).filestyle({buttonText: $(this).attr('data-label'), buttonBefore: true,iconName: "fa fa-photo", buttonName: "btn-default btn-flat"});
                document.getElementById(inputId).addEventListener("change", function(){handleFileSelect(event, $(this).attr('well'))}, false);
            });
        }
        function checkbox(clas) {
            clas = clas || '';
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue icheckbox_square-yellow icheckbox_square-green icheckbox_square-red icheckbox_square-grey '+clas,
                radioClass: 'iradio_square-blue iradio_square-yellow iradio_square-green iradio_square-red iradio_square-grey '+clas
            });
        }
        function inputMask(){
            $(":input").inputmask();
        }
        function select(){
            $("select").each(function () {
                if( typeof $(this).attr('class') !== 'undefined' &&  $(this).attr('class').indexOf('image-picker') < 0)
                    $(this).select2();
            });
            $(".select_two_multi").select2({closeOnSelect: false});
        }
        function notify(title, body, type){
            $uibModal.open({
                template: '<div class="modal-body"><h3 class="text-'+type+'">'+title+'</h3><p>'+body+'</p></div>',
                controller: 'InstanceModalController'
            });
        }
        function in_array(needle, haystack) {

            for (var key in haystack) {
                if (haystack[key] === needle) {
                    return true;
                }
            }
            return false;
        }
        function ckEditor(id){
            /*CKEDITOR.config.customConfig = 'http://localhost/matejer.com/web/bundles/ckeditor/config.js';
            CKEDITOR.config.skin = 'bootstrapck,/matejer.com/web/bundles/ckeditor/skins/bootstrapck/';*/
            CKEDITOR.config.customConfig = '/bundles/ckeditor/config.js';
            CKEDITOR.config.skin = 'bootstrapck,/bundles/ckeditor/skins/bootstrapck/';
            CKEDITOR.replace('#'+id);
            //customConfig: 'http://localhost/matejer.com/web/bundles/ckeditor/config.js',
            //skin: 'moonocolor,/myskins/moonocolor/' 
            //'bundles/ckeditor/lang/en.js'  
            //'bundles/ckeditor/skins/bootstrapck/editor.css'
        }
        function imagePicker(label){
            $(".image-picker").imagepicker({hide_select : true, show_label : label});
        }
        function postImgPckr(){
            $('.thumbnails.image_picker_selector').addClass('cgs');
            $('.thumbnails.image_picker_selector').parent().addClass('pcgs');
        }
        return {
            imagePicker: imagePicker,
            postImgPckr: postImgPckr,
            setUserData: setUserData,
            editUserProds: editUserProds,
            editUserShops: editUserShops,
            addShopProd: addShopProd,
            isSubscribed: isSubscribed,
            isOffreable: isOffreable,
            isLiked: isLiked,
            fileStyle: fileStyle,
            checkbox: checkbox,
            select: select,
            ckEditor: ckEditor,
            notify: notify,
            inputMask: inputMask,
            in_array: in_array
        };
    }])
    .service('URLService', [function(){
        "use strict";
        var token = '';
        var setToken = function(tokenParam){
            token = tokenParam;
        };
        function imageFormUrl(entity){
            return '/modal/image-'+entity+'/'+token;
        }
        function userDataUrl(){
            return '/api/user-data';
        }
        function removeEditUrl(type, entity, action, id){
            var str = entity+'-'+type;
            switch(str){
                case 'shop-cat':
                    return '/myShop/categories/' + action + '/' + token + '/' + id;
                case 'shop-col':
                    return '/myShop/collections/' + action + '/' + token + '/' + id;
                case 'shop-pay':
                    return '/myShop/payments/' + action + '/' + token + '/' + id;
                case 'user-cat':
                    return '/myProfile/categories/' + action + '/' + token + '/' + id;
                default:
                    if (type === 'cat') {
                        return '/TM/' + entity + '/categories/' + action + '/' + token + '/' + id;
                    } if (type === 'arr') {
                        return '/TM/' + entity + '/categories/' + action + '/' + token + '/' + id;
                    }
            }
        }
        function passwordUnlockUrl(type, slug){
            if(type === 'shop'){
                return '/myShop/password-unlock/'+token;
            }else {
                return '/TM/'+slug+'/password-unlock/'+token;
            }
        }
        function checkRelationUrl(id, entity){
            return '/api/check/'+id+'/'+entity;
        }
        function availibilityUrl(value){
            return '/api/is-available/username/'+token+'/'+value;
        }
        function subscribeUrl(entity, slug){
            return '/api/subscribe/'+entity+'/'+token+'/'+slug;
        }
        function likeUrl(id){
            return '/api/like/'+token+'/'+id;
        }
        function quickViewUrl(entity, slug){
            return '/modal/'+entity+'/'+token+'/'+slug;
        }
        function offerFormUrl(slug){
            return '/modal/offer-form/'+token+'/'+slug;
        }
        function colorsUrl(){
            return '/modal/'+token+'/colors';
        }
        function galleryUrl(tab, search, page){
            return '/gallery-'+tab+'/'+page+'/'+search;
        }
        function helpUrl(group){
            return '/modal/help/'+token+'/'+group;
        }
        function tokenUrl(){
            return '/api/get-token';
        }
        function editReviewUrl(entity, id){
            return '/reviews/'+entity+'/'+token+'/'+id;
        }
        return {
            imageFormUrl: imageFormUrl,
            userDataUrl: userDataUrl,
            passwordUnlockUrl: passwordUnlockUrl,
            removeEditUrl: removeEditUrl,
            checkRelationUrl: checkRelationUrl,
            subscribeUrl: subscribeUrl,
            quickViewUrl: quickViewUrl,
            offerFormUrl: offerFormUrl,
            colorsUrl: colorsUrl,
            galleryUrl: galleryUrl,
            setToken: setToken,
            helpUrl: helpUrl,
            availibilityUrl: availibilityUrl,
            tokenUrl: tokenUrl,
            likeUrl: likeUrl,
            editReviewUrl: editReviewUrl
        };
    }])
;
// controllers
matejerApp
    .controller('MatejerController', ['$scope', '$window', '$element', '$translate', 'UtilService', 'URLService', 'APIService', function ($scope, $window, $element, $translate, util, url, api){

        "use strict";
        $scope.loadingPage = '';
        $scope.init = function ( color, locale ) {
            $translate.use( locale );
            switch (color){
                case 'blue':
                    $scope.theme = 'primary';
                    $scope.background = 'bg-blue';
                    break;
                case 'yellow':
                    $scope.theme = 'warning';
                    $scope.background = 'bg-yellow';
                    break;
                case 'red':
                    $scope.theme = 'danger';
                    $scope.background = 'bg-red';
                    break;
                case 'green':
                    $scope.theme = 'success';
                    $scope.background = 'bg-green';
                    break;
                case 'white':
                    $scope.theme = 'default';
                    $scope.background = 'bg-gray-light';
                    break;
                default:
                    $scope.theme = 'primary';
                    $scope.background = 'bg-blue';
                    break;
            }
        };
        $window.onload = function initialize(){
            if(typeof $scope.options !== 'undefined'){
                if('userdata' in $scope.options){
                    var uDRequest = api.getData('POST', url.userDataUrl());
                    uDRequest . then(function successCallback(response) {
                        if(response.stat === 'success') {
                            util.setUserData(response.data);
                        }
                        $scope.$broadcast("USER_DATA_EVENT");
                    });
                }
                if('check' in $scope.options){
                    var cRequest = api.getData('POST', url.checkRelationUrl($scope.options.check.id, $scope.options.check.entity));
                    cRequest . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            if(response.result) {
                                $scope.$broadcast("CHECK_EVENT_TRUE");
                            }
                            else {
                                $scope.$broadcast("CHECK_EVENT_FALSE");
                            }
                        }
                    });
                }
                if('inputMask' in $scope.options) {
                    util.inputMask();
                }
                if('select' in $scope.options) {
                    util.select();
                }
                if('checkbox' in $scope.options){
                    if('checkClass' in $scope.options) {
                        util.checkbox($scope.options.checkClass);
                    }
                    else {
                        util.checkbox();
                    }
                }
                if('fileStyle' in $scope.options) {
                    util.fileStyle();
                }
                if('token' in $scope.options){
                    var request = api.getData('POST', url.tokenUrl());
                    request . then(function successCallback(response) {
                        if(response.stat === 'success') {
                            url.setToken(response.token);
                        }
                    });
                }
                if('imagePicker' in $scope.options){
                    util.imagePicker($scope.options.imagePicker);
                    if('postImgPckr' in $scope.options) {
                        util.postImgPckr();
                    }
                }
                if('ckeditor' in $scope.options) {
                    util.ckEditor($scope.options.ckeditor);
                }
            }
            $scope.$broadcast('PAGE_LOAD_COMPLETE');
        };
        $scope.isLoading = function(id){
            return $scope.loadingPage === id;
        }
        $scope.getPage = function(url, id){
            $scope.loadingPage = id;
            var request = api.getData('GET', url);
            request . then(function successCallback(response) {
                api.compileInjectData(response.injections, $element, $scope);
            }, function errorCallback() {
                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
            }).finally(function finalCallback() {
                $scope.$broadcast('USER_DATA_PRODUCT_EVENT');
                $scope.loadingPage = '';
            });
        }
    }])
    .controller('SPAOfferFormController', ['$scope', function($scope){
        'use strict';
        $scope.showForm = false;
        $scope.toggleForm = function(){
            $scope.showForm = !$scope.showForm;
        };
    }])
    .controller('ConfirmedController', ['$scope', '$filter', '$element', 'UtilService', 'APIService', 'URLService', function($scope, $filter, $element, util, api, url){

        'use strict';
        $scope.loading = false;
        var lastRequest = null;
        $scope.$on( "$destroy", function handleDestroyEvent() {
                api.cancel( lastRequest );
            }
        );

        $scope.updateClass = function(){

            $scope.cancel();
            $scope.loading = true;
            lastRequest = api.isAvailable(url.availibilityUrl($scope.username));
            lastRequest . then(function successCallback(response) {
                    onSuccess(response);
                }, function errorCallback(response) {
                    util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                })
                .finally(function finalCallback(response) {
                    $scope.loading = false;
                });
        };
        $scope.cancel = function(){
            api.cancel( lastRequest );
            $scope.loading = false;
        };

        function onSuccess(response) {
            $element.find('#username_check').html('<div class="alert alert-'+response.stat+' alert-dismissible box-shadow"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+response.message+'</div>');
        }
    }])
    .controller('RegistrationController', ['$scope', 'UtilService', function($scope, util){

        'use strict';
        $scope.disabled = true;
        $('input').on('ifChecked', function(){
            $scope.disabled = false;$scope.$apply();
        });
        $('input').on('ifUnchecked', function(){
            $scope.disabled = true;$scope.$apply();
        });
    }])
    .controller('EditProfileController', ['$scope', '$element', '$compile', '$filter', 'APIService', 'UtilService', function($scope, $element, $compile, $filter, api, util){

        'use strict';
        $scope.generalVisibile = true; $scope.generalLoding = false;
        $scope.addressVisibile = true; $scope.addressLoding = false;
        $scope.contactVisibile = true; $scope.contactLoding = false;
        $scope.refreshingForm = false; $scope.uploadImage = false;
        $scope.refreshForm = function(type) {
            $scope.refreshingForm = true;
            var state = angular.element('.__address_state');
            var country = angular.element('.__address_country');
            var data = {};
            data[country.attr('name')] = country.val();
            data[state.attr('name')] = state.val();
            if(type === 'country' && country.val() > 0 || type === 'state' && state.val()){
                //noinspection JSUnresolvedVariable
                var request = api.submitForm($scope.addressUrl, $.param(data));
            request . then(function successCallback(response) {
                //noinspection JSUnresolvedVariable
                var addressForm = angular.element(response.injections[0].content);
                var stateHtml = addressForm.find('.__address_state');
                var cityHtml = addressForm.find('.__address_city');
                if(type === 'country') {
                    angular.element('.__address_state').parent().html($compile(stateHtml)($scope));
                }
                angular.element('.__address_city').parent().html(cityHtml);
                util.select();
            }, function errorCallback() {
                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
            })
                .finally(function finalCallback(response) {
                    $scope.refreshingForm = false;
                });
            }
        };
        $scope.getForm = function(type){
            toggleLoading(type, true);
            var request = api.getData('GET','edit/'+type);
            request . then(function successCallback(response) {
                    if(type === 'address'){
                        var templateEl = angular.element(response.injections[0].content);
                        $compile(templateEl)($scope);
                        angular.element(response.injections[0].injectIn).append(templateEl);
                    }else
                        api.injectData( response.injections , $element );
                    if(type === 'contact')
                        util.inputMask();
                }, function errorCallback(response) {
                    util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                })
                .finally(function finalCallback(response) {
                    toggleLoading(type, false);
                    toggleVisibility(type, false);
                    if(type === 'address')
                        util.select();
                });
        };
        $scope.submitForm =  function(type, event){
            toggleLoading(type, true);
            var form = angular.element(event.target).closest('.tab-pane').find('form');
            var action = form.attr("action");
            var data = form.serialize();
            var request = api.submitForm(action, data);
            request . then(function successCallback(response) {
                    if(type === 'contact'){
                        var templateEl = angular.element(response.injections[0].content);
                        $compile(templateEl)($scope);
                        angular.element(response.injections[0].injectIn).html(templateEl);
                    }else
                        api.injectData( response.injections , $element );
                    if( response.status === "form_submit_success" )
                         $scope.cancelForm(type);
                    else toggleVisibility(type, false);

                }, function errorCallback(response) {
                    util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                })
                .finally(function finalCallback(response) {
                    toggleLoading(type, false);
                });
        };
        $scope.cancelForm = function(type){
            toggleVisibility(type, true);
            emptyFormContainer(type);
        };
        function toggleLoading(type, stat){
            if     (type === 'general') $scope.generalLoding = stat;
            else if(type === 'address') $scope.addressLoding = stat;
            else if(type === 'contact') $scope.contactLoding = stat;
        }
        function toggleVisibility(type, stat){
            if     (type === 'general') $scope.generalVisibile = stat;
            else if(type === 'address') $scope.addressVisibile = stat;
            else if(type === 'contact') $scope.contactVisibile = stat;
        }
        function emptyFormContainer(type){
            if     (type === 'general') $element.find('#general_form_container').html('');
            else if(type === 'address') $element.find('#address_form_container').html('');
            else if(type === 'contact') $element.find('#contact_form_container').html('');
        }
    }])
    .controller('SpecificationController', ['$scope', '$element', '$compile', function($scope, $element, $compile){

        'use strict';
        $scope.simpleCounter = 0;
        $scope.doubleCounter = 0;
        $scope.colorCounter = 0;
        $scope.simpleGroup = function(id,fullName){
            $scope.id = id;
            $scope.fullName = fullName;
            $scope.simpleCounter = ++$scope.simpleCounter;
            $element.find('.__specs_container').append($compile('<abo-simple-spec-group></abo-simple-spec-group>')($scope));
        };
        $scope.doubleGroup = function(id,fullName){
            $scope.id = id;
            $scope.fullName = fullName;
            $scope.doubleCounter = ++$scope.doubleCounter;
            $element.find('.__specs_container').append($compile('<abo-double-spec-group></abo-double-spec-group>')($scope));
        };
        $scope.addColor = function(code){
            var colors = [];
            angular.forEach(angular.element(".__colors_container button"), function(value, key){
                var clr = angular.element(value);
                colors.push(clr.attr('id'));
            });
            if(colors.indexOf(code) === -1){
                var id = $scope.colorId.replace(/__name__/g, ++$scope.colorCounter);
                var name = $scope.colorName.replace(/__name__/g, $scope.colorCounter);
                $element.find('.__colors_container').append($compile('<abo-color abo-id="'+id+'" abo-name="'+name+'" abo-code="'+code+'"></abo-color>')($scope));
                console.log('<abo-color abo-id="'+id+'" delete-color="deleteColor()" abo-name="'+name+'" abo-code="'+code+'"></abo-color>');
            }
        };
    }])
    .controller('LoginController', ['$scope', '$filter', '$window', 'UtilService', function($scope, $filter, $window, util){

        'use strict';
        $window.onload = function initialize(){
            angular.element('#facebook').attr('class','btn btn-block btn-social btn-facebook btn-flat');
            angular.element('#facebook').html('<i class="fa fa-facebook"></i> '+$filter('translate')('signFb'));
            angular.element('#google').attr('class','btn btn-block btn-social btn-google btn-flat');
            angular.element('#google').html('<i class="fa fa-google-plus"></i> '+$filter('translate')('signGp'));
            angular.element('#loginfbgp').find('br').each(function(){$(this).remove();});
            util.checkbox();
        };
    }])
    .controller('RemoveEditController', ['$scope', '$timeout', 'APIService', '$filter', 'UtilService', '$uibModal', 'URLService', function($scope, $timeout, api, $filter, util, $uibModal, url){

        "use strict";
        var options = {
            controller: 'InstanceModalController'
        };
        $scope.isLocked = true;
        $scope.tooltip = $filter('translate')('cat_edit_lckd_tltp');
        $scope.enableEdit = function (entity){
            if(!$scope.isLocked) {
                lock();
            }else{
                if(entity === 'user'){
                    unlock();
                }else{
                    unlockPass(entity);
                }
            }
        };
        var lockTimer = null;
        function newTimer() {
            lockTimer = $timeout(lock, 300000);
            lockTimer.then( function () {}, function () {newTimer();} );
        }
        $scope.$on('EDIT_CATS_CANCEL_TIMEOUT', function () {
            $timeout.cancel( lockTimer );
        });
        function lock(){
            $scope.isLocked = true;
            $scope.tooltip = $filter('translate')('cat_edit_lckd_tltp');
            $scope.$broadcast('EDIT_CATS_ABILITY', !$scope.isLocked);
        }
        function unlock(){
            newTimer()
            $scope.isLocked = false;
            $scope.tooltip = $filter('translate')('cat_edit_ulckd_tltp');
            $scope.$broadcast('EDIT_CATS_ABILITY', !$scope.isLocked);
        }
        function unlockPass(entity){
            $scope.unlocking = true;
            $scope.$broadcast('EDIT_CATS_ABILITY', !$scope.isLocked);
            var request = api.getData('GET', url.passwordUnlockUrl(entity));
            request . then(function successCallback(response) {
                if(response.form_stat === 'error'){
                    options.template = response.template;
                    openModal(options);
                }
                else{
                    unlock();
                }
            }, function errorCallback() {
                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
            })
            .finally(function finalCallback(response) {
                $scope.unlocking = false;
            });
        };
        $scope.submit = function(){
            $scope.unlocking = true;
            var form = angular.element('#password_unlock_admin_mode');
            var action = form.attr('action');
            var data = form.serialize();
            if(url !== '' && data !== null){
                var request = api.submitForm(action, data);
                request . then(function successCallback(response) {
                        if(response.form_stat === 'success'){
                            unlock();
                        }
                        else if(response.form_stat === 'error'){
                            options.template = response.template;
                            openModal(options);
                        }
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    })
                    .finally(function finalCallback() {
                        $scope.unlocking = false;
                    });
            }
        };
        function openModal(options){
            var modalInstance = $uibModal.open(options);
            modalInstance.result.then(function (result) {
                    if(result === 'submit_form')
                        $scope.submit();
                }, function () {}
            );
        };
    }])
    .controller('InstanceModalController', ['$scope', '$uibModalInstance', 'UtilService', function ($scope, $uibModalInstance, util){

        'use strict';
        $scope.process = function(){
            $uibModalInstance.close('process');
        };
        var colors = [];
        $scope.addColor = function(code){
            angular.element('#td-'+code).addClass('selected');
            if(!util.in_array(code, colors))
                colors.push(code);
        };
        $scope.selectColor = function(){
            $uibModalInstance.close(colors);
        };
        $scope.submit = function(){
            $uibModalInstance.close('submit_form');
        };
        $scope.dismiss = function(){
            $uibModalInstance.dismiss('dismiss');
        };
        $scope.disableSubmit = function(event){
            if(event.keyCode === 13 && !event.shiftKey){
                event.preventDefault();
                $scope.submit();
            }
        };
    }])
    .controller('ProductController', ['$scope', '$uibModal', '$filter', 'UtilService', 'URLService', 'APIService', function ($scope, $uibModal, $filter, util, url, api){

        'use strict';
        $scope.loadingGal = false;
        $scope.prodGallery = function (slug) {
            $scope.loadingGal = true;
            var request = api.getData('GET', url.quickViewUrl('gallery', slug));
            request . then(function successCallback(response) {
                if(response.stat === 'success')
                    $uibModal.open({controller: 'InstanceModalController',size: 'lg','template': response.template});
                else if(response.stat === 'danger')
                    util.notify(response.title, response.content, response.stat);
            }, function errorCallback() {
                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
            }).finally(function finalCallback() {
                $scope.loadingGal = false;
            });
        }
    }])
    .controller('ReviewController', ['$scope', '$element', '$filter', 'APIService', 'UtilService', 'URLService', function ($scope, $element, $filter, api, util, url){

        'use strict';
        $scope.inProcess = 0;
        $scope.loading = false;
        $scope.edit = false;
        $scope.valueError = false;
        $scope.commentError = false;
        $scope.editReview = function(id){
            $scope.inProcess = id;
            $scope.loading = true;
            var request = api.getData('GET', url.editReviewUrl($scope.entity, id));
            request . then(function successCallback(response) {
                api.compileInjectData( response.injections, $element, $scope );
                $scope.loading = false;
                $scope.edit = true;
            }, function errorCallback() {
                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
            });
        };
        $scope.cancelEdit = function(){
            $element.find('#review_form_container_'+$scope.inProcess).html('');
            $scope.edit = false;
            $scope.inProcess = 0;
        };
        $scope.submitReview = function(){
            $scope.valueError = false;
            $scope.commentError = false;
            if(angular.element('#'+$scope.valueId).val() < 1 || angular.element('#'+$scope.valueId).val() > 5){
                $scope.valueError = true;
            }
            else if(parseInt(angular.element('#'+$scope.commentId+'_remaining').text()) < 0){
                $scope.commentError = true;
            }
            else{
                $scope.loading = true;
                var data = $element.find('form').serialize();
                var request = api.submitForm($element.find('form').attr('action'), data);
                request . then(function successCallback(response) {
                    if(response.stat === 'success'){
                        $scope.edit = false;
                    }
                    api.compileInjectData( response.injections, $element, $scope );
                }, function errorCallback() {
                    util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                })
                .finally(function finalCallback(response) {
                    $scope.loading = false;
                    $scope.inProcess = 0;
                });
            }
        };
        $scope.setIds = function(valueId, commentId){
            $scope.valueId = valueId;
            $scope.commentId = commentId;
        };
        $scope.title = function(){
            $element.find('.user-review-name').html($filter('translate')('your_review'));
        };
        $scope.show = function(id){
            return $scope.edit && $scope.inProcess === id;
        };
        $scope.init = function(entity){
            $scope.entity = entity;
        };
        $scope.isLoading = function(id){
            return $scope.inProcess === id && $scope.loading;
        };
        $scope.isDisabled = function(id){
            return $scope.inProcess !== id && $scope.inProcess !== 0;
        };
    }])
    .controller('GalleryController', ['$scope', '$element', '$filter', 'APIService', 'UtilService', 'URLService', function ($scope, $element, $filter, api, util, url){

        'use strict';
        $scope.selected = '';
        $scope.toggleShow = function(id){
            if($scope.selected === id){
                $scope.selected = '';
            }
            else{
                $scope.selected = id;
            }
        };
        $scope.getClass = function(id){
            return $scope.selected === id ? 'show-gs' : 'show-img';
        };
        $scope.loadingShops = false;
        $scope.loadingOffers = false;
        $scope.loadingProducts = false;
        $scope.loadingPage = '';
        $scope.loadData = function(tab, page){
            page = page || 1;
            if(isDone(tab) && isEmpty(tab, page)){
                load(tab, page);
            }
        };
        $scope.isLoading = function(id){
            return $scope.loadingPage === id;
        }
        $scope.getPage = function(url, id){
            $scope.loadingPage = id;
            var request = api.getData('GET', url);
            request . then(function successCallback(response) {
                api.compileInjectData(response.injections, $element, $scope);
            }, function errorCallback() {
                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
            }).finally(function finalCallback() {
                $scope.$broadcast('USER_DATA_PRODUCT_EVENT');
                $scope.loadingPage = '';
            });
        }
        function load(tab, page){
            change(tab, true);
            var method = $scope.search === 'no_query'? 'GET' : 'POST';
            var request = api.getData(method, url.galleryUrl(tab, $scope.search, page));
            request . then(function successCallback(response) {
                api.compileInjectData(response.injections, $element, $scope);
            }, function errorCallback() {
                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
            }).finally(function finalCallback() {
                $scope.$broadcast(change(tab, false));
            });
        }
        function change(tab, value){
            if(tab === 'shop'){
                $scope.loadingShops = value;
                return 'USER_DATA_SHOP_EVENT';
            }
            else if(tab === 'offer'){
                $scope.loadingOffers = value;
                return 'USER_DATA_OFFER_EVENT';
            }
            else if(tab === 'product'){
                $scope.loadingProducts = value;
                return 'USER_DATA_PRODUCT_EVENT';
            }
        }
        function isDone(tab){
            if(tab === 'shop')
                return !$scope.loadingShops;
            else if(tab === 'offer')
                return !$scope.loadingOffers;
            else if(tab === 'product')
                return !$scope.loadingProducts;
        }
        function isEmpty(tab){
            return $element.find('#gallery_'+tab+'s').html() === '';
        }
    }])
    .controller('ShareController', ['$scope', '$element', '$filter', function($scope, $element, $filter){

        $scope.$on('PAGE_LOAD_COMPLETE', resize);
        function resize(){
            $element.find('#atstbx').prepend('<a class="btn bg-gray-light btn-sm card-btn pull-left hidden-xs" style="margin: 3px 2px 0 0;">'+$filter('translate')('share_product')+' <i class="fa fa-chevron-right"></i></a>');
            angular.forEach($element.find('.at-icon-wrapper'), function(value, key) {
                var style = angular.element(value).attr('style').replace(/32/g,'30');
                var style = angular.element(value).attr('style', 'margin-top: 1px;'+style);
            });
        }
    }])
;
// directives
matejerApp
    .directive('help', ['$uibModal', '$filter', 'APIService', 'UtilService', 'URLService', function($uibModal, $filter, api, util, url) {

        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            scope: {
                helpGroup: '@', helpText: '@', helpClass: '@'
            },
            controller: function($scope, $element) {
                $scope.loading = false;
                $scope.btnValue = $filter('translate')($scope.helpText);
                var options = {controller: 'InstanceModalController'};
                $scope.help = function(){
                    $scope.loading = true;
                    var request = api.getData('GET', url.helpUrl($scope.helpGroup));
                    request . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            options.template = response.template;
                            $uibModal.open(options);
                        }
                        else
                            util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.loading = false;
                    });
                };
            },
            template: '<a class="pointer-link {[{ helpClass }]}" ng-click="help()">{[{ btnValue }]} <i class="fa fa-info-circle" ng-hide="loading"></i><i class="fa fa-spinner fa-spin" ng-show="loading"></i></a>'
        };
    }])
    .directive('confirmEmail', ['$filter', 'APIService', 'UtilService', function($filter, api, util){

        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            scope: {
                email: '@', idEmail: '@'
            },
            controller: function($scope, $element) {
                $scope.confirmEmail = false;
                $scope.code = '';
                $scope.submitting = false;
                $scope.resending = false;
                $scope.confirmed = false;
                $scope.toggleConfirm = function(){
                    $scope.confirmEmail = !$scope.confirmEmail;
                };
                $scope.disableSubmit = function(event){
                    if(event.keyCode === 13 && !event.shiftKey){
                        event.preventDefault();
                        $scope.submitCode();
                    }
                };
                $scope.submitCode = function(){
                    $scope.submitText = '';
                    var data = $element.find('form').serialize();
                    if($scope.code === ''){
                        $scope.submitError = true;
                        $scope.submitText = 'Email confirmation code can not be empty. If you can\'t find the email containing the code, hit resend button and we will send you a new email with the code.';
                    }
                    else{
                        $scope.submitting = true;
                        var request = api.submitForm('edit/confirm_mail/'+$scope.idEmail, data);
                        request . then(function successCallback(response) {
                            if(response.stat === 'success'){
                                $scope.confirmEmail = false;
                                $scope.confirmed = true;
                                util.notify(response.title, response.content, 'success');
                            }
                            else if(response.stat === 'error'){
                                $scope.submitError = true;
                                $scope.submitText = response.content;
                            }
                        }, function errorCallback() {
                            util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                        })
                        .finally(function finalCallback(response) {
                            $scope.submitting = false;
                        });
                    }
                };
                $scope.resendCode = function(){
                    $scope.resending = true;
                    var request = api.getData('POST','edit/send_code/'+$scope.idEmail);
                    request . then(function successCallback(response) {
                        util.notify(response.title, response.content, response.stat);
                    }, function errorCallback(response) {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    })
                    .finally(function finalCallback() {
                        $scope.resending = false;
                    });
                };
            },
            templateUrl: 'edit/confirm_mail'
        };
    }])
    .directive('removeEdit', ['$uibModal', '$filter', 'APIService', 'UtilService', 'URLService', function($uibModal, $filter, api, util, url) {

        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            transclude: true,
            scope: {
                itemId: '@',
                itemName: '@',
                itemType: '@',
                entity: '@',
                disableEdit: '=',
                disableRemove: '='
            },
            controller: function ( $scope, $element ) {
                $scope.manageMode = false;
                $scope.editAbility = false;
                $scope.removing = false;
                $scope.editing = false;
                $scope.editBtn = $filter('translate')('edit_btn');
                $scope.removeBtn = $filter('translate')('remove_btn');
                $scope.itemName = $filter('translate')($scope.itemName);
                $scope.disableEdit = angular.isDefined($scope.disableEdit) ? $scope.disableEdit : false;
                $scope.disableRemove = angular.isDefined($scope.disableRemove) ? $scope.disableRemove : false;
                $scope.disabledEdt = function () {
                    return $scope.disableEdit || $scope.editing || $scope.removing;
                }
                $scope.disabledRmv = function () {
                    return $scope.disableRemove || $scope.editing || $scope.removing;
                }
                $scope.manage = function(){
                    $scope.manageMode = !$scope.manageMode;
                    $scope.$emit('EDIT_CATS_CANCEL_TIMEOUT');
                };
                $scope.$on('EDIT_CATS_ABILITY', function(event, ability){
                    $scope.manageMode = false;
                    $scope.editAbility = ability;
                });
                $scope.remove = function(){
                    $scope.$emit('EDIT_CATS_CANCEL_TIMEOUT');
                    $scope.removing = true;
                    openModal({controller: 'InstanceModalController',template: confirmTemplate()});
                };
                $scope.edit = function(){
                    $scope.$emit('EDIT_CATS_CANCEL_TIMEOUT');
                    $scope.editing = true;
                    var request = api.getData('GET', url.removeEditUrl($scope.itemType, $scope.entity, 'edit', $scope.itemId));
                    request . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            options.template = response.template;
                            openModal(options);
                        }
                        else {
                            util.notify(response.title, response.content, response.stat);
                        }
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback(response) {
                        $scope.editing = false;
                        $scope.$emit('EDIT_CATS_CANCEL_TIMEOUT');
                    });
                };
                var options = {controller: 'InstanceModalController'};
                function submit (){
                    $scope.editing = true;
                    $scope.$emit('EDIT_CATS_CANCEL_TIMEOUT');
                    var form = angular.element('#remove_edit_'+$scope.entity+'_'+$scope.itemType+'_form');
                    var action = form.attr('action');
                    var data = form.serialize();
                    if(url !== '' && data !== null){
                        var request = api.submitForm(action, data);
                        request . then(function successCallback(response) {
                                if(response.form_stat === 'success'){
                                    console.log($element.html());
                                    $element.find('.editable').html(response.data);
                                    console.log('after edit => '+$element.find('.editable').html());
                                    util.notify(response.title, response.content, 'success');
                                }
                                else if(response.form_stat === 'error'){
                                    options.template = response.template;
                                    openModal(options);
                                }
                            }, function errorCallback() {
                                util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                            })
                            .finally(function finalCallback() {
                                $scope.editing = false;
                                $scope.$emit('EDIT_CATS_CANCEL_TIMEOUT');
                            });
                    }
                };
                function removeConfirmed(){
                    $scope.removing = true;
                    var request = api.getData('POST', url.removeEditUrl($scope.itemType, $scope.entity, 'remove', $scope.itemId));
                    request . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            $element.closest('tr').remove();
                        }
                        util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.removing = false;
                    });
                };
                function confirmTemplate(){
                    var template = '<div class="modal-content"><div class="modal-header"><button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button><h4 class="modal-title">';
                    template = template +  $filter('translate')('remove_edit_m_title') + '</h4></div><div class="modal-body">';
                    template = template +  '<i class="fa fa-warning fa-lg"></i> ' + $filter('translate')('item_rm_confirm', { name: $scope.itemName });
                    template = template +  '</div><div class="modal-footer"><button type="button" class="btn btn-default medium-btn btn-flat" ng-click="dismiss()">' + $filter('translate')('cancel_btn');
                    template = template +  '</button><button type="button" class="btn btn-primary medium-btn btn-flat" ng-click="process()">' + $filter('translate')('remove_btn') + '</button></div></div>';
                    return template;
                };
                function openModal(options){
                    var modalInstance = $uibModal.open(options);
                    modalInstance.rendered.then(function(){
                        util.select();
                        util.checkbox();
                    });
                    modalInstance.result.then(
                        function (result) {
                            if(result === 'process')
                                removeConfirmed();
                            else  if(result === 'submit_form')
                                submit ();
                        }, function () {
                            $scope.removing = false;
                            $scope.editing = false;
                            $scope.$emit('EDIT_CATS_CANCEL_TIMEOUT');
                        }
                    );
                };
            },
            template: "<div class=\"row-fluid\"><ng-transclude></ng-transclude><button class=\"btn btn-default btn-sm btn-circle pull-right\" ng-click=\"manage()\" ng-show=\"editAbility\" style=\"padding: 3px 0;\"><i class=\"fa fa-cog fa-lg\"></i></button></div>\
                        <div class=\"row-fluid\" style=\"margin-top: 20px;\" ng-show=\"manageMode\">\
                        <div class=\"col-xs-6 no-padding-left\"><button type=\"button\" ng-click=\"remove()\" ng-disabled=\"disabledRmv()\" class=\"btn btn-danger btn-sm btn-flat btn-block\"><i class=\"fa fa-lg pull-left\" ng-class=\"removing?'fa-spin fa-spinner':'fa-trash'\"></i> {[{ removeBtn }]}</button></div>\
                        <div class=\"col-xs-6 no-padding-right\"><button type=\"button\" ng-click=\"edit()\" ng-disabled=\"disabledEdt()\" class=\"btn btn-info btn-sm btn-flat btn-block\">  <i class=\"fa fa-lg pull-left\" ng-class=\"editing?'fa-spin fa-spinner':'fa-edit'\"></i> {[{ editBtn }]}</button></div>"
        };
    }])
    .directive('reviewComment', function() {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            scope: {
                commentMaxLength: '@', 
                commentPh: '@', 
                commentClass: '@',
                commentValue: '@',
                commentName: '@', 
                commentId: '@'
            },
            controller: function($scope, $element) {
                $scope.commentRows = 2;
                $scope.comment = $scope.commentValue;
                $scope.maxLength = $scope.commentMaxLength - $scope.comment.length;
                $scope.count = function(){//keydown
                    $scope.maxLength = $scope.commentMaxLength - $scope.comment.length;
                };
                $scope.focus = function(){
                    $scope.commentRows = 5;
                };
                $scope.blur = function(){
                    $scope.commentRows = 2;
                }
            },
            template: '<textarea name="{[{ commentName }]}" id="{[{ commentId }]}" max-length="{[{ commentMaxLength }]}" ng-model="comment" ng-change="count();" class="{[{ commentClass }]}" placeholder="{[{ commentPh }]}" rows="{[{ commentRows }]}" ng-focus="focus()" ng-blur="blur()">{[{ commentValue }]}</textarea><span class="pull-right" id="{[{ commentId }]}_remaining">{[{ maxLength }]}</span>'
        };
    })
    .directive('reviewRate', function() {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            transclude: true,
            scope: {
                reviewLabel: '@', 
                reviewValue: '@'
            },
            controller: function($scope, $element) {
                $scope.classes = evaluate($scope.reviewValue);
                $scope.mouseIn = function(n){
                    $scope.classes = evaluate(n);
                };
                $scope.mouseOut = function(){
                    $scope.classes = evaluate($scope.reviewValue);
                };
                $scope.clicked = function(n){
                    $scope.reviewValue = n;
                    $scope.classes = evaluate($scope.reviewValue);
                    $element.find('input').val(n);
                };
                function evaluate(value){
                    return {
                        1: value < 1 ? 'fa fa-star-o': 'fa fa-star',
                        2: value < 2 ? 'fa fa-star-o': 'fa fa-star',
                        3: value < 3 ? 'fa fa-star-o': 'fa fa-star',
                        4: value < 4 ? 'fa fa-star-o': 'fa fa-star',
                        5: value < 5 ? 'fa fa-star-o': 'fa fa-star'
                    };
                }
            },
            template:   '{[{ reviewLabel }]}<span class="pull-right">\
                        <i ng-repeat="(n, name) in classes" class="star-review star-lg pointer-link" ng-class="name" ng-mouseenter="mouseIn(n)" ng-mouseleave="mouseOut()" ng-click="clicked(n)"></i>\
                        </span><ng-transclude></ng-transclude>'
        };
    })
    .directive('quickView', ['$compile', '$uibModal', '$filter', 'APIService', 'UtilService', 'URLService', function($compile, $uibModal, $filter, api, util, url) {
        'use strict';
        return {
            restrict: 'EA',
            replace: true,
            scope: {
                viewEntity: '@', 
                viewSlug: '@',
                theme: '@'
            },
            controller: function($scope, $element) {
                $scope.loading = false;
                $scope.viewText = $filter('translate')('quick_view');
                var options = {controller: 'InstanceModalController',size: 'lg'};
                $scope.getModal = function(){
                    $scope.loading = true;
                    var request = api.getData('GET', url.quickViewUrl($scope.viewEntity, $scope.viewSlug));
                    request . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            options.template = response.template;
                            $uibModal.open(options);
                        }
                        else
                            util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.loading = false;
                    });
                };
            },
            template: '<button class="btn btn-{[{ theme }]} btn-sm card-btn" title="{[{ viewText }]}" ng-click="getModal()"><i class="fa fa-search-plus" ng-hide="loading"></i><i class="fa fa-spinner fa-spin" ng-show="loading"></i> <span class="hidden-xs">{[{ viewText }]}</span></button>'
        };
    }])
    .directive('subscribe', ['$filter', 'APIService', 'UtilService', 'URLService', function($filter, api, util, url) {
        'use strict';
        return {
            restrict: 'EA',
            replace: true,
            scope: {
                subscribeEntity: '@', 
                subscribeSlug: '@',
                isSubscribed: '=?',
                theme: '@'
            },
            controller: function($scope, $element) {
                $scope.loading = false;
                $scope.isReady = angular.isDefined($scope.isSubscribed) ? true : false;
                $scope.subscribeText = btnText();
                $scope.iClass = btnClass();
                if(!$scope.isReady){
                    $scope.$on('USER_DATA_SHOP_EVENT', listener);
                    $scope.$on('CHECK_EVENT_TRUE', trueCheck);
                    $scope.$on('CHECK_EVENT_FALSE', falseCheck);
                }
                $scope.subscribe = function(){
                    $scope.loading = true;
                    var request = api.getData('POST', url.subscribeUrl($scope.subscribeEntity, $scope.subscribeSlug));
                    request . then(function successCallback(response) {
                        if(response.stat === 'subscribed'){
                            $scope.isSubscribed = true;
                            util.editUserProds($scope.subscribeSlug, 'add');
                        }
                        else if(response.stat === 'unsubscribed'){
                            $scope.isSubscribed = false;
                            util.editUserProds($scope.subscribeSlug, 'remove');
                        }
                        else
                            util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.subscribeText = btnText();
                        $scope.iClass = btnClass();
                        $scope.loading = false;
                    });
                };
                function btnClass(){
                    return $scope.isSubscribed ? 'fa fa-check-square-o' : 'fa fa-square-o';
                }
                function btnText(){
                    return $scope.isSubscribed? $filter('translate')('subscribed') : $filter('translate')('unsubscribed');
                }
                function listener() {
                    $scope.isSubscribed = util.isSubscribed($scope.subscribeSlug);
                    $scope.subscribeText = btnText();
                    $scope.iClass = btnClass();
                    $scope.isReady = true;
                }
                function trueCheck() {
                    $scope.isSubscribed = true;
                    $scope.subscribeText = btnText();
                    $scope.iClass = btnClass();
                    $scope.isReady = true;
                }
                function falseCheck() {
                    $scope.isSubscribed = false;
                    $scope.subscribeText = btnText();
                    $scope.iClass = btnClass();
                    $scope.isReady = true;
                }
            },
            template: '<button class="btn btn-{[{ theme }]} btn-sm card-btn" title="{[{ subscribeText }]}" ng-click="subscribe()"><i class="{[{ iClass }]}" ng-hide="loading"></i><i class="fa fa-spinner fa-spin" ng-show="loading"></i> <span class="hidden-xs">{[{ subscribeText }]}</span></button>'
        };
    }])
    .directive('like', ['$filter', 'APIService', 'UtilService', 'URLService', function($filter, api, util, url) {
        'use strict';
        return {
            restrict: 'EA',
            replace: true,
            scope: {
                likeId: '=',
                isLiked: '=?',
                theme: '@'
            },
            controller: function($scope, $element) {
                $scope.loading = false;
                $scope.singleLike = true;
                $scope.isReady = angular.isDefined($scope.isLiked) ? true : false;
                $scope.likeText = btnText();
                $scope.iClass = btnClass();
                if(!$scope.isReady){
                    $scope.$on('USER_DATA_EVENT', listener);
                    $scope.$on('USER_DATA_PRODUCT_EVENT', listener);
                    $scope.$on('CHECK_EVENT_TRUE', trueCheck);
                    $scope.$on('CHECK_EVENT_FALSE', falseCheck);
                }
                $scope.like = function(){
                    $scope.loading = true;
                    var request = api.getData('POST', url.likeUrl($scope.likeId));
                    request . then(function successCallback(response) {
                        if(response.stat === 'liked'){
                            $scope.isLiked = true;
                            if(!$scope.singleLike)
                                util.editUserProds($scope.likeId, 'add');
                        }
                        else if(response.stat === 'unliked'){
                            $scope.isLiked = false;
                            if(!$scope.singleLike)
                                util.editUserProds($scope.likeId, 'remove');
                        }
                        else
                            util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.likeText = btnText();
                        $scope.iClass = btnClass();
                        $scope.loading = false;
                    });
                };
                function btnClass(){
                    return $scope.isLiked ? 'fa fa-heart' : 'fa fa-heart-o';
                }
                function btnText(){
                    return $scope.isLiked? $filter('translate')('liked') : $filter('translate')('unliked');
                }
                function listener() {
                    $scope.isLiked = util.isLiked($scope.likeId);
                    $scope.likeText = btnText();
                    $scope.iClass = btnClass();
                    $scope.singleLike = false;
                    $scope.isReady = true;
                }
                function trueCheck() {
                    $scope.isLiked = true;
                    $scope.likeText = btnText();
                    $scope.iClass = btnClass();
                    $scope.isReady = true;
                }
                function falseCheck() {
                    $scope.isLiked = false;
                    $scope.likeText = btnText();
                    $scope.iClass = btnClass();
                    $scope.isReady = true;
                }
            },
            template: '<button class="btn btn-{[{ theme }]} btn-sm card-btn" title="{[{ likeText }]}" ng-show="isReady" ng-click="like()"><i class="{[{ iClass }]}" ng-hide="loading"></i><i class="fa fa-spinner fa-spin" ng-show="loading"></i> <span class="hidden-xs">{[{ likeText }]}</span></button>'
        };
    }])
    .directive('offer', ['$uibModal', '$filter', 'APIService', 'UtilService', 'URLService', function($uibModal, $filter, api, util, url) {
        'use strict';
        return {
            restrict: 'EA',
            replace: true,
            scope: {
                isPublic: '=',
                offerId: '=',
                offerCat: '=',
                offerSlug: '@',
                theme: '@'
            },
            controller: function($scope, $element) {
                $scope.loading = false;
                $scope.isOfferable = false;
                $scope.offerText = $filter('translate')('offer');
                $scope.$on('USER_DATA_EVENT', listener);
                $scope.$on('USER_DATA_PRODUCT_EVENT', listener);
                function listener() {
                    $scope.isOfferable = util.isOffreable($scope.offerId, $scope.offerCat);
                }
                var options = {controller: 'InstanceModalController',size: 'lg'};
                $scope.offer = function(){
                    $scope.loading = true;
                    var request = api.getData('GET', url.offerFormUrl($scope.offerSlug));
                    request . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            options.template = response.template;
                            openModal(options);
                        }
                        else
                            util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.loading = false;
                    });
                };
                function submit(){
                    var data = angular.element('#offerForm').serialize();
                    console.log(data);
                    var request = api.submitForm(url.offerFormUrl($scope.offerSlug), data);
                    request . then(function successCallback(response) {
                        if(response.form_stat === 'success'){
                            $scope.isOfferable = false;
                            util.addShopProd($scope.offerId);
                            util.notify(response.title, response.content, response.form_stat);
                        }
                        else{
                            options.template = response.template;
                            openModal(options);
                        }
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    });
                }
                function openModal(options){
                    var modalInstance = $uibModal.open(options);
                    modalInstance.rendered.then(function(){
                        util.select();
                    });
                    modalInstance.result.then(function (result) {
                            if(result === 'submit_form')
                                submit();
                        }, function () {}
                    );
                }
            },
            template: '<button class="btn btn-{[{ theme }]} btn-sm card-btn" title="{[{ offerText }]}" ng-show="isOfferable" ng-click="offer()"><i class="fa fa-tag" ng-hide="loading"></i><i class="fa fa-spinner fa-spin" ng-show="loading"></i> <span class="hidden-xs">{[{ offerText }]}</span></button>'
        };
    }])
    .directive('aboImage', ['$uibModal', '$filter', 'APIService', 'UtilService', 'URLService', function($uibModal, $filter, api, util, url) {
        'use strict';
        return {
            restrict: 'EA',
            replace: true,
            scope: {
                imageEntity: '@',
                theme: '@'
            },
            controller: function($scope, $element) {
                $scope.loading = false;
                $scope.title = $filter('translate')('abo_image_'+$scope.imageEntity);
                $scope.image = function(){
                    $scope.loading = true;
                    var request = api.getData('GET', url.imageFormUrl($scope.imageEntity));
                    request . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            var options = {
                                controller: 'InstanceModalController',
                                size: 'lg',
                                template: response.template
                            };
                            var modalInstance = $uibModal.open(options);
                            modalInstance.rendered.then(function(){
                                util.imagePicker(false);
                                util.fileStyle();
                            });
                        }
                        else
                            util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.loading = false;
                    });
                };
            },
            template: '<button class="btn btn-{[{ theme }]} btn-sm btn-flat image-btn" title="{[{ title }]}" ng-click="image()"><i class="fa fa-lg" ng-class="loading ? \'fa-spinner fa-spin\' : \'fa-picture-o\'"></i></button>'
        };
    }])
    .directive('specControl', ['$compile', '$filter', function($compile, $filter) {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            transclude: true,
            scope: {
                fullname: '@'
            },
            controller: function($scope, $element) {
                $scope.tableText = $filter('translate')('new_table');
                $scope.listText = $filter('translate')('new_list');
                $scope.simpleGroup = function(){
                    $element.find('.box-body ._container').append($compile(getSimpleHtml())($scope));
                };
                $scope.doubleGroup = function(){
                    $element.find('.box-body ._container').append($compile(getDoubleHtml())($scope));
                };
                var counter = 0;
                function getDoubleHtml(){
                    return '<div double-group double-fullname="'+$scope.fullname+'" double-counter="'+ ++counter +'"></div>';
                }
                function getSimpleHtml(){
                    return '<div simple-group simple-fullname="'+$scope.fullname+'" simple-counter="'+ ++counter +'"></div>';
                }
            },
            template: '<div class="box-body"><ng-transclude></ng-transclude><div class="_container"></div></div></div><div class="box-footer"><button type="button" class="btn btn-default btn-flat" ng-click="simpleGroup()"><i class="fa fa-bars"></i> {[{ listText }]}</button><button type="button" class="btn btn-default btn-flat" ng-click="doubleGroup()"><i class="fa fa-th-list"></i> {[{ tableText }]}</button><button class="btn btn-warning btn-flat pull-right medium-btn" type="submit">Submit</button></div>'
        };
    }])
    .directive('doubleGroup', ['$compile', '$filter', function($compile, $filter) {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            transclude: true,
            scope: {
                doubleFullname: '@',
                doubleCounter: '@'
            },
            controller: function($scope, $element) {
                $scope.groupLabel = $filter('translate')('double_name');//simple_name
                $scope.valuePh = $filter('translate')('value_ph');
                $scope.namePh = $filter('translate')('name_ph');
                $scope.groupPh = $filter('translate')('group_ph');
                var itemCounter = 0;$scope.replacedFullname = '';
                $scope.removeItem = function($event){
                    $($event.currentTarget).closest('.row-fluid').remove();
                };
                $scope.removeGroup = function(){
                    $element.remove();
                };
                $scope.addItem = function(){
                    itemCounter++;
                    $scope.replacedFullname = $scope.doubleFullname.replace(/__name__/g, $scope.doubleCounter+'_'+itemCounter);
                    console.log('item added => itemCounter = '+itemCounter+' || replacedFullname => '+$scope.replacedFullname);
                    $element.find('.double_container').append($compile('<div double-item></div>')($scope));
                };
            },
            template: '<div class="row" style="margin-top: 5px;"><div class="col-xs-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default btn-flat" style="width: 120px;" type="button">{[{ groupLabel }]}</button></span><input class="form-control" type="text" ng-model="groupName" placeholder="{[{ groupPh }]}"/><span class="input-group-btn"><button ng-click="removeGroup()" class="btn btn-danger btn-flat" type="button"><i class="fa fa-trash-o"></i></button></span><span class="input-group-btn"><button ng-click="addItem()" class="btn btn-primary btn-flat" type="button"><i class="fa fa-plus-square-o"></i></button></span></div></div><div class="double_container"></div><ng-transclude></ng-transclude></div>'
        };
    }])
    .directive('doubleItem', [function() {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            template: '<div class="row-fluid"><input name="{[{ ::replacedFullname }]}[group]" value="{[{ groupName }]}" type="hidden"/><span class="col-xs-4" style="padding-right: 0px;margin-top: 5px;"><input name="{[{ ::replacedFullname }]}[name]" class="form-control" type="text" placeholder="{[{ namePh }]}"/></span><span class="col-xs-8" style="padding-left: 5px;margin-top: 5px;"><div class="input-group"><input name="{[{ ::replacedFullname }]}[value]" class="form-control" type="text" placeholder="{[{ valuePh }]}"/><span class="input-group-btn"><button ng-click="removeItem($event)" class="btn btn-warning btn-flat" type="button"><i class="fa fa-minus-square-o"></i></button></span></div></span></div>'
        };
    }])
    .directive('simpleGroup', ['$compile', '$filter', function($compile, $filter) {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            transclude: true,
            scope: {
                simpleFullname: '@',
                simpleCounter: '@'
            },
            controller: function($scope, $element) {
                $scope.groupLabel = $filter('translate')('simple_name');
                $scope.valuePh = $filter('translate')('value_ph');
                $scope.groupPh = $filter('translate')('group_ph');
                var itemCounter = 0;$scope.replacedFullname = '';
                $scope.removeItem = function($event){
                    $($event.currentTarget).closest('.row-fluid').remove();
                };
                $scope.removeGroup = function(){
                    $element.remove();
                };
                $scope.addItem = function(){
                    itemCounter++;
                    $scope.replacedFullname = $scope.simpleFullname.replace(/__name__/g, $scope.simpleCounter+'_'+itemCounter);
                    console.log('item added => itemCounter = '+itemCounter+' || replacedFullname => '+$scope.replacedFullname);
                    $element.find('.simple_container').append($compile('<div simple-item></div>')($scope));
                };
            },
            template: '<div class="row" style="margin-top: 5px;"><div class="col-xs-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default btn-flat" style="width: 120px;" type="button">{[{ groupLabel }]}</button></span><input class="form-control" type="text" ng-model="groupName" placeholder="{[{ groupPh }]}"/><span class="input-group-btn"><button ng-click="removeGroup()" class="btn btn-danger btn-flat" type="button"><i class="fa fa-trash-o"></i></button></span><span class="input-group-btn"><button ng-click="addItem()" class="btn btn-primary btn-flat" type="button"><i class="fa fa-plus-square-o"></i></button></span></div></div><div class="simple_container"></div><ng-transclude></ng-transclude></div>'
        };
    }])
    .directive('simpleItem', [function() {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            template: '<div class="row-fluid"><input name="{[{ ::replacedFullname }]}[group]" value="{[{ groupName }]}" type="hidden"/><input name="{[{ ::replacedFullname }]}[name]" value="" type="hidden"/><span class="col-xs-12" style="margin-top: 5px;"><div class="input-group"><input name="{[{ ::replacedFullname }]}[value]" class="form-control" type="text" placeholder="{[{ valuePh }]}"/><span class="input-group-btn"><button ng-click="removeItem($event)" class="btn btn-warning btn-flat" type="button"><i class="fa fa-minus-square-o"></i></button></span></div></span></div>'
        };
    }])
    .directive('aboColor', function() {
        'use strict';
        return {
            restrict: 'EA',
            replace: true,
            controller: function ( $scope, $element) {
                $scope.deleteClr = function(){$element.remove();};
            },
            scope: {aboName: '@', aboCode: '@'},
            template:   '<button type="button" id="{[{ aboCode }]}" ng-click="deleteClr()" class="btn btn-default btn-flat abo-color" style="background-color: #{[{ aboCode }]}"><i class="fa fa-circle-thin" style="opacity: 0;"></i><input name="{[{ aboName }]}" id="{[{ aboId }]}" class="form-control" value="{[{ aboCode }]}" type="hidden"/></button>'
        };
    })
    .directive('rateStar', function() {
        'use strict';
        return {
            restrict: 'EA',
            replace: false,
            scope: {rateValue: '=', starSize: '@?'},
            controller: function ( $scope ) {
                $scope.starSize = angular.isDefined($scope.starSize) ? $scope.starSize : 'lg';
                $scope.stars = {
                    'one': 'star-review star-'+$scope.starSize+' '+getClass(1),
                    'two': 'star-review star-'+$scope.starSize+' '+getClass(2),
                    'three': 'star-review star-'+$scope.starSize+' '+getClass(3),
                    'four': 'star-review star-'+$scope.starSize+' '+getClass(4),
                    'five': 'star-review star-'+$scope.starSize+' '+getClass(5)
                };
                function getClass(i){
                    if($scope.rateValue > i - 0.25)
                        return 'fa fa-star';
                    else if($scope.rateValue > i - 0.75)
                        return 'fa fa-star-half-o';
                    else
                        return 'fa fa-star-o';
                }
            },
            template:   '<i class="{[{ stars.one }]}"></i><i class="{[{ stars.two }]}"></i><i class="{[{ stars.three }]}"></i><i class="{[{ stars.four }]}"></i><i class="{[{ stars.five }]}"></i>'
        };
    })
    .directive('color', ['$compile', '$uibModal', '$filter', 'APIService', 'UtilService', 'URLService', function($compile, $uibModal, $filter, api, util, url){
        'use strict';
        return {
            restrict: 'EA',
            transclude: true,
            scope: {
                colorFullname: '@',
                colorBtn: '@'
            },
            controller: function ( $scope, $element) {
                $scope.addBtn = $filter('translate')('add_color');
                $scope.loading = false;
                $scope.colors = [];
                var options = {controller: 'InstanceModalController',size: 'lg'};
                $scope.addColors = function(){
                    var name; var html= '';
                    $element.find('.colors').html('');
                    angular.forEach($scope.colors, function(clr, key){
                        name = $scope.colorFullname.replace(/__name__/g, key);
                        html = html + '<div abo-color abo-name="'+name+'" abo-code="'+clr+'"></div>';
                    });
                    $element.find('.colors').html($compile(html)($scope));
                };
                $scope.getColors = function(){
                    $scope.loading = true;
                    var request = api.getData('GET', url.colorsUrl());
                    request . then(function successCallback(response) {
                        if(response.stat === 'success'){
                            options.template = response.template;
                            openModal(options);
                        }
                        else
                            util.notify(response.title, response.content, response.stat);
                    }, function errorCallback() {
                        util.notify($filter('translate')('error_title'), $filter('translate')('error_content'), 'danger');
                    }).finally(function finalCallback() {
                        $scope.loading = false;
                    });
                };
                function openModal(options){
                    var modalInstance = $uibModal.open(options); // process dismiss
                    modalInstance.result
                        .then(function (colors) {
                            angular.forEach(colors, function(clr){
                                if(!util.in_array(clr, $scope.colors))
                                    $scope.colors.push(clr);
                            });
                            $scope.addColors();
                        }, function() {}
                    );
                }
            },
            template:   '<div class="colors"><ng-transclude></ng-transclude></div><div class="col-xs-12" style="padding: 0;margin: 10px 0;"><button ng-click="getColors();" type="button" class="btn btn-{[{ colorBtn }]} btn-flat medium-btn pull-right"><i class="fa fa-spinner fa-spin pull-left" ng-show="loading"></i> {[{ addBtn }]}</button></div>'
        };
    }])
;
// Image Picker
(function() {
    var ImagePicker, ImagePickerOption, both_array_are_equal, sanitized_options,
        __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
        __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

    jQuery.fn.extend({
        imagepicker: function(opts) {
            if (opts == null) {
                opts = {};
            }
            return this.each(function() {
                var select;
                select = jQuery(this);
                if (select.data("picker")) {
                    select.data("picker").destroy();
                }
                select.data("picker", new ImagePicker(this, sanitized_options(opts)));
                if (opts.initialized != null) {
                    return opts.initialized.call(select.data("picker"));
                }
            });
        }
    });

    sanitized_options = function(opts) {
        var default_options;
        default_options = {
            hide_select: true,
            show_label: false,
            initialized: void 0,
            changed: void 0,
            clicked: void 0,
            selected: void 0,
            limit: void 0,
            limit_reached: void 0
        };
        return jQuery.extend(default_options, opts);
    };

    both_array_are_equal = function(a, b) {
        return jQuery(a).not(b).length === 0 && jQuery(b).not(a).length === 0;
    };

    ImagePicker = (function() {

        function ImagePicker(select_element, opts) {
            this.opts = opts != null ? opts : {};
            this.sync_picker_with_select = __bind(this.sync_picker_with_select, this);

            this.select = jQuery(select_element);
            this.multiple = this.select.attr("multiple") === "multiple";
            if (this.select.data("limit") != null) {
                this.opts.limit = parseInt(this.select.data("limit"));
            }
            this.build_and_append_picker();
        }

        ImagePicker.prototype.destroy = function() {
            var option, _i, _len, _ref;
            _ref = this.picker_options;
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                option = _ref[_i];
                option.destroy();
            }
            this.picker.remove();
            this.select.unbind("change");
            this.select.removeData("picker");
            return this.select.show();
        };

        ImagePicker.prototype.build_and_append_picker = function() {
            var _this = this;
            if (this.opts.hide_select) {
                this.select.hide();
            }
            this.select.change(function() {
                return _this.sync_picker_with_select();
            });
            if (this.picker != null) {
                this.picker.remove();
            }
            this.create_picker();
            this.select.after(this.picker);
            return this.sync_picker_with_select();
        };

        ImagePicker.prototype.sync_picker_with_select = function() {
            var option, _i, _len, _ref, _results;
            _ref = this.picker_options;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                option = _ref[_i];
                if (option.is_selected()) {
                    _results.push(option.mark_as_selected());
                } else {
                    _results.push(option.unmark_as_selected());
                }
            }
            return _results;
        };

        ImagePicker.prototype.create_picker = function() {
            this.picker = jQuery("<ul class='thumbnails image_picker_selector'></ul>");
            this.picker_options = [];
            this.recursively_parse_option_groups(this.select, this.picker);
            return this.picker;
        };

        ImagePicker.prototype.recursively_parse_option_groups = function(scoped_dom, target_container) {
            var container, option, option_group, _i, _j, _len, _len1, _ref, _ref1, _results;
            _ref = scoped_dom.children("optgroup");
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                option_group = _ref[_i];
                option_group = jQuery(option_group);
                container = jQuery("<ul></ul>");
                container.append(jQuery("<li class='group_title'>" + (option_group.attr("label")) + "</li>"));
                target_container.append(jQuery("<li>").append(container));
                this.recursively_parse_option_groups(option_group, container);
            }
            _ref1 = (function() {
                var _k, _len1, _ref1, _results1;
                _ref1 = scoped_dom.children("option");
                _results1 = [];
                for (_k = 0, _len1 = _ref1.length; _k < _len1; _k++) {
                    option = _ref1[_k];
                    _results1.push(new ImagePickerOption(option, this, this.opts));
                }
                return _results1;
            }).call(this);
            _results = [];
            for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
                option = _ref1[_j];
                this.picker_options.push(option);
                if (!option.has_image()) {
                    continue;
                }
                _results.push(target_container.append(option.node));
            }
            return _results;
        };

        ImagePicker.prototype.has_implicit_blanks = function() {
            var option;
            return ((function() {
                    var _i, _len, _ref, _results;
                    _ref = this.picker_options;
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        option = _ref[_i];
                        if (option.is_blank() && !option.has_image()) {
                            _results.push(option);
                        }
                    }
                    return _results;
                }).call(this)).length > 0;
        };

        ImagePicker.prototype.selected_values = function() {
            if (this.multiple) {
                return this.select.val() || [];
            } else {
                return [this.select.val()];
            }
        };

        ImagePicker.prototype.toggle = function(imagepicker_option) {
            var new_values, old_values, selected_value;
            old_values = this.selected_values();
            selected_value = imagepicker_option.value().toString();
            if (this.multiple) {
                if (__indexOf.call(this.selected_values(), selected_value) >= 0) {
                    new_values = this.selected_values();
                    new_values.splice(jQuery.inArray(selected_value, old_values), 1);
                    this.select.val([]);
                    this.select.val(new_values);
                } else {
                    if ((this.opts.limit != null) && this.selected_values().length >= this.opts.limit) {
                        if (this.opts.limit_reached != null) {
                            this.opts.limit_reached.call(this.select);
                        }
                    } else {
                        this.select.val(this.selected_values().concat(selected_value));
                    }
                }
            } else {
                if (this.has_implicit_blanks() && imagepicker_option.is_selected()) {
                    this.select.val("");
                } else {
                    this.select.val(selected_value);
                }
            }
            if (!both_array_are_equal(old_values, this.selected_values())) {
                this.select.change();
                if (this.opts.changed != null) {
                    return this.opts.changed.call(this.select, old_values, this.selected_values());
                }
            }
        };

        return ImagePicker;

    })();

    ImagePickerOption = (function() {

        function ImagePickerOption(option_element, picker, opts) {
            this.picker = picker;
            this.opts = opts != null ? opts : {};
            this.clicked = __bind(this.clicked, this);

            this.option = jQuery(option_element);
            this.create_node();
        }

        ImagePickerOption.prototype.destroy = function() {
            return this.node.find(".thumbnail").unbind();
        };

        ImagePickerOption.prototype.has_image = function() {
            return this.option.data("img-src") != null;
        };

        ImagePickerOption.prototype.is_blank = function() {
            return !((this.value() != null) && this.value() !== "");
        };

        ImagePickerOption.prototype.is_selected = function() {
            var select_value;
            select_value = this.picker.select.val();
            if (this.picker.multiple) {
                return jQuery.inArray(this.value(), select_value) >= 0;
            } else {
                return this.value() === select_value;
            }
        };

        ImagePickerOption.prototype.mark_as_selected = function() {
            return this.node.find(".thumbnail").addClass("selected");
        };

        ImagePickerOption.prototype.unmark_as_selected = function() {
            return this.node.find(".thumbnail").removeClass("selected");
        };

        ImagePickerOption.prototype.value = function() {
            return this.option.val();
        };

        ImagePickerOption.prototype.label = function() {
            if (this.option.data("img-label")) {
                return this.option.data("img-label");
            } else {
                return this.option.text();
            }
        };

        ImagePickerOption.prototype.clicked = function() {
            this.picker.toggle(this);
            if (this.opts.clicked != null) {
                this.opts.clicked.call(this.picker.select, this);
            }
            if ((this.opts.selected != null) && this.is_selected()) {
                return this.opts.selected.call(this.picker.select, this);
            }
        };

        ImagePickerOption.prototype.create_node = function() {
            var image, thumbnail;
            this.node = jQuery("<li/>");
            image = jQuery("<img class='image_picker_image'/>");
            image.attr("src", this.option.data("img-src"));
            thumbnail = jQuery("<div class='thumbnail' data-toggle='tooltip' title='"+this.label()+"'>");
            //thumbnail = jQuery("<div class='thumbnail'>");
            thumbnail.click({
                option: this
            }, function(event) {
                return event.data.option.clicked();
            });
            thumbnail.append(image);
            if (this.opts.show_label) {
                thumbnail.append(jQuery("<p/>").html(this.label()));
            }
            this.node.append(thumbnail);
            return this.node;
        };

        return ImagePickerOption;

    })();

}).call(this);
// file_thumbnail.js
function handleFileSelect(evt, id) {

    var id = id || "list";
    $('#'+id).html('');
    var files = evt.target.files;
    for (var i = 0, f; f = files[i]; i++) {
        var reader = new FileReader();
        reader.onload = (function(theFile) {
            return function(e) {
                $('#'+id).append('<img class="thumbnail file-img-preview" src="'+e.target.result+'" alt="'+theFile.name+'"/>');
            };
        })(f);
        reader.readAsDataURL(f);
    }
}
// filestyle.js
(function($) {"use strict";

	var Filestyle = function(element, options) {
		this.options = options;
		this.$elementFilestyle = [];
		this.$element = $(element);
	};

	Filestyle.prototype = {
		clear : function() {
			this.$element.val('');
			this.$elementFilestyle.find(':text').val('');
			this.$elementFilestyle.find('.badge').remove();
		},

		destroy : function() {
			this.$element.removeAttr('style').removeData('filestyle').val('');
			this.$elementFilestyle.remove();
		},

		disabled : function(value) {
			if (value === true) {
				if (!this.options.disabled) {
					this.$element.attr('disabled', 'true');
					this.$elementFilestyle.find('label').attr('disabled', 'true');
					this.options.disabled = true;
				}
			} else if (value === false) {
				if (this.options.disabled) {
					this.$element.removeAttr('disabled');
					this.$elementFilestyle.find('label').removeAttr('disabled');
					this.options.disabled = false;
				}
			} else {
				return this.options.disabled;
			}
		},

		buttonBefore : function(value) {
			if (value === true) {
				if (!this.options.buttonBefore) {
					this.options.buttonBefore = true;
					if (this.options.input) {
						this.$elementFilestyle.remove();
						this.constructor();
						this.pushNameFiles();
					}
				}
			} else if (value === false) {
				if (this.options.buttonBefore) {
					this.options.buttonBefore = false;
					if (this.options.input) {
						this.$elementFilestyle.remove();
						this.constructor();
						this.pushNameFiles();
					}
				}
			} else {
				return this.options.buttonBefore;
			}
		},

		icon : function(value) {
			if (value === true) {
				if (!this.options.icon) {
					this.options.icon = true;
					this.$elementFilestyle.find('label').prepend(this.htmlIcon());
				}
			} else if (value === false) {
				if (this.options.icon) {
					this.options.icon = false;
					this.$elementFilestyle.find('.glyphicon').remove();
				}
			} else {
				return this.options.icon;
			}
		},

		input : function(value) {
			if (value === true) {
				if (!this.options.input) {
					this.options.input = true;

					if (this.options.buttonBefore) {
						this.$elementFilestyle.append(this.htmlInput());
					} else {
						this.$elementFilestyle.prepend(this.htmlInput());
					}

					this.$elementFilestyle.find('.badge').remove();

					this.pushNameFiles();

					this.$elementFilestyle.find('.group-span-filestyle').addClass('input-group-btn');
				}
			} else if (value === false) {
				if (this.options.input) {
					this.options.input = false;
					this.$elementFilestyle.find(':text').remove();
					var files = this.pushNameFiles();
					if (files.length > 0 && this.options.badge) {
						this.$elementFilestyle.find('label').append(' <span class="badge">' + files.length + '</span>');
					}
					this.$elementFilestyle.find('.group-span-filestyle').removeClass('input-group-btn');
				}
			} else {
				return this.options.input;
			}
		},

		size : function(value) {
			if (value !== undefined) {
				var btn = this.$elementFilestyle.find('label'), input = this.$elementFilestyle.find('input');

				btn.removeClass('btn-lg btn-sm');
				input.removeClass('input-lg input-sm');
				if (value != 'nr') {
					btn.addClass('btn-' + value);
					input.addClass('input-' + value);
				}
			} else {
				return this.options.size;
			}
		},

		buttonText : function(value) {
			if (value !== undefined) {
				this.options.buttonText = value;
				this.$elementFilestyle.find('label span').html(this.options.buttonText);
			} else {
				return this.options.buttonText;
			}
		},

		buttonName : function(value) {
			if (value !== undefined) {
				this.options.buttonName = value;
				this.$elementFilestyle.find('label').attr({
					'class' : 'btn ' + this.options.buttonName
				});
			} else {
				return this.options.buttonName;
			}
		},

		iconName : function(value) {
			if (value !== undefined) {
				this.$elementFilestyle.find('.glyphicon').attr({
					'class' : '.glyphicon ' + this.options.iconName
				});
			} else {
				return this.options.iconName;
			}
		},

		htmlIcon : function() {
			if (this.options.icon) {
				return '<span class="glyphicon ' + this.options.iconName + '"></span> ';
			} else {
				return '';
			}
		},

		htmlInput : function() {
			if (this.options.input) {
				return '<input type="text" class="form-control ' + (this.options.size == 'nr' ? '' : 'input-' + this.options.size) + '" disabled> ';
			} else {
				return '';
			}
		},

		// puts the name of the input files
		// return files
		pushNameFiles : function() {
			var content = '', files = [];
			if (this.$element[0].files === undefined) {
				files[0] = {
					'name' : this.$element[0] && this.$element[0].value
				};
			} else {
				files = this.$element[0].files;
			}

			for (var i = 0; i < files.length; i++) {
				content += files[i].name.split("\\").pop() + ', ';
			}

			if (content !== '') {
				this.$elementFilestyle.find(':text').val(content.replace(/\, $/g, ''));
			} else {
				this.$elementFilestyle.find(':text').val('');
			}
			
			return files;
		},

		constructor : function() {
			var _self = this, 
				html = '', 
				id = _self.$element.attr('id'), 
				files = [], 
				btn = '', 
				$label;

			if (id === '' || !id) {
				id = 'filestyle-' + $('.bootstrap-filestyle').length;
				_self.$element.attr({
					'id' : id
				});
			}

			btn = '<span class="group-span-filestyle ' + (_self.options.input ? 'input-group-btn' : '') + '">' + 
				  '<label for="' + id + '" class="btn ' + _self.options.buttonName + ' ' + 
				  	(_self.options.size == 'nr' ? '' : 'btn-' + _self.options.size) + '" ' + 
				  	(_self.options.disabled ? 'disabled="true"' : '') + '>' + 
				  		_self.htmlIcon() + _self.options.buttonText + 
				  '</label>' + 
				  '</span>';

			html = _self.options.buttonBefore ? btn + _self.htmlInput() : _self.htmlInput() + btn;

			_self.$elementFilestyle = $('<div class="bootstrap-filestyle input-group">' + html + '</div>');
			_self.$elementFilestyle.find('.group-span-filestyle').attr('tabindex', "0").keypress(function(e) {
				if (e.keyCode === 13 || e.charCode === 32) {
					_self.$elementFilestyle.find('label').click();
					return false;
				}
			});

			// hidding input file and add filestyle
			_self.$element.css({
				'position' : 'absolute',
				'clip' : 'rect(0px 0px 0px 0px)' // using 0px for work in IE8
			}).attr('tabindex', "-1").after(_self.$elementFilestyle);

			if (_self.options.disabled) {
				_self.$element.attr('disabled', 'true');
			}

			// Getting input file value
			_self.$element.change(function() {
				var files = _self.pushNameFiles();

				if (_self.options.input == false && _self.options.badge) {
					if (_self.$elementFilestyle.find('.badge').length == 0) {
						_self.$elementFilestyle.find('label').append(' <span class="badge">' + files.length + '</span>');
					} else if (files.length == 0) {
						_self.$elementFilestyle.find('.badge').remove();
					} else {
						_self.$elementFilestyle.find('.badge').html(files.length);
					}
				} else {
					_self.$elementFilestyle.find('.badge').remove();
				}
			});

			// Check if browser is Firefox
			if (window.navigator.userAgent.search(/firefox/i) > -1) {
				// Simulating choose file for firefox
				_self.$elementFilestyle.find('label').click(function() {
					_self.$element.click();
					return false;
				});
			}
		}
	};

	var old = $.fn.filestyle;

	$.fn.filestyle = function(option, value) {
		var get = '', element = this.each(function() {
			if ($(this).attr('type') === 'file') {
				var $this = $(this), data = $this.data('filestyle'), options = $.extend({}, $.fn.filestyle.defaults, option, typeof option === 'object' && option);

				if (!data) {
					$this.data('filestyle', ( data = new Filestyle(this, options)));
					data.constructor();
				}

				if ( typeof option === 'string') {
					get = data[option](value);
				}
			}
		});

		if ( typeof get !== undefined) {
			return get;
		} else {
			return element;
		}
	};

	$.fn.filestyle.defaults = {
		'buttonText' : 'Choose file',
		'iconName' : 'glyphicon-folder-open',
		'buttonName' : 'btn-default',
		'size' : 'nr',
		'input' : true,
		'badge' : true,
		'icon' : true,
		'buttonBefore' : false,
		'disabled' : false
	};

	$.fn.filestyle.noConflict = function() {
		$.fn.filestyle = old;
		return this;
	};

	// Data attributes register
	$(function() {
		$('.filestyle').each(function() {
			var $this = $(this), options = {

				'input' : $this.attr('data-input') === 'false' ? false : true,
				'icon' : $this.attr('data-icon') === 'false' ? false : true,
				'buttonBefore' : $this.attr('data-buttonBefore') === 'true' ? true : false,
				'disabled' : $this.attr('data-disabled') === 'true' ? true : false,
				'size' : $this.attr('data-size'),
				'buttonText' : $this.attr('data-buttonText'),
				'buttonName' : $this.attr('data-buttonName'),
				'iconName' : $this.attr('data-iconName'),
				'badge' : $this.attr('data-badge') === 'false' ? false : true
			};

			$this.filestyle(options);
		});
	});
})(window.jQuery);

