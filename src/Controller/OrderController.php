<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Item;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Service\DiscountService;
use App\Service\OrderService;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
	public function index(
		Request $request, 
		OrderRepository $repository, 
		CustomerRepository $customerRepository, 
		ProductRepository $productRepository,
		OrderService $orderService
	)
    {
	$data = json_decode($request->getContent(), true);

	$order = $orderService->convertDataToOrder($data, $customerRepository, $productRepository);

	$repository->persistOrder($order);	

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }

    /**
     * @Route("/order/discount", name="discount")
     */
	public function discount(
		Request $request, 
		DiscountService $service, 
		CustomerRepository $customer, 
		ProductRepository $product, 
		ValidatorInterface $validator,
		OrderService $orderService
	)
    {
	$data = json_decode($request->getContent(), true);

	$discount = $service->checkAppliableDiscount($orderService->convertDataToOrder($data, $customer, $product, $validator), $customer);	

    	 return $this->json([
            'message' => 'The total discount for this order is ' . $discount
        ]);

    }
}
