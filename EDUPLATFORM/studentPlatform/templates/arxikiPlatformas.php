<html lang="gr">
    <head>   
        <style>
            .anakoinwsi {
                border-radius: 15px 50px 30px;
                transition: box-shadow 0.5s;
            }
            .anakoinwsi:hover {
                box-shadow: 3px 6px #071C33;
            }
            .inputGroup {
                background-color: #fff;
                display: block;
                margin: 10px 0;
                position: relative;
            }
            .inputGroup label {
                padding: 12px 15px;
                width: 100%;
                display: block;
                text-align: left;
                color: #3C454C;
                cursor: pointer;
                position: relative;
                z-index: 2;
                transition: color 200ms ease-in;
                overflow: hidden;
            }
            .inputGroup label:before {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                content: '';
                background-color: #EF6A26;
                position: absolute;
                left: 5%;
                top: 50%;
                -webkit-transform: translate(-50%, -50%) scale3d(1, 1, 1);
                transform: translate(-50%, -50%) scale3d(1, 1, 1);
                transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
                opacity: 0;
                z-index: -1;
            }
            .inputGroup label:after {
                width: 32px;
                height: 32px;
                content: '';
                border: 2px solid #D1D7DC;
                background-color: #fff;
                background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
                background-repeat: no-repeat;
                background-position: 2px 3px;
                border-radius: 50%;
                z-index: 2;
                position: absolute;
                right: 35px;
                top: 50%;
                -webkit-transform: translateY(-50%);
                transform: translateY(-50%);
                cursor: pointer;
                transition: all 200ms ease-in;
            }
            .inputGroup input:checked ~ label {
                color: #fff;
            }
            .inputGroup input:checked ~ label:before {
                -webkit-transform: translate(-50%, -50%) scale3d(56, 56, 1);
                transform: translate(-50%, -50%) scale3d(56, 56, 1);
                opacity: 1;
            }
            .inputGroup input:checked ~ label:after {
                background-color: #c95214;
                border-color: #c95214;
            }
            .inputGroup input {
                width: 32px;
                height: 32px;
                order: 1;
                z-index: 2;
                position: absolute;
                right: 30px;
                top: 50%;
                -webkit-transform: translateY(-50%);
                transform: translateY(-50%);
                cursor: pointer;
                visibility: hidden;
            }
        </style>
    </head>
<body>  
    <div ng-controller="crudController as vm" ng-init="getAllAnnouncements('refreshAll'); viewProgramma()">
