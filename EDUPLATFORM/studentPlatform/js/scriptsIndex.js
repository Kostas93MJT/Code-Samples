//Accordion
(function ($) {
$(document).ready(function() {
$('#cssmenu > ul > li > a').click(function() {
  $('#cssmenu li').removeClass('active');
  $(this).closest('li').addClass('active');	
  var checkElement = $(this).next();
  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
    $(this).closest('li').removeClass('active');
    checkElement.slideUp('normal');
  }
  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
    $('#cssmenu ul ul:visible').slideUp('normal');
    checkElement.slideDown('normal');
  }
  if($(this).closest('li').find('ul').children().length == 0) {
    return true;
  } else {
    return false;	
  }		
});
});
})(jQuery);

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}

var app = angular.module("crudApp", ["ngAnimate",'ngRoute','datatables', 'ngMaterial', 'ngMessages', 'material.svgAssetsCache', 'chasselberg.slider','ngFileUpload','mwl.calendar', 'ui.bootstrap','toastr']);

angular
    .module('crudApp')
    .factory('alert', function($uibModal) {

    function show(action, event) {
      return $uibModal.open({
        templateUrl: 'modalContent.html',
        controller: function() {
          var vm = this;
          vm.action = action;
          vm.event = event;
        },
        controllerAs: 'vm'
      });
    }

    return {
      show: show
    };

  });

app.directive("fileInput", function($parse){  
      return{  
           link: function($scope, element, attrs){  
                element.on("change", function(event){  
                     var files = event.target.files;  
                     //console.log(files[0].name);  
                     $parse(attrs.fileInput).assign($scope, element[0].files);  
                     $scope.$apply();
                });  
           }  
      }  
 });

app.directive('validFile',function(){
  return {
      require:'ngModel',
      link:function(scope,el,attrs,ngModel){
          //change event is fired when file is selected
          el.bind('change',function(){
              scope.$apply(function(){
                  ngModel.$setViewValue(el.val());
                  ngModel.$render();
              });
          });
      }
  }
});

app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

app.filter('unsafe', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});

app.animation('.slide-toggle-js', function(){
  return {
    enter: function(element, done) {
      $(element).hide().slideDown(function(){
          done();
        });
    },
    leave: function(element, done) {
      $(element).slideUp(function(){
          done();
        });      
    }
  };  
});

app.config(function(toastrConfig) {
    angular.extend(toastrConfig, {
        autoDismiss: false,
        containerId: 'toast-container',
        maxOpened: 0,    
        newestOnTop: true,
        timeOut: 8000,
        extendedTimeOut: 2000,
        progressBar: true,
        positionClass: 'toast-bottom-right',
        preventDuplicates: true,
        preventOpenDuplicates: true,
        target: 'body'
    });
});

