@extends('layouts.mastertop')
@section('headsc')
  <link rel="stylesheet" href="css/graph.css">
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="http://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="https://code.highcharts.com/modules/data.js"></script>
<!--<script type="text/javascript" src="js/graphs.js"></script>-->
<script type="text/javascript" src="js/graphs_completo.js"></script>
@endsection

@section('contenttop')
<br>
<div class="container-fluid">
  	<div class="row">
    		<div class="col-sm-9">
			<h1 class="text-center">Matrícula FP por familias Septiembre 2018</h1>
    			<div id="big"></div>
  		</div>
  	</div>
      	<div class="row small col-9">	</div>
</div>


@endsection

