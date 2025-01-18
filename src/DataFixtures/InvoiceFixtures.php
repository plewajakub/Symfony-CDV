<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InvoiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $invoice = new Invoice();
        $invoice->setCompanyName('Sigma Company');
        $invoice->setCompanyStreet('Chill Street');
        $invoice->setCompanyStreetNumber('123');
        $invoice->setCompanyStreetFlatNumber('321');
        $invoice->setCompanyCity('Poznan');
        $invoice->setCompanyPostCode('80-460');
        $invoice->setCreated(new \DateTime());
        $invoice->setUpdated(new \DateTime());
        $invoice->setEmail('jplewa2@edu.cdv.pl');
        $invoice->setPhone('997213769');
        $invoice->setTaxNumber('1234567890');

        $manager->persist($invoice);
        $manager->flush();
    }
}
