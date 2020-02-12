mysql -uroot -pSuricato1.fp < fam_cua_uni.sql | sed 's/\t/,/g' > out.csv
