<?php

namespace KimaiPlugin\QuickRestartBundle\Controller;

use App\Repository\TimesheetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class QuickStartController extends AbstractController
{
    #[Route(path: '/quick-start', name: 'quick_start', methods: ['GET'])]
    public function index(TimesheetRepository $repository): Response
    {
        $user = $this->getUser();

        $activeTimesheet = $repository->createQueryBuilder('t')
            ->where('t.user = :user')
            ->andWhere('t.end IS NULL')
            ->setParameter('user', $user)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        $lastTimesheet = null;
        if ($activeTimesheet === null) {
            $lastTimesheet = $repository->createQueryBuilder('t')
                ->where('t.user = :user')
                ->andWhere('t.end IS NOT NULL')
                ->setParameter('user', $user)
                ->orderBy('t.end', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        }

        return $this->render('@QuickRestart/quick_start.html.twig', [
            'activeTimesheet' => $activeTimesheet,
            'lastTimesheet' => $lastTimesheet,
        ]);
    }
}
