<?php

namespace Burut\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    public $faqs = [
        0 => ["---------------------" => "--------------------"],
        1 => ["Вопрос номер 1" => "Ответ 1 ответ ответ орлырволв ывддловл"],
        2 => ["Вопрос 2" => "Ответ 2 kjhkjhf"],
        3 => ["Вопрос 3" => "qqqqqqqqqqqqqqqqqqqqqqqq qqq"],
        4 => ["Вопрос 4" => "kjhk kj hkj kjh kj"],
        5 => ["Вопрос 5" => "-----2234378  4378u h"]
    ];


    /**
     * @Route("/")
     * @Template("BurutMenuBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        return array('text' => "main page");
    }

    /**
     * @Route("/about")
     * @Template("BurutMenuBundle:Default:about.html.twig")
     */
    public function aboutAction()
    {
        return array('text' => "about page");
    }

    /**
     * @Route("/contacts")
     * @Template("BurutMenuBundle:Default:contacts.html.twig")
     */
    public function contactsAction()
    {
        return array();
    }

    /**
     * @Route("/help")
     * @Template("BurutMenuBundle:Default:help.html.twig")
     */
    public function helpAction()
    {
        return array();
    }

    /**
     * @Route("/faq")
     * @Template("BurutMenuBundle:Default:faq.html.twig")
     */
    public function faqAction()
    {
        return array("faqs" => $this->faqs);
    }

    /**
     * @Route("/faq/{id}")
     * @Template("BurutMenuBundle:Default:faq_id.html.twig")
     */
    public function faqIdAction($id)
    {
        if (!isset($this->faqs[$id])) {
            $id = 0;
        }

        $faq = $this->faqs[$id];
        $question = key($faq);
        $answer = $faq[$question];

        return array("q" => $question, "a" => $answer, "id" => $id);
    }
}
