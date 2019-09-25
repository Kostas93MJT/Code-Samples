<?php
   include('session.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/progressCircle.css">
      
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="js/angular-datatables.min.js"></script>

    <!-- FROALA EDITOR INCLUDES. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_editor.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_style.min.css" rel="stylesheet" type="text/css" />
    <style>
        #forma1 {
            display: inline-block;
            margin: 0 20px 0 0; }

        #forma2 {
            display: block;
            margin: 0 20px 0 0; }
        .fr-quick-insert { display: none; }
        
        .modal-lg {
            max-width: 90%;
        }

        /* The Modal (background) */
        .modal {
            padding-top: 10%;
        }
    </style>
</head>
    <body ng-app="crudApp">
        <div class="content" ng-controller="crudController" ng-init="getCruds(); getDimoskopiseis()">
            <div class="row" style="margin-top:-5px">
                <div style="margin-left: 160px">
                    <h1 style="border-bottom: 1px solid #ed8151; font-size: 30px; color: #ed8151">Ανακοινώσεις</h1><br/>
                       <table class="table table-hover" datatable="ng" dt-options="vm.dtOptions" dt-columns="dtColumns" style="margin-top:20px;" id="scrollPanw">
                           <thead>
                            
                               <tr>
                                   <th>N/N</th>
                                   <th>Χρήστης</th>
                                   <th>Θέμα</th>
                                   <th>Τίτλος</th>
                                   <th>Περιεχόμενο</th>
                                   <th>Ημερομηνία</th>
                                   <th> </th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr ng-repeat="crud in cruds">
                                   <td>{{$index + 1}}</td>
                                   <td>{{crud.anebikeApo}}</td>
                                   <td>{{crud.thema}}</td>
                                   <td>{{crud.titlos}}</td>
                                   <td ng-bind-html="crud.periexomeno + '.. [...]' ">[...]</td>
                                   <td>{{crud.imerominia}}</td>
                                   <td><a href="javascript:void(0);" ng-click="deleteData(crud)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Διαγραφή</a></td>
                               </tr>
                           </tbody>
                       </table><br/>
                    <br/>
                    <fieldset style="margin-left:100px; width:900px">
                        <legend style="border-bottom: .5px solid gray">Προσθήκη ανακοίνωσης</legend>
                        <form name="myform">
                            <div id="forma1" class="form-group" style="margin-top:15px">
                                <label id="forma2" for="kefalaiotitlos">Θέμα <font color="#EB0000" >*</font></label>
                                <select style="width: 300px; margin-top:5px" id="thema" name="thema" ng-model="showCrudData.thema" class="form-control" required>
                                    <option value="" disabled>Επιλέξτε...</option>
                                    <option value="Διδακτικό Υλικό">Διδακτικό Υλικό</option>
                                    <option value="Γραπτή Εργασία">Γραπτή Εργασία</option>
                                    <option value="Συνάντηση">Συνάντηση</option>
                                    <option value="Άλλο">Άλλο</option>
                                </select>
                            </div>
                            <div id="forma1" class="form-group" style="margin-top:10px">
                                <label id="forma2" for="titlos">Τίτλος <font color="#EB0000" >*</font></label>
                                <input type="text" style="width: 580px; margin-top:5px;" id="titlos" name="titlos" ng-model="showCrudData.titlos" class="form-control" required />
                            </div><br/><br/>
                            <div id="forma1" class="form-group" style="margin-top:10px">
                                <label id="forma2" for="periexomeno">Περιεχόμενο <font color="#EB0000" >*</font></label><br/>
                                <textarea id="froala-editor" name="periexomeno" required></textarea>
                            </div><br/>
                            <div class="alert alert-danger" id="alert-danger1" style="display:none;width:900px"><p></p></div>
                            <div class="alert alert-success" id="alert-success1" style="display:none;width:900px"><p></p></div>
                            <button class="btn btn-primary" style="margin-top:25px;" ng-click="saveData()" >Αποθήκευση</button>
                            <button class="btn btn-light" style="margin-top:25px; border:1px solid gray" type="reset">Καθαρισμός</button>
                        </form>
                     </fieldset>
                </div>
            </div><br>
   
               
            <div class="row">
                <div style="margin-left: 160px; margin-top:50px;">
                    
                    <h1 style="border-bottom: 1px solid #ed8151; font-size: 30px; color: #ed8151">Δημοσκοπήσεις</h1>
                    
                    <br/>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm" style="text-align: justify;">
                               Δημιουργήστε δημοσκοπήσεις που θα σας βοηθήσουν να κατανοήσετε καλύτερα τις ανάγκες των μαθητών σας. Οι απαντήσεις μπορούν να είναι μόνο καταφατικές ή αρνητικές. <br/><br/> Αφού φτιάξετε τη δημοσκόπηση και μόλις ληφθεί τουλάχιστον μία θετική απάντηση, θα μπορείτε να παρακολουθείτε την εξέλιξη της αλλά και την απάντηση που έδωσε κάθε μαθητής. <br/><br/> Προσθέστε νέες δημοσκοπήσεις με τη χρήση της <label  for="titlosDimoskop" style="font-weight:bold">δίπλα φόρμας </label>.
                            </div>
                            <div class="col-sm">   
                                <form name="myform2" style="border: 2px solid gray; padding:5px 17px 17px 17px">
                                    <fieldset>
                                        <legend>Νέα δημοσκόπηση</legend>
                                        <div id="forma1" class="form-group" style="margin-top:8px">
                                            <label id="forma2" for="titlosDimoskop">Τίτλος δημοσκόπησης <font color="#EB0000" >*</font></label>
                                            <input type="text" style="width: 500px; margin-top:5px;" id="titlosDimoskop" name="titlosDimoskop" ng-model="showCrudData.titlosDimoskop" class="form-control" required />
                                        </div>
                                        <div id="forma1" class="form-group" style="margin-top:10px">
                                            <label id="forma2" for="periexomenoDimoskop">Περιεχόμενο <font color="#EB0000" >*</font></label>
                                            <textarea rows="3" type="text" style="width: 500px; margin-top:5px; resize: none" id="periexomenoDimoskop" name="periexomenoDimoskop" ng-model="showCrudData.periexomenoDimoskop" class="form-control" placeholder="Πληκτρολογήστε το ερώτημα που θέλετε να θέσετε..." required ></textarea>
                                        </div>
                                        <button class="btn btn-primary" style="margin-top:20px" ng-click="saveDimoskopisi()">Καταχώρηση</button><span id="alert2" style="color:green; display:none;" > &ensp; *Επιτυχής καταχώρηση!</span>
                                    </fieldset>
                                </form>
                            </div>
                        </div><br/><br/>
                        
                        <legend style="font-weight:bold" id="scrollKatw"><i class="fas fa-signal"> </i> Επισκόπηση καταχωρημένων δημοσκοπήσεων</legend><span id="alert3" style="color:green; display:none;" > &ensp; *Επιτυχής διαγραφή!</span>
                        <div class="row" style="border:2px solid #e5e5e5; border-radius:15px; padding: 15px 15px 5px 15px;  margin-top:30px" ng-repeat="dimoskopisi in showDimoskopiseis">
                            <div class="col-sm-1" style="display: flex;align-items: center;justify-content: center;"> 
                                <h1 style="color: #00479e"># {{$index + 1}}</h1>
                            </div>
                            <div class="col-sm-2"> 
                                <pct-complete value="dimoskopisi.tisekatoNAI"></pct-complete><br/>
                            </div>
                            <div class="col-sm-2" style="display: flex;align-items: center;justify-content: center;"> 
                                <span style="margin-left:20%; font-weight:bold">των μαθητών απάντησαν θετικά</span>
                            </div>
                            <div class="col-sm" style="border-left:1px solid #00479e;">
                                <h3 style="display:inline">Στοιχεία δημοσκόπησης</h3><button type="button" class="btn btn-xs btn-danger" style="float:right; font-size:90%" title="Διαγραφή δημοσκόπησης" ng-click="showMathitesAnswers(dimoskopisi, 'delete')"><i class="fa fa-trash"></i></button><br/>
                                <span><b>Ερώτημα: </b> {{dimoskopisi.periexomeno}}</span><br/>
                                <span><b>Τίτλος: </b> {{dimoskopisi.titlos}}</span><br/> 
                                <span><b>Ανέβηκε στις: </b> {{dimoskopisi.imerominia}}</span><br/><br/>
                                <h3>Επισκόπηση απαντήσεων</h3>
                                <span><b>Συνολικές απαντήσεις:</b> {{dimoskopisi.posesApantiseis}} 
                                </span>&ensp;<a href="javascript:void(0)" class="btn btn-light" data-toggle="modal" data-target="#myModal" ng-click="showMathitesAnswers(dimoskopisi, 'show')" data-backdrop="false" style="float:right; border:.5px solid lightgray">Λεπτομέρειες</a>  
                            </div>
                    
                            <!-- The Modal -->
                            <div class="modal fade" id="myModal">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Απαντήσεις μαθητών</h4>
                                            <button type="button" class="close" data-dismiss="modal" ng-click="showMathitesAnswers('', 'hide')">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <table class="table table-hover table-striped table-bordered" datatable="ng" dt-options="vm.dtOptions" dt-columns="dtColumns" style="margin-top:20px;">
                                            <thead>          
                                                <tr>
                                                    <th>N/N</th>
                                                    <th>ΑΜ</th>
                                                    <th>Όνομα</th>
                                                    <th>Επώνυμο</th>
                                                    <th>Email</th>
                                                    <th>Απάντηση</th>
                                                    <th>Ημερομηνία</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="mathitis in showMathitesApantiseis">
                                                    <td>{{$index + 1}}.</td>
                                                    <td>{{mathitis.AMmathiti}}</td>
                                                    <td>{{mathitis.onoma}}</td>
                                                    <td>{{mathitis.epwnumo}}</td>
                                                    <td>{{mathitis.email}}</td>
                                                    <td>{{mathitis.apantisi}}</td>
                                                    <td>{{mathitis.imerominia}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" ng-click="showMathitesAnswers('', 'hide')">Κλείσιμο</button>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                            <!-- /End Modal -->
                        </div> 
                    </div>
                </div>         
            </div>    
        </div>
    
        
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0//js/froala_editor.min.js"></script>
    <!-- <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="js/scriptsUploadfile4.js"></script>
  </body>
</html>