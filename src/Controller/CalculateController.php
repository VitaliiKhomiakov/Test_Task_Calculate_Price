<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Request\CalculatePriceRequestDTO;
use App\Service\Price\PriceCalculationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class CalculateController extends AbstractController
{
    public function __construct(private readonly PriceCalculationService $priceCalculationService) {}

    #[Route('/calculate-price', name: 'calculate_price', methods: [Request::METHOD_POST])]
    public function calculate(#[MapRequestPayload] CalculatePriceRequestDTO $request): JsonResponse
    {
        $total = $this->priceCalculationService->calculate($request);

        return $this->json(['total' => $total]);
    }
}
