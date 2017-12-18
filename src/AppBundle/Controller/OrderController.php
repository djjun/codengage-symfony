<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Service\OrderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class OrderController extends Controller
{

    /**
     * @Route("/orders", name="orders.index")
     * @Method("GET")
     *
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request)
    {
        $service = $this->container->get('app.service.order_service');

        $filter = $request->get('search');

        $orders = $service->search($filter);

        return $this->render('order/index.html.twig', [
            'orders' => $orders,
            'filter' => $filter
        ]);
    }

    /**
     * @Route("/orders/create", name="orders.create")
     * @Method("GET")
     *
     * @return mixed
     */
    public function createAction()
    {
        $customers = $this->container->get('app.service.customer_service')->search('');
        $products = $this->container->get('app.service.product_service')->search('');

        return $this->render('order/create.html.twig', [
            'customers' => $customers,
            'products' => $products

        ]);

    }

    /**
     * @Route("/orders", name="orders.store")
     * @Method("POST")
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeAction(Request $request)
    {
        $service = $this->container->get('app.service.order_service');

        $name = $request->get('name');
        $code = $request->get('code');
        $price = floatval($request->get('price'));


        try {
            $service->create($name, $code, $price);

            $this->addFlash('success', "Pedido '$name' cadastrado com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao cadastrar o pedido '$name'!",
                'body' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('orders.index');
    }

    /**
     * @Route("/orders/create", name="orderproduct.store")
     * @Method("POST")
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeProductAction(Request $request)
    {
        $service = $this->container->get('app.service.order_service');

        $name = $request->get('name');
        $code = $request->get('code');
        $price = floatval($request->get('price'));


        try {
            $service->create($name, $code, $price);

            $this->addFlash('success', "Pedido '$name' cadastrado com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao cadastrar o pedido '$name'!",
                'body' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('orders.index');
    }

    /**
     * @Route("/orders/{id}", name="orders.show")
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

        $order = $em
            ->getRepository('AppBundle:Order')
            ->find($id);

        if (is_null($order)) {
            throw $this->createNotFoundException("Pedido não encontrado.");
        }

        return $this->render('order/show.html.twig', [
            'order' => $order
        ]);
    }

    /**
     * @Route("/orders/{id}/edit", name="orders.edit")
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

        $order = $em
            ->getRepository('AppBundle:Order')
            ->find($id);

        if (is_null($order)) {
            throw $this->createNotFoundException("Pedido não encontrado.");
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order
        ]);
    }

    /**
     * @Route("/orders/{id}", name="orders.update")
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

        $order = $em
            ->getRepository('AppBundle:Order')
            ->find($id);



        if (is_null($order)) {
            throw $this->createNotFoundException("Pedido não encontrado.");
        }

        $order
            ->setName($request->get('name'))
            ->setCode($request->get('code'))
            ->setPrice(bcadd($request->get('price'), '0', 2));


        $em->persist($order);
        $em->flush();

        $this->addFlash('success', "Pedido '" . $order->getName() . "' atualizado com sucesso!");

        return $this->redirectToRoute('orders.index');
    }

    /**
     * @Route("/orders/{id}", name="orders.destroy")
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

        $order = $em
            ->getRepository('AppBundle:Order')
            ->find($id);

        if (is_null($order)) {
            throw $this->createNotFoundException("Pedido não encontrado.");
        }

        $em->remove($order);
        $em->flush();

        $this->addFlash('success', "Pedido '" . $order->getName() . "' removido com sucesso!");

        return $this->redirectToRoute('orders.index');
    }
}
