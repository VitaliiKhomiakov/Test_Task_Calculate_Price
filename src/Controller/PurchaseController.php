<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\PaymentType;
use App\Exception\ValidationException;
use App\Service\DTO\CalculatePriceDTO;
use App\Service\PaymentService;
use App\Validator\CalculateRequestValidator;
use App\Validator\PaymentRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class PurchaseController extends AbstractController
{
    public function __construct(private readonly PaymentService $paymentService) {}

    /**
     * @throws ValidationException
     */
    #[Route('/purchase', name: 'purchase', methods: [Request::METHOD_POST])]
    public function processPurchase(
        Request $request,
        CalculateRequestValidator $calculateRequestValidator,
        PaymentRequestValidator $paymentRequestValidator
    ): JsonResponse {
        $data = $request->getPayload()->all();
        $calculateRequestValidator->validate($data);
        $paymentRequestValidator->validate($data['paymentProcessor'] ?? '');

        $this->paymentService->process(new CalculatePriceDTO($data), PaymentType::tryFrom($data['paymentProcessor']));

        return $this->json(['status' => 'success']);
    }
}