<?php

namespace App\Service;

use App\Entity\Order;

class DiscountService{

    const PREMIUM_REVENUE = 100;
    const PREMIUM_DISCOUNT = 0.1;

    public function checkAppliableDiscount(Order $order)
    {
	    $discount = 0;

	    if($this->isPremiumCustomer($order)){
	    	$discount = $this->getPremiumCustomerDiscountValue($order);
	    }

	    return $discount;
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
