#generador de json con dos niveles de anidamiento
#eliminar del csv las primeras líneas
import json

tree=[]
nl=0
lf=''
linefinal='{'
fcsv="ocupaciones_cualificaciones.csv"

for line in open(fcsv,'r').readlines():
    nl+=1
    line=line.replace('\n','')
    l2=line
    l3=l2.split('-n-')
    #json.stringify(l3[0],null,'\t')

    lactual=l3[0]
    
    children=l3[1]
    
    if(nl==1): 
        lf="[{"+lactual
        lf+=",\"children\":[{"+children+"}"
        lant=lactual 
        continue
    if(lactual==lant):
        lf+=",{"+children+"}"
    else:
        lf+="]},{"+lactual+",\"children\":[{"+children+"}"
    lant=lactual

lf=lf+"]}]"
#eliminamos dobles comillas
lf=lf.replace('""','"')

print(lf)

#pjson=json.loads('{"in1":"2","in2":"2"}')

#print(tree[0]['children']['nombre'])
