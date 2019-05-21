<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class DevFixtures
 * User: Nessandro
 * Date: 2019-05-17
 * Time: 23:13
 */

class DevFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $fakeGenerator = Factory::create();

        $this->generatePosts($manager, $fakeGenerator);
        $this->generateComments($manager, $fakeGenerator);

    }

    /**
     * @description generate fake posts
     * @param ObjectManager $manager
     * @param Generator $fakeGenerator
     */
    private function generatePosts(ObjectManager $manager,Generator $fakeGenerator)
    {
        for($i = 0; $i < 30 ; $i++)
        {
            $post = new Post();
            $post->setContent($fakeGenerator->text(mt_rand(100,200)));
            $post->setTitle($fakeGenerator->sentence(mt_rand(2,5)));
            $post->setSrc($fakeGenerator->email);
            $post->setUid(mt_rand(1,10));
            $post->setCreatedAt($fakeGenerator->dateTimeThisMonth);

            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * @description
     * @param ObjectManager $manager
     * @param Generator $fakeGenerator
     */
    private function generateComments(ObjectManager $manager,Generator $fakeGenerator)
    {
        for($i = 0; $i < 1000 ; $i++)
        {
            $comment = new Comment();
            $comment->setCreatedAt($fakeGenerator->dateTimeThisMonth);
            $comment->setUid(mt_rand(1,10));
            $comment->setContent($fakeGenerator->sentence(mt_rand(3,15)));
            $comment->setPostId(mt_rand(1,30));
            $manager->persist($comment);
        }

        $manager->flush();
    }

}