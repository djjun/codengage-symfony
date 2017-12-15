<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends Controller
{
    /**
     * @Route("/customers", name="customers.index")
     * @Method("GET")
     *
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request)
    {
        $service = $this->container->get('app.service.customer_service');

        $filter = $request->get('search');

        $customers = $service->search($filter);

        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
            'filter' => $filter
        ]);
    }

    /**
     * @Route("/customers/create", name="customers.create")
     * @Method("GET")
     *
     * @return mixed
     */
    public function createAction()
    {
        return $this->render('customer/create.html.twig');
    }

    /**
     * @Route("/customers", name="customers.store")
     * @Method("POST")
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeAction(Request $request)
    {
        $service = $this->container->get('app.service.customer_service');

        $name = $request->get('name');
        $bornAt = $request->get('bornAt');

        try {
            $service->create($name, $bornAt);

            $this->addFlash('success', "Cliente '$name' cadastrado com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao cadastrar o cliente '$name'!",
                'body' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('customers.index');
    }

    /**
     * @Route("/customers/{id}", name="customers.show")
     * @Method("GET")
     *
     * @param string $id
     * @return mixed
     */
    public function showAction($id)
    {
        $service = $this->container->get('app.service.customer_service');

        try {
            $customer = $service->findOrFail($id);

            return $this->render('customer/show.html.twig', [
                'customer' => $customer
            ]);
        } catch (\Exception $e) {
            $this->addFlash('warning', $e->getMessage());

            return $this->redirectToRoute('customers.index');
        }
    }

    /**
     * @Route("/customers/{id}/edit", name="customers.edit")
     * @Method("GET")
     *
     * @param string $id
     * @return mixed
     */
    public function editAction($id)
    {
        $service = $this->container->get('app.service.customer_service');

        try {
            $customer = $service->findOrFail($id);

            return $this->render('customer/edit.html.twig', [
                'customer' => $customer
            ]);
        } catch (\Exception $e) {
            $this->addFlash('warning', $e->getMessage());

            return $this->redirectToRoute('customers.index');
        }
    }

    /**
     * @Route("/customers/{id}", name="customers.update")
     * @Method("PUT")
     *
     * @param string $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAction($id, Request $request)
    {
        $service = $this->container->get('app.service.customer_service');

        $name = $request->get('name');
        $bornAt = $request->get('bornAt');

        try {
            $service->update($id, $name, $bornAt);

            $this->addFlash('success', "Cliente '" . $name . "' atualizado com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao atualizar o cliente '$name'!",
                'body' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('customers.index');
    }

    /**
     * @Route("/customers/{id}", name="customers.destroy")
     * @Method("DELETE")
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroyAction($id)
    {
        $service = $this->container->get('app.service.customer_service');

        try {
            $service->destroy($id);

            $this->addFlash('success', "Cliente removido com sucesso!");
        } catch (\Exception $e) {
            $this->addFlash('danger', [
                'title' => "Falha ao remover o cliente!",
                'body' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('customers.index');
    }
}
