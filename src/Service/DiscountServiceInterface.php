<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\CustomerRepository;

interface DiscountServiceInterface{

     public function checkAppliableDiscount(Order $order, CustomerRepository $repository);
    
     function getProductDiscount(Order $order): float; 

     function haveProductDiscount(Order $order): bool; 
    
     function applyMinimumAmountDiscount(Order $order): Order;

     function getPremiumCustomerDiscountValue(Order $order): float;
    }
