$(document).ready(function(){
    $('textarea#froala-editor').froalaEditor({width: '900',placeholderText: "Πληκτρολογήστε το περιεχόμενο της ανακοίνωσης..."});
});

var app = angular.module("crudApp", ['datatables', 'ngSanitize']);

app.directive('pctComplete', function() {
  return {
    restrict: 'E',
    replace: true,
    scope: {
      value: '='
    },
    template: ' <div class="c100 p{{value}} big blue">\
                      <span>{{value}}%</span>\
                      <div class="slice">\
                        <div class="bar"></div>\
                        <div class="fill"></div>\
                      </div>\
                    </div>'
  };
});

app.controller("crudController", function($scope,$http, $location, $anchorScroll, DTOptionsBuilder, DTColumnBuilder){ 
    $scope.cruds = [];
    $scope.showCrudData = {};
    $scope.showMathitesApantiseis = {};
    $scope.vm = {};

    $scope.opo = 45;
    
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

    $scope.getCruds = function(){
        $http.get('crud4.php', {
            params:{
                'type':'view'
            }
        }).then(function(response){
            $scope.cruds = response.data;
        });
    };
    
    $scope.saveData = function() {
        var html = $('textarea#froala-editor').froalaEditor('html.get');
        $scope.showCrudData.periexomeno = JSON.stringify(html);
        var data = $.param({
            'data':$scope.showCrudData,
            'type':'add'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud4.php", data, config).then(function(response){
            if(response.data.status == 'OK'){
                $scope.getCruds(); 
                $scope.myform.$setPristine();
                $scope.showCrudData = {};
                $scope.messageSuccess(response.data.msg);
            }else{
                $scope.messageError(response.data.msg);
            }
        });
    };
    
    $scope.getDimoskopiseis = function () {
        $http.get('crud4.php', {
            params:{
                'type':'viewDimoskopiseis'
            }
        }).then(function(response){
            $scope.showDimoskopiseis = response.data.dimoskopisi;
        });
    };
    
    $scope.saveDimoskopisi = function () {
        var data = $.param({
            'data':$scope.showCrudData,
            'type':'saveDimoskopisi'
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("crud4.php", data, config).then(function(response){
            if(response.data.status == 'OK'){
                $scope.getDimoskopiseis(); 
                $scope.myform2.$setPristine();
                $scope.showCrudData = {};
                $('#alert2').show(100);
                $('#alert2').delay(5000).hide(100);
            }else{
                $scope.messageError(response.data.msg);
            }
        });
    };
    
    $scope.showMathitesAnswers = function(dimoskopisi, what) {
        if (what == "show") {
            $scope.showMathitesApantiseis = dimoskopisi.mathites;
            $location.hash('scrollPanw');
            $anchorScroll();
        } else if (what == "delete"){
            var conf = confirm('Θέλετε σίγουρα να διαγράψετε την δημοσκόπηση?');
            if(conf === true){
                var data = $.param({
                    'id': dimoskopisi.IDpoll,
                    'type':'deleteDimoskopisi'    
                });
                var config = {
                    headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }    
                };
                $http.post("crud4.php",data,config).then(function(response){
                    if(response.data.status == 'OK'){
                        $('#alert3').show(200);
                        $('#alert3').delay(5000).hide(200);
                        $scope.getDimoskopiseis();
                    }else{
                        $scope.messageError(response.data.msg);
                    }
                });
            }
        } else {
            $scope.showMathitesApantiseis = {};
            $location.hash('scrollKatw');
            $anchorScroll();
        }
    };
    
    $scope.deleteData = function(crud){
        var conf = confirm('Θέλετε σίγουρα να διαγράψετε την ανακοίνωση?');
        if(conf === true){
            var data = $.param({
                'id': crud.IDannouncement,
                'type':'delete'    
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }    
            };
            $http.post("crud4.php",data,config).then(function(response){
                if(response.data.status == 'OK'){
                    var index = $scope.cruds.indexOf(crud);
                    $scope.cruds.splice(index,1);
                    $scope.messageSuccess(response.data.msg);
                }else{
                    $scope.messageError(response.data.msg);
                }
            });
        }
    };
    
    $scope.messageSuccess = function(msg){
        $('#alert-success1 > p').html(msg);
        $('#alert-success1').show();
        $('#alert-success1').delay(5000).slideUp(function(){
            $('#alert-success1 > p').html('');
        });
    };
    
    $scope.messageError = function(msg){
        $('#alert-danger1 > p').html(msg);
        $('#alert-danger1').show();
        $('#alert-danger1').delay(5000).slideUp(function(){
            $('#alert-danger1 > p').html('');
        });
    };
});