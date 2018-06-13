<!-- Styles -->
<style>
#chartdiv {
  width   : 100%;
  height    : 500px;
  font-size : 11px;
}         
</style>

<!-- Chart code -->
<?php 
  $json_data = json_encode($premium_data);
?>
<script>
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "theme": "light",
  "allLabels": [
    {
      "text": "",
      "bold": true,
      "x": "Date Range",
      "y": "Premium Amount"
    }
  ],
  "dataProvider": <?=$json_data?>,
  "valueAxes": [ {
    "gridColor": "#FFFFFF",
    "gridAlpha": 0.2,
    "dashLength": 0,
    "title": "Premium Amount"
  } ],
  "gridAboveGraphs": true,
  "startDuration": 1,
  "graphs": [ {
    "balloonText": "[[category]]: <b>[[value]]</b>",
    "fillAlphas": 0.8,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "daily_premium"
  } ],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "week_day",
  "categoryAxis": {
    "gridPosition": "start",
    "gridAlpha": 0,
    "tickPosition": "start",
    "tickLength": 20,
    "title": "Day"
  },
  "export": {
    "enabled": true
  }

} );
</script>


<!-- HTML -->
<div id="chartdiv"></div>