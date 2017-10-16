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
use Illuminate\Http\Request;
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

    public function store(StoreApplicationRequest $request)
    {
        try {
            $application = $this->applicationService->store(
                $request->validated(),
                $request
            );

            $contest = $application->contest ? true : false;

            $this->applicationService->sendMail($request->input('email'), ['id' => $application->id, 'token' => $application->token], $contest);

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

    public function verified(Request $request)
    {
        $searchKeyword = $request->input('phrase');

        $applications = Application::select('id', 'firstname', 'lastname', 'title', 'message', 'img_tip', 'video_url', 'video_type',
            'video_id', 'video_image_id')
            ->whereNull('token')
            ->where('contest', true)
            ->where(function ($query) use ($searchKeyword) {
                $query->where('title', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('message', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('firstname', 'LIKE', '%' . $searchKeyword . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $searchKeyword . '%');
            })
            ->orderBy('id', 'desc') // Sortowanie po ID malejąco
            ->skip($request->input('offset', 0))
            ->take($request->input('limit', 10))
            ->get();


        return response()->json([
            'total' => $applications->count(),
            'rows' => $applications->toArray()
        ], Response::HTTP_OK);
    }

    public function show(Application $application)
    {
        return view('application/show', [
            'contest' => $application
        ]);
    }
}
