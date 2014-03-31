Le scaffold de portfolio avec cakephp2.4.6
===========================================

Prérequis
----------
- avoir un design graphique déjà prédéfini
- avoir des bases en css et php
- activer le mode rewrite d'apache
***
Description
------------
Cette application a été développé pour faciliter la création d'un portfolio avec frontend et backoffice sécurisé.
A l'aide de ces sources, plus besoin de partir de 0, il suffit simplement de cloner le repo 
puis de generer votre base de donnée. En deux cliques 3 commandes, votre site est déployé.
***
Il ne vous reste plus qu'a definir un template css si ce n'est pas encore le cas et le tour est joué.
***
Comment ça marche?
------------------

Une fois que vous avez télécharger le repo dans votre serveur web:
***
1. Inserez cake dans les variables d'environement de votre systeme, c'est grâce à cela que vous pourrer construire votre site.
***
2. Rendez vous dans dossier app de votre site
***
3. Implémenter le code source des 3 éléments de chaque de la l'approche MVC avec la commande cake bake
	[ATTENTION] L'ordre d'implémentation dois être respecter, car une vue ne peut exister dans le controller, et un controller ne peut exister
	si son model n'existe pas. De même, dans la génération des models, les models fils de peuvent exister si les pères ne le sont pas.
***
Le code source est entierement adaptable, pour plus d'information vous pouvez vous rendre sur la documentation de cakephp : 
	http://book.cakephp.org/2.0/fr/console-and-shells.html

