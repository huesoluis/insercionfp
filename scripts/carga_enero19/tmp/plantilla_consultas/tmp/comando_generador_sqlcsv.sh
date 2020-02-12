mysql -uroot -p < fam_cua_uni.sql | sed 's/\t/,/g' > out.csv
