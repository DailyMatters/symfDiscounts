<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_show_all")
     */
    public function index()
    {
	$repository = $this->getDoctrine()->getRepository(Product::class);

	return $this->json([
		$repository->findAll()
	]);
    }
}
