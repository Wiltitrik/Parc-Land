#!/bin/bash
if test -f archive.tar.gz; then
	tar -xzvf archive.tar.gz > /dev/null 2>&1
	echo "Dossier public_html décompressé."
	rm archive.tar.gz
	cd public_html
	for i in `ls`; do
		uudecode $i
		echo "$i décodé."
		rm $i
	done
	cd ..
	cat << FIN_CREATE > create.sh
#!/bin/bash
if test \$# -lt 3 && exit 1
cat public_html/drop.sql | mysql -u\$1 -p\$2 \$3
cat public_html/bd.sql | mysql -u\$1 -p\$2 \$3
FIN_CREATE
	chmod u+x create.sh
else
	echo "Pas d'archive"
	exit 1
fi
