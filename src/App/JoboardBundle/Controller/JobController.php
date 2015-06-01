<?php

namespace App\JoboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\JoboardBundle\Entity\Job;
use App\JoboardBundle\Form\JobType;

/**
 * Job controller.
 *
 */
class JobController extends Controller
{

    /**
     * Lists all Job entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppJoboardBundle:Category')->getWithJobs();

        foreach($categories as $category) {
            $category->setActiveJobs($em->getRepository('AppJoboardBundle:Job')->getActiveJobs(
                $category->getId(),
                $this->container->getParameter('max_jobs_on_homepage'))
            );

            $activeJobsCount = $em->getRepository('AppJoboardBundle:Job')->countActiveJobs($category->getId());

            if ($activeJobsCount >= $this->container->getParameter('max_jobs_on_homepage')) {
                $activeJobsCount -= $this->container->getParameter('max_jobs_on_homepage');
                $category->setMoreJobs($activeJobsCount);
            }
        }

        return $this->render('AppJoboardBundle:Job:index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * Creates a new Job entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Job();
        $form = $this->createForm(new JobType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('app_job_preview', array(
                'company' => $entity->getCompanySlug(),
                'location' => $entity->getLocationSlug(),
                'token' => $entity->getToken(),
                'position' => $entity->getPositionSlug()
            )));
        }

        return $this->render('AppJoboardBundle:Job:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Job entity.
     *
     * @param Job $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Job $entity)
    {
        $form = $this->createForm(new JobType(), $entity, array(
            'action' => $this->generateUrl('app_job_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Job entity.
     *
     */
    public function newAction()
    {
        $entity = new Job();
        $entity->setType('full-time');
        $form = $this->createForm(new JobType(), $entity, [
            'action' => $this->generateUrl('app_job_create'),
            'method' => 'POST',
        ]);

        return $this->render('AppJoboardBundle:Job:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Job entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppJoboardBundle:Job')->getActiveJob($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $session = $this->get('session');

        // получить вакансии, которые уже есть в истории
        $jobs = $session->get('job_history', []);

        $job = [
            'id' => $entity->getId(),
            'position' =>$entity->getPosition(),
            'company' => $entity->getCompany(),
            'companyslug' => $entity->getCompanySlug(),
            'locationslug' => $entity->getLocationSlug(),
            'positionslug' => $entity->getPositionSlug()
        ];

        if (!in_array($job, $jobs)) {
            // добавить текущую вакансию в начало массива
            array_unshift($jobs, $job);

            // обновить истории посещений
            $session->set('job_history', array_slice($jobs, 0, 3));
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppJoboardBundle:Job:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     */
    public function editAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppJoboardBundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Такой вакансии не существует.');
        }

        if ($entity->getIsActivated()) {
            throw $this->createNotFoundException('Эта вакансия опубликована и не может быть отредактирована.');
        }

        $editForm = $this->createForm(new JobType(), $entity, [
            'action' => $this->generateUrl('app_job_update', ['token' => $token]),
            'method' => 'PUT',
        ]);
        $deleteForm = $this->createDeleteForm($token);

        return $this->render('AppJoboardBundle:Job:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Job entity.
    *
    * @param Job $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Job $entity)
    {
        $form = $this->createForm(new JobType(), $entity, array(
            'action' => $this->generateUrl('app_job_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Job entity.
     *
     */
    public function updateAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppJoboardBundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Такой вакансии не существует.');
        }

        $editForm   = $this->createForm(new JobType(), $entity, [
            'action' => $this->generateUrl('app_job_update', ['token' => $token]),
            'method' => 'PUT'
        ]);
        $deleteForm = $this->createDeleteForm($token);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('app_job_preview', array(
                'company' => $entity->getCompanySlug(),
                'location' => $entity->getLocationSlug(),
                'token' => $entity->getToken(),
                'position' => $entity->getPositionSlug()
            )));
        }

        return $this->render('AppJoboardBundle:Job:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Job entity.
     *
     */
    public function deleteAction(Request $request, $token)
    {
        $form = $this->createDeleteForm($token);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppJoboardBundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Такой вакансии не существует.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('app_job'));
    }

    /**
     * Creates a form to delete a Job entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($token)
    {
        return $this->createFormBuilder(['token' => $token])
            ->add('token', 'hidden')
            ->getForm()
            ;
    }

    public function previewAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppJoboardBundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Такой вакансии не существует.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());
        $publishForm = $this->createPublishForm($entity->getToken());
        $extendForm = $this->createExtendForm($entity->getToken());

        return $this->render('AppJoboardBundle:Job:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'publish_form' => $publishForm->createView(),
            'extend_form' => $extendForm->createView(),
        ));
    }

    public function publishAction(Request $request, $token)
    {
        $form = $this->createPublishForm($token);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppJoboardBundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Такой вакансии не существует.');
            }

            $entity->publish();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Ваша вакансия опубликована на 30 дней.');
        }

        return $this->redirect($this->generateUrl('app_job_preview', array(
            'company' => $entity->getCompanySlug(),
            'location' => $entity->getLocationSlug(),
            'token' => $entity->getToken(),
            'position' => $entity->getPositionSlug()
        )));
    }

    private function createPublishForm($token)
    {
        return $this->createFormBuilder(array('token' => $token))
            ->add('token', 'hidden')
            ->getForm()
            ;
    }

    public function extendAction($token)
    {
        $form = $this->createExtendForm($token);
        $request = $this->get('request');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppJoboardBundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Такой вакансии не существует.');
            }

            if(!$entity->extend()){
                throw $this->createNodFoundException('Невозможно пролдить вакансию');
            }

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', sprintf('Ваша вакансия продлена до %s', $entity->getExpiresAt()->format('m/d/Y')));
        }

        return $this->redirect($this->generateUrl('app_job_preview', [
            'company'  => $entity->getCompanySlug(),
            'location' => $entity->getLocationSlug(),
            'token'    => $entity->getToken(),
            'position' => $entity->getPositionSlug()
        ]));
    }

    private function createExtendForm($token)
    {
        return $this->createFormBuilder(['token' => $token])
            ->add('token', 'hidden')
            ->getForm();
    }


}
