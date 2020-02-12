            function get_files(){
		var gfiles='php/get_files_empresas_familias.php';
		var csvdir='csvs_empresas_familias/';
		var csvdircompleto='csvs_empresas_familias_dcompletos/';


		     $.ajax({
                           type: "POST",
                           url: gfiles,
                           cache: false,    
                           success: function(result){
                                    
                                    var res = result.split('/');
                                    show_graph(res,csvdir,csvdircompleto);  
                                   
                                return result;
                               },
                      error: function(data) {
    }
                        });
            }

	   function cf(event)
		{	
        		show_big(event.data.sel,event.data.df,event.data.link);
		};
           function show_graph(data,csvdir,csvdirc)
            {
                var len=data.length;
                $.each(data,function(i,gr){
                if(i==len-1) return false;
                $.get(csvdir+gr, function(csv) {
			gr = gr.substring(0, gr.length-4);
        	        var cont='';
                	var selector='';
		        dowfichero=csvdir+gr.concat('.csv');	
		        dowficheroc=csvdirc+gr.concat('.csv');	
	        	fichero=gr.concat('.csv');	
			linkgr="<a href='"+dowficheroc+"'>"+gr+"</a>";
        	        if(i!=0){
                	        cont=' <div class="col-sm-4 col-xm-12"><div class="peq'+i+'"></div></div>';
                 		$('.small').append(cont);
		                selector='.peq'+i;
				$(selector).click({sel:selector,df:dowfichero,link:linkgr},cf);
                        }
                        else  
                            {
                            selector='#big';

                            }
			    $(selector).highcharts({
                    		credits: {
        				enabled: false
    					},
			        chart: 	{
			        	type: 'bar'
			        	},
			        data: {
			            csv: csv
			        },
			        title: {
						text: linkgr
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
                
                  
        function show_big(selector,file,link)
	{
        	jQuery('html,body').animate({scrollTop:0},0);     
		$.get(file, function(csv) 
		{
		console.log("clickando");
			file = file.substring(0, file.length-4);
         			$("#big").highcharts
				({
		                    	credits: {enabled: true},
			        	chart: {type: 'bar'},
			      		data: {csv: csv},
			        	title: {
						text: link
					},
					yAxis: {
						title: {text: 'Número de alumnos'}
						}
			    });
            
            
            
        });
                   
	}

$(document).ready(function() {
           get_files();
			
    $('#search').keyup(function () { 
        var valThis = $(this).val();
    
    $('#rsidebar>li>').each(function(){
     var text = $(this).text().toLowerCase();
     
        (text.indexOf(valThis) >= 0) ? $(this).show() : $(this).hide();         
   });
      
        
   });

			
		});
