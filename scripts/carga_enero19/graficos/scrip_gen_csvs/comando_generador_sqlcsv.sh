mysql -uroot -pSuricato1.fp < matricula_provincias.sql | sed 's/\t/,/g' > out.csv
