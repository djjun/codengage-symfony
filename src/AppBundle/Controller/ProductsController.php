<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Service\ProductService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class ProductsController extends Controller
{
    /**
     * @var ProductService
     */
    private $service;

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->service = new ProductService();
    }

    /**
     * @Route("/products", name="products.index")
     * @Method("GET")
     *
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request)
    {
        $filter = $request->get('search');

        $em = $this
            ->getDoctrine()
            ->getManager();

        $repository = $em->getRepository(Product::class);

        $products = $repository->search($filter);

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'filter' => $filter
        ]);
    }

    /**
     * @Route("/products/create", name="products.create")
     * @Method("GET")
     *
     * @return mixed
     */
    public function createAction()
    {
        return $this->render('product/create.html.twig');
    }

    /**
     * @Route("/products", name="products.store")
     * @Method("POST")
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeAction(Request $request)
    {
        $product = $this->service->create(
            $request->get('name'),
            $request->get('code'),
            $request->get('price'));

        $this->addFlash('success', "Produto '" . $product->getName() . "' cadastrado com sucesso!");

        return $this->redirectToRoute('products.index');
    }

    /**
     * @Route("/products/{id}", name="products.show")
     * @Method("GET")
     *
     * @param string $id
     * @return mixed
     */
    public function showAction($id)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $product = $em
            ->getRepository('AppBundle:Product')
            ->find($id);

        if (is_null($product)) {
            throw $this->createNotFoundException("Produto não encontrado.");
        }

        return $this->render('products/show.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/products/{id}/edit", name="products.edit")
     * @Method("GET")
     *
     * @param string $id
     * @return mixed
     */
    public function editAction($id)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $product = $em
            ->getRepository('AppBundle:Product')
            ->find($id);

        if (is_null($product)) {
            throw $this->createNotFoundException("Produto não encontrado.");
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/products/{id}", name="products.update")
     * @Method("PUT")
     *
     * @param string $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAction($id, Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $product = $em
            ->getRepository('AppBundle:Product')
            ->find($id);

        if (is_null($product)) {
            throw $this->createNotFoundException("Produto não encontrado.");
        }

        $product
            ->setName($request->get('name'))
            ->setBornAt($request->get('bornAt'));

        $em->persist($product);
        $em->flush();

        $this->addFlash('success', "Produto '" . $product->getName() . "' atualizado com sucesso!");

        return $this->redirectToRoute('products.index');
    }

    /**
     * @Route("/products/{id}", name="products.destroy")
     * @Method("DELETE")
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroyAction($id)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $product = $em
            ->getRepository('AppBundle:Product')
            ->find($id);

        if (is_null($product)) {
            throw $this->createNotFoundException("Produto não encontrado.");
        }

        $em->remove($product);
        $em->flush();

        $this->addFlash('success', "Produto '" . $product->getName() . "' removido com sucesso!");

        return $this->redirectToRoute('products.index');
    }
}
