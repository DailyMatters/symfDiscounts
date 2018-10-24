<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\CustomerRepository;

class DiscountService implements DiscountServiceInterface{

    const PREMIUM_DISCOUNT = 0.1;

    const MINIMUM_AMOUNT_DISCOUNT = 5;
    const SWITCH_CATEGORY = 2;
    const TOOL_CATEGORY = 1;

    public function checkAppliableDiscount(Order $order, CustomerRepository $repository)
    {
	    $discount = 0;

	    $customer = $repository->findOneBy(['id' => $order->getCustomerId()]);

	    if ($customer->isPremiumCustomer()) {
	    	$discount = $this->getPremiumCustomerDiscountValue($order);
	    }

	    $order = $this->applyMinimumAmountDiscount($order);

	    if ($this->haveProductDiscount($order)) {
	    	$discount += $this->getProductDiscount($order);
	    }

	    return $discount;
    }

    public function getProductDiscount(Order $order): float 
    {
	//store and array with just the values and select the lowest with the min function 
	$productPrices = [];

	$items = $order->getIems();

	foreach ($items as $item) {
	    if($item->getProductId()->getId === self::TOOL_CATEGORY) {
	    	$productPrices[] = $item->getProductId()->getUnitPrice();
	    }
	}

	return min($productPrices);
    }

    public function haveProductDiscount(Order $order): bool 
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

    public function applyMinimumAmountDiscount(Order $order): Order
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

    public function getPremiumCustomerDiscountValue(Order $order): float
    {
	    $orderTotal = $order->getTotal();

	    return $orderTotal * self::PREMIUM_DISCOUNT;
    }

}
