<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{

    public function testPremiumCustomer()
    {
    	$customer = new Customer();
	$customer->setSince(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
	$customer->setName("Unnamed Customer");
	$customer->setRevenue(150);

	$this->assertTrue($customer->isPremiumCustomer());
    }

    public function testNonPremiumCustomer()
    {
    	$customer = new Customer();
	$customer->setSince(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
	$customer->setName("Unnamed Customer");
	$customer->setRevenue(50);

	$this->assertFalse($customer->isPremiumCustomer());
    }
}
