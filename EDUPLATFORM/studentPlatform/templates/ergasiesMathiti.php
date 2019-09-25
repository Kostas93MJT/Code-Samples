<head>
    
    <style> 
        #kataxwrisi {
            display: inline-block;
            border-radius: 4px;
            background-color: #fff;
            border: 1px solid gray;
            color: #000;
            text-align: center;
            font-size: 100%;
            padding: 6px;
            width: 13%;
            height:4%;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }

        #kataxwrisi span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        #kataxwrisi span:after {
            content: '\f054';
            font-family: FontAwesome;
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        #kataxwrisi:hover:enabled span {
            padding-right: 20px;
        }

        #kataxwrisi:hover:enabled span:after {
            opacity: 1;
            right: 0;
        }
        
        #kataxwrisi:disabled {
            background: lightgray;
            cursor: not-allowed;
            color: gray;
        }
        #anoigmaarxeiou:hover {
            text-decoration: underline;   
        }
        
        form .progress {
            line-height: 15px;
        }

        .progress {
            
            width: 300px;
            border: 2px groove #CCC;
        }

        .progress div {
            font-size: smaller;
            background: #0fbf1d;
            width: 0;
        }
    </style>
</head>
<body>
<!-- Middle Column -->
    <div class="w3-col m9" ng-init="getErgasies()">
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <i class="w3-left w3-circle w3-margin-right fa fa-file-text" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
              <h4>Ανοιχτές Εργασίες</h4><br>
              <hr class="w3-clear" style="margin-top:-2%">
                <p>Παρακάτω θα βρεις τυχόν εργασίες που έχουν ανακοινωθεί για τα μαθήματα που έχεις κάνει εγγραφή. Το αρχείο που θα ανεβάσεις θα πρέπει να είναι να είναι σε μορφή PDF και να είναι συμπληρωμένο με τα πλήρη στοιχεία σου. Αν έχεις ήδη ανεβάσει κάποιο αρχείο και θα ήθελες να το αντικαταστήσεις, ανέβασε εκ νέου το καινούριο αρχείο και η αντικατάσταση θα γίνει αυτόματα. </p><br/>
                
                <p style="border-top:1px solid #ef6a26;padding-top:12px;border-bottom:1px solid #ef6a26;padding-bottom:12px;" ng-show="uparxeiData"><strong>Μαθήματα με ανοικτές εργασίες: </strong> <span ng-repeat="ergasia in Ergasies">&ensp;<i class="fa fa-arrow-right"></i>&ensp;{{ergasia.mathima}}&ensp; </span></p>
                <p style="border-top:1px solid #ef6a26;padding-top:12px;border-bottom:1px solid #ef6a26;padding-bottom:12px; text-align:center" ng-show="!uparxeiData"><strong>Δεν υπάρχουν ανοικτές εργασίες</strong></p>
                <br/><br/>
            </div>
          </div>
        </div>
      </div>
      
      <div class="w3-container w3-card w3-white w3-round w3-margin" ng-repeat="ergasia in Ergasies"><br>
        <i class="w3-left w3-circle w3-margin-right fa fa-square" style="margin-top:1%; color:#071c33"></i>
        <span class="w3-right w3-opacity">Ανοιχτή έως {{ergasia.imeraParadosis}}</span>
        <h5>Εργασία στο μάθημα "{{ergasia.mathima}}"</h5><br>
        <div style="background-color:#f9f9f9; border: 2px solid #ef6a26;border-radius: 10px;">
            <div style="background-color:#ef6a26; text-align:center; width:100%; height:5%; color:#fff;padding-top:8px;font-size:130%;font-weight:bold;border-bottom:2px solid #ef6a26">ΕΚΦΩΝΗΣΗ - ΛΕΠΤΟΜΕΡΕΙΕΣ ΕΡΓΑΣΙΑΣ</div><br>
            <p style="padding-left:20px;"><strong><i class="fa fa-chevron-right"></i> Εκφώνηση Εργασίας </strong> <br>&ensp;<i class="fa fa-download"></i> &nbsp;<a target="_blank" href="../material/assignments/{{ergasia.onomaArxeiou}}" id="anoigmaarxeiou" style="text-decoration:underline"> Άνοιγμα</a></p><br>
            <p style="text-align:justify; padding-left:20px;padding-right:8px;"><strong><i class="fa fa-chevron-right"></i> Περιγραφή εργασίας </strong><br>{{ergasia.sxolia}}</p><br>
            <p style="padding-left:20px"><strong><i class="fa fa-chevron-right"></i> Αριθμός Εργασίας </strong> <br>&ensp;{{ergasia.arithmos}}η γραπτή εργασία</p><br>
            <p style="padding-left:20px"><strong><i class="fa fa-chevron-right"></i> Εβδομάδα Διδασκαλίας </strong> <br>&ensp;{{ergasia.ebdomadaDidaskalias}}η εβδομάδα </p><br/>
            <div style="background-color:#ef6a26; text-align:center; width:100%; height:5%; color:white;padding-top:8px;font-size:130%;font-weight:bold;border-bottom:2px solid #ef6a26;border-top:2px solid #ef6a26;">ΚΑΤΑΧΩΡΗΣΗ ΕΡΓΑΣΙΑΣ - ΠΡΟΘΕΣΜΙΑ </div><br/><br/>
            <p style="text-align:justify; padding-left:20px;padding-right:8px;"><strong><i class="fa fa-chevron-right"></i> Οδηγίες παράδοσης </strong><br> Το όνομα του αρχείου PDF που θα ανεβάσεις θα πρέπει να έχει το τίλο <strong>{{ergasia.onomaMathiti}}_{{ergasia.tmimaMathiti}}_ΓΣ{{ergasia.arithmos}}.pdf</strong> .</p><br>
            <form name="forma{{$index}}">
                <label for="file" style="padding-left:20px"> Εδώ μπορείς να ανεβάσεις τη συμπληρωμένη εργασία: &ensp;</label><br/>
                <input type="file" class="btn btn-info" accept=".pdf" style="background-color: #fff; border: 1px solid gray; color:gray; display:inline; height:4%; margin-left:30%;width:300px" ngf-select ng-model="arxeio[$index]" ngf-max-size="25MB" name="file" required >
                <button id="kataxwrisi" ng-disabled="!forma{{$index}}.$valid" ng-click="uploadErgasia(arxeio[$index], ergasia.IDergasias)"><span>Αποθήκευση</span></button><br/>
                <i class="fa fa-exclamation-circle" style="color:red;margin-left:30%" ng-show="forma{{$index}}.file.$error.maxSize"> Το αρχείο είναι πολύ μεγάλο, μέγιστο: 15MB </i>
                <div class="progress" ng-show="arxeio[$index].progress >= 0" style="margin-left:30%;margin-top:-.5%">
                    <div style="width:{{arxeio[$index].progress}}%; text-align:center" 
                        ng-bind="arxeio[$index].progress + '%'"></div>
                </div>
            </form><br/>
            <p style="padding-left:20px" ng-show="alreadyupload{{$index}}"><strong style="text-decoration:underline">Σημείωση: </strong>Έχεις ήδη ανεβάσει ένα αρχείο για αυτή την εργασία: &ensp;<a target="_blank" href="../material/students_assignments/{{ergasia.onomaPDF}}" id="anoigmaarxeiou" style="font-weight:bold; font-style: italic"><i class="fa fa-folder-open"></i> {{ergasia.onomaPDF}}</a></p><br/>
            <p style="padding-left:20px"><i class="fa fa-exclamation-triangle" style="font-size:120%;color:#ef6a26"></i>&ensp; Η προθεσμία για τη κατάθεση της εργασίας είναι μέχρι και τις &nbsp;<font style="font-weight:bold;font-size:110%">{{ergasia.imeraParadosis}}</font></p><br/><br/>
         </div><br/>
      </div>
      
      <div class="w3-container w3-card w3-white w3-round w3-margin" ng-show="!uparxeiData">
          <img src="../img/Lets-Party-Cat.jpg" height="70%" width="70%" style=" display: block; margin-left: auto; margin-right: auto;">
    </div>
    <!-- End Middle Column -->
    </div>
</body>