app.controller("crudController", function($scope, $http, $interval, moment, alert, calendarConfig, toastr){
    
    var quotesKalwsorismatos = [{item1: 'Η πλατφόρμα σου είναι πανέτοιμη!', item2: 'Γειά χαρά!'},{item1:'Έλα να μαζευόμαστε σιγά σιγά!', item2:'Σε περιμέναμε...'},{item1:'Η πλατφόρμα σου σε περιμένει!', item2:'Άντε που είσαι;'}];
    var y = 0;
    
    // ALGORITHM NOTIFICATION WINDOW CODE HERE
    $interval( $scope.repeatAlgorithmNotifications , 35000, 12);

    $scope.repeatAlgorithmNotifications = function () {
        if ($scope.ulikoGiaProtaseisAlgorithmou[y].gnwsiako == "idio") {
            toastr.success('<br><strong style="font-size:110%">"' + $scope.ulikoGiaProtaseisAlgorithmou[y].titlos + '"</strong> για το μάθημα <strong>' + $scope.ulikoGiaProtaseisAlgorithmou[y].mathima + '</strong><br><br> Θα σε βοηθήσει στη κατανόηση της θεωρίας που διαβάζεις', '<i class="fa fa-info-circle"></i>  &nbsp;Δοκίμασε να ρίξεις μια ματιά σε αυτό! <img src="css/icons/' + $scope.ulikoGiaProtaseisAlgorithmou[y].helper + '_idio.gif" height="110px" width="110px" align="right">', {
            allowHtml: true });
        } else {
            toastr.success('<br><strong style="font-size:110%">"' + $scope.ulikoGiaProtaseisAlgorithmou[y].titlos + '"</strong> για το μάθημα <strong>' + $scope.ulikoGiaProtaseisAlgorithmou[y].mathima + '</strong><br><br> Θα σε βοηθήσει να εξελίξεις τις γνώσεις σου πάνω στο μάθημα', '<i class="fa fa-info-circle"></i>  &nbsp;Μήπως να τσεκάρεις και αυτό εδώ; <img src="css/icons/' + $scope.ulikoGiaProtaseisAlgorithmou[y].helper + '_anwtero.gif" height="110px" width="110px" align="right">', {
            allowHtml: true });
        }
        y++;
    };
    // END ALGORITHM NOTIFICATION WINDOW CODE
    
    // ANGULAR CALENDAR CODE HERE
    var vm = this;
    //These variables MUST be set as a minimum for the calendar to work
    vm.calendarView = 'month';
    vm.viewDate = new Date();
    
    vm.cellIsOpen = false;

    vm.eventClicked = function(event) {
      alert.show('Clicked', event);
    };

    vm.eventEdited = function(event) {
      alert.show('Edited', event);
    };

    vm.eventDeleted = function(event) {
      alert.show('Deleted', event);
    };

    vm.eventTimesChanged = function(event) {
      alert.show('Dropped or resized', event);
    };

    vm.toggle = function($event, field, event) {
      $event.preventDefault();
      $event.stopPropagation();
      event[field] = !event[field];
    };
    
    vm.timespanClicked = function(date, cell) {
        
      if (vm.calendarView === 'month') {
        if ((vm.cellIsOpen && moment(date).startOf('day').isSame(moment(vm.viewDate).startOf('day'))) || cell.events.length === 0 || !cell.inMonth) {
          vm.cellIsOpen = false;
        } else {
          vm.cellIsOpen = true;
          vm.viewDate = date;
        }
      } else if (vm.calendarView === 'year') {
        if ((vm.cellIsOpen && moment(date).startOf('month').isSame(moment(vm.viewDate).startOf('month'))) || cell.events.length === 0) {
          vm.cellIsOpen = false;
        } else {
          vm.cellIsOpen = true;
          vm.viewDate = date;
        }
      }

    };
    
    $scope.translateMonth = function(orisma) {
        var moumou = orisma.replace(/January/g,"Ιανουάριος").replace(/February/g,"Φεβρουάριος").replace(/March/g,"Μάρτιος").replace(/April/g,"Απρίλιος").replace(/May/g,"Μάϊος").replace(/June/g,"Ιούνιος").replace(/July/g,"Ιούλιος").replace(/August/g,"Αύγουστος").replace(/September/g,"Σεπτέμβριος").replace(/October/g,"Οκτώβριος").replace(/November/g,"Νοέμβριος").replace(/December/g,"Δεκέμβριος").replace(/Week/g,"Εβδομάδα").replace(/of/g,"του");
        return moumou;
    };
    
    $scope.viewProgramma = function(){
        var data = $.param({
            'type': 'viewProgramma'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            var viewProgramma = response.data;
            for (var i = 0; i < viewProgramma.length; i++) {
                if (viewProgramma[i].tieinai == "proj") {
                    vm.events.push({
                    title: '<span style="font-weight:bold; color:white; text-shadow: 2px 2px 4px #000">' + viewProgramma[i].mathima + ':</span> &nbsp;<i>' + viewProgramma[i].titlos + '</i>',
                    startsAt: viewProgramma[i].arxi,
                    endsAt: viewProgramma[i].telos,
                    color: { primary: '#ad2121', secondary: '#FAE3E3'},
                    draggable: true,
                    resizable: true
                    });     
                } else if (viewProgramma[i].tieinai == "meet") {
                    vm.events.push({
                    title: '<span style="font-weight:bold; color:white; text-shadow: 2px 2px 4px #000">' + viewProgramma[i].mathima + ':</span> &nbsp;<i>' + viewProgramma[i].titlos + '</i>',
                    startsAt: viewProgramma[i].arxi,
                    endsAt: viewProgramma[i].telos,
                    color: { primary: '#e3bc08', secondary: '#FDF1BA'},
                    draggable: true,
                    resizable: true
                    });
                } else {
                    vm.events.push({
                    title: '<span style="font-weight:bold; color:white; text-shadow: 2px 2px 4px #000">' + viewProgramma[i].mathima + ':</span> &nbsp;<i>' + viewProgramma[i].titlos + '</i>',
                    startsAt: viewProgramma[i].arxi,
                    endsAt: viewProgramma[i].telos,
                    color: { primary: '#1e90ff', secondary: '#D1E8FF'},
                    draggable: true,
                    resizable: true
                    });
                }
                
            }
        });
    };
    
    $scope.addUserPollanswer = function(apantisi) {
        var data = $.param({
            'type': 'addUserPollanswer',
            'data': apantisi
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            $scope.getAllAnnouncements('refreshPolls');
        });
    }
    
    // END CALENDAR CODE HERE
    $scope.ulikoGiaProtaseisAlgorithmou = {};
    $scope.notifications = {};
    $scope.userPolls = {};
    $scope.currentPagePolls = 0;
    $scope.pageSizePolls = 1;
    
    $scope.uparxeiEidopoihsh = true;
    
    $scope.currentPage = 0;
    $scope.pageSize = 5;
    $scope.anakoinwseis = {};
    
    // GET ALL ANNOUNCEMENTS AND USER POLLS
    $scope.getAllAnnouncements = function(eidos){
        var data;
        var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };
        if (eidos == "refreshAll") {
            data = $.param({
                'type': 'getAllAnnouncements'
            });  
            $http.post("crud.php", data, config).then(function(response){
                $scope.anakoinwseis = response.data.records;
                $scope.numberOfPages = Math.ceil($scope.anakoinwseis.length/$scope.pageSize);
            });
        }
        data = $.param({
            'type': 'getUserPolls'
        });
        $http.post("crud.php", data, config).then(function(response){
            $scope.userPolls = response.data;
            $scope.numberOfPagesPolls = Math.ceil($scope.userPolls.length/$scope.pageSizePolls);
        });
    };
    
    // GET USERID, LASTLOGIN, IMEROMHNIA GENNISIS KAI MHNYMA KALWSORISMATOS
    $scope.getEggegramenaMathimata = function(){
        var data = $.param({
            'type': 'EggegrammenaMathimata'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            $scope.EggegramenaMathimata = response.data[0].map(function(e) {
                return e;
            });
            $scope.userID = response.data[1];
            $scope.lastLogin = response.data[2];
            $scope.imerominiaGennisis = response.data[3];
            $scope.ebdomadaDidaskalias = response.data[4];
            var temp = response.data[5];
            toastr.success($scope.kalwsorisma.item1, $scope.kalwsorisma.item2 + ' <img src="css/icons/' + temp + '_welcome.gif" height="80px" width="120px" align="right">', {allowHtml: true});
        });
    };
    
    $scope.notificationsSeen = function (){
        var data = $.param({
            'type': 'notificationsSeen'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
                $('.count').html(0);
        });  
    };
    
    // EDW PAIRNEI KAI EIDOPOIHSEIS KAI EIDOPOIHSEIS ALGORITHMOU
    $scope.getNotifications = function() {
        $scope.kalwsorisma = quotesKalwsorismatos[Math.floor(Math.random()*3)];
        var data = $.param({
            'type': 'getNotifications'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            $scope.notifications = response.data.records;
            var count = 0;
            for (var k in $scope.notifications) {
                if ($scope.notifications.hasOwnProperty(k)) {
                    ++count;
                }
            }
            $('.count').html(count);
            if (count == 0) {
                $scope.uparxeiEidopoihsh = false;
            }
        });
        data = $.param({
            'type': 'algorithmNotifications'
        });
        $http.post("crud.php", data, config).then(function(response){
            $scope.ulikoGiaProtaseisAlgorithmou = response.data;
        });
    };
});

