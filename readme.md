---
title: "Rapport de projet"
format: html
---

# Application web de gestion et d'annotation d'images et de photos
L2 Info : Language Web
Tristan GROULT TP1

## Configuration necessaire
Il est necessaire d'activer le module appache `mod_rewrite` qui est utilisé pour réécrire les URLs proprement et donc cacher les choix d'implémentations et de technologie utilisé. Ce module peut être activer (neccessite un redémarage de la config apache2) avec :
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```



Il est necessaire d'activer le module appache `mod_rewrite` qui est utilisé pour réécrire les URLs proprement et donc cacher les choix d'implémentations et de technologie utilisé. Ce module peut être activer (neccessite un redémarage de la config apache2) avec :
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```
