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
     * @Route("/twitter", name="_twit_edit")
     * @Template("BurutMenuBundle:MiniTwitter:twitter.html.twig")
     */
//    public function twitEditAction(Request $request)
//    {
//
//        $twit = $this->getDoctrine()
//            ->getRepository('Burut\Bundle\MenuBundle\Entity\Twit')
//            ->findAll();
//
//       // $em = $this->getDoctrine()->getEntityManager();
//       // $twit = $em->getRepository('BurutMenuBundle:Twit')->find($id);
//
//        $form = $this->createFormBuilder($twit)
//            ->add('name', 'text')
//            ->add('message', 'text')
//            ->add('image', 'text')
//            ->getForm();
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getEntityManager();
//            $em->persist($twit);
//            $em->flush();
//            var_dump($twit, $form);
//        }
//        return array(
//            "twits" => $twit,
//            "form" => $form->createView()
//            );
//    }

    public function twitterAction(Request $request)
    {
        $twit = new Twit();

        $form = $this->createFormBuilder($twit)
            ->add('name', 'text')
            ->add('message', 'text')
            ->add('image', 'text')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $twit->setCreatedAt(new \DateTime());
            $em->persist($twit);
            $em->flush();
        }

        $twits = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Twit')
            ->findBy(
                array(),
                array('created_at' => 'DESC')
            );

        return array(
            "twits" => $twits,
            "form" => $form->createView()
        );
    }


//    /**
//     * @Route("/twitter", name="_twitter")
//     * @Template("BurutMenuBundle:MiniTwitter:twitter.html.twig")
//     */
//    public function twitAction()
//    {
//        $twits = $this->getDoctrine()
//            ->getRepository('Burut\Bundle\MenuBundle\Entity\Twit')
//            ->findAll();
//        return array("twits" => $twits,
//            );
//    }

}