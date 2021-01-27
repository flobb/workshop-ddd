<?php

namespace App\Infrastructure\Domain;

use Doctrine\Persistence\ManagerRegistry;

class DomainObjectManager
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function getManagerForClass(string $fqcn)
    {
        $em = $this->registry->getManagerForClass($fqcn);

        if (null === $em) {
            throw new \RuntimeException(\sprintf('No entity manager found for class "%s".', $fqcn));
        }

        return $em;
    }

    public function getRepositoryForClass(string $fqcn)
    {
        $repository = $this->registry->getRepository($fqcn);

        if (null === $repository) {
            throw new \RuntimeException(\sprintf('No repository found for class "%s".', $fqcn));
        }

        return $repository;
    }

    public function persist($object): void
    {
        $em = $this->getManagerForClass(get_class($object));

        $em->persist($object);
        $em->flush();
    }
}
