<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ValidationException;
use App\Service\PriceService;
use App\Service\DTO\CalculatePriceDTO;
use App\Validator\CalculateRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class CalculateController extends AbstractController
{
    public function __construct(private readonly PriceService $priceService)
    {
    }

    /**
     * @throws ValidationException
     */
    #[Route('/calculate-price', name: 'calculate_price', methods: [Request::METHOD_POST])]
    public function calculate(Request $request, CalculateRequestValidator $calculateRequestValidator): JsonResponse
    {
        $data = $request->getPayload()->all();
        $calculateRequestValidator->validate($data);
        $total = $this->priceService->calculate(new CalculatePriceDTO($data));

        return $this->json(['total' => $total]);
    }
}