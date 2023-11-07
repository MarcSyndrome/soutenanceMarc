#!/bin/bash

# Informations de connexion à la base de données
DB_USER="utilisateur"
DB_PASSWORD="mot_de_passe"
DB_NAME="base_de_données_Y"

# Informations sur le nouveau client
NOM="Bart"
PRENOM="Haba"
ID="13340"
PRODUIT_ACHETE="Cigarettes"
MONTANT_TRANSACTION="777.00"

# Insère un nouveau client dans la base de données
mysql -u $DB_USER -p$DB_PASSWORD $DB_NAME << EOF
INSERT INTO clients (nom, prénom, ID, produit_acheté, montant_transaction)
VALUES ('$NOM', '$PRENOM', '$ID', '$PRODUIT_ACHETE', $MONTANT_TRANSACTION);
EOF

# Accède au fichier Excel (ceci est un exemple bien sûr)
FICHIER_EXCEL="parsskonvieng2Loains.ods"

# Étape 1 : Ajouter les données du nouveau client à la feuille "Transactions"
echo -e "$ID\t$PRODUIT_ACHETE\t$MONTANT_TRANSACTION" >> transactions_temp.txt

# Étape 2 : Ajouter les données du nouveau client à la feuille "Identité"
echo -e "$NOM\t$PRENOM\t$ID" >> identite_temp.txt

# Étape 3 : Ajouter les données du nouveau client à la feuille "Toutes Données"
echo -e "$NOM\t$PRENOM\t$ID\t$PRODUIT_ACHETE\t$MONTANT_TRANSACTION" >> toutes_donnees_temp.txt

# Ajoute la logique pour manipuler les fichiers Excel
echo "Nouveau client ajouté à la base de données et aux feuilles Excel. Bienvenue $NOM $PRENOM"
