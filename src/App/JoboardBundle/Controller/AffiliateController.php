<?php

# src/App/JoboardBundle/Controller/AffiliateController.php

namespace App\JoboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\JoboardBundle\Entity\Affiliate;
use App\JoboardBundle\Form\AffiliateType;
use Symfony\Component\HttpFoundation\Request;
use App\JoboardBundle\Entity\Category;

class AffiliateController extends Controller
{
    public function newAction()
    {
        $entity = new Affiliate();
        $form   = $this->createForm(new AffiliateType(), $entity);

        return $this->render('AppJoboardBundle:Affiliate:affiliate_new.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }

    public function createAction(Request $request)
    {
        $affiliate = new Affiliate();
        $form = $this->createForm(new AffiliateType(), $affiliate);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $formData = $request->get('affiliate');
            $affiliate->setUrl($formData['url']);
            $affiliate->setEmail($formData['email']);
            $affiliate->setIsActive(false);

            $em->persist($affiliate);
            $em->flush();

            return $this->redirect($this->generateUrl('app_affiliate_wait'));
        }

        return $this->render('AppJoboardBundle:Affiliate:affiliate_new.html.twig', [
            'entity' => $affiliate,
            'form'   => $form->createView(),
        ]);
    }

    public function waitAction()
    {
        return $this->render('AppJoboardBundle:Affiliate:wait.html.twig');
    }
}