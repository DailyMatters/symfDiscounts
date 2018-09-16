<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Item;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Service\DiscountService;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request, OrderRepository $repository, CustomerRepository $customerRepository, ProductRepository $productRepository)
    {
	$data = json_decode($request->getContent(), true);

	$order = $this->convertDataToOrder($data, $customerRepository, $productRepository);

	$repository->persistOrder($order);	

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }

    /**
     * @Route("/order/discount", name="discount")
     */
    public function discount(Request $request, DiscountService $service, CustomerRepository $customer, ProductRepository $product)
    {
	$data = json_decode($request->getContent(), true);

	$discount = $service->checkAppliableDiscount($this->convertDataToOrder($data, $customer, $product));	

	var_dump($discount);die;

    	 return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);

    }


    private function convertDataToOrder(array $data, CustomerRepository $customerRepository, ProductRepository $productRepository): Order 
    {
	$order = new Order();

	$customer = $customerRepository->findOneBy(['id' => $data['customer-id']]);

	$order->setCustomerId($customer);
	$order->setTotal($data['total']);
	
	foreach($data['items'] as $element){
		$item = new Item();

		$item->setQuantity($element['quantity']);
		$item->setUnitPrice($element['unit-price']);
		$item->setTotal($element['total']);

		$product = $productRepository->findOneBy(['product_id' => $element['product-id']]);
		$item->setProductId($product);

		$order->addItems($item);
	}

	return $order;
    }
}
