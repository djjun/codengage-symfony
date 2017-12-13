<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
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
        $filter = $request->get('search');

        $em = $this
            ->getDoctrine()
            ->getManager();

        $repository = $em->getRepository(Customer::class);

        $customers = $repository->search($filter);

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
        $customer = $this->service->create($request->get('name'), $request->get('bornAt'));

        $this->addFlash('success', "Cliente '" . $customer->getName() . "' cadastrado com sucesso!");

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
        $em = $this
            ->getDoctrine()
            ->getManager();

        $customer = $em
            ->getRepository('AppBundle:Customer')
            ->find($id);

        if (is_null($customer)) {
            throw $this->createNotFoundException("Cliente não encontrado.");
        }

        return $this->render('customer/show.html.twig', [
            'customer' => $customer
        ]);
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
        $em = $this
            ->getDoctrine()
            ->getManager();

        $customer = $em
            ->getRepository('AppBundle:Customer')
            ->find($id);

        if (is_null($customer)) {
            throw $this->createNotFoundException("Cliente não encontrado.");
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer
        ]);
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
        $em = $this
            ->getDoctrine()
            ->getManager();

        $customer = $em
            ->getRepository('AppBundle:Customer')
            ->find($id);

        if (is_null($customer)) {
            throw $this->createNotFoundException("Cliente não encontrado.");
        }

        $customer
            ->setName($request->get('name'))
            ->setBornAt($request->get('bornAt'));

        $em->persist($customer);
        $em->flush();

        $this->addFlash('success', "Cliente '" . $customer->getName() . "' atualizado com sucesso!");

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
        $em = $this
            ->getDoctrine()
            ->getManager();

        $customer = $em
            ->getRepository('AppBundle:Customer')
            ->find($id);

        if (is_null($customer)) {
            throw $this->createNotFoundException("Cliente não encontrado.");
        }

        $em->remove($customer);
        $em->flush();

        $this->addFlash('success', "Cliente '" . $customer->getName() . "' removido com sucesso!");

        return $this->redirectToRoute('customers.index');
    }
}
