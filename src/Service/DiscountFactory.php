<?php

namespace App\Service;

use App\Service\PremiumCustomerDiscount;
use App\Service\SwitchAmountDiscount;
use App\Service\ToolAmountDiscount;

class DiscountFactory
{
    private $discounts;
   
    public function __construct()
    {
    	$this->discounts = [
	    new PremiumCustomerDiscount(),
	    new SwitchAmountDiscount(),
	    new ToolAmountDiscount()
	];
    }

    public function getDiscounts(): array
    {
        return $this->discounts;
    }
}
