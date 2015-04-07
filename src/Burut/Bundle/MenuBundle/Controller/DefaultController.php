<?php

namespace Burut\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    private $prod = [
        "гречка" => "10",
        "свечка" => "20",
        "печка" => "30",
        "хлеб" => "40",
        "сало" => "50",
        "мясо" => "60",
        "колюаса" => "70",
    ];

    private $products = [
        1 => [
            "title" => "Гречка",
            "price" => "10",
            "img"   => "http://www.likar.info/pictures_ckfinder/images/grechka-po-kupecheski-retsept2.jpg",
            "comments" => "Гречка – отличная замена мясу, благодаря хорошо растворимым и усваиваемым белкам, а также калорийности и приятному вкусу."
        ],
        2 => [
            "title" => "Свечка",
            "price" => "20",
            "img"   => "http://foto-ramki.com/predmety/clipart-svechki.png",
            "comments" => "Герой романа «Свечка» Евгений Золоторотов — ветеринарный врач, московский интеллигент, прекрасный сын, муж и отец"
        ],
        4 => [
            "title" => "Хлеб",
            "price" => "40",
            "img"   => "http://finansovoe-izobilie.ru/wp-content/uploads/hleb.jpg",
            "comments" => "Хлеб — пищевой продукт, получаемый путём выпечки, паровой обработки или жарки теста, состоящего, как минимум, из муки и воды"
        ],
        7 => [
            "title" => "Колбаса",
            "price" => "70",
            "img"   => "http://www.ua.all.biz/img/ua/catalog/98295.jpeg",
            "comments" => "В детстве, бабушка в селе колбасу делала сама. Эта домашняя колбаса давно стала частью семейной традиции."
        ]

    ];

    private $faqs = [
        0 => ["-" => "-"],
        1 => ["Вопрос номер 1" => "Ответ 1 ответ ответ орлырволв ывддловл"],
        2 => ["Вопрос 2" => "Ответ 2 kjhkjhf"],
        3 => ["Вопрос 3" => "qqqqqqqqqqqqqqqqqqqqqqqq qqq"],
        4 => ["Вопрос 4" => "kjhk kj hkj kjh kj"],
        5 => ["Вопрос 5" => "-----2234378  4378u h"]
    ];

    private $contacts = [
        "Иванов Иван" => "123-45-67",
        "Петров Петр" => "3456-67-8",
        "Сидоров Сидр" => "76-34-554"
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
        return array("cont" => $this->contacts);
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

    /**
     * @Route("/products")
     * @Template("BurutMenuBundle:Default:products.html.twig")
     */
    public function productsAction()
    {
        return array("products" => $this->products);
    }

    /**
     * @Route("/product/{id}")
     * @Template("BurutMenuBundle:Default:product.html.twig")
     */
    public function productAction($id)
    {
        if (!isset($this->products[$id])) {
            return array("id" => 0);
            }
        return array("product" => $this->products[$id], "id" => $id);
    }


}
