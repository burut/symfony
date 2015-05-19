<?php

# src/App/JoboardBundle/DataFixtures/ORM/LoadJobData

namespace App\JoboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\JoboardBundle\Entity\Job;

class LoadJobData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        for($i = 100; $i <= 130; $i++) {
            $job = new Job();
            $job->setCategory($em->merge($this->getReference('category-programming')));
            $job->setType('full-time');
            $job->setCompany('Company '.$i);
            $job->setPosition('Web Developer');
            $job->setLocation('Paris, France');
            $job->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit.');
            $job->setHowToApply('Send your resume to lorem.ipsum [at] dolor.sit');
            $job->setIsPublic(true);
            $job->setIsActivated(true);
            $job->setToken('job_'.$i);
            $job->setEmail('job@example.com');
            $job->setExpiresAt(new \DateTime('+30 days'));

            $em->persist($job);
        }


        $jobPartTime = new Job();
        $jobPartTime->setCategory($em->merge($this->getReference('category-design')));
        $jobPartTime->setType('part-time');
        $jobPartTime->setCompany('ООО Дизайн Компания');
        $jobPartTime->setLogo('design_company_logo.gif');
        $jobPartTime->setUrl('http://design.example.com/');
        $jobPartTime->setPosition('Web Дизайнер');
        $jobPartTime->setLocation('Москва');
        $jobPartTime->setDescription('Ищем профессионального дизайнера');
        $jobPartTime->setHowToApply('Высылайте резюме на designer_resume@example.com');
        $jobPartTime->setIsPublic(true);
        $jobPartTime->setIsActivated(true);
        $jobPartTime->setToken('designer_resume@example.com');
        $jobPartTime->setEmail('resume@example.com');
        $jobPartTime->setExpiresAt(new \DateTime('+30 days'));
        $em->persist($jobPartTime);
        $em->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}