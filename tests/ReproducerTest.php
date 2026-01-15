<?php

namespace App\Tests;

use App\Entity\InverseSide;
use App\Entity\OwningSide;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\DependencyInjection\ServicesResetterInterface;
use Symfony\Component\HttpKernel\Kernel;
use Zenstruck\Foundry\Test\Factories;

use function Zenstruck\Foundry\Persistence\persistent_factory;

class ReproducerTest extends KernelTestCase
{
    use Factories;

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $entityManager = self::getContainer()->get('doctrine.orm.default_entity_manager');

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropDatabase();
        $schemaTool->updateSchema($metadata);
    }

    #[Test]
    public function one_to_one_with_owning_entity_as_id(): void
    {
        $this->expectNotToPerformAssertions();

        $owningSideFactory = persistent_factory(OwningSide::class)->withAutorefresh();
        $inverseSideFactory = persistent_factory(InverseSide::class)->withAutorefresh();

        $inverseSide = $inverseSideFactory->create(['owningSide' => $owningSideFactory]);

        $owningSideFactory::assert()->count(1);
        $inverseSideFactory::assert()->count(1);

        // we reset services here to have fresh entitymanager etc. i guess? Without this, refresh wont be triggered
        self::getContainer()->get(ServicesResetterInterface::class)->reset();

        $inverseSide->getStatus();
    }
}
