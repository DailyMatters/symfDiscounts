<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Item;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Service\DiscountServiceInterface;
use App\Service\OrderServiceInterface;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{
  
    /**
     * @Route("/order/discount", name="discount")
     */
	public function discount(
		Request $request, 
		DiscountServiceInterface $discountService, 
		CustomerRepository $customer, 
		ProductRepository $product, 
		ValidatorInterface $validator,
		OrderServiceInterface $orderService
	)
    {
	$data = json_decode($request->getContent(), true);

	$discount = $discountService->checkAppliableDiscount($orderService->convertDataToOrder($data, $customer, $product, $validator), $customer);	

    	 return $this->json([
            'message' => 'The total discount for this order is ' . $discount
        ]);

    }
}
