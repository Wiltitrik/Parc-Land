#!/bin/bash
# cd /run/user/31833/gvfs/sftp:host=10.1.16.236/home/c/colin.herbecq
#Compression de public_html
if test -d public_html; then
	count=1
	for i in `ls public_html`; do
		uuencode public_html/$i $i > public_html/$count;
		echo "$i encodé => $count.";
		rm public_html/$i
		count=`expr $count + 1`
	done
	tar -czvf archive.tar.gz public_html > /dev/null 2>&1
	echo "Dossier public_html compressé."
	rm -r public_html 
else
	echo "Dossier public_html non-trouvé"
	exit 1
fi 

#Creation du désarchiveur
cat << FIN_DESARCHIV > desarchiveur.sh
#!/bin/bash
if test -f archive.tar.gz; then
	tar -xzvf archive.tar.gz > /dev/null 2>&1
	echo "Dossier public_html décompressé."
	rm archive.tar.gz
	cd public_html
	for i in \`ls\`; do
		uudecode \$i
		echo "\$i décodé."
		rm \$i
	done
	cd ..
	cat << FIN_CREATE > create.sh
#!/bin/bash
if test \\\$# -lt 3 && exit 1
cat public_html/drop.sql | mysql -u\\\$1 -p\\\$2 \\\$3
cat public_html/bd.sql | mysql -u\\\$1 -p\\\$2 \\\$3
FIN_CREATE
	chmod u+x create.sh
else
	echo "Pas d'archive"
	exit 1
fi
FIN_DESARCHIV
chmod u+x desarchiveur.sh
