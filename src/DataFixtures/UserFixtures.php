<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Achraf');
        $user->setPassword('$2y$13$Vj/u61vOIhcvKkh8Lv/dC./8Pfp930SFp0lGIJiI4BpA8lhmQjTlq');

        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$RLiDG0UUDcgk8lRj/vC57e/PQzj.TraBrxhlAXbya01PvcFsyL/fa');
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $manager->flush();
    }
}
