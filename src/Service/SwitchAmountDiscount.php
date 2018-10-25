<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\CustomerRepository;

class SwitchAmountDiscount implements DiscountInterface{

    const MINIMUM_AMOUNT_DISCOUNT = 5;
    const SWITCH_CATEGORY = 2;

    public function check(Order $order, CustomerRepository $repository): bool
    {
    	return true;
    }

    public function apply(Order $order): Order
    {
	$items = $order->getItems();
	
	foreach($items as $item) {
		if($item->getQuantity() >= self::MINIMUM_AMOUNT_DISCOUNT) {
		    if($item->getProductId()->getCategory() === self::SWITCH_CATEGORY){
			$item->setQuantity($item->getQuantity() + (int)$item->getQuantity()/5);
		        $order->addItems($item);
		}
	    }
	}

	return $order;
    }

}
