<?php

namespace App\Test\Controller;

use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/produits/front/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Produits::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'produit[productName]' => 'Testing',
            'produit[productDescription]' => 'Testing',
            'produit[productPhoto]' => 'Testing',
            'produit[productPrice]' => 'Testing',
            'produit[addeddate]' => 'Testing',
            'produit[relatedArtist]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setProductName('My Title');
        $fixture->setProductDescription('My Title');
        $fixture->setProductPhoto('My Title');
        $fixture->setProductPrice('My Title');
        $fixture->setAddeddate('My Title');
        $fixture->setRelatedArtist('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setProductName('Value');
        $fixture->setProductDescription('Value');
        $fixture->setProductPhoto('Value');
        $fixture->setProductPrice('Value');
        $fixture->setAddeddate('Value');
        $fixture->setRelatedArtist('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'produit[productName]' => 'Something New',
            'produit[productDescription]' => 'Something New',
            'produit[productPhoto]' => 'Something New',
            'produit[productPrice]' => 'Something New',
            'produit[addeddate]' => 'Something New',
            'produit[relatedArtist]' => 'Something New',
        ]);

        self::assertResponseRedirects('/produits/front/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getProductName());
        self::assertSame('Something New', $fixture[0]->getProductDescription());
        self::assertSame('Something New', $fixture[0]->getProductPhoto());
        self::assertSame('Something New', $fixture[0]->getProductPrice());
        self::assertSame('Something New', $fixture[0]->getAddeddate());
        self::assertSame('Something New', $fixture[0]->getRelatedArtist());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setProductName('Value');
        $fixture->setProductDescription('Value');
        $fixture->setProductPhoto('Value');
        $fixture->setProductPrice('Value');
        $fixture->setAddeddate('Value');
        $fixture->setRelatedArtist('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/produits/front/');
        self::assertSame(0, $this->repository->count([]));
    }
}
