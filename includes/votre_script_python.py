import sys
import mysql.connector
import tensorflow as tf
import tensorflow_hub as hub

def calculer_similarite_use(reponse_candidat, reponse_attendue):
    try:
        # Chargement du modèle Universal Sentence Encoder
        embed = hub.load("https://tfhub.dev/google/universal-sentence-encoder/4")

        # Encodage des phrases en vecteurs
        vecteur_candidat = embed([reponse_candidat])[0]
        vecteur_attendu = embed([reponse_attendue])[0]

        # Calcul de la similarité entre les vecteurs (produit scalaire)
        similarite = tf.tensordot(vecteur_candidat, vecteur_attendu, axes=1)
        pourcentage_similarite = similarite * 100

        return pourcentage_similarite.numpy().item()

    except Exception as e:
        print("Erreur lors du calcul de similarité :", e)
        return None

# Récupérer la réponse du candidat à partir des arguments passés en ligne de commande
reponse_candidat = sys.argv[1]

# Récupérer la réponse attendue à partir des arguments passés en ligne de commande
reponse_attendue = sys.argv[2]

# Connexion à la base de données MySQL avec l'encodage utf8
try:
    connection = mysql.connector.connect(host="localhost", user="root", password="", database="cee_db", charset='utf8')

    if connection.is_connected():
        cursor = connection.cursor()

        # Calcul de similarité
        resultat_similarite = calculer_similarite_use(reponse_candidat, reponse_attendue)
        # Affichage des résultats personnalisé avec balises HTML et CSS
        print("<div style='background-color: #f0f0f0; padding: 20px; margin: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);'>")
        print("<h1 style='color: #337ab7;'>Résultat de l'évaluation :</h1>")
        print("<hr>")
        print("<p><strong>Réponse du candidat :</strong></p>")
        print("<p>", reponse_candidat, "</p>")
        print("<hr>")
        print("<p><strong>Réponse attendue :</strong></p>")
        print("<p>", reponse_attendue, "</p>")
        print("<hr>")
        print("<p><strong>Pourcentage de similarité :</strong>", resultat_similarite, "%</p>")
        print("<hr>")
        print("</div>")
		
        update_query = "UPDATE exam_tbl SET similarite = %s WHERE ex_id = %s"
        cursor.execute(update_query, (resultat_similarite, id_examen))
        connection.commit()
        
        # Vous pouvez ajouter ici le code pour enregistrer le résultat de la comparaison dans la base de données si nécessaire

    else:
        print(u"Connexion à la base de données échouée")

except mysql.connector.Error as err:
    print(u"Erreur lors de la connexion à la base de données :", err)

#
#import sys
#import mysql.connector
#import tensorflow as tf
#import tensorflow_hub as hub
#
#def calculer_similarite_use(reponse_candidat, reponse_attendue):
#    try:
#        # Chargement du modèle Universal Sentence Encoder
#        embed = hub.load("https://tfhub.dev/google/universal-sentence-encoder/4")
#
#        # Encodage des phrases en vecteurs
#        vecteur_candidat = embed([reponse_candidat])[0]
#        vecteur_attendu = embed([reponse_attendue])[0]
#
#        # Calcul de la similarité entre les vecteurs (produit scalaire)
#        similarite = tf.tensordot(vecteur_candidat, vecteur_attendu, axes=1)
#        pourcentage_similarite = similarite * 100
#
#        return pourcentage_similarite.numpy().item()
#
#    except Exception as e:
#        print("Erreur lors du calcul de similarité :", e)
#        return None
#
## Récupérer la réponse du candidat à partir des arguments passés en ligne de commande
#reponse_candidat = sys.argv[1]
#
## Récupérer la réponse attendue à partir des arguments passés en ligne de commande
#reponse_attendue = sys.argv[2]
#
## Connexion à la base de données MySQL avec l'encodage utf8
#try:
#    connection = mysql.connector.connect(host="localhost", user="root", password="", database="cee_db", charset='utf8')
#
#    if connection.is_connected():
#        cursor = connection.cursor()
#
#        # Calcul de similarité
#        resultat_similarite = calculer_similarite_use(reponse_candidat, reponse_attendue)
#
#        # Affichage des résultats pour vérification
#     
#        print(u"Réponse attendue :", reponse_attendue)
#        print(u"Pourcentage de similarité :", resultat_similarite, "%")
#
#        # Vous pouvez ajouter ici le code pour enregistrer le résultat de la comparaison dans la base de données si nécessaire
#
#    else:
#        print(u"Connexion à la base de données échouée")
#
#except mysql.connector.Error as err:
#    print(u"Erreur lors de la connexion à la base de données :", err)
