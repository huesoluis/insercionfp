<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Información de cualificaciones y titulos formativos de Aragón</title>
<link rel="stylesheet" href="{{ URL::asset('css/styleacordion.css') }}" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Example of Bootstrap 3 Fixed Navbar</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<style type="text/css">
    body{
        padding-top: 70px;
    }
</style>


<style>
body { background-color: #fafafa; }

.header-default {
  box-sizing: border-box;
  width: 100%;
  padding: 10px;
  border: 1px solid #d1d1d1;
  border-radius: 4px 4px 0 0;
  background-color: #edecec;
  color: #3a3a3a;
  margin-bottom: -0.9em !important;
  cursor: pointer;
}

.header-default:hover { background-color: #e0e0e0; }

.header-active {
  background-color: #97d79d !important;
  margin-bottom: 0px !important;
}

.header-active:hover { background-color: #7cd382 !important; }

.content-default { display: none; }

.right { float: right; }

.accordion-content {
  text-align: justify;
  box-sizing: border-box;
  margin: 0px;
  padding: 15px;
  border: 1px solid #d1d1d1;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
}

.inline { display: inline; }

.btn-ordering {
  margin: 0px 10px 0px 10px;
  background-color: #e0e0e0;
  min-width: 80px;
  border-radius: 4px;
}

.btn-ordering:hover {
  border-style: inset;
  background-color: #bcbcbc;
}

.btn-div {
 margin-top: 40px;
 text-align: right;
 }
 [data-type="accordion-search"] {
   min-height: 15px;
   border-radius: 4px;
    }
 [data-type="accordion-filter"] {
   min-height: 15px;
   border-radius: 0px;
   min-width: 120px;
   height: 20px;
     }
.button1 {
  display: inline-block;
  border-radius: 4px;
  background-color: rgba(0,0,0,0.78);
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 14px;
  padding: 5px;
  width: 120px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button1 span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button1 span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button1:hover span {
  padding-right: 25px;
}

.button1:hover span:after {
  opacity: 1;
  right: 0;
}

            </style>

</head>

<body>
<div>
<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a href="#" class="navbar-brand">Principal</a>-->
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/ocupaciones_cualificaciones')}}">Ocupaciones</a></li>
                <li><a href="{{ url('/familias_cualificaciones_unidades')}}">Familias Profesionales</a></li>
                <li><a href="{{ url('/cert_cual_ucmf') }}">Certificados de profesionalidad</a></li>
                <li><a href="{{ url('/titulosfp') }}">Títulos FP</a></li>
                <li><a href="{{ url('/centros') }}">Centros FP</a></li>
            </ul>
        </div>
    </div>
</nav>
</div>
<div class="container">
<!--
<input  type="text"  style="min-height:80px; font-size:44px;" placeholder="{{$nombreentidad }}" name="search" id="search" data-type="accordion-search">
      <button class="button1 toggle1" style="vertical-align:middle"  ordering="desc" data-type="accordion-ordering"><span>Ordena</span></button>
-->
<br>
<p class="description" style="font-size:30px;">
<b>Certificados de profesionalidad, cualificaciones, unidades de competencia y módulos formativos relacionadas</b>
</p>
<div class="row">
        <div class="col-md-6">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text"  id="search" class="form-control input-lgi sbox" placeholder="Buscar" data-type="accordion-search"/>
		    <span class="input-group-btn">
<!--
      <button class="button1 toggle1" style="vertical-align:middle"  ordering="desc" data-type="accordion-ordering"><span>Ordena</span></button>
-->  
		    </span>
                </div>
            </div>
        </div>
</div>
<br>
<br>

<ul class="accordion1">
  
@foreach ($entidad as $ent)
  <li class="dencuali" data-type="dencuali">
    <a class="toggle1 enlaces" data-type="titulo" href="javascript:void(0);">{{ $ent['codigo'] }}&nbsp;&nbsp;&nbsp; {{ $ent['denominacion'] }}</a>
    <ul class="inner">
      <li>
        <a href="#" class="toggle1">Cualificación de referencia</a>
    	<ul class="inner">
		@foreach ($ent['children1'] as $ech1)
	 		<li>
			<a href="#" class="toggle1">{{ $ech1['codigo'] }} {{$ech1['den_cual']}}</a>
			
					<div class="inner">
				<br><b>UNIDADES ASOCIADAS</b><br><br>
				@foreach ( $ech1['children2'] as $ech2)
		  			<p>
					{{$ech2['codigouc']}} {{$ech2['denominacionuc']}} 
					<br>
					{{$ech2['codigomf']}} {{$ech2['denominacionmf']}}
					<br>
					<br>
		 			</p>
				@endforeach 
			
					</div>
			</li>
		@endforeach 
	      

		

        </ul>
      </li>
    </ul>
      
  </li>
@endforeach 
  
</ul>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.sticky.js') }}"></script>
<script>
  $(document).ready(function(){
	 $(".sbox").sticky({topSpacing:70});
	        });
</script>
<script type="text/javascript" src="{{ URL::asset('js/index.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/acordionsearch.js') }}"></script>
</div>
</body>
</html>
