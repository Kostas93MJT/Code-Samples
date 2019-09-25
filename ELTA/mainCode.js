
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });   
});

var app = angular.module('myApp', ['ngMaterial', 'ngMessages', 'material.svgAssetsCache']);
app.controller('myCtrl', function($scope,$http,$timeout,$mdDialog,$window,$interval) {
    $scope.loading_spinner = false;
    $scope.accountCreated = false;
    $scope.getNumber = {};
    $scope.contentAlert = '';
    $scope.titleAlert = '';
    $scope.isConnected = false;
    $scope.connectedUser = '';
    $scope.information = {};
    $scope.anamoni = true;
    $scope.anamoniEksipiretiste = false;
    var xronometrisi;
    
    $http.get('js/serverCommands.php', {
            params:{
                'type':'test'
            }
        }).then(function(response){
            $scope.aaaa = response.data;
        });
    
    $http.get('js/serverCommands.php', {
            params:{
                'type':'getCounty'
            }
        }).then(function(response){
            $scope.counties = response.data;
        });
    
    $http.get('js/serverCommands.php', {
            params:{
                'type':'isConnected'
            }
        }).then(function(response){
            if (response.data.isCon == "YES") {
                $scope.isConnected = true;
                $scope.connectedUser = response.data.user;
            } else {
                $scope.isConnected = false;
            }
        });
    
    $scope.showSelectedComp = function($event, fuse_id, index) {     
      $tooltip(angular.element($event.target), {title: 'My Title'});
    };
    
    $scope.checkEmail = function () {
        $http.get('js/serverCommands.php', {
            params:{
                'type':'checkEmail',
                'email': $scope.emailSignup
            }
        }).then(function(response){
            if (response.data == 1) 
                $scope.exists = true;
            else
                $scope.exists = false;
        });
    };
    
    $scope.printNumber = function() {
        if ($scope.isConnected) {
            var data = $.param({
                'type': 'printNumber',
                'user': $scope.connectedUser,
                'katastima': $scope.getNumber.county.IDkatastimatos,
                'douleia': $scope.getNumber.what
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };
            $http.post("js/serverCommands.php", data, config).then(function(){
                $scope.getStoreStatus();
                xronometrisi = $interval(function () {
                    $scope.getStoreStatus();
                }, 30000);
                $scope.showAdvanced();
            });
            
        } else {
            $scope.titleAlert = "Προσοχή!"
            $scope.contentAlert = "Δεν έχετε συνδεθεί σε κάποιο λογαριασμό";
            $scope.showAlert(event);
        }
    };
    
    $scope.getStoreStatus = function() {
        var data = $.param({
                'type': 'checkStoreStatus',
                'user': $scope.connectedUser
            });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("js/serverCommands.php", data, config).then(function(response){
             $scope.information = response.data;
             $scope.information.posoiPerimenoun = parseInt($scope.information.posoiPerimenoun);
             $scope.information.posaAtomaEntosTetartou = parseInt($scope.information.posaAtomaEntosTetartou);
             $scope.information.capacity = parseInt($scope.information.capacity);
             $scope.information.posoiOnline = parseInt($scope.information.posoiOnline); 
             $scope.information.counters = parseInt($scope.information.counters); 
             $scope.information.perimenounPiswApoPelati = parseInt($scope.information.perimenounPiswApoPelati);
             if ($scope.information.capacity == 0)
                 $scope.pithanotitaKathismatos = 100;
             else
                 $scope.pithanotitaKathismatos = 100 - Math.floor(($scope.information.posaAtomaEntosTetartou / $scope.information.capacity)*100);
             if (($scope.information.arithmosPelati - 1) == $scope.information.numberServiced)
                 $scope.anamoni = false;
             else if ($scope.information.arithmosPelati == $scope.information.numberServiced) {
                  $scope.anamoni = false;
                  $scope.anamoniEksipiretiste = true;
             } else if ($scope.information.arithmosPelati < $scope.information.numberServiced)
                $scope.destroyNumber();
             else
                $scope.anamoni = true;
         });
    };
    
    $scope.destroyNumber = function() {
        $interval.cancel(xronometrisi);
        var data = $.param({
                'type': 'destroyNumber',
                'user': $scope.connectedUser,
                'katastima': $scope.information.IDkatastimatos
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };
            $http.post("js/serverCommands.php", data, config).then(function(response){
                if (response.data == "OK") $scope.cancel();
                $scope.information = {};
                $scope.anamoni = true;
                $scope.anamoniEksipiretiste = false;
            });
    };
    
    $scope.logoutUser = function() {
        $http.get("do_logout.php").then(function(){
            $window.location.reload();
        });
    };
    
    $scope.loginUser = function() {
        if (!($scope.emailLogin ==undefined || $scope.passwordLogin ==undefined)) {
            var data = $.param({
                'user': $scope.emailLogin,
                'pass': $scope.passwordLogin
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };
            $http.post("do_login.php", data, config).then(function(response){
                if (response.data.status == "OK") {
                    $window.location.reload();
                } else {
                    $scope.messageError(response.data.msg);
                }
            });
        }
    };
    
    $scope.signupUser = function() {
        $scope.loading_spinner = true;
        $http.get('js/serverCommands.php', {
            params:{
                'type':'createAccount',
                'user': $scope.emailSignup,
                'pass': $scope.passwordSignup
            }
        }).then(function(response){
            $scope.emailSignup = $scope.passwordSignup = $scope.passwordSignupRE = "";
            $timeout( function(){
                $scope.loading_spinner = false;
                $scope.accountCreated = true;
            }, 2000 );
            $timeout( function(){
                $scope.accountCreated = false;
            }, 6000 );
            
        });
        
    };
    
    $scope.messageError = function(msg){
        $('.alert-danger > span').html(msg);
        $('.alert-danger').show();
        $('.alert-danger').delay(5000).slideUp(function(){
            $('.alert-danger > span').html('');
        });
    };
    
    $scope.checkNewsletter = function() {
        $http.get('js/serverCommands.php', {
            params:{
                'type':'checkNewsletter',
                'user': $scope.inputNewsletter
            }
        }).then(function(response){
            if (response.data == 0) {
                $scope.titleAlert = "Συγχαρητήρια!"
                $scope.contentAlert = "Έχετε εγγραφεί επιτυχώς στο newsletter των ΕΛΤΑ!";
            } else {
                $scope.titleAlert = "Προσοχή!"
                $scope.contentAlert = "Είστε ήδη εγεγγραμένος στο newsletter των ΕΛΤΑ!";
            }
            $scope.showAlert(event);
        });
        
    };
    
    $scope.re = /^.{6,}$/;
    $scope.status = '  ';
    $scope.customFullscreen = false;
    
    $scope.showAlert = function(ev) {
    // Appending dialog to document.body to cover sidenav in docs app
    // Modal dialogs should fully cover application
    // to prevent interaction outside of dialog
    $mdDialog.show(
      $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title($scope.titleAlert)
        .textContent($scope.contentAlert)
        .ariaLabel('Alert Dialog Demo')
        .ok('ΕΓΙΝΕ')
        .targetEvent(ev)
    );
  };
  
    $scope.showAdvanced = function() {
        $mdDialog.show({
            controller: function () { this.parent = $scope; },
            controllerAs: 'ctrl2',
            templateUrl: 'dialog1.tmpl.html',
            clickOutsideToClose:false,
            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
        })
            .then(function(answer) {
            $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
            $scope.status = 'You cancelled the dialog.';
        });
    };
    
    $scope.showTabDialog = function(ev) {
        $mdDialog.show({
            controller: function () { this.parent = $scope; },
            controllerAs: 'ctrl',
            templateUrl: 'tabDialog.tmpl.html',
            targetEvent: ev,
            clickOutsideToClose:true
        }).then(function(answer) {
            $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
            $scope.status = 'You cancelled the dialog.';
        });
    };
    

    $scope.hide = function() {
      $mdDialog.hide();
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    $scope.answer = function(answer) {
      $mdDialog.hide(answer);
    };

});