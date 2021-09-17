<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use  App\Entity\Posts;
class Post extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $post= new Posts();
        $post->setDescription('asdasdasdasd');
        $post->setImageName('asdasdasdasdas');
        $post->setDate('Saturday July 4 2021 ');
        $post->setTrueDate(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));

        $manager->persist($post);
        $manager->flush();
    }
}
