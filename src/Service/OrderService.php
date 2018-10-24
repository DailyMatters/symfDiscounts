<?php

namespace App\Service;

use App\Entity\Item;
use App\Entity\Order;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderService{

    public function convertDataToOrder(array $data, CustomerRepository $customerRepository, ProductRepository $productRepository, ValidatorInterface $validator): Order 
    {
	$order = new Order();

	$customer = $customerRepository->findOneBy(['id' => $data['customer-id']]);

	$order->setCustomerId($customer);
	$order->setTotal($data['total']);
	
	foreach($data['items'] as $element){
		$item = new Item();

		$item->setQuantity($element['quantity']);
		$item->setUnitPrice($element['unit-price']);
		$item->setTotal($element['total']);

		$product = $productRepository->findOneBy(['product_id' => $element['product-id']]);
		$item->setProductId($product);

		//validate the item
		$errors = $validator->validate($item);
		if( count($errors) > 0) {
		    $errorString = (string) $errors;	

		    throw new \Exception('Invalid Item: ' . $errorString);
		}

		$order->addItems($item);
	}

	return $order;
    }
}
