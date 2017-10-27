<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Whence;
use App\Services\ApplicationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function form()
    {
        return view('application/form', [
            'isEndPromotion' => false,
            'isEndContest' => false,
            'isEndResult' => false,
            'categories' => Category::getAllCached(),
            'shops' => Shop::getAllCached(),
            'whences' => Whence::getAllCached(),
            'products' => Product::getAllCached()
        ]);
    }

    public function store(StoreApplicationRequest $request): JsonResponse
    {
        try {
            $application = $this->applicationService->store(
                $request->validated(),
                $request
            );

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('front.thx.form')
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'errors' => [
                        'main' => [
                            'Nie możemy dodać Twojego zgłoszenia, aby rozwiązać problem skontaktuj się z administratorem serwisu.'
                        ]
                    ],
                    'message' => 'Wewnętrzny błąd serwisu.'
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function show(Application $application)
    {
        return view('application/show', [
            'contest' => $application
        ]);
    }
}
