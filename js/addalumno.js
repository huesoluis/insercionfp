$(document).ready(function() {
    var wrapper     = $(".row"); 
    var periodo2    = $("#b12m"); 
    var periodo1      = $("#b6m"); 
    
    var bf=	'#p1_grd';
    var P1	=  '¿Ha completado la FCT?';
    var P2	=  'Situacion laboral';
    var P3	=  '¿En un trabajo relacionado con el título cursado?';
    var P4	=  '¿En la misma empresa que la FCT?';
    var P5	=  'Tipo de contrato';

function compruebaEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function validacorreo(mail) {
  if (compruebaEmail(mail)) {
	return 1;
  } else {
	return 0;
  }
  return false;
}
//FORMULARIO CREACION NUEVO ALUMNO
$(periodo1).click(function(e){ //on add input button click
    var nom      = $("#p1_nombremodal").val(); //Add button ID
    var tel      = $("#p1_telefonomodal").val(); //Add button ID
    var ema      = $("#p1_emailmodal").val(); //Add button ID
    var dni      = $("#p1_dnimodal").val(); 
    var ap      = $("#p1_apmodal").val(); 
    var ap2      = $("#p1_sapmodal").val(); 
    var nif=dni.slice(0, -1);
    var ciclo      = $("#p1_codciclomodal").val(); 
    var bfp1='#nalumnop1';
    var ob_dni = document.getElementById("p1_dnimodal");
    var ob_nombre = document.getElementById("p1_nombremodal");
    var ob_denciclo = document.getElementById("p1_codciclomodal");
    e.preventDefault();

    if (!validacorreo(ema) && tel.length!=9) {
        alert("Debes introducir un correo o telefono valido");
	return;
    }
    if (ob_dni.value.length!=9) {
        alert("Debes introducir un dni válido");
	return;
    }
    if (ob_denciclo.value=='elige ciclo') {
        alert("Debes seleccionar un ciclo");
	return;
    }
            $('<div class="row"> <div class="col-25 pres"><button type="" class="pres btn btn-primary">Datos alumno</button></div> <div class="col-25 "> <h4>'+nom+' '+ap+' '+ap2+'</h4>  <h4><a href:"tel:+'+tel+'">'+tel+'</a></h4>  <h4><a href="mailto:'+ema+'">'+ema+'</a></h4><input type="checkbox" class="reset"  value="reset['+nif+'][]" name="reset"><span id="vaciar">VACIAR DATOS</span></input><br>  </div><div class=" col-25 "> <input type="hidden" name="telefono['+nif+'][]" value="'+tel+'"><input type="hidden" name="email['+nif+'][]" value="'+ema+'"> <input type="hidden" name="dni['+nif+'][]" value="'+dni+'"> <input type="hidden" name="codciclo['+nif+'][]" value="'+ciclo+'"><input type="hidden" name="nif['+nif+'][]" value="'+nif+'">  <input type="hidden" name="nombre['+nif+'][]" value="'+nom+'"><button type="" class="pres btn btn-primary">'+P1+'</button> <input type="radio" name="fct['+nif+'][]" value="si">SI<br>		  <input type="radio" name="fct['+nif+'][]" value="exento">EXENTO<br>	</div>	<button type="" class="pres btn btn-primary">'+P2+'</button><div class=" col-25 trab preg" > 		 <input type="radio" name="trabaja['+nif+'][]" class="trabajasa" value="si">TRABAJA<br>		  <input type="radio" name="trabaja['+nif+'][]" value="en desempleo">EN DESEMPLEO<br>		  <input type="radio" name="trabaja['+nif+'][]" value="estudia">ESTUDIA<br>  <input type="radio" name="trabaja['+nif+'][]" value="nsnc">NS/NC<br>	</div><button type="" class="pres btn btn-primary">'+P3+'</button>	<div class="sitrabaja" id="'+nif+'">	<div class=" col-25 preg">  <input type="radio" name="relacionado['+nif+'][]" value="si">SI<br><input type="radio" name="relacionado['+nif+'][]" value="no">NO<br>	</div><button type="" class="pres btn btn-primary">'+P4+'</button><div class=" col-25 preg">  <input type="radio" name="mismaempresa['+nif+'][]" value="si">SI<br>  <input type="radio" name="mismaempresa['+nif+'][]" value="no">NO<br>	</div><button type="" class="pres btn btn-primary">'+P5+'</button>	<div class=" col-25 preg">  <input type="radio" name="contrato['+nif+'][]" value="fijo">FIJO<br><input type="radio" name="contrato['+nif+'][]" value="autonomo">CUENTA PROPIA<br><input type="radio" name="contrato['+nif+'][]" value="otro">OTRO</div>		</div>').insertBefore('#enviar6m');


$('#login-modal_p1').modal('toggle');
$('.sitrabaja').hide('slow');

$('.trab').click(function() {
	act=$(this.input);
var id=$("input[type='radio'].trabajasa",this).attr('name');
id=id.replace('trabaja[','');
id=id.replace('][]','');
if($("input[type='radio'].trabajasa",this).is(':checked')) {
	$('#'+id).show('slow');
}else{
	$('#'+id).hide('slow');
	}
});

$('.reset').click(function(ev) {
id=ev.target.value;
id=id.replace('reset[','');
id=id.replace('][]','');
if(ev.target.checked!=true) return;
fct="fct["+id+"][]";
$("input[name='"+fct+"']").prop('checked',false);

trabaja="trabaja["+id+"][]";
$("input[name='"+trabaja+"']").prop('checked',false);

relacionado="relacionado["+id+"][]";
$("input[name='"+relacionado+"']").prop('checked',false);

mismaempresa="mismaempresa["+id+"][]";

$("input[name='"+mismaempresa+"']").prop('checked',false);

contrato="contrato["+id+"][]";
$("input[name='"+contrato+"']").prop('checked',false);

$('#'+id).hide('slow');
}
);
    });//FIN funcion click para añaidr un nuevo alumno del periodo de 6 meses


//AÑADIMOS UN ALUMNOS DEL SEGUNDO PERIODO 12 meses
$(periodo2).click(function(e){ 
    var nom      = $("#p2_nombremodal").val(); 
    var tel      = $("#p2_telefonomodal").val(); //Add button ID
    var ema      = $("#p2_emailmodal").val(); //Add button ID
    var ap       = $("#p2_apmodal").val(); 
    var ap2       = $("#p2_sapmodal").val(); 
    var dni      = $("#p2_dnimodal").val(); 
    var nif=dni.slice(0, -1);
    var texto='12 meses';
    var ciclo      = $("#p2_codciclomodal").val(); 
    var bfp2='#nalumnop2';
    e.preventDefault();
    var ob_dni = document.getElementById("p2_dnimodal");
    var ob_nombre = document.getElementById("p2_nombremodal");
    var ob_denciclo = document.getElementById("p2_codciclomodal");
    if (!validacorreo(ema) && tel.length!=9) {
        alert("Debes introducir un correo o telefono valido");
	return;
    }
    if (ob_dni.value.length!=9) {
        alert("Debes introducir un dni válido");
	return;
    }
    if (ob_denciclo.value=='elige ciclo') {
        alert("Debes seleccionar un ciclo");
	return;
    }
            $('<div class="row"><div class="col-25 "><h4>'+nom+' '+ap+' '+ap2+'</h4><h4><a href="tel:+'+tel+'">'+tel+'</a></h4><h4>'+ema+'</h4><input type="checkbox" class="reset"  value="reset['+nif+'][]" name="reset"><span id="vaciar">VACIAR DATOS</span></input><br>  </div><div class=" col-25 "> <input type="hidden" name="telefono['+nif+'][]" value="'+tel+'"><input type="hidden" name="email['+nif+'][]" value="'+ema+'"> <input type="hidden" name="dni['+nif+'][]" value="'+dni+'"> <input type="hidden" name="codciclo['+nif+'][]" value="'+ciclo+'"><input type="hidden" name="nif['+nif+'][]" value="'+nif+'">  <input type="hidden" name="nombre['+nif+'][]" value="'+nom+'"> <input type="radio" name="fct['+nif+'][]" value="si">SI<br>		  <input type="radio" name="fct['+nif+'][]" value="exento">EXENTO<br>	</div>	<div class=" col-25 trab preg" > 		 <input type="radio" name="trabaja['+nif+'][]" class="trabajasa" value="si">TRABAJA<br>		  <input type="radio" name="trabaja['+nif+'][]" value="en desempleo">EN DESEMPLEO<br>		  <input type="radio" name="trabaja['+nif+'][]" value="estudia">ESTUDIA<br>  <input type="radio" name="trabaja['+nif+'][]" value="nsnc">NS/NC<br>	</div>	<div class="sitrabaja" id="'+nif+'">	<div class=" col-25 preg">  <input type="radio" name="relacionado['+nif+'][]" value="si">SI<br><input type="radio" name="relacionado['+nif+'][]" value="no">NO<br>	</div><div class=" col-25 preg">  <input type="radio" name="mismaempresa['+nif+'][]" value="si">SI<br>  <input type="radio" name="mismaempresa['+nif+'][]" value="no">NO<br>	</div>	<div class=" col-25 preg">  <input type="radio" name="contrato['+nif+'][]" value="fijo">FIJO<br><input type="radio" name="contrato['+nif+'][]" value="autonomo">CUENTA PROPIA<br><input type="radio" name="contrato['+nif+'][]" value="otro">OTRO<br></div></div>').insertBefore("#enviar12m");

$('#login-modal_p2').modal('toggle');
$('.sitrabaja').hide('slow');

$('.trab').click(function() {
	act=$(this.input);

var id=$("input[type='radio'].trabajasa",this).attr('name');
id=id.replace('trabaja[','');
id=id.replace('][]','');

if($("input[type='radio'].trabajasa",this).is(':checked')) {
	$('#'+id).show('slow');
}else{
	$('#'+id).hide('slow');
	}
});

$('.reset').click(function(ev) {
id=ev.target.value;
id=id.replace('reset[','');
id=id.replace('][]','');
if(ev.target.checked!=true) return;
fct="fct["+id+"][]";
$("input[name='"+fct+"']").prop('checked',false);

trabaja="trabaja["+id+"][]";
$("input[name='"+trabaja+"']").prop('checked',false);

relacionado="relacionado["+id+"][]";
$("input[name='"+relacionado+"']").prop('checked',false);

mismaempresa="mismaempresa["+id+"][]";

$("input[name='"+mismaempresa+"']").prop('checked',false);

contrato="contrato["+id+"][]";
$("input[name='"+contrato+"']").prop('checked',false);

$('#'+id).hide('slow');
}
);
    });
//FIN funcion clck para añaidr un nuevo alumno de periodo 12 meses

    $(wrapper).on("click",".remove_field", function(e){ 
        e.preventDefault(); $(this).parent('div').remove(); ;
    })
$('.trab').each(function() {
	act=$(this.input);

var id=$("input[type='radio'].trabajasa",this).attr('name');
id=id.replace('trabaja[','');
id=id.replace('][]','');

if($("input[type='radio'].trabajasa",this).is(':checked')) {
	$('#'+id).show('slow');
}else{
	$('#'+id).hide('slow');
	}
});
$('.checked').show('slow');

$('.trab').click(function() {
	act=$(this.input);

var id=$("input[type='radio'].trabajasa",this).attr('name');
id=id.replace('trabaja[','');
id=id.replace('][]','');

if($("input[type='radio'].trabajasa",this).is(':checked')) {
	$('#'+id).show('slow');
}else{
	$('#'+id).hide('slow');
	}


});

$('.reset').click(function(ev) {
id=ev.target.value;
if(ev.target.checked!=true) return;
id=id.replace('reset[','');
id=id.replace('][]','');
fct="fct["+id+"][]";
$("input[name='"+fct+"']").prop('checked',false);

trabaja="trabaja["+id+"][]";
$("input[name='"+trabaja+"']").prop('checked',false);

relacionado="relacionado["+id+"][]";
$("input[name='"+relacionado+"']").prop('checked',false);

mismaempresa="mismaempresa["+id+"][]";
$("input[name='"+mismaempresa+"']").prop('checked',false);

contrato="contrato["+id+"][]";
$("input[name='"+contrato+"']").prop('checked',false);
$('#'+id).hide('slow');
}
);
});





