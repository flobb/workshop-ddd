<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Domain\Stakeholder\Model\User;
use App\Infrastructure\Domain\DomainObjectManager;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }

    /**
     * @When i call the url :path
     */
    public function iCallTheUrl(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @When do something strange
     */
    public function doSomethingStrange()
    {
        throw new PendingException();
    }

    /**
     * @When I add a user with the userid :uuid and email :email
     */
    public function iAddAUserWithTheUseridAndEmail(string $uuid, string $email)
    {
        $user = new User();
        $user->setUserId($uuid);
        $user->setEmail($email);
        $user->setPassword(uniqid('password', true));

        $this->kernel->getContainer()->get(DomainObjectManager::class)->persist($user);
    }

    /**
     * @When the user table is empty
     */
    public function theUserTableIsEmpty()
    {
        $this->kernel->getContainer()->get('doctrine.dbal.stakeholder_connection')->executeQuery('TRUNCATE User');
    }
}
