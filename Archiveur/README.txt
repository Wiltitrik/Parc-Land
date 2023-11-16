Etant donné que l'on doit donner l'archive du dossier public_html et non le dossier lui-même, je vous donne ici l'archiveur et le désarchiveur (car c'est le désarchiveur qui désarchive). Cependant c'est bien l'archiveur qui créé le désarchiveur lorsqu'on exécute son script. Mais vu que l'archiveur a besoin du dossier public_html pour fonctionner, je vous donne directement le désarchiveur. 

Voici la description des scripts :
- archiveur.sh : archive le dossier public_html, créé le script desarchiveur.sh et lui donne les droits d'exécution.
- desarchiveur.sh : désarchive l'archive archive.tar.gz, créé le script create.sh et lui donne les droits d'exécution.
- create.sh : supprime et créé les nouvelles tables. Il prend 3 arguments : le nom d'utilisateur MySQL, le mot de passe MySQL et le nom de la base.

Vu que la commande uuencode/uudecode est installée que sur le pc local et que la commande mysql est installée que sur le serveur 10.1.16.236, il faudra jongler avec un terminal distant et local. Les étapes sont décrites ci-dessous.

Voici quelques explications sur le fonctionnement de l'archiveur.

- Tout d'abord, veuillez vous connecter au serveur ssh://10.1.16.236 (en mode graphique de préférence).
- Ensuite déposez le fichier archive.tar.gz dans votre dossier personnel.
- Déposez l'archiveur.sh et le désarchiveur.sh dans le même dossier où se trouve archive.tar.gz. N'oubliez pas de donner les droits au désarchiveur (chmod u+x desarchiveur.sh)
- Lancez un terminal local et exécutez cette commande : cd /run/user/31833/gvfs/sftp:host=10.1.16.236/home/(l'initial de votre prénom)/(votre prenom.nom)
- Exécutez la commande ./desarchiveur.sh. Le dossier public_html devrait être désarchivé et un nouveau script bash "create.sh" devrait faire son apparition.
- Lancez un terminal distant là où se trouve le fichier "create.sh" et exécutez la commande ./create.sh avec comme arguments votre nom d'utilisateur MySQL, votre mot de passe et le nom de votre base : Exemple ./create.sh colinherbecq mysql colinherbecq
- Et voilà, votre dossier public_html est prêt et votre base de données est remplie.
