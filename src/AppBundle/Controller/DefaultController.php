<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ContactType;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="contact_listing")
     */
    public function listingAction(Request $request)
    {
        // On récupère les contacts
        $contactList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Contact')
            ->findAll();

        // On affiche la liste des contacts
        return $this->render('contact/listing.html.twig', [
            'contactList' => $contactList
        ]);
    }

    /**
     * @Route("/contact/add", name="contact_add")
     */
    public function addAction(Request $request)
    {
        // On crée un nouveau contact
        $contact = new Contact();

        // On prépare le formulaire
        $form = $this->createForm(ContactType::class, $contact);
        // On lie le formulaire à la requête
        $form->handleRequest($request);

        // Si le formulaire a été posté
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // On enregistre notre contact en bdd
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
            } catch(\Exception $e) {
                // L'enregistrement a échoué, on affiche un message d'erreur
                $request->getSession()->getFlashBag()->add('error', 'L\'ajout du contact a échoué.');
                // Puis on redirige vers la liste des contacts
                return $this->redirect($this->generateUrl('contact_listing'));
            }
            // L'enregistrement a marché, on affiche un message de confirmation
            $request->getSession()->getFlashBag()->add('success', 'Votre contact a bien été enregistré.');
            // Puis on redirige vers la liste des contacts
            return $this->redirect($this->generateUrl('contact_listing'));
        }

        // Le formulaire n'a pas été posté ou contient une erreur, on affiche le formulaire
        return $this->render('contact/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contact/edit/{id}",
     *     requirements={"id": "\d+"}, name="contact_edit")
     */
    public function editAction(Request $request, $id)
    {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        // On récupère le contact correspondant au paramètre $id
        $contact = $em->getRepository('AppBundle:Contact')->find($id);
        // Si le contact n'existe pas, on affiche une erreur 404
        if($contact === null)
        {
            throw $this->createNotFoundException('Le contact demandé n\'existe pas.');
        }
        // On crée le formulaire à partir du contact à modifier
        $form = $this->createForm(new ContactType(), $contact);
        // On lie le formulaire à la requête et on vérifie que les valeurs entrées sont correctes
        if($form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connaît déjà le contact
            try {
                $em->flush();
            } catch(\Exception $e) {
                // L'enregistrement a échoué, on affiche un message d'erreur
                $request->getSession()->getFlashBag()->add('error', 'L\'édition du contact a échoué.');
                // Puis on redirige vers la liste des contacts
                return $this->redirect($this->generateUrl('contact_listing'));
            }
            // On affiche un message de confirmation
            $request->getSession()->getFlashBag()->add('success', 'Votre contact a bien été modifié.');
            // On redirige vers la liste des contacts
            return $this->redirect($this->generateUrl('contact_listing'));
        }

        // Si on est là, c'est que le formulaire n'a pas été posté ou comporte des erreurs
        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/contact/delete/{id}",
     *     requirements={"id": "\d+"}, name="contact_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        // On récupère le contact correspondant à $id
        $contact = $em->getRepository('AppBundle:Contact')->find($id);
        // Si le contact n'existe pas, on affiche une erreur 404
        if($contact === null)
        {
            throw $this->createNotFoundException('Le contact demandé n\'existe pas.');
        }
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        $form = $this->createFormBuilder()->getForm();
        // On lie le formulaire à la requête et on vérifie qu'il est valide
        if($form->handleRequest($request)->isValid()) {
            // On supprime le contact
            try {
                $em->remove($contact);
                $em->flush();
            } catch(\Exception $e) {
            // L'enregistrement a échoué, on affiche un message d'erreur
            $request->getSession()->getFlashBag()->add('error', 'La suppression du contact a échoué.');
            // Puis on redirige vers la liste des contacts
            return $this->redirect($this->generateUrl('contact_listing'));
        }
            // On affiche un message de confirmation
            $request->getSession()->getFlashBag()->add('success', 'Votre contact a bien été supprimé.');
            // Puis on redirige vers la page d'accueil
            return $this->redirect($this->generateUrl('contact_listing'));
        }

        // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
        return $this->render('contact/delete.html.twig', [
            'contact' => $contact,
            'form' => $form->createView()
        ]);
    }

}
