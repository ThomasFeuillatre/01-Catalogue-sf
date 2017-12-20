<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Jeu;

class DefaultController extends Controller
{
    /**
     * @Route("/{categorie}_{id}", name="homepage")
     */
    public function indexAction(Request $request,$categorie = null,$id = null)
    {
        $repositoryJeu = $this->getDoctrine()->getRepository("AppBundle:Jeu");

        if(isset($id))
        {
            $listeJeux = $repositoryJeu->findByCategorie($id);
        }
        else
        {
            $listeJeux = $repositoryJeu->findAll();
        }


        $repositoryCategorie = $this->getDoctrine()->getRepository("AppBundle:Categorie");
        $listeCategorie = $repositoryCategorie->findAll();

        return $this->render('default/index.html.twig',['listeJeux' => $listeJeux,'listeCategorie' => $listeCategorie]);
    }

    /**
     * @Route("/detail/{id}", name="detail",  requirements={"id"="\d+"})
     */
    public function detail(Request $request, $id)
    {
        $repositoryJeu = $this->getDoctrine()->getRepository("AppBundle:Jeu");
        $jeu = $repositoryJeu->find($id);
        return $this->render('default/detail.html.twig',['jeu' => $jeu]);
    }

    /**
     * @Route("/edition/{id}", name="editor",  requirements={"id"="\d+"})
     */
    public function editor(Request $request, $id)
    {

        $repositoryJeu = $this->getDoctrine()->getRepository("AppBundle:Jeu");
        $jeu = $repositoryJeu->find($id);


        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class,$jeu);
        $formBuilder
            ->add('title', TextType::class)
            ->add('descrCourte', TextareaType::class)
            ->add('descLong', TextareaType::class)
            ->add('submit', SubmitType::class, array(
            'label' => 'Valider',
            'attr'  => array('class' => 'btn btn-default pull-right')
            ));
        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jeu);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'detail',
                array('id' => $jeu->getId())
            ));
        }

        return $this->render('default/editor.html.twig',['form' => $form->createView(), 'jeu' => $jeu]);
    }
}
