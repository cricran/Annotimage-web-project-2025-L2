# Application web de gestion et d'annotation d'images et de photos
L2 Info

Langage Web

Tristan GROULT - TP1

## Base de données :

Les requêtes pour créer les tables nécessaires sont données dans le fichier `db.sql`.

La configuration de l'accès à la base de données se fait dans le fichier `config.php`.

Pour obtenir une version de démonstration avec des utilisateurs et des images déjà ajoutés, exécutez les requêtes contenues dans `demo.sql`. (le nom d'utilisateur et le mot de passe sont identique)

## Droits d'accès

L'utilisateur associé au serveur PHP doit avoir les droits de lecture et d'écriture pour le dossier `images/`.

## Serveur

La racine du projet pour le serveur doit être le fichier `public/`. Si vous utilisez "Apache 2", voici une configuration possible du `VirtualHost` :

```
<VirtualHost *:80>
	ServerName annotimage.localhost
	DocumentRoot "/var/www/projet/public"
	<Directory "/var/www/projet">
		Options +FollowSymLinks +Indexes
		AllowOverride all
		Require all granted
	</Directory>
	ErrorLog /var/log/apache2/error.projetl2.log
	CustomLog /var/log/apache2/access.projetl2.log combined
</VirtualHost>
```
