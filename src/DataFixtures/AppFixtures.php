<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

	public function load(ObjectManager $manager)
	{
		//Insert product 1
		$product = new Product();
		$product->setDescription('Screwdriver');
		$product->setCategory(1);
		$product->setPrice(9.75);
		$product->setProductId('A101');
		$manager->persist($product);

		//Insert product 2
		$product = new Product();
		$product->setDescription('Electric screwdriver');
		$product->setCategory(1);
		$product->setPrice(49.50);
		$product->setProductId('A102');
		$manager->persist($product);

		//Insert product 3
		$product = new Product();
		$product->setDescription('Basic on-off scwitch');
		$product->setCategory(2);
		$product->setPrice(4.99);
		$product->setProductId('B101');
		$manager->persist($product);

		//Insert product 4
		$product = new Product();
		$product->setDescription('Press Button');
		$product->setCategory(2);
		$product->setPrice(4.99);
		$product->setProductId('B102');
		$manager->persist($product);

		//Insert product 5
		$product = new Product();
		$product->setDescription('Switch with motion detector');
		$product->setCategory(2);
		$product->setPrice(12.95);
		$product->setProductId('A103');
		$manager->persist($product);

		//Insert Customer 1
		$customer = new Customer();
		$customer->setName('Coca Cola');
		$customer->setSince(new \Datetime('2014-06-28'));
		$customer->setRevenue(492.12);
		$manager->persist($customer);

		//Insert Customer 2
		$customer = new Customer();
		$customer->setName('Teamleader');
		$customer->setSince(new \Datetime('2015-01-15'));
		$customer->setRevenue(1505.95);
		$manager->persist($customer);

		//Insert Customer 3
		$customer = new Customer();
		$customer->setName('Jeroen De Wit');
		$customer->setSince(new \Datetime('2016-02-11'));
		$customer->setRevenue(0.00);
		$manager->persist($customer);

		$manager->flush();
	}

}