<!-- Middle Column -->
    <div class="w3-col m7" >
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <i class="w3-left  w3-margin-right fa fa-map-marker" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
              <h4>Προσγειώθηκες στη πλατφόρμα του Ανοικτού Πανεπιστημίου!</h4><br>
              <hr class="w3-clear" style="margin-top:-2%">
                <p style="text-align: justify;"><b>Η πλατφόρμα αυτή έχει φτιαχτεί με γνώμονα να είναι συνοδοιπόρος σου στη γνώση</b> και να σε βοηθήσει να κατακτήσεις τους στόχους σου. </p><p style="text-align: justify;"><b>Πλοηγήσου στο κεντρικό μενού αριστερά</b> για να δεις τα μαθήματα που έχεις εγγραφεί και να βρεις πληροφορίες για αυτά. Επίσης, εκεί θα βρεις εργασίες που "τρέχουν" καθώς και λεπτομέρειες σχετικά με το πρόγραμμα εξαμήνου σου. </p><p style="text-align: justify;"> <b>Θες να φέρεις αυτή τη πλατφόρμα στα μέτρα σου;</b> Μπορείς να αλλάξεις τις ρυθμίσεις του λογαριασμού σου κάνοντας κλικ στο avatar σου πάνω δεξιά. Μη ξεχνάς ότι αυτή η πλατφόρμα σου προσφέρει εξατομικευμένη υποστήριξη λαμβάνοντας υπόψιν πως αλληλεπιδράς και βαθμολογείς τις πληροφορίες που σου παρέχονται. Οπότε κάθισε αναπαυτικά και απόλαυσε το ταξίδι!</p><br>
            </div>
          </div>
        </div>
      </div><br>
        
    <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding"><br>
                <h2 class="text-center" ng-bind="translateMonth(vm.calendarTitle)" style="border:1px solid darkgray; padding: .3em 0em .3em 0em"></h2><br>
                <hr class="w3-clear" style="margin-top:-2%">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="btn-group">
                            <button class="btn btn-primary" mwl-date-modifier date="vm.viewDate" decrement="vm.calendarView" ng-click="vm.cellIsOpen = false">Προηγούμενο</button>
                            <button class="btn btn-default" mwl-date-modifier date="vm.viewDate" set-to-today ng-click="vm.cellIsOpen = false">Σήμερα</button>
                            <button class="btn btn-primary" mwl-date-modifier date="vm.viewDate" increment="vm.calendarView" ng-click="vm.cellIsOpen = false">Επόμενο</button>
                        </div>
                    </div>
                    <br class="visible-xs visible-sm">
                    <div class="col-md-6 text-center">
                        <div class="btn-group">
                            <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'year'" ng-click="vm.cellIsOpen = false">Έτη</label>
                            <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'month'" ng-click="vm.cellIsOpen = false">Μήνες</label>
                            <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'week'" ng-click="vm.cellIsOpen = false">Εβδομάδες</label>
                            <label class="btn btn-primary" ng-model="vm.calendarView" uib-btn-radio="'day'" ng-click="vm.cellIsOpen = false">Ημέρες</label>
                        </div>
                    </div>

                </div><br>
                <mwl-calendar events="vm.events" calendar-dayNames="vm.dayNames" view="vm.calendarView" view-title="vm.calendarTitle" view-date="vm.viewDate" on-event-click="vm.eventClicked(calendarEvent)" on-event-times-changed="vm.eventTimesChanged(calendarEvent); calendarEvent.startsAt = calendarNewEventStart; calendarEvent.endsAt = calendarNewEventEnd" cell-is-open="vm.cellIsOpen" day-view-start="06:00" day-view-end="22:59" day-view-split="30" cell-modifier="vm.modifyCell(calendarCell)" cell-auto-open-disabled="true" on-timespan-click="vm.timespanClicked(calendarDate, calendarCell)"></mwl-calendar>
              </div><br><br>
            </div>
        </div>
    </div><br>    
        
      <div class="w3-row-padding">
        <div class="w3-col m12" >
          <div class="w3-card w3-round w3-white" style="outline:1px solid gray">
            <div class="w3-container w3-padding">
              <i class="w3-left  w3-margin-right fa fa-bullhorn" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
              <h4>Τελευταίες ανακοινώσεις</h4>
            </div>
          </div>
        </div>
      </div>
      
        <div class="w3-container w3-card w3-white w3-round w3-margin anakoinwsi" ng-repeat="item in anakoinwseis | startFrom:currentPage*pageSize | limitTo:pageSize" ><br>
            <span class="w3-right w3-opacity">{{item.imerominia}}</span>
            <i class="w3-left  w3-margin-right fa fa-check-square" style="font-size:155% ; margin-top:1%; color:#071c33"></i>
            <h4 >Ανακοίνωση στο μάθημα "<span style="color:#071C33; font-weight:bold">{{item.mathima}}</span>"</h4>
            <hr class="w3-clear">
            <p>Θέμα: <b>{{item.thema}}</b></p>
            <p ng-bind-html="item.periexomeno | unsafe" style="margin-top:2%"></p><br>
        </div>
        <div class="w3-margin" style="float:right">
            <button class="btn btn-default" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">Προηγούμενο</button>
            {{currentPage+1}}/{{numberOfPages}}
            <button class="btn btn-default" ng-disabled="currentPage >= anakoinwseis.length/pageSize - 1" ng-click="currentPage=currentPage+1">Επόμενο</button> 
        </div>
      
    <!-- End Middle Column -->
    </div>
    
    <!-- Right Column -->
    <div class="w3-col m2">
      <div class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
            <div class="w3-container w3-padding"><br>
                <p style="font-size:110%">Τρέχουσα εβδομάδα</p>
                <hr style="margin-top:-1%">
                <p style="margin-top:-1%; font-size:110%"><strong><i class="fa fa-calendar"></i> &nbsp;{{ebdomadaDidaskalias}}η εβδομάδα</strong></p><br>
            </div>
        </div>
      </div>
      <br>
      
      <div class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
            <div class="w3-container w3-padding reveal-animation"><br>
                <p style="font-size:110%">Δημοσκοπήσεις</p>
                <hr style="margin-top:-1%">
                <div ng-repeat="poll in userPolls | startFrom:currentPagePolls*pageSizePolls | limitTo:pageSizePolls">
                        <p style="font-size:105%">
                            <i class="fa fa-caret-right" > </i> Μάθημα<br><strong style="font-size:100%">{{poll.mathima}}</strong><br><br>
                            <i class="fa fa-caret-right" > </i> Θέμα<br><strong style="font-size:100%">{{poll.titlos}}</strong>
                        </p>
                        <p>{{poll.periexomeno}}</p>
                        <div style="padding:1em" ng-show="poll.edwseApantisi">
                            <div class="w3-light-grey" style="background-color:#bf0909!important">
                                <div class="w3-container w3-center" style="width:{{ (poll.posaNai/poll.posa)*100 | number:0 }}%; background-color:#27960c; height:.8em"></div>
                            </div><span >{{ (poll.posaNai/poll.posa)*100 | number:0 }}% θετικές</span><br>
                        </div>
                        <strong ng-show="poll.edwseApantisi">Η απάντηση μου</strong>
                        <form name="myform">
                            <div class="inputGroup">
                                <input id="radio{{$index}}" ng-model="poll.apantisi"  type="radio" value="NAI" ng-disabled="poll.edwseApantisi" required/>
                                <label for="radio{{$index}}">&emsp;&emsp;Ναι</label>
                            </div>
                            <div class="inputGroup">
                                <input id="radio{{$index + 20}}" ng-model="poll.apantisi"  type="radio" value="OXI" ng-disabled="poll.edwseApantisi" required/>
                                <label for="radio{{$index + 20}}">&emsp;&emsp;Όχι</label>
                            </div>
                            <div ng-hide="!poll.edwseApantisi"><span>Καταχωρήθηκε στις <br><strong>{{poll.imerominiaanswer}}</strong></span><br><br></div>
                            <div ng-hide="poll.edwseApantisi"><button type="button" class="btn btn-default" ng-disabled="myform.$invalid;" ng-click="addUserPollanswer(poll)">Καταχώρηση</button><br><br></div>
                        </form>
                        <hr ng-show="!$last" style="margin-top:-1%">
                    <!-- <div ng-show="!poll.edwseApantisi">
                        <p style="font-size:105%">
                            <i class="fa fa-caret-right" > </i> Μάθημα<br><strong style="font-size:100%">{{poll.mathima}}</strong><br><br>
                            <i class="fa fa-caret-right" > </i> Θέμα<br><strong style="font-size:100%">{{poll.titlos}}</strong>
                        </p>
                        <p>{{poll.periexomeno}}</p>
                        <div class="inputGroup">
                            <input id="radio1" ng-model="poll.apantisi" name="radio" type="radio" value="NAI"/>
                            <label for="radio1">&emsp;&emsp;Ναι</label>
                        </div>
                        <div class="inputGroup">
                            <input id="radio2" ng-model="poll.apantisi" name="radio" type="radio" value="OXI" disabled/>
                            <label for="radio2">&emsp;&emsp;Όχι</label>
                        </div>
                        <button type="button" class="btn btn-default" style="float:center">Καταχώρηση</button><br><br>
                        <hr ng-show="!$last" style="margin-top:-1%">
                    </div> -->
                </div>
                <button class="btn btn-primary" ng-disabled="currentPagePolls == 0" ng-click="currentPagePolls=currentPagePolls-1">&lt;</button>
                {{currentPagePolls+1}}/{{numberOfPagesPolls}}
                <button class="btn btn-primary" ng-disabled="currentPagePolls >= userPolls.length/pageSizePolls - 1" ng-click="currentPagePolls=currentPagePolls+1">&gt;</button><br><br>
            </div>
        </div>
      </div>
      <br>
      
      <div class="w3-card w3-round w3-white  w3-center"><br>
        <p><i class="fa fa-thumbs-up w3-xxxlarge"></i></p><br>
      </div>
      
    <!-- End Right Column -->
    </div>
    </div>
    </body>
</html>