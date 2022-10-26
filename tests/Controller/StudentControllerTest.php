<?php

namespace App\Test\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StudentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private StudentRepository $repository;
    private string $path = '/student/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Student::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Student index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'student[NSC]' => 'Testing',
            'student[Email]' => 'Testing',
            'student[classroom]' => 'Testing',
            'student[clubs]' => 'Testing',
        ]);

        self::assertResponseRedirects('/student/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Student();
        $fixture->setNSC('My Title');
        $fixture->setEmail('My Title');
        $fixture->setClassroom('My Title');
        $fixture->setClubs('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Student');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Student();
        $fixture->setNSC('My Title');
        $fixture->setEmail('My Title');
        $fixture->setClassroom('My Title');
        $fixture->setClubs('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'student[NSC]' => 'Something New',
            'student[Email]' => 'Something New',
            'student[classroom]' => 'Something New',
            'student[clubs]' => 'Something New',
        ]);

        self::assertResponseRedirects('/student/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNSC());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getClassroom());
        self::assertSame('Something New', $fixture[0]->getClubs());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Student();
        $fixture->setNSC('My Title');
        $fixture->setEmail('My Title');
        $fixture->setClassroom('My Title');
        $fixture->setClubs('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/student/');
    }
}
