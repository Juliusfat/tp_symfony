<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;


use AppBundle\Entity\Utilisateur;
use Doctrine\DBAL\Types\FloatType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AppController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();
        $session = $request->getSession();

        if (!$session->has('panier')){
            $session->set('panier',[]);
        }

        $panier=$session->get('panier');



        return $this->render('app/index.html.twig', [
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/display/{id}", name="article_display")
     */
    public function displayAction(Request $request, $id)
    {
        /** @var  $em */
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);
        return $this->render('app/display.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     */
    public function deleteArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (!$article instanceof Article) {
            $this->addFlash('primary', "L'article n'existe pas");
        }

        /** @var Article $article */

        $em->remove($article);
        $em->flush();
        $this->addFlash('success', "L'article " . $id . " a bien été supprimé");

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/creation", name="article_creation")
     */
    public function creationArticleAction(Request $request)
    {
        $article = new Article();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $article);
        // ajout des champs du formulaire
        $formBuilder

            ->add('nom',     TextType::class)
            ->add('description',   TextareaType::class)
            ->add('prix',    NumberType::class)
            ->add('stockrestant', IntegerType::class)
            ->add('valider', SubmitType::class);


        //on récupère l'objet form
        $form = $formBuilder->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                $this->addFlash('success', "l'article a bien été ajouté");
                return $this->redirectToRoute('article_creation');
            }
        }

        return $this->render('app/form.html.twig', ['formArticle' => $form->createView()]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscriptionAction(Request $request)
    {
        $user = new Utilisateur();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);
        // ajout des champs du formulaire
        $formBuilder

            ->add('nom',     TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('codePostal',   IntegerType::class)
            ->add('telephone',    TextType::class)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('valider', SubmitType::class);


        //on récupère l'objet form
        $form = $formBuilder->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', "l'utilisateur a bien été enregistré");
                return $this->redirectToRoute('inscription');
            }
        }

        return $this->render('app/inscription.html.twig',['formUser' => $form->createView()]);
    }

    /**
     * @Route("/panier/{id}", name="panier")
     */
    public function panierAction(Request $request,$id)
    {
        // Gestion de la session et du panier
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->find($id);

        if ($article = null) {
            $this->addFlash('danger', "l'article n'existe pas");
            return $this->redirectToRoute('homepage');
        }

        $session = $request->getSession();

        if (!$session->has('panier')){
            $session->set('panier',[]);
        }

        $panier=$session->get('panier');


        if(array_key_exists($id, $panier)){
            $panier[$id]+=1;
        } else {
            $panier[$id]=1;
        }
        $session->set('panier',$panier);

        $this->addFlash('success', "article ajouté au panier");

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/commande", name="commande")
     */
    public function commandeAction(Request $request)
    {


        return $this->render('app/commande.html.twig');
    }
}

