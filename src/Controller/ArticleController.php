<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_liste")
     */
    public function listeArticles(ArticleRepository $repo)
    {
        //chercher l'ensemble des articles et on le stock
        $articles=$repo->findAll();
        return $this->render('/article/index.html.twig', [
            'articles' => $articles //on va le donner dans twig
        ]);
    }

    /**
     * @Route("/articlesAdmin", name="articles_admin")
     */
    public function listeAdmin(ArticleRepository $repo)
    {
        //chercher l'ensemble des articles et on le stock
        $articlesAdmin=$repo->findAll();
        return $this->render('/article/show.html.twig', [
            'articles' => $articlesAdmin //on va le donner dans twig
        ]);
    }

    /**
     * Permet de creer un article
     *
     * @Route("article/new", name="article_create")
     * 
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager){
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        //lien entre le champ du formulaire a la variable $ad
        $form->handleRequest($request);


        //est ce qu'il a eté soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

           $manager->persist($article); //elle persiste
           $manager->flush(); //pour que la requete parte belle et bien
          
           //message d'alerte de creation d'annonce
           $this->addFlash(
            'success' , "L'article <strong>{$article->getLibelle()}</strong> a bien été enregistrée !"
           );

           return $this->redirectToRoute('articles_liste');
        }

        return $this->render('article/new.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * Permet de voir un seul article
     * 
     * @Route("/article/{id}", name="article_affiche")
     * 
     * @return Response
     */
    public function afficheArticle($id, Article $article)
    {
        return $this->render('/article/afficheArticle.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * Permet de supprimer un article
     * 
     * @Route("/article/delete/{id}", name="article_delete")
     * 
     * 
     * @param Article $article
     * @param ObjectManager $manager
     * @return Response 
     */
        public function delete(Article $article, ObjectManager $manager ){
            
            $manager->remove($article);
            $manager->flush();

            $this->addFlash(
                'danger' , "L'article <strong>{$article->getLibelle()}</strong> a bien été supprimé !"
            );

        return $this->redirectToRoute('articles_admin');

    }

     /**
     * Permet d'afficher le formulaire d'edition
     * 
     *
     * 
     * @Route("/article/edit/{id}", name="article_edit")
     * 
     * @return Response
     */
    public function edit(Article $article, Request $request, ObjectManager $manager){
        
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

           $manager->persist($article); //elle persiste
           $manager->flush();

           $this->addFlash(
            'success' , "L'article <strong>{$article->getLibelle()}</strong> a bien été enregistré !"
           );


           return $this->redirectToRoute('article_affiche',[
            'id' => $article->getId()
           ]);
            
        }
        return $this->render('article/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

}
