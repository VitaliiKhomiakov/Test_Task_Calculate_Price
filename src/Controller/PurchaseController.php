<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Request\PurchaseRequestDTO;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class PurchaseController extends AbstractController
{
    public function __construct(private readonly PaymentService $paymentService) {}

    #[Route('/purchase', name: 'purchase', methods: [Request::METHOD_POST])]
    public function processPurchase(#[MapRequestPayload] PurchaseRequestDTO $request): JsonResponse
    {
        $this->paymentService->process($request);

        return $this->json(['status' => 'success']);
    }
}
