<?php
/**
 * Created by PhpStorm.
 * User: pauldossantos
 * Date: 03/10/2018
 * Time: 16:23
 */

namespace App\Controller;

use App\Model\PersonneManager;
use App\Model\SessionManager;

class PersonneController extends AbstractController
{
    /**
     * Afficher l'accueil. En paramètre twig j'envois les alertes dans "alerts", et je set la session('alerts') si
     * elle existe, sinon je set rien
     * @return string
     */
    public function showAllAction()
    {
        $personneManager = new PersonneManager();
        $personnes = $personneManager->getAllPersonne();

        return $this->twig->render(
            'Personne/showAll.html.twig',
            [
                'personnes' => $personnes,
                'alerts' => $_SESSION['alerts'] ?? ""
            ]
        );
    }

    /**
     * Méthode permettant de gérer l'ajoute et l'édit d'une personne. On donne un id en paramètre qui peut être null
     * quand on est sur un ajout.
     * @param null $id
     * @return string
     */
    public function addOrEditAction($id = null)
    {
        // On définit nos variables avec des valeurs par défaut qui seront modifiée si necessaire par la suite.
        $modeEdit = false;
        $personne = null;
        $errors = [];

        // Je prépare mes managers
        $personneManager = new PersonneManager();
        $sessionManager = new SessionManager();

        // Je récupère la liste des sessions pour les boucler dans mon select.
        // Je créer un variable sessionsIdAcceptes qui sera un array_column de la colonne id
        $sessions = $sessionManager->getAllSession();
        $sessionsIdAcceptes = array_column($sessions, 'id');

        // Si l'ID est différent de null (C'est a dire: si on envoi un ID à notre méthode)
        if (!$id == null) {
            //On récupère la personne avec l'id
            $personne = $personneManager->getPersonne($id);

            /* Si getPersonne retourne bien une personne, le if($personne) retournera true, si il n'y a pas de personne
               ça retournera null et donc on restera en mode ajout. Pour les petits malin qui veulent editer une personne
               qui n'existe pas */
            if($personne) {
                $modeEdit = true;
            }
        }

        // Si mon formulair est envoyé
        if (isset($_POST) && !empty($_POST)) {
            // GESTION DES ERREURS
            if (strlen($_POST['nom']) > 100 || strlen($_POST['nom']) < 3) {
                $errors['nom'] = "Le nom doit contenir entre 3 et 100 caractères et ne peux pas être vide";
            }

            if (strlen($_POST['prenom']) > 100 || strlen($_POST['prenom']) < 3) {
                $errors['prenom'] = "Le prénom doit contenir entre 3 et 100 caractères et ne peux pas être vide";
            }

            if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {
                $errors['email'] = "Votre adresse e-mail n'est pas valide";
            }

            // Je vérifie que mon POST session_id est bien présent dans la liste des id des sessions acceptées
            if (empty($_POST['session_id']) or !in_array($_POST['session_id'], $sessionsIdAcceptes)) {
                $errors['session_id'] = "La valeur ne peut pas être vide ou invalide";
            }
            // FIN DE LA GESTION DES ERREURS

            // S'il n'y a pas d'erreur, alors je peux ajouter ou modifier ma personne.
            if (count($errors) === 0) {

                // Je set mes variables pour une manipulation plus simple. (L'id peut être null en cas d'ajout)
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $sessionId = $_POST['session_id'];
                $id = $_POST['id'] ?? null;

                // Si je suis en mode edit, je vais éditer la personne et je redirige vers la liste des personne
                if ($modeEdit) {
                    $personneManager->editPersonne($id, $nom, $prenom, $email, $sessionId);
                    $_SESSION['alerts']['success'] = "La modification de " . $prenom . "à été effectué avec succès !";
                    header("location: /personnes");
                    exit();
                /* Si je suis pas en mode edit, j'ajoute la personne en base, et si tout se passe bien, et je
                   redirige vers la liste des personne */
                } elseif ($personneManager->addNewPersonne($nom, $prenom, $email, $sessionId)) {
                    $_SESSION['alerts']['success'] = "L'ajout de " . $_POST['prenom'] . " à été effectué avec succès !";
                    header("location: /personnes");
                    exit();
                /* Sinon, si ($personneManager->addNewPersonne($nom, $prenom, $email, $sessionId) me retourne false
                   c'est qu'il y a un problème dans la base de donnée, on affiche un message d'erreur */
                } else {
                    $errors['general'] =
                        "Nous avons rencontrer un problème, veuillez réessayer ou contacter l'administrateur";
                };
            }
        }

        // Si pas de redirection, on renvois tout à la page suivante avec tous les paramètres
        return $this->twig->render(
            'Personne/addOrEdit.html.twig',
            [
                'edit' => $modeEdit,
                'personne' => $personne,
                'sessions' => $sessions,
                'errors' => $errors,
                'post' => $_POST
            ]
        );
    }

    /**
     * Méthode pour supprimer une personne en POST et pas en GET
     */
    public function deletePersonne()
    {
        // GESTION DES ERREURS
        if (!isset($_POST['personne_id'])) {
            $_SESSION['alerts']['danger'] = "Je ne vois pas quelle personne supprimer.";
            header("location: /personnes");
            exit();
        } elseif (!is_numeric($_POST['personne_id'])) {
            $_SESSION['alerts']['danger'] = "Petit malin, l'id doit être sous forme numérique :D";
            header("location: /personnes");
            exit();
        }
        // On pourrait imaginer encore d'autre vérifications comme savoir si l'id est bien en base de donnée...

        $id = $_POST['personne_id'];
        $personneManager = new PersonneManager();

        if ($personneManager->deletePersonne($id)) {
            $_SESSION['alerts']['success'] = "Super, la personne a bien été supprimée !";
            header("location: /personnes");
            exit();
        } else {
            $_SESSION['alerts']['danger'] = "Un problème est survenu !";
            header("location: /personnes");
            exit();
        }
    }
}
