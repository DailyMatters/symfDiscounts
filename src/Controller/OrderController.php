<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Item;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Service\OrderServiceInterface;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\DiscountFactory;

class OrderController extends AbstractController
{
  
    /**
     * @Route("/order/discount", name="discount")
     */
    public function discount(
	Request $request, 
	DiscountFactory $discountFactory, 
	CustomerRepository $customer, 
	ProductRepository $product, 
	ValidatorInterface $validator,
	OrderServiceInterface $orderService
    )
    {
	$data = json_decode($request->getContent(), true);
	$order = $orderService->convertDataToOrder($data, $customer, $product, $validator);

	foreach ($discountFactory->getDiscounts() as $discount) {
            if($discount->check($order, $customer)){
                $order = $discount->apply($order);
            }
        }

	return $this->json([
	    'message' => 'Order total: ' . $order->getTotal()
	]);
    }
}
