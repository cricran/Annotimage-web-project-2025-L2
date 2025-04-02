---
title: "Rapport de projet"
format: html
index: true
---

# Application web de gestion et d'annotation d'images et de photos
L2 Info : Language Web
Tristan GROULT TP1

## Structure du projet

## Difficultés rencontrées

## Liste des amélioration apporter

---

## Configuration necessaire
Il est necessaire d'activer le module appache `mod_rewrite` qui est utilisé pour réécrire les URLs proprement et donc cacher les choix d'implémentations et de technologie utilisé. Ce module peut être activer (neccessite un redémarage de la config apache2) avec :
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

L'extention GD doit aussi être activer si ce n'est pas le cas. Vérification avec
```bash
php -m | grep gd
```
Si GD n'est pas activé, installez-le :
```bash
sudo apt install php-gd
sudo systemctl restart apache2
```
