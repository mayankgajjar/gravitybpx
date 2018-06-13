<!--div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>     
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
<?php echo 'CRM' ?>
        </li>
    </ol>        
</div-->
<div class="row" style="padding-bottom: 60px;">
    <div class="col-md-12">
        <div class="commision contracting-wrapper">
            <div class="step-activity-logo">
                <div class="activity-image">
                    <img src="<?php echo site_url('assets/images/agent-acelarator.png') ?>"/>
                </div>
            </div>        
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="commision portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?php echo 'Commission Paid By Product Type' ?></span>
                </div>
                <div class="tools">
                    <a class="khoku" href="javascript:;"> </a>
                    <a class="refresh" href="javascript:;"> </a>                  
                </div>                
            </div>
            <div class="portlet-body">
                <div id="chart_6" class="chart" style="height: 685px;"> </div>
                <div class="pai-chart-label">
                    <span class="first"><span class="color" style="background-color: #0b429b;"></span><span>Medicare Advantage</span></span>
                    <span class="second"><span class="color" style="background-color: #518729;"></span><span>Prescription Drug Plan</span></span>
                    <span class="second"><span class="color" style="background-color: #FF741A;"></span><span>Medicare Supplement</span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">        
        <div class="commision portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?php echo 'Commission Details' ?></span>
                </div>
                <div class="tools">
                    <a class="khoku" href="javascript:;"> </a>
                    <a class="refresh" href="javascript:;"> </a>                    
                </div>
            </div>
            <div class="portlet-body">
                <div id="chart_1" class="chart" style="height: 220px;"></div>
            </div>                    
        </div>
        <div class="commision portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?php echo 'Commission Statement' ?></span>
                </div>
                <div class="tools">
                    <a class="khoku" href="javascript:;"> </a>
                    <a class="refresh" href="javascript:;"> </a>                    
                </div>                
            </div>
            <div class="portlet-body">
                <div class="pending-activities">                   
                    <div class="activities">
                               <div class="search-list">
                                   <span>View</span>
                                   <select>
                                       <option value="Select">Select</option>
                                       <option value="saab">Saab</option>
                                       <option value="opel">Opel</option>
                                       <option value="audi">Audi</option>
                                   </select>
                               </div>
                               <div class="table-responsive">
                                   <table class="table" style="width: 800px;max-width: 800px;">
                                       <tr>
                                           <th>Carrier Name</th>
                                           <th>Agent/Agency Name</th>
                                           <th>Status Reason</th>
                                           <th>Marketer/Recruiter Name</th>
                                           <th>Invite Sent Date</th>
                                           <th>Role</th>
                                       </tr>
                                       <tr>
                                           <td>Carrier Name</td>
                                           <td>Agent/Agency Name</td>
                                           <td>Status Reason</td>
                                           <td>Marketer/Recruiter Name</td>
                                           <td>Invite Sent Date</td>
                                           <td>Role</td>
                                       </tr>
                                       <tr>
                                           <td>Carrier Name</td>
                                           <td>Agent/Agency Name</td>
                                           <td>Status Reason</td>
                                           <td>Marketer/Recruiter Name</td>
                                           <td>Invite Sent Date</td>
                                           <td>Role</td>
                                       </tr>
                                       <tr>
                                           <td>Carrier Name</td>
                                           <td>Agent/Agency Name</td>
                                           <td>Status Reason</td>
                                           <td>Marketer/Recruiter Name</td>
                                           <td>Invite Sent Date</td>
                                           <td>Role</td>
                                       </tr>
                                       <tr>
                                           <td>Carrier Name</td>
                                           <td>Agent/Agency Name</td>
                                           <td>Status Reason</td>
                                           <td>Marketer/Recruiter Name</td>
                                           <td>Invite Sent Date</td>
                                           <td>Role</td>
                                       </tr>
                                       <tr>
                                           <td>Carrier Name</td>
                                           <td>Agent/Agency Name</td>
                                           <td>Status Reason</td>
                                           <td>Marketer/Recruiter Name</td>
                                           <td>Invite Sent Date</td>
                                           <td>Role</td>
                                       </tr>
                                       <tr>
                                           <td>Carrier Name</td>
                                           <td>Agent/Agency Name</td>
                                           <td>Status Reason</td>
                                           <td>Marketer/Recruiter Name</td>
                                           <td>Invite Sent Date</td>
                                           <td>Role</td>
                                       </tr>
                                   </table>
                               </div>
                           </div>
                       </div>                
            </div>                    
        </div>        
    </div>
</div>
<script type="text/javascript">
    AmCharts.makeChart("chart_6", {
        "type": "pie",
        "theme": "light",
        "fontFamily": 'Open Sans',
        "color": '#888',
        labelsEnabled: false,
        autoMargins: false,
        marginTop: 0,
        marginBottom: 0,
        marginLeft: 0,
        marginRight: 0,
        pullOutRadius: 0,
        "colorField": "color",
        accessible: true,
        "dataProvider": [
            {
                "drugplan": "Medicare Advantage",
                "amount": 2304.47,
                "color": "#0B429B"
            },
            {
                "drugplan": "Prescription Drug Plan",
                "amount": 586.62,
                "color": "#518729"
            }, {
                "drugplan": "Medicare Supplement",
                "amount": 0.52,
                "color": "#FF741A"
            }, ],
        "valueField": "amount",
        "titleField": "drugplan",
    });   

    var chart;

    var chartData = [{
            month: "12/16/2016",
            amount: 279.76,
            "color": "#0B429B"},
        {
            month: "01/13/2017",
            amount: 178.17,
             "color": "#0B429B"},
        {
            month: "02/03/2017",
            amount: 2713.44,
            "color": "#0B429B"},
        ];
AmCharts.ready(function() {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "month";
    chart.startDuration = 1;

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;    
    categoryAxis.gridPosition = "start";

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.
    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "amount";
    graph.colorField = "color"
    graph.balloonText = "[[category]]: $[[value]]";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 0.8;
    chart.addGraph(graph);
    
    chart.addListener("clickGraphItem", function (event) {
        // let's look if the clicked graph item had any subdata to drill-down into
        if (event.item.dataContext.subdata != undefined) {
            // wow it has!
            // let's set that as chart's dataProvider
            event.chart.dataProvider = event.item.dataContext.subdata;
            event.chart.validateData();
        }
    });

    chart.write("chart_1");
});

</script>