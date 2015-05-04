<?php

namespace Burut\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Burut\Bundle\MenuBundle\Entity\Twit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class MiniTwitterController extends Controller

{
    /**
     * @Route("/twit_create", name="_twit_create")
     */
    public function productCreateAction()
    {
        $twit = new Twit();
        $twit->setCreatedAt("");
        $twit->setName("");
        $twit->setMessage("");
        $twit->setImage("");
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($twit);
        $em->flush();
        var_dump($twit);
        return $this->redirectToRoute('_twit_edit', array('id'=>$twit->getId()));
    }

    /**
     * @Route("/twit/edit", name="_twit_edit")
     * @Template("BurutMenuBundle:MiniTwitter:twit.html.twig")
     */
    public function twitEditAction($id, Request $request)
    {

        $twit = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Twit')
            ->find($id);

       // $em = $this->getDoctrine()->getEntityManager();
       // $twit = $em->getRepository('BurutMenuBundle:Twit')->find($id);

        $form = $this->createFormBuilder($twit)
            ->add('name', 'text')
            ->add('message', 'text')
            ->add('image', 'text')
            ->getForm();
        $form->handleRequest($request);
        var_damp($twit, $form);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($twit);
            $em->flush();
            var_damp($twit, $form);
            return array(
                "twit" => $twit,
                "form" => $form->createView()
            );
        }
        var_damp($twit, $form);
            return array(
            "twit" => $twit,
            "form" => $form->createView()
            );
    }

    /**
     * @Route("/twitter", name="_twitter")
     * @Template("BurutMenuBundle:MiniTwitter:twitter.html.twig")
     */
    public function twitAction()
    {
        $twits = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Twit')
            ->findAll();
        return array("twits" => $twits,
            );
    }

}