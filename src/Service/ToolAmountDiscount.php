<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\CustomerRepository;

class ToolAmountDiscount implements DiscountInterface{

    const TOOL_CATEGORY = 1;

    public function check(Order $order, CustomerRepository $repository): bool
    {
        $toolItems = [];

	$items = $order->getItems();

	foreach ($items as $item) {
	    if($item->getProductId()->getId() === self::TOOL_CATEGORY) {
	    	$toolItems[] = $item;	
	    }
	}
       
	if (sizeof($toolItems) >= 2) {
	    return true;
	}

	return false;	
    }

    public function apply(Order $order): Order
    {
        //store and array with just the values and select the lowest with the min function 
	$productPrices = [];

	$items = $order->getIems();

	foreach ($items as $item) {
	    if($item->getProductId()->getId === self::TOOL_CATEGORY) {
	    	$productPrices[] = $item->getProductId()->getUnitPrice();
	    }
	}

	$discountValue = min($productPrices);

	return $order->setTotal($order->getTotal() - $discountValue);
    }

}