app.animation('.reveal-animation', function() {
    return {
        enter: function(element, done) {
            element.css('display', 'none');
            element.fadeIn(500, done);
            return function() {
                element.stop();
            }
        },
        leave: function(element, done) {
            element.fadeOut(300, done)
            return function() {
                element.stop();
            }}
  }
});

app.config(function($routeProvider) {
    $routeProvider
    .when("/course/:idmathima/:iduser", {
        templateUrl : "templates/mathimaYlika.php",
        controller : "mathimaYlika"
    })
    .when("/assignment/:iduser", {
        templateUrl : "templates/ergasiesMathiti.php",
        controller : "ergasiesMathiti"
    })
    .when("/home", {
        templateUrl : "templates/arxikiPlatformas.php",
        controller : "crudController"
    })
    .when("/contact", {
        templateUrl : "templates/contact.html",
        controller : "contactController"
    })
    .otherwise({
        templateUrl: "templates/arxikiPlatformas.php",
        controller : "crudController"
    })
});

app.controller("ergasiesMathiti", function ($scope, $http, $routeParams, Upload, $timeout, $route, $window) {
    $scope.dedomena = {};
    $scope.ergasies = {};
    $scope.dedomena.name = $routeParams.iduser;
    $scope.uparxeiData = false;
    
    $scope.uploadErgasia = function(file,iderg) {
        file.upload = Upload.upload({
            url: 'uploadErgasia.php',
            data: {username: $scope.dedomena.name, idergasias: iderg, file: file},
        });

        file.upload.then(function (response) {
            $timeout(function () {
                //file.result = true;
                $timeout(function() { 
                    $window.alert('Το αρχείο ανέβηκε με επιτυχία! Η σελίδα θα ανανεωθεί αυτόματα'); 
                    $route.reload(); 
                    //$window.location.reload();
                }, 2000);
                //uparxei kai to $route.reload(); 
            });
        }, function (response) {
            if (response.status > 0)
                $scope.errorMsg = response.status + ': ' + response.data;
        }, function (evt) {
            // Math.min is to fix IE which reports 200% sometimes
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
    };
    
   $scope.getErgasies = function() {
        var data = $.param({
            'data': $scope.dedomena,
            'type': 'getErgasiestemp'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            if (response.data == 'NO DATA'){
                $scope.uparxeiData = false;
            } else {
                $scope.uparxeiData = true;
                $scope.Ergasies = response.data;
                var alreadyupload = 'alreadyupload';
                for (var i = 0; i < (response.data.length + 1); i++) {
                    if ($scope.Ergasies[i].onomaPDF != null) {
                        $scope[alreadyupload + i] = true;
                    } 
                }
            }   
        });
       
    };
    
});

app.controller("mathimaYlika", function ($scope, $http, $routeParams, DTOptionsBuilder, DTColumnBuilder, $mdDialog) {
    $scope.cruds = [];
    $scope.dedomena = {};
    $scope.dedomena.id = $routeParams.idmathima;
    $scope.dedomena.name = $routeParams.iduser;
    $scope.vm = {};
    $scope.currentPageByMathima = 0;
    $scope.pageSizeByMathima = 5;
    $scope.anakoinwseisByMathima = {};
    $scope.stateJS = true;
    
    var lang = {
    "decimal":        "",
    "emptyTable":     "Δεν υπάρχουν δεδομένα",
    "info":           "Προβολή _START_ έως _END_ από _TOTAL_ καταχωρήσεις",
    "infoEmpty":      "0 καταχωρήσεις",
    "infoFiltered":   "(από τις _MAX_ συνολικές καταχωρήσεις)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Εμφάνιση _MENU_ καταχωρήσεων",
    "loadingRecords": "Φόρτωση...",
    "processing":     "Επεξεργασία...",
    "search":         "Αναζήτηση:",
    "zeroRecords":    "Δεν βρέθηκαν καταχωρήσεις",
    "paginate": {
        "first":      "Πρώτο",
        "last":       "Τελευταίο",
        "next":       "Επόμενο",
        "previous":   "Προηγούμενο"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}

    $scope.vm.dtOptions = DTOptionsBuilder.newOptions()
        .withOption('order', [0, 'asc'])
        .withOption('language', lang)
    
    $scope.getAllAnnouncementsByMathima = function(){
        var data = $.param({
            'data': $scope.dedomena,
            'type': 'getAllAnnouncementsByMathima'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            $scope.anakoinwseisByMathima = response.data.records;
            $scope.numberOfPagesByMathima = Math.ceil($scope.anakoinwseisByMathima.length/$scope.pageSizeByMathima);
        });
    };
    
    $scope.getSummathitesGnwsiako = function(){
        var data = $.param({
            'data': $scope.dedomena,
            'type': 'getSummathitesGnwsiako'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            $scope.getSummathitesGnwsiako = response.data;
        });
    };
    
    $scope.getTmimaDaskalos = function() {
        var data = $.param({
            'data': $scope.dedomena,
            'type': 'getTmimaDaskalos'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            $scope.tmima = response.data.tmima;
            $scope.dedomena.onomaKathigiti = response.data.kathigitisOnoma;
            $scope.emailKathigiti = response.data.kathigitisEmail;
            $scope.dedomena.usernameKathigiti = response.data.kathigitisUsername;
            $scope.epipedoGnwsis = response.data.epipedoGnwsis;
        });
    };
    
    $scope.getDidaktikaYlika = function() {
        var data = $.param({
            'data': $scope.dedomena,
            'type': 'getDidaktikaYlika'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud.php", data, config).then(function(response){
            $scope.cruds = response.data.records;
        });
    };
    
    $scope.infoModal = {};
    $scope.apantiseisModal = {};
    $scope.customFullscreen = false;
    $scope.infoModal.katebasmaArxeiou = false;
    
    $scope.showTabDialog = function(ev, crud) {
        $scope.infoModal = crud;
        switch ($scope.epipedoGnwsis) {
            case "ΑΡΧΑΡΙΟ":
                if (crud.gnwsiakoEpipedo == "ΑΡΧΑΡΙΟ")
                    $scope.infoModal.xrwma = "#14d114";
                else if (crud.gnwsiakoEpipedo == "ΚΑΝΟΝΙΚΟ")
                    $scope.infoModal.xrwma = "#f9841d";
                else
                    $scope.infoModal.xrwma = "#ef4126";
                break;
            case "ΚΑΝΟΝΙΚΟ":
                if (crud.gnwsiakoEpipedo == "ΚΑΝΟΝΙΚΟ")
                    $scope.infoModal.xrwma = "#14d114";
                else if (crud.gnwsiakoEpipedo == "ΥΨΗΛΟ")
                    $scope.infoModal.xrwma = "#f9841d";
                else
                    $scope.infoModal.xrwma = "#ef4126";
                break;
            case "ΥΨΗΛΟ":
                if (crud.gnwsiakoEpipedo == "ΥΨΗΛΟ")
                    $scope.infoModal.xrwma = "#14d114";
                else if (crud.gnwsiakoEpipedo == "ΠΟΛΥ ΥΨΗΛΟ")
                    $scope.infoModal.xrwma = "#f9841d";
                else
                    $scope.infoModal.xrwma = "#ef4126";
                break;
            case "ΠΟΛΥ ΥΨΗΛΟ":
                if (crud.gnwsiakoEpipedo == "ΠΟΛΥ ΥΨΗΛΟ")
                    $scope.infoModal.xrwma = "#14d114";
                else
                    $scope.infoModal.xrwma = "#ef4126";
                break;
        }
        $scope.apantiseisModal.IDmaterial = crud.IDmaterial; 
        $scope.getSliderValue(crud);
        if (crud.biblio == 'ΠΡΟΣΘΕΤΑ ΥΛΙΚΑ')
            $scope.infoModal.katebasmaArxeiou = true;
        else
            $scope.infoModal.katebasmaArxeiou = false;
        $mdDialog.show({
            targetEvent: ev,
            controller: function () { this.parent = $scope; },
            controllerAs: 'ctrl',
            templateUrl: 'tabDialog.tmpl.html',
            clickOutsideToClose:true
        })
            .then(function(answer) {
                var data = $.param({
                    'data': $scope.apantiseisModal,
                    'type': 'aksiologisiYlikou'
                });
                var config = {
                    headers : {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }
                };
                if (answer == 'Τα δεδομένα ανανεώθηκαν με επιτυχία!') {
                    $http.post("crud.php", data, config).then(function(){
                            $scope.apantiseisModal = {};
                            $('#alertDedomena').slideDown();
                            $('#alertDedomena').delay(3000).slideUp();
                        });
                }
            }, function() {
                $scope.apantiseisModal = {};
            });
    };

    $scope.getSliderValue = function(dedomena) {
        var data = $.param({
                    'data': dedomena,
                    'type': 'getSliderValue'
                });
                var config = {
                    headers : {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }
                };
                $http.post("crud.php", data, config).then(function(response){
                    if (response.data.msg == 'NO'){
                        $scope.sliderValue = 1;
                    } else {
                        $scope.sliderValue = response.data.gnwsiako;
                        $scope.apantiseisModal.epipleonYliko = response.data.epipleon;
                        $scope.apantiseisModal.teleutaiaProv = response.data.teleutaiaProv;
                        $scope.apantiseisModal.teleutaiaProvTrue = response.data.teleutaiaProvTrue;
                    }
                    return;
                });
    };
    
    $scope.$watch('sliderValue', function() {
        switch ($scope.sliderValue) {
            case 1:
                $scope.katanohsh = 'ΚΑΘΟΛΟΥ';
                $scope.apantiseisModal.katanohsh = 'ΚΑΘΟΛΟΥ'
                break;
            case 2:
                $scope.katanohsh = 'ΛΙΓΟ';
                $scope.apantiseisModal.katanohsh = 'ΑΡΧΑΡΙΟ';
                break;
            case 3:
                $scope.katanohsh = 'ΜΕΤΡΙΑ';
                $scope.apantiseisModal.katanohsh = 'ΚΑΝΟΝΙΚΟ';
                break;
            case 4:
                $scope.katanohsh = 'ΚΑΛΑ';
                $scope.apantiseisModal.katanohsh = 'ΥΨΗΛΟ';
                break;
            case 5:
                $scope.katanohsh = 'ΠΟΛΥ ΚΑΛΑ';
                $scope.apantiseisModal.katanohsh = 'ΠΟΛΥ ΥΨΗΛΟ';
                break;
        }
    });
    
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

app.controller("contactController", function ($scope, $http) {
    $scope.showCrudData = {};
    
    $scope.sentMail = function() {
        $scope.showCrudData = {};
        $scope.myform.$setPristine();
        $('#stalthike').show(200);
        $('#stalthike').delay(4000).hide(200);
    };
});
