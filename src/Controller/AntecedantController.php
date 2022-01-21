<?php

namespace App\Controller;

use App\Entity\Antecedant;
use App\Form\AntecedantType;
use App\Repository\AntecedantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/antecedant")
 * @IsGranted("ROLE_USER")
 */
class AntecedantController extends AbstractController
{
    private $antecedantRepository;

    /**
     * AntecedantController constructor.
     * @param $antecedantRepository
     */
    public function __construct(AntecedantRepository $antecedantRepository)
    {
        $this->antecedantRepository = $antecedantRepository;
    }

    /**
     * @Route("/", name="entity_antecedant_index", methods={"GET"})
     */
    public function index(AntecedantRepository $antecedantRepository): Response
    {
        return $this->render('antecedant/index.html.twig', [
            'antecedants' => $antecedantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entity_antecedant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $antecedant = new Antecedant();
        $form = $this->createForm(AntecedantType::class, $antecedant)->add('saveAndCreateNew', SubmitType::class, [
            'translation_domain' => 'action',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($antecedant);
            $entityManager->flush();
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('entity_antecedant_new');
            }
            return $this->redirectToRoute('entity_antecedant_index');
        }

        return $this->render('antecedant/new.html.twig', [
            'antecedant' => $antecedant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entity_antecedant_show", methods={"GET"})
     */
    public function show(Antecedant $antecedant): Response
    {
        return $this->render('antecedant/show.html.twig', [
            'antecedant' => $antecedant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="antecedant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Antecedant $antecedant): Response
    {
        $form = $this->createForm(AntecedantType::class, $antecedant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entity_antecedant_index');
        }

        return $this->render('antecedant/edit.html.twig', [
            'antecedant' => $antecedant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="antecedant_delete", methods={"POST"})
     */
    public function delete(Request $request, Antecedant $antecedant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$antecedant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($antecedant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('antecedant_index');
    }
    /**
     * @Route("/get/getantecedants", name="getantecedants", methods={"GET"})
     */
    public function getAntecedants(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->antecedantRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'code' => $local->getCode(),
                    'libelle' => $local->getLibelle(),
                    'groupe' => $local->getGroupe(),
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
