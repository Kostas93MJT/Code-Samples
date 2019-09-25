<!-- To scriptaki tou slider brisketai sto js/angular-datatables -->
<head>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Raleway:400,300,500,700);
        .uliko:hover {
            color: #074c99;
            cursor: pointer;
            text-decoration: none;
        }
        .anakoinwsi {
            border-radius: 15px 50px 30px;
            transition: box-shadow 0.5s;
        }
        .anakoinwsi:hover {
            box-shadow: 3px 6px #071C33;
        }
        #anoigmaarxeiou:hover {
            text-decoration: underline;   
        }
        .contact-button {
            position: relative;
            -webkit-perspective: 1000;
            -webkit-backface-visibility: hidden;
            -webkit-transform: translate3d(0, 0, 0);
            color: white;
            text-decoration: none;
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
            font-size: 1em;
            border: 1px solid white;
            border-radius: 4px;
            padding: 8px 24px 8px 26px;
            transition: 0.3s ease-in-out;
            background-color: #337AB7;
        }
        .contact-button span {
            font-family: 'Raleway', sans-serif;
            text-transform: none;
            position: absolute;
            color: #EE283E;
            top: 10px;
            left: 1.2em;
            opacity: 0;
            transition: all 0s ease 0s;
        }
        .contact-button:hover {
            color:white;
            transition: 0.3s ease-in-out;
            border: 2px solid white;
            border-radius: 50px;
            background-color: white;
        }
        .contact-button:hover > span {
            opacity: 1; 
            transition: all 0.25s ease-in-out 0.1s;
        }
    </style>
