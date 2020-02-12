$(document).ready(function() {
    var wrapper     = $(".row"); //Fields wrapper
    var sep_ab      = $("#sep_bpr"); //Add button ID
    var jun_ab      = $("#jun_bpr"); //Add button ID
    
$(jun_ab).click(function(e){ //on add input button click
    var nom      = $("#jun_nombremodal").val(); //Add button ID
    var tel      = $("#jun_telefonomodal").val(); //Add button ID
    var ema      = $("#jun_emailmodal").val(); //Add button ID
    var dni      = $("#jun_dnimodal").val(); 
    var nif=dni.slice(0, -1);
    var ciclo      = $("#jun_codciclomodal").val(); 
    bf='#jun_grd';
    var ob_dni = document.getElementById("jun_dnimodal");
    var ob_nombre = document.getElementById("jun_nombremodal");
    var ob_denciclo = document.getElementById("jun_codciclomodal");
    e.preventDefault();

    if (dni.length<=7) {
        alert("Debes introducir un DNI correcto");
	return;
    }
    if (nom.length<=2) {
        alert("Debes introducir un nombre");
	return;
    }
    if (ob_denciclo.value=='elige ciclo') {
        alert("Debes seleccionar un ciclo");
	return;
    }
            $('<div class="row">      <div class="col-25 "> <h4>'+nom+'</h4>  <h4>'+tel+'</h4>  <h4>'+ema+'</h4>                 <input type="checkbox" class="reset"  value="reset['+nif+'][]" name="reset"><span id="vaciar">VACIAR DATOS</span></input><br>  </div><div class=" col-25 "> <input type="hidden" name="telefono['+nif+'][]" value="'+tel+'"><input type="hidden" name="email['+nif+'][]" value="'+ema+'"> <input type="hidden" name="dni['+nif+'][]" value="'+dni+'"> <input type="hidden" name="codciclo['+nif+'][]" value="'+ciclo+'"><input type="hidden" name="nif['+nif+'][]" value="'+nif+'">  <input type="hidden" name="nombre['+nif+'][]" value="'+nom+'"> <input type="radio" name="fct['+nif+'][]" value="si">SI<br>		  <input type="radio" name="fct['+nif+'][]" value="no">NO<br>	</div>	<div class=" col-25 trab preg" > 		 <input type="radio" name="trabaja['+nif+'][]" class="trabajasa" value="si">TRABAJA<br>		  <input type="radio" name="trabaja['+nif+'][]" value="en desempleo">EN DESEMPLEO<br>		  <input type="radio" name="trabaja['+nif+'][]" value="estudia">ESTUDIA<br>  <input type="radio" name="trabaja['+nif+'][]" value="nsnc">NS/NC<br>	</div>	<div class="sitrabaja" id="'+nif+'">	<div class=" col-25 preg">  <input type="radio" name="relacionado['+nif+'][]" value="si">SI<br><input type="radio" name="relacionado['+nif+'][]" value="no">NO<br>	</div><div class=" col-25 preg">  <input type="radio" name="mismaempresa['+nif+'][]" value="si">SI<br>  <input type="radio" name="mismaempresa['+nif+'][]" value="no">NO<br>	</div>	<div class=" col-25 preg">  <input type="radio" name="contrato['+nif+'][]" value="fijo">FIJO<br><input type="radio" name="contrato['+nif+'][]" value="otro">OTRO<br>	</div>		</div>').insertBefore(bf);


 $('#login-modal_jun').modal('toggle');

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
    });//FIN funcion click para añaidr un nuevo alumno de junio


//AÑADIMOS UN ALUMNOM DE SEPTIMEBRE DE 2017
$(sep_ab).click(function(e){ 
    var nom      = $("#sep_nombremodal").val(); 
    var tel      = $("#sep_telefonomodal").val(); //Add button ID
    var ema      = $("#sep_emailmodal").val(); //Add button ID
    var dni      = $("#sep_dnimodal").val(); 
    var nif=dni.slice(0, -1);
    var texto='12 meses';
    var ciclo      = $("#sep_codciclomodal").val(); 
    bf='#sep_grd';
        e.preventDefault();
    var ob_dni = document.getElementById("sep_dnimodal");
    var ob_nombre = document.getElementById("sep_nombremodal");
    var ob_denciclo = document.getElementById("sep_codciclomodal");

    if (dni.length<=7) {
        alert("Debes introducir un DNI correcto");
	return;
    }
    if (nom.length<=2) {
        alert("Debes introducir un nombre");
	return;
    }
    if (ob_denciclo.value=='elige ciclo') {
        alert("Debes seleccionar un ciclo");
	return;
    }
            $('<div class="row"><div class="col-25 "><h4>'+nom+'</h4><h4>'+tel+'</h4><h4>'+ema+'</h4><input type="checkbox" class="reset"  value="reset['+nif+'][]" name="reset"><span id="vaciar">VACIAR DATOS</span></input><br>  </div><div class=" col-25 "> <input type="hidden" name="telefono['+nif+'][]" value="'+tel+'"><input type="hidden" name="email['+nif+'][]" value="'+ema+'"> <input type="hidden" name="dni['+nif+'][]" value="'+dni+'"> <input type="hidden" name="codciclo['+nif+'][]" value="'+ciclo+'"><input type="hidden" name="nif['+nif+'][]" value="'+nif+'">  <input type="hidden" name="nombre['+nif+'][]" value="'+nom+'"> <input type="radio" name="fct['+nif+'][]" value="si">SI<br>		  <input type="radio" name="fct['+nif+'][]" value="no">NO<br>	</div>	<div class=" col-25 trab preg" > 		 <input type="radio" name="trabaja['+nif+'][]" class="trabajasa" value="si">TRABAJA<br>		  <input type="radio" name="trabaja['+nif+'][]" value="en desempleo">EN DESEMPLEO<br>		  <input type="radio" name="trabaja['+nif+'][]" value="estudia">ESTUDIA<br>  <input type="radio" name="trabaja['+nif+'][]" value="nsnc">NS/NC<br>	</div>	<div class="sitrabaja" id="'+nif+'">	<div class=" col-25 preg">  <input type="radio" name="relacionado['+nif+'][]" value="si">SI<br><input type="radio" name="relacionado['+nif+'][]" value="no">NO<br>	</div><div class=" col-25 preg">  <input type="radio" name="mismaempresa['+nif+'][]" value="si">SI<br>  <input type="radio" name="mismaempresa['+nif+'][]" value="no">NO<br>	</div>	<div class=" col-25 preg">  <input type="radio" name="contrato['+nif+'][]" value="fijo">FIJO<br><input type="radio" name="contrato['+nif+'][]" value="otro">OTRO<br>	</div>		</div>').insertBefore(bf);


 $('#login-modal_sep').modal('toggle');

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
//FIN funcion clck para añaidr un nuevo alumno de septimebre

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





