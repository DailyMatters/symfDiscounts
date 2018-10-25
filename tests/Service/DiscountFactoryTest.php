<?php

namespace App\Tests\Service;

use App\Service\DiscountFactory;
use PHPUnit\Framework\TestCase;

class DiscountFactoryTest extends TestCase
{
    protected $discountFactory;

    protected function setUp(){
    	$this->discountFactory = new DiscountFactory();
    }

    public function testGetDiscountsReturnArray()
    {
	$this->assertInternalType("array", $this->discountFactory->getDiscounts());
    }

    public function testGetDiscountArrayIsNotEmpty()
    {
	$this->assertNotEmpty($this->discountFactory->getDiscounts());
    }
}
