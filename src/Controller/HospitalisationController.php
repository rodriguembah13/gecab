<?php

namespace App\Controller;

use App\Entity\Hospitalisation;
use App\Form\HospitalisationType;
use App\Repository\HospitalisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hospitalisation")
 */
class HospitalisationController extends AbstractController
{
    /**
     * @Route("/", name="hosp_hospitalisation_index", methods={"GET"})
     */
    public function index(HospitalisationRepository $hospitalisationRepository): Response
    {
        return $this->render('hospitalisation/index.html.twig', [
            'hospitalisations' => $hospitalisationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hosp_hospitalisation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hospitalisation = new Hospitalisation();
        $form = $this->createForm(HospitalisationType::class, $hospitalisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hospitalisation);
            $entityManager->flush();

            return $this->redirectToRoute('hospitalisation_index');
        }

        return $this->render('hospitalisation/new.html.twig', [
            'hospitalisation' => $hospitalisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hosp_hospitalisation_show", methods={"GET"})
     */
    public function show(Hospitalisation $hospitalisation): Response
    {
        return $this->render('hospitalisation/show.html.twig', [
            'hospitalisation' => $hospitalisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hosp_hospitalisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hospitalisation $hospitalisation): Response
    {
        $form = $this->createForm(HospitalisationType::class, $hospitalisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hospitalisation_index');
        }

        return $this->render('hospitalisation/edit.html.twig', [
            'hospitalisation' => $hospitalisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hosp_hospitalisation_delete", methods={"POST"})
     */
    public function delete(Request $request, Hospitalisation $hospitalisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hospitalisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hospitalisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hospitalisation_index');
    }
}
