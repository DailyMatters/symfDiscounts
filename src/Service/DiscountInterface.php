<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\CustomerRepository;

interface DiscountInterface{

     public function check(Order $order, CustomerRepository $repository): bool;

     public function apply(Order $order): Order;

}
