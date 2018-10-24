<?php

namespace App\Service;

use App\Entity\Item;
use App\Entity\Order;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface OrderServiceInterface{

    public function convertDataToOrder(array $data, CustomerRepository $customerRepository, ProductRepository $productRepository, ValidatorInterface $validator): Order;

}
