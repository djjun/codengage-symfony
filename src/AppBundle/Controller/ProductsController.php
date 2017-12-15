<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Service\ProductService;
use AppBundle\Traits\MoneyFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class ProductsController extends Controller
{
    use MoneyFormatter;

    /**
     * @Route("/products", name="products.index")
     * @Method("GET")
     *
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request)
    {
        $service = $this->container->get('app.service.product_service');

        $filter = $request->get('search');

        $products = $service->search($filter);

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
        $service = $this->container->get('app.service.product_service');

        $name = $request->get('name');
        $code = $request->get('code');
        $price = $request->get('price');
        $price = $this->BRLToDouble($price);

        try {
            $service->create($name, $code, $price);

            $this->addFlash('success', "Produto '$name' cadastrado com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao cadastrar o produto '$name'!",
                'body' => $e->getMessage()
            ]);
        }

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
        $service = $this->container->get('app.service.product_service');

        try {
            $product = $service->findOrFail($id);

            return $this->render('product/show.html.twig', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            $this->addFlash('warning', $e->getMessage());

            return $this->redirectToRoute('products.index');
        }
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
        $service = $this->container->get('app.service.product_service');

        try {
            $product = $service->findOrFail($id);

            return $this->render('product/edit.html.twig', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            $this->addFlash('warning', $e->getMessage());

            return $this->redirectToRoute('products.index');
        }
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
        $service = $this->container->get('app.service.product_service');

        $name = $request->get('name');
        $code = $request->get('code');
        $price = $request->get('price');
        $price = $this->BRLToDouble($price);

        try {
            $service->update($id, $name, $code, $price);

            $this->addFlash('success', "Produto '" . $name . "' atualizado com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao atualizar o produto '$name'!",
                'body' => $e->getMessage()
            ]);
        }

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
        $service = $this->container->get('app.service.product_service');

        try {
            $service->destroy($id);

            $this->addFlash('success', "Produto removido com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao remover o produto!",
                'body' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('products.index');
    }
}
