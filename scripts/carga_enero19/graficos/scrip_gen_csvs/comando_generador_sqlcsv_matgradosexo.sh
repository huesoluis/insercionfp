mysql -uroot -pSuricato1.fp < matricula_sexo.sql | sed 's/\t/,/g' > out.csv
