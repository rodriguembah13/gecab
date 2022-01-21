<?php

namespace App\Controller;

use App\Entity\ActeMedicalPatient;
use App\Entity\AntecedantPatient;
use App\Entity\Consultation;
use App\Entity\FactureItem;
use App\Entity\Medicament;
use App\Entity\Patient;
use App\Entity\Prescription;
use App\Entity\Rendezvous;
use App\Entity\SalleAttente;
use App\Entity\User;
use App\Form\ActePatientType;
use App\Form\AntecedantPatientType;
use App\Form\ConsultationType;
use App\Form\FactureItemType;
use App\Form\PrecriptionType;
use App\Form\RendezvousPatientType;
use App\Form\RendezvousType;
use App\Repository\ActeMedicalPatientRepository;
use App\Repository\ActeMedicalRepository;
use App\Repository\AntecedantPatientRepository;
use App\Repository\AntecedantRepository;
use App\Repository\ConsultationRepository;
use App\Repository\NotificationRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezvousRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consultation")
 * @IsGranted("ROLE_USER")
 */
class ConsultationController extends AbstractController
{
    private $consultationRepository;
    private $patientRepository;
    private $ordonnanceRepository;
    private $notificationRepository;
    private $antecedantPatientRepository;
    private $antecdantRepository;
    private $actePatientRepository;
    private $actesMedicalRepository;
    private $rendezvousRepository;
    /**
     * ConsultationController constructor.
     * @param $consultationRepository
     * @param $patientRepository
     */
    public function __construct(RendezvousRepository $rendezvousRepository,ActeMedicalRepository $acteMedicalRepository,ActeMedicalPatientRepository $acteMedicalPatientRepository,AntecedantRepository $antecdantRepository,AntecedantPatientRepository $antecedantPatientRepository,NotificationRepository $notificationRepository,OrdonnanceRepository $ordonnanceRepository,ConsultationRepository $consultationRepository, PatientRepository $patientRepository)
    {
        $this->consultationRepository = $consultationRepository;
        $this->patientRepository = $patientRepository;
        $this->ordonnanceRepository=$ordonnanceRepository;
        $this->notificationRepository=$notificationRepository;
        $this->antecedantPatientRepository=$antecedantPatientRepository;
        $this->antecdantRepository=$antecdantRepository;
        $this->actePatientRepository=$acteMedicalPatientRepository;
        $this->actesMedicalRepository=$acteMedicalRepository;
        $this->rendezvousRepository=$rendezvousRepository;
    }

    /**
     * @Route("/", name="consult_consultation_index", methods={"GET"})
     */
    public function index(ConsultationRepository $consultationRepository): Response
    {
        return $this->render('consultation/index.html.twig', [
            'consultations' => [],
        ]);
    }

    /**
     * @Route("/new", name="consultation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation)
        ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'multiple' => false,
                'placeholder' => 'veuillez choisir un patient',
                'required' => true,
                'label'=>'Patient',
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 10, 'data-live-search' => true],
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultation);
            $entityManager->flush();
            $url = $this->generateUrl('consultation_edit_salle', ['id' => $consultation->getId(),'patient'=>$consultation->getPatient()->getId()]);
            $this->addFlash('success', 'Operation executée avec success');

            return $this->redirect($url);
        }

        return $this->render('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/new/{id}", name="consultation_new_patient", methods={"GET","POST"})
     */
    public function newByPatient(Patient $patient,Request $request): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $consultation->setCreatedBy($this->getUser());
            $consultation->setMedecin($this->getUser());
            $consultation->setPatient($patient);
            $entityManager->persist($consultation);
            $entityManager->flush();
            $url = $this->generateUrl('consultation_edit_salle', ['id' => $consultation->getId(),'salleattente'=>$patient->getId()]);
            $this->addFlash('success', 'Operation executée avec success');

