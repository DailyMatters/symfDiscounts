<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\CustomerRepository;

class PremiumCustomerDiscount implements DiscountInterface{

    const PREMIUM_DISCOUNT = 0.1;

    public function check(Order $order, CustomerRepository $repository): bool
    {
	 return $this->checkPremiumCustomer($order, $repository);
    }

    public function apply(Order $order): Order
    {
	 $discountValue = $this->getPremiumCustomerDiscountValue($order);

	 return $order->setTotal($order->getTotal() - $discountValue);
    }

    private function checkPremiumCustomer(Order $order, CustomerRepository $customer): bool
    {
	 $customer = $customer->findOneBy(['id' => $order->getCustomerId()]);
	
	 if ($customer->isPremiumCustomer()) {
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