</head>
<body>
<!-- Middle Column -->
    <div class="w3-col m9" ng-init="getTmimaDaskalos(); getDidaktikaYlika(); getAllAnnouncementsByMathima(); getSummathitesGnwsiako()">
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <i class="w3-left w3-circle w3-margin-right fa fa-leanpub" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
              <h4>{{dedomena.id}}</h4><br>
              <hr class="w3-clear" style="margin-top:-2%">
                <p><font style="font-weight:bold">Υπεύθυνος καθηγητής τμήματος: </font><font style="color:grey"> &nbsp;{{dedomena.onomaKathigiti}}</font>&nbsp; <a style="color:darkorange; font-size:16px" href="mailto:{{emailKathigiti}}" title="{{emailKathigiti}}"> <i class="fa fa-envelope-o"></i></a></p>
                <p><font style="font-weight:bold">Τμήμα: </font><font style="color:grey"> &nbsp;{{tmima}}</font></p><br>
                

            </div>
          </div>
        </div>
      </div>
      
      <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
          <div class="w3-container w3-padding">
              <i class="w3-left w3-circle w3-margin-right fa fa-file-text" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
              <h4>Διδακτικό Υλικό</h4><br>
              <hr class="w3-clear" style="margin-top:-2%">
              <p>Εδώ θα βρείτε όλο το διδακτικό υλικό που είναι διαθέσιμο για το μάθημα.</p><br/>
              <div style="padding:2%">
                  <table class="table table-striped table-hover" datatable="ng" dt-options="vm.dtOptions" dt-columns="dtColumns">
                      <thead>  
                          <tr>
                              <th>N/N</th>
                              <th>Τίτλος</th>
                              <th>Βιβλίο - Πηγή</th>
                              <th>Ανέβηκε</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr ng-repeat="crud in cruds">
                              <td>{{$index + 1}}.</td>
                              <td><a class="uliko link" ng-click="showTabDialog($event, crud)">{{crud.titlosArxeiou}}</a></td>
                              <td>{{crud.biblio}}</td>
                              <td>{{crud.imerominia}}</td>
                          </tr>
                      </tbody>
                  </table><br/><br/>
              </div>
              <p id="alertDedomena" style="color:green;display:none;text-align:center"> <strong> Τα δεδομένα ανανεώθηκαν με επιτυχία! </strong></p><br/>
          </div>    
        </div>
      
        <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
            <div class="w3-container w3-padding">
                <i class="w3-left w3-circle w3-margin-right fa fa-leanpub" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
                <h4>Μαθητές και υποστήριξη</h4><br>
                <hr class="w3-clear" style="margin-top:-2%">
                <p style="text-align:justify"><span style="font-weight:bold">Ποιός είπε ότι επειδή δεν υπάρχουν τοίχοι και θρανία δε μπορούμε να φτιάξουμε μια διαδικτυακή αίθουσα;</span> Η πλατφόρμα αυτή ενθαρρύνει την ανταλλαγή γνώσεων μεταξύ των φοιτητών! Παρακάτω μπορείς να δεις κι άλλα άτομα τα οποία είναι γραμμένα στο ίδιο μάθημα καθώς και το email του. Κάποιοι τα ξέρουν όλα ενώ κάποιοι άλλοι ξεκουράζονται παραπάνω. Κάποιοι ίσως σου λύσουν απορίες ενώ κάποιοι ίσως σου δημιουργήσουν νέες. Όπως και να έχει, δε μπορείς να ξέρεις αν δε δοκιμάσεις <i class="fa fa-smile-o"></i> </p>
                <div style="padding:2em">
                    <table class="table table-bordered table-hover" datatable="ng" dt-options="vm.dtOptions" dt-columns="dtColumns">
                      <thead>  
                          <tr>
                              <th>N/N</th>
                              <th>Όνομα συμμαθητή</th>
                              <th>Επώνυμο</th>
                              <th>Τμήμα</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr ng-repeat="summathitis in getSummathitesGnwsiako" style="color:{{summathitis.xrwma}}; font-weight:bold">
                              <td style="color:black">{{$index + 1}}.</td>
                              <td><span class="uliko link">{{summathitis.onoma}}</span></td>
                              <td>{{summathitis.epwnumo}}</td>
                              <td style="color:black">{{summathitis.tmima}}</td>
                              <td><a href="mailto:{{summathitis.email}}" title="Στείλτε email στο {{emailKathigiti}}" class="contact-button">Αποστολή e-mail &nbsp;<i class="fa fa-paper-plane"></i><span><i class="fa fa-envelope"></i> &nbsp;{{summathitis.email}}</span></a></td>
                          </tr>
                      </tbody>
                    </table><br>
                    <md-button md-autofocus ng-click="stateJS = !stateJS" style="margin-left:1em; padding:0em 1em; border:1px solid lightgray; border-radius:10px"><i class="fa fa-info-circle"></i> &nbsp; ΒΟΗΘΕΙΑ </md-button>
                    <br>
                    <div style="padding:0em 2em;font-size:95%" class="slide-toggle-js" ng-if="!stateJS">
                        <i class="fa fa-square" style="text-align:right; color:#4db70b"></i> Είστε σε παρόμοιο επίπεδο και πιθανόν να έχετε κοινές απορίες<br>
                        <i class="fa fa-square" style="text-align:right; color:#186dcc"></i> Έχει καταλάβει κάποια πράγματα παραπάνω και θα μπορούσε να σε βοηθήσει<br>
                        <i class="fa fa-square" style="text-align:right; color:#ef910e"></i> Πράγματα που έχεις καταλάβει ίσως είναι βουνό για εκείνον και θα μπορούσες να δώσεις ένα χεράκι
                    </div>
                </div><br>
            </div>
      </div>     
        
      <div class="w3-row-padding">
        <div class="w3-col m12" >
          <div class="w3-card w3-round w3-white" style="outline:1px solid gray">
            <div class="w3-container w3-padding">
              <i class="w3-left  w3-margin-right fa fa-bullhorn" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
              <h4>Ανακοινώσεις μαθήματος</h4>
            </div>
          </div>
        </div>
      </div>
      
        <div class="w3-container w3-card w3-white w3-round w3-margin anakoinwsi reveal-animation" ng-repeat="item in anakoinwseisByMathima | startFrom:currentPageByMathima*pageSizeByMathima | limitTo:pageSizeByMathima" ><br>
            <span class="w3-right w3-opacity">{{item.imerominia}}</span>
            <i class="w3-left  w3-margin-right fa fa-check-square" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
            <h4> <span style="color:#071C33; font-weight:bold">{{item.mathima}}: </span> {{item.titlos}}</h4>
            <hr class="w3-clear">
            <p>Θέμα: <b>{{item.thema}}</b></p>
            <p ng-bind-html="item.periexomeno | unsafe" style="margin-top:2%"></p><br>
        </div>
        <div class="w3-margin" style="float:right">
        <button class="btn btn-default" ng-disabled="currentPageByMathima == 0" ng-click="currentPageByMathima=currentPageByMathima-1">Προηγούμενο</button>
        {{currentPageByMathima+1}}/{{numberOfPagesByMathima}}
        <button class="btn btn-default" ng-disabled="currentPageByMathima >= anakoinwseisByMathima.length/pageSizeByMathima - 1" ng-click="currentPageByMathima=currentPageByMathima+1">Επόμενο</button> </div><br> 

      
      
    <!-- End Middle Column -->
    </div>
    <script type="text/ng-template" id="tabDialog.tmpl.html">
        <md-dialog aria-label="{{ctrl.parent.infoModal.titlosArxeiou}}">
            <form name="myform">
                <md-toolbar>
                    <div class="md-toolbar-tools" style="background-color:#0e5eb7; color:#fff">
                        <h2> <i class="fa fa-circle" style="color:{{ctrl.parent.infoModal.xrwma}}; text-shadow: 0 0 8px {{ctrl.parent.infoModal.xrwma}};"></i>&nbsp; {{ctrl.parent.infoModal.titlosArxeiou}} </h2>
                        <span flex></span>
                        <md-button class="md-icon-button" ng-click="ctrl.parent.cancel()">
                            <md-icon md-svg-src="img/icons/ic_close_24px.svg" aria-label="Close dialog"></md-icon>
                        </md-button>
                    </div>
                </md-toolbar>
                <md-dialog-content style="max-width:800px;max-height:810px; ">
                    <md-tabs md-dynamic-height md-border-bottom>
                        <md-tab label="ΠΛΗΡΟΦΟΡΙΕΣ ΥΛΙΚΟΥ">
                            <md-content class="md-padding">
                                <h3>Πληροφορίες: </h3><br/>
                                    <p style="text-align:justify;"> {{ctrl.parent.infoModal.sxolia}} </p><br/>
                                    <p style="border-top:1px solid gray;padding-top:15px;border-bottom:1px solid gray;padding-bottom:15px"> <font style="font-weight:bold"> Βιβλίο/Πηγή: </font> {{ctrl.parent.infoModal.biblio}}, &ensp; <font style="font-weight:bold"> Επίπεδο Γνώσης: </font> {{ctrl.parent.infoModal.gnwsiakoEpipedo}} <br/>
                                    <font style="font-weight:bold"> Εβδομάδα Διδασκαλίας: </font> {{ctrl.parent.infoModal.ebdomadaDidaskalias}}η εβδομάδα, &ensp; <font style="font-weight:bold"> Ημερομηνία Καταχώρησης: </font> {{ctrl.parent.infoModal.imerominia}} </p><br/>
                                    <p ng-show="ctrl.parent.infoModal.katebasmaArxeiou"><i class="fa fa-download"></i> &nbsp;<a target="_blank" href="../material/{{ctrl.parent.infoModal.IDmaterial}}" id="anoigmaarxeiou"> Άνοιγμα Αρχείου</a></p>
                            </md-content>
                        </md-tab>
                        <md-tab label="Η ΑΞΙΟΛΟΓΗΣΗ ΜΟΥ">
                            <md-content class="md-padding">
                                <h3>Αξιολόγηση υλικού: </h3><br/>
                                <p> Αν ασχολήθηκες με το υλικό, μη ξεχάσεις να απαντήσεις τις παρακάτω ερωτήσεις οι οποίες θα βοηθήσουν τη πλατφόρμα να σου προσφέρει καλύτερη εξατομικευμένη υποστήριξη <i class="fa fa-smile-o"></i></p><br/>
                                <p style="font-weight:bold">Πόσο κατανόησες το τρέχον υλικό; </p><br/>
                                <p style="width:60%;margin-left:20%;"><slider ng-model="ctrl.parent.sliderValue" model="ctrl.parent.sliderValue" step="1" min="1" max="5"></slider></p>
                                <p style="text-align:center;font-weight:bold;font-size:120%">{{ctrl.parent.katanohsh}}</p><br/>
                                <p style="font-weight:bold">Θα επιθυμούσες επιπλέον υλικό για αυτά που διάβασες: 
                                    <label style="font-weight:normal;margin-left:3%">
                                        <input type="radio" value="NAI" ng-model="ctrl.parent.apantiseisModal.epipleonYliko" required> Ναι
                                    </label>
                                    <label style="font-weight:normal;margin-left:2%">
                                        <input type="radio" value="OXI" ng-model="ctrl.parent.apantiseisModal.epipleonYliko" required> Όχι
                                    </label>
                                </p>
                                <p style="font-weight:bold" ng-show="ctrl.parent.apantiseisModal.teleutaiaProvTrue"><i class="fa fa-calendar"></i> Τελευταία ανάγνωση: <label style="font-weight:normal;">{{ctrl.parent.apantiseisModal.teleutaiaProv}}</label></p>  
                            </md-content>
                        </md-tab>
                    </md-tabs>
                </md-dialog-content>
                <md-dialog-actions layout="row">
                    <md-button href="http://en.wikipedia.org/wiki/Mango" target="_blank" md-autofocus>
                        <i class="fa fa-info-circle"></i> &nbsp; ΒΟΗΘΕΙΑ 
                    </md-button>
                    <span flex></span>
                    <md-button ng-click="ctrl.parent.answer('Δεν καταχωρήθηκαν αλλαγές!')" >
                        ΑΚΥΡΩΣΗ
                    </md-button>
                    <md-button ng-click="ctrl.parent.answer('Τα δεδομένα ανανεώθηκαν με επιτυχία!')" style="margin-right:20px;" ng-disabled="myform.$invalid">
                        ΚΑΤΑΧΩΡΗΣΗ
                    </md-button>
                </md-dialog-actions>
            </form>
        </md-dialog>
</script>
</body>