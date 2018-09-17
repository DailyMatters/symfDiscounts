<?php

namespace App\Service;

use App\Entity\Order;

class DiscountService{

    const PREMIUM_REVENUE = 100;
    const PREMIUM_DISCOUNT = 0.1;

    const MINIMUM_AMOUNT_DISCOUNT = 5;
    const SWITCH_CATEGORY = 2;
    const TOOL_CATEGORY = 1;

    public function checkAppliableDiscount(Order $order)
    {
	    $discount = 0;

	    if ($this->isPremiumCustomer($order)) {
	    	$discount = $this->getPremiumCustomerDiscountValue($order);
	    }

	    $order = $this->applyMinimumAmountDiscount($order);

	    if ($this->haveProductDiscount($order)) {
	    	$discount += $this->getProductDiscount($order);
	    }

	    return $discount;
    }

    private function getProductDiscount(Order $order): float 
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

    private function haveProductDiscount(Order $order): bool 
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

    private function applyMinimumAmountDiscount(Order $order): Order
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

    private function isPremiumCustomer(Order $order): bool
    {
    	$customer = $order->getCustomerId();

	if($customer->getRevenue() >= self::PREMIUM_REVENUE){
	   return true;
	}

	return false;
    }

    private function getPremiumCustomerDiscountValue(Order $order): float
    {
	    $orderTotal = $order->getTotal();

	    return $orderTotal * self::PREMIUM_DISCOUNT;
    }

}
