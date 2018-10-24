<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Product;
use App\Service\OrderService;
use PHPUnit\Framework\TestCase;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderServiceTest extends TestCase
{

    public function testOrderConversionFromJson()
    {
	$productRepoMock = $this->createMock(ProductRepository::class); 
	$customerRepoMock = $this->createMock(CustomerRepository::class);
	$validatorMock = $this->createMock(ValidatorInterface::class);

	$product = new Product();
	$product->setDescription("A Product");
	$product->setCategory(8);
	$product->setPrice("4.99");
	$product->setProductId("B102");

	$productRepoMock->expects($this->any())
            ->method('findOneBy')
            ->willReturn($product);

    	$json = json_decode('{
  		"id": "1",
  		"customer-id": "1",
  		"items": [
    		    {
      			"product-id": "B102",
      			"quantity": "10",
      			"unit-price": "4.99",
      			"total": "49.90"
    		    }
  		],
  		"total": "49.90"
		}', true);
   
	$service = new OrderService();

	$this->assertInstanceOf(Order::class, $service->convertDataToOrder($json, $customerRepoMock, $productRepoMock, $validatorMock ));	
    }

}