            return $this->redirect($url);
            //return $this->redirectToRoute('consult_consultation_index');
        }

        return $this->render('consultation/new_salle.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
            'patient'=>$patient,
        ]);
    }
    /**
     * @Route("/newsalle/{id}", name="consultation_new_salleatente", methods={"GET","POST"})
     */
    public function newBySalleAttente(SalleAttente $salleAttente,Request $request): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $consultation->setCreatedBy($this->getUser());
            $consultation->setMedecin($this->getUser());
            $consultation->setPatient($salleAttente->getPatient());
            $entityManager->persist($consultation);
            $notification=$this->notificationRepository->findOneBy(['notified_id'=>$salleAttente->getId()]);
            $notification->setStatus('complete');
            $salleAttente->setStatus('complete');
            $entityManager->persist($notification);
            $entityManager->persist($salleAttente);
            $entityManager->flush();
            $url = $this->generateUrl('consultation_edit_salle', ['id' => $consultation->getId(),'patient'=>$salleAttente->getPatient()->getId()]);
            $this->addFlash('success', 'Operation executée avec success');

            return $this->redirect($url);
            //return $this->redirectToRoute('consult_consultation_index');
        }

        return $this->render('consultation/new_salle.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
            'patient'=>$salleAttente->getPatient(),
        ]);
    }
    /**
     * @Route("/{id}", name="consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consultation $consultation): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('consult_consultation_index');
        }

        return $this->render('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/{patient}/edit", name="consultation_edit_salle", methods={"GET","POST"})
     */
    public function editsalle(Request $request, Consultation $consultation,Patient $patient): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);
        $lineprescription=new Prescription();
        $formOrdonnance = $this->createForm(PrecriptionType::class, $lineprescription);
        $formOrdonnance->handleRequest($request);
        $lineAntecedant=new AntecedantPatient();
        $formAntecedant = $this->createForm(AntecedantPatientType::class, $lineAntecedant);
        $formAntecedant->handleRequest($request);
        $lineFacture=new ActeMedicalPatient();
        $formFactureItem = $this->createForm(ActePatientType::class, $lineFacture);
        $formFactureItem->handleRequest($request);
        $rendezvous=new Rendezvous();
        $formRendezvous = $this->createForm(RendezvousPatientType::class, $rendezvous);
        $formRendezvous->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('consult_consultation_index');
        }
        if ($formRendezvous->isSubmitted() && $formRendezvous->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $rendezvous->setPatient($patient);
            $rendezvous->setCreatedAt(new \DateTime('now'));
            $rendezvous->setLibelle("Rdv ".$patient);
            $entityManager->persist($rendezvous);
            $entityManager->flush();
            $url = $this->generateUrl('consultation_edit_salle', ['id' => $consultation->getId(),'patient'=>$patient->getId()]);
            return $this->redirect($url);
        }

        return $this->render('consultation/editsalle.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
            'form_ordonance' => $formOrdonnance->createView(),
            'form_antecedant' => $formAntecedant->createView(),
            'form_rendezvous' => $formRendezvous->createView(),
            'form_facture' => $formFactureItem->createView(),
            'patient'=>$patient,
            'ordonnances'=>$this->ordonnanceRepository->findBy(['patient'=>$patient]),
            'rendezvouss'=>$this->rendezvousRepository->findBy(['patient'=>$patient]),
            'antecedantPatients'=>$this->antecedantPatientRepository->findBy(['patient'=>$patient]),
            'actesPatients'=>$this->actePatientRepository->findBy(['patient'=>$patient,'status'=>'encours']),
        ]);
    }
    /**
     * @Route("/{id}", name="consultation_delete", methods={"POST"})
     */
    public function delete(Request $request, Consultation $consultation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consult_consultation_index');
    }
    /**
     * @Route("/get/getconsultations", name="consultation_index_ajax", methods={"GET"})
     */
    public function getPatients(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->consultationRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'motif' => $local->getMotif(),
                    'patient' => $local->getPatient()->getNomComplet(),
                    'patient_id' => $local->getPatient()->getId(),
                    'dianostique' => $local->getDianostique(),
                    'medecin' => $local->getMedecin() ? $local->getMedecin()->getFullName():"",
                    'createdAt'=>$local->getCreatedAt()->format('Y-m-d')
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/get/getactespatient", name="getactespatient", methods={"GET"})
     */
    public function getActesPatient(Request $request): JsonResponse
    {
        $array = [];
        $arrayfinal = [];
        $idx = 0;
        $montantht=0.0;
        $montanttva=0.0;
        $patient=$this->patientRepository->find($request->get('patient'));
        try {
            $lists = $this->actePatientRepository->findBy(['patient'=>$patient,'status'=>'encours']);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'item' => $local->getActeMedical()->getLibelle(),
                    'price' => $local->getAmount(),
                    'tva'=> 0.0,
                    'quantite' => $local->getQuantity(),
                    'total' => $local->getQuantity() * $local->getAmount(),
                ];
                $array[$idx++] = $temp;
                $montantht+= ($local->getQuantity() * $local->getAmount());
                $montanttva+= 0.0;
            }
            $arrayfinal=[
              'data'=>$array,
              'totaltva'=>$montanttva,
              'montantht'=> $montantht,
              'montantnet'=> $montantht+ $montanttva,
            ];

            return new JsonResponse($arrayfinal,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/get/getconsultationbypatient", name="getconsultationbypatient", methods={"GET"})
     */
    public function getConsultationByPatient(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->consultationRepository->findBy(['patient'=>$request->get("id")]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'motif' => $local->getMotif(),
                    'patient' => $local->getPatient()->getNomComplet(),
                    'patient_id' => $local->getPatient()->getId(),
                    'dianostique' => $local->getDianostique(),
                    'medecin' => $local->getMedecin() ? $local->getMedecin()->getFullName():"",
                    'createdAt'=>$local->getCreatedAt()->format('Y-m-d')
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/get/saveAntecedant", name="saveAntecedant", methods={"GET"})
     */
    public function saveAntecedant(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $idx = 0;
        $antecedant=$this->antecdantRepository->find($request->get('antecedant'));
        $patient=$this->patientRepository->find($request->get('patient'));
        $traitement=$request->get('traitement');
        $begin=$request->get('begin');
        $end=$request->get('end');
        try {
            $antecedantPatient=new AntecedantPatient();
            $antecedantPatient->setAntecedant($antecedant->getLibelle());
            $antecedantPatient->setTraitement($traitement);
            $antecedantPatient->setDateBegin(new \DateTime($begin));
            $antecedantPatient->setDateEnd(new \DateTime($end));
            $antecedantPatient->setPatient($patient);
            $temp=[
                'antecedant'=>$antecedant->getLibelle(),
                'traitement'=>$traitement,
                'begin'=>$begin,
                'end'=>$end,
                ];
            $entityManager->persist($antecedantPatient);
            $entityManager->flush();
            return new JsonResponse($temp,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/acte/save", name="saveactepatient", methods={"POST"})
     */
    public function saveActePatient(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $idx = 0;
        $actemedical=$this->actesMedicalRepository->find($request->get('actemedical'));
        $patient=$this->patientRepository->find($request->get('patient'));
        $amount=$request->get('amount');
        $quantite=$request->get('quantite');
        try {
            $actePatient=new ActeMedicalPatient();
            $actePatient->setStatus("encours");
            $actePatient->setCreatedAt(new \DateTime('now'));
            $actePatient->setCreatedBy($this->getUser());
            $actePatient->setAmount($amount);
            $actePatient->setQuantity($quantite);
            $actePatient->setActeMedical($actemedical);
            $actePatient->setPatient($patient);
            $temp=[
                'actemedical'=>$actePatient->getActeMedical()->getLibelle(),
                'amount'=>$amount,
                'quantite'=>$quantite,
            ];
            $entityManager->persist($actePatient);
            $entityManager->flush();
            return new JsonResponse($temp,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
