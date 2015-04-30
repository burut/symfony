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
        3 => [
            "title" => "Хлеб",
            "price" => "40",
            "img" => "http://finansovoe-izobilie.ru/wp-content/uploads/hleb.jpg",
            "comments" => "Хлеб — пищевой продукт, получаемый путём выпечки, паровой обработки или жарки теста, состоящего, как минимум, из муки и воды"
        ],
        4 => [
            "title" => "Колбаса",
            "price" => "70",
            "img" => "http://www.ua.all.biz/img/ua/catalog/98295.jpeg",
            "comments" => "В детстве, бабушка в селе колбасу делала сама. Эта домашняя колбаса давно стала частью семейной традиции."
        ]
];


}