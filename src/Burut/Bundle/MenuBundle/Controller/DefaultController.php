<?php

namespace Burut\Bundle\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Burut\Bundle\MenuBundle\Entity\Client;
use Burut\Bundle\MenuBundle\Entity\Oursites;
use Burut\Bundle\MenuBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller

{
    private $prod = [
        "гречка" => "10",
        "свечка" => "20",
        "печка" => "30",
        "хлеб" => "40",
        "сало" => "50",
        "мясо" => "60",
        "колбаса" => "70",
    ];

    private $products = [
        1 => [
            "title" => "Гречка",
            "price" => "10",
            "img" => "http://www.likar.info/pictures_ckfinder/images/grechka-po-kupecheski-retsept2.jpg",
            "comments" => "Гречка – отличная замена мясу, благодаря хорошо растворимым и усваиваемым белкам, а также калорийности и приятному вкусу."
        ],
        2 => [
            "title" => "Свечка",
            "price" => "20",
            "img" => "http://foto-ramki.com/predmety/clipart-svechki.png",
            "comments" => "Герой романа «Свечка» Евгений Золоторотов — ветеринарный врач, московский интеллигент, прекрасный сын, муж и отец"
        ],
        4 => [
            "title" => "Хлеб",
            "price" => "40",
            "img" => "http://finansovoe-izobilie.ru/wp-content/uploads/hleb.jpg",
            "comments" => "Хлеб — пищевой продукт, получаемый путём выпечки, паровой обработки или жарки теста, состоящего, как минимум, из муки и воды"
        ],
        7 => [
            "title" => "Колбаса",
            "price" => "70",
            "img" => "http://www.ua.all.biz/img/ua/catalog/98295.jpeg",
            "comments" => "В детстве, бабушка в селе колбасу делала сама. Эта домашняя колбаса давно стала частью семейной традиции."
        ]
    ];
    private $ourteams = [
        1 => [
            "name" => "burut",
            "position" => "студент прохладной жизни",
            "age" => "33",
            "photo" => "https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQ2ZUs2fDu1wp3_AUhA8zXum9T2aUREZn8PwDYjQpQWqffvWEpZ",
            "bio" => "жестяк!!!!"
        ],
        2 => [
            "name" => "skylabs",
            "position" => "синьор помидор",
            "age" => "32",
            "photo" => "http://klaw.ru/images/0/image-342.jpg",
            "bio" => "торговля воздухом "
        ],
        3 => [
            "name" => "гонзик",
            "position" => "обер-атаман",
            "age" => "сей факт науке не известен!!!!",
            "photo" => "data:image/jpeg;base64,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",
            "bio" => "все печально"
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

               //             /**
               //              * @Route("/products")
               //              * @Template("BurutMenuBundle:Default:products.html.twig")
               //              */
               //             public function productsAction()
               //             {
               //                 return array("products" => $this->products);
               //                 }
               //
               //             /**
               //              * @Route("/product/{id}")
               //              * @Template("BurutMenuBundle:Default:product.html.twig")
               //              */
               //             public function productAction($id)
               //             {
               //                 if (!isset($this->products[$id])) {
               //                     return array("id" => 0);
               //                 }
               //                 return array("product" => $this->products[$id], "id" => $id);
               //             }

    /**
     * @Route("/ourteams")
     * @Template("BurutMenuBundle:Default:ourteams.html.twig")
     */
    public function ourteamAction()
    {
        return array("ourteam" => $this->ourteams);
    }

    /**
     * @Route("/ourteam/{id}")
     * @Template("BurutMenuBundle:Default:ourteam.html.twig")
     */
    public function ourteamsAction($id)
    {
        if (!isset($this->ourteams[$id])) {
            return array("id" => 0);
        }
        return array("ourteam" => $this->ourteams[$id], "id" => $id);
    }

    /**
     * @Route("/client_create", name="_client_create")
     */
    public function clientCreateAction()
    {
        $client = new Client();
        $client->setName("");
        $client->setAddress("");
        $client->setPhone("");
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($client);
        $em->flush();
        return $this->redirectToRoute('_client_edit', array('id'=>$client->getId()));
    }

    /**
     * @Route("/client/list", name="_client_list")
     * @Template("BurutMenuBundle:Default:client_list.html.twig")
     */
    public function clientsListAction()
    {
        $clients = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Client')
            ->findAll();
        return array("clients" => $clients);

    }

    /**
     * @Route("/client/delete/{id}")
     */
    public function clientDeleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $client = $em->getRepository('Burut\Bundle\MenuBundle\Entity\Client')->find($id);

        if (!$client) {
            throw $this->createNotFoundException('No client found for id '.$id);
        }

        $em->remove($client);
        $em->flush();

        return $this->redirectToRoute('_client_list');
    }

    /**
     * @Route("/client/edit/{id}", name="_client_edit")
     * @Template("BurutMenuBundle:Default:client_edit.html.twig")
     */
    public function clientEditAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $client = $em->getRepository('Burut\Bundle\MenuBundle\Entity\Client')->find($id);

        $form = $this->createFormBuilder($client)
            ->add('name', 'text')
            ->add('address', 'text')
            ->add('phone', 'text')
            ->getForm();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($client);
                $em->flush();
                return $this->redirectToRoute('_client_list');
            }
            return array(
            "client" => $client,
            "form" => $form->createView());
    }

    /**
     * @Route("/site_create", name="_site_create")
     */
    public function siteCreateAction()
    {
        $site = new Oursites();
        $site->setTitle("");
        $site->setUrl("");
        $site->setAuthor("");
        $site->setCategory("");
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($site);
        $em->flush();
        return $this->redirectToRoute('_site_edit', array('id'=>$site->getId()));
    }

    /**
     * @Route("/site/list", name="_site_list")
     * @Template("BurutMenuBundle:Default:our_site_list.html.twig")
     */
    public function siteListAction()
    {
        $sites = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Oursites')
            ->findAll();
        return array("sites" => $sites);

    }

    /**
     * @Route("/site/delete/{id}")
     */
    public function siteDeleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $site = $em->getRepository('Burut\Bundle\MenuBundle\Entity\Oursites')->find($id);

        if (!$site) {
            throw $this->createNotFoundException('No site found for id '.$id);
        }

        $em->remove($site);
        $em->flush();

        return $this->redirectToRoute('_site_list');
    }

    /**
     * @Route("/site/edit/{id}", name="_site_edit")
     * @Template("BurutMenuBundle:Default:our_sites_edit.html.twig")
     */
    public function siteEditAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $site = $em->getRepository('BurutMenuBundle:Oursites')->find($id);

        $form = $this->createFormBuilder($site)
            ->add('title', 'text')
            ->add('url', 'text')
            ->add('author', 'text')
            ->add('category', 'text')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($site);
            $em->flush();
            return $this->redirectToRoute('_site_list');
        }
        return array(
            "site" => $site,
            "form" => $form->createView());
    }

    // - загоняем в базу product

    /**
     * @Route("/product_create", name="_product_create")
     */
    public function productCreateAction()
    {
        $product = new Product();
        $product->setTitle("");
        $product->setPrice("");
        $product->setImg("");
        $product->setComments("");
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();
        return $this->redirectToRoute('_site_edit', array('id'=>$product->getId()));
    }

    /**
     * @Route("/products/list", name="_product_list")
     * @Template("BurutMenuBundle:Default:products.html.twig")
     */
    public function productListAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('Burut\Bundle\MenuBundle\Entity\Product')
            ->findAll();
         if (!count($products))
         {
             foreach ($this->products as $prod) {

                 $product = new Product();
                 $product->setTitle($prod["title"]);
                 $product->setPrice($prod["price"]);
                 $product->setImg($prod["img"]);
                 $product->setComments($prod["comments"]);
                 $em = $this->getDoctrine()->getEntityManager();
                 $em->persist($product);
                 $em->flush();
             }


         }
            return array("products" => $products);
    }

    /**
     * @Route("/product/delete/{id}")
     */
    public function productDeleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('Burut\Bundle\MenuBundle\Entity\Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('_product_list');
    }

    /**
     * @Route("/product/edit/{id}", name="_product_edit")
     * @Template("BurutMenuBundle:Default:product_edit.html.twig")
     */
    public function productEditAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('BurutMenuBundle:Product')->find($id);

        $form = $this->createFormBuilder($product)
            ->add('title', 'text')
            ->add('url', 'text')
            ->add('author', 'text')
            ->add('category', 'text')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('_product_list');
        }
        return array(
            "site" => $product,
            "form" => $form->createView());
    }

                /**
                  * @Route("/product/{id}")
                  * @Template("BurutMenuBundle:Default:product.html.twig")
                  */
                 public function productAction($id)
                 {
                     $em = $this->getDoctrine()->getEntityManager();
                     $product = $em->getRepository('Burut\Bundle\MenuBundle\Entity\Product')->find($id);

                     if (!isset($this->products[$id])) {
                         return array("id" => 0);
                     }
                     return array("product" => $product, "id" => $id);
                 }


}
