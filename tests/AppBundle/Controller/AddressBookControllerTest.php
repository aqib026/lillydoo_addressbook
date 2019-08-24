<?php

/*
 * This file is part of the www.lillydoo.com test.
 *
 * @author Omar Makled <omar.makled@gmail.com.com>
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressBookControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;
    protected $entityManager;
    protected  $container;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = self::$kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();
    }


    public function testIndex()
    {
        $this->client->request('GET', '/address-book');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/address-book/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form([
            'appbundle_addressbook[firstname]' => 'firstname',
            'appbundle_addressbook[lastname]' => 'lastname',
            'appbundle_addressbook[street_num]' => 'address',
            'appbundle_addressbook[country]' => 'country',
            'appbundle_addressbook[city]' => 'city',
            'appbundle_addressbook[zip]' => 'zip',
            'appbundle_addressbook[phonenumber]' => 'phone',
            'appbundle_addressbook[emailaddress]' => 'email@mail.com',
            'appbundle_addressbook[birthday]' => date('Y-m-d'),
        ]);
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    }

    public function testEditAction()
    {

        $address = $this->entityManager->getRepository('AppBundle:AddressBook')->findOneBy(['emailaddress' => 'email@mail.com']);
        $crawler = $this->client->request('GET','/address-book/edit/'.$address->getId());        
        $form = $crawler->selectButton('Save')->form([
            'appbundle_addressbook[firstname]' => 'newfirstname',
        ]);
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteAction()
    {
        $address = $this->entityManager->getRepository('AppBundle:AddressBook')->findOneBy(['emailaddress' => 'email@mail.com']);
        $crawler = $this->client->request('GET','/address-book/delete/'.$address->getId());        
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}