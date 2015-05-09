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
    public function twitterAction(Request $request)
    {
        $twit = new Twit();
        $form = $this->createFormBuilder($twit)
            ->add('name', 'text')
            ->add('message', 'text')
            ->add('image', 'text', ['required' => false])
            ->getForm();
        $form->handleRequest($request);

        if (!$form->isValid()) {
            $twit->setImage("");
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $twit->setCreatedAt(new \DateTime());
            $em->persist($twit);
            $em->flush();

            $twit = new Twit();
            $name = $form->get("name")->getData();
            $twit->setName($name);
            $form = $this->createFormBuilder($twit)
                ->add('name', 'text')
                ->add('message', 'text')
                ->add('image', 'text', ['required' => false])
                ->getForm();
        }

        $twits = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Twit')
            ->findBy(
                array(),
                array('createdAt' => 'DESC')
            );

        return array(
            "twits" => $twits,
            "form" => $form->createView()
        );
    }


    /**
     * @Route("/twitter_feed", name="_twitter_feed")
     * @Template("BurutMenuBundle:MiniTwitter:table.html.twig")
     */
    public function twitterFeedAction(Request $request)
    {
        $twits = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Twit')
            ->findBy(
                array(),
                array('createdAt' => 'DESC')
            );

        return array(
            "twits" => $twits,
        );
    }

}