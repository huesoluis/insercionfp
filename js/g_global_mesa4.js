 $(document).ready(function() {
		
        var centro=window.location.toString();       
     	if(centro.indexOf('?')!=-1) centro=window.location.toString().split('?')[1].split('=')[1];       
	else  centro=centro.split('/')[4].slice(0,-4);      
        get_datos_global(centro);
			
	var options = {
	url: "../js/datos/centros.json",

	getValue: "name",

	list: {
		maxNumberOfElements: 10,
		match: {
			enabled: true
		},
		onClickEvent: function() {
			alert("Click !");
		},
	}
	
	};

	$("#buscar_centros").easyAutocomplete(options);
        
   	});

			
function get_datos_global(centro){
                 $.ajax({
                           type: "POST",
                           url: "../php/get_datos_mesa4.php",
			   data : {cen:centro},
                           cache: false,    
                           success: function(result){
                                    var res = result.split(',');
				    console.log(res);
                                    show_datos_global(res);  
                                    show_grafico_insercion(centro,'trabaja_desempleo','trabaja_desempleo','% INSERCION EN GENERAL');  
                                    show_grafico_insercion(centro,'trabaja_relacionado','trabaja_relacionado','% INSERCION LABORAL EN SECTOR RELACIONADO');  
                                return result;
                               },
                      error: function(xhr,status,error) {
                                   console.log("nook leyendo"); 
				console.log("(" + xhr.responseText + ")");
			}
                        });
            }
        function show_grafico_insercion(centro,selector,fichero,titulo){

		file='../datos/mesa4/'+fichero+'.csv';
		$.get(file, function(csv) {
		file = file.substring(0, file.length-4);
        	  $('#'+selector).highcharts({
                    credits:{
			        enabled: false
    			    },
			        chart: {
			        	type: 'column'
			               },
			        data: {
			            csv: csv
			        },
			        title: {
						text: titulo
					},
					yAxis: {
						title: {
							text: 'Porcentaje de alumnos'
						}
					}
			    });
            
            
            
        }).done(function() {
  })
  .fail(function(j,t,e) {
    console.log( "error"+e );
  })
  .always(function() {
                   
	})
}
	function get_grafica_gempdes(){

                 $.ajax({
                           type: "POST",
                           url: "php/get_gempdes.php",
                           cache: false,    
                           success: function(result){
                                    
                                    var res = result.split('/');
                                    show_graph(res);  
                                   
                                return result;
                               },
                      error: function(data) {
    }
                        });
            }

           function show_datos_global(data)
            {
		var j=0;
		var k=1;
		$('.dg').each(function(i,o){
			$(this).append(data[j]);
			j=j+2;
			});

		$('.dgp').each(function(i,o){
			$(this).append(data[k]);
			k=k+2;
			});
	   }
           function show_graph(data)
            {
                var len=data.length;
                $.each(data,function(i,gr){
                    
                    if(i==len-1) return false;
                $.get('csvs_matsexo/'+gr, function(csv) {
		gr = gr.substring(0, gr.length-4);
                    var cont='';
                    var selector='';
                    if(i!=0){
                        cont=' <div class="col-sm-4 col-xm-12"><div class="peq'+i+'"></div></div>';
                       $('.small').append(cont);
                    selector='.peq'+i;
                        }
                        else  
                            {
                            selector='#big';

                            }
                   // add_clicks(selector,gr);
			    $(selector).highcharts({
                    		credits: {
        				enabled: false
    					},
			        chart: 	{
			        	type: 'column',
					events: {
	                			click: function(event) {
                    			console.log(gr);
	                    		fichero=gr.concat('.csv');	
                     			show_big(selector,fichero);
	                				}
	            				}
			        },
			        data: {
			            csv: csv
			        },
			        title: {
						text: gr
					},
				yAxis: {
					title: {
						text: 'Número de alumnos'
						}
					}
			    });
			});
                });
                             }
                
                  
              function add_clicks(sel,file)
            {
                    console.log(sel);
                  $(sel).click(function(){
                                   
                     show_big(sel,file);

    });
            }
        function show_big(selector,file){
		console.log("focus");
        jQuery('html,body').animate({scrollTop:0},0);     
	$.get('csvs_matsexo/'+file, function(csv) {
		file = file.substring(0, file.length-4);
          $("#big").highcharts({
                    credits:{
			        enabled: false
    			    },
			        chart: {
			        	type: 'column'
			               },
			        data: {
			            csv: csv
			        },
			        title: {
						text: file
					},
					yAxis: {
						title: {
							text: 'Número de alumnos'
						}
					}
			    });
            
            
            
        });
                   
	}

