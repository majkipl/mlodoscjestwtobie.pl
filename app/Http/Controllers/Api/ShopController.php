<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AddShopRequest;
use App\Http\Requests\Api\IndexShopRequest;
use App\Http\Requests\Api\UpdateShopRequest;
use App\Models\Shop;
use App\Traits\ApiRequestParametersTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    use ApiRequestParametersTrait;

    /**
     * @param IndexShopRequest $request
     * @return JsonResponse
     */
    public function index(IndexShopRequest $request): JsonResponse
    {
        $params = $this->getRequestParameters($request);
        extract($params);

        $query = Shop::search($search, $searchable)->filter($filter)->orderBy($sort, $order);

        $shopsCount = $query->count('id');
        $shops = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $shopsCount,
            'rows' => $shops
        ], Response::HTTP_OK);
    }

    /**
     * @param AddShopRequest $request
     * @return JsonResponse
     */
    public function add(AddShopRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $shop = new Shop($request->validated());
            $params = $request->all();

            $shop->save();

            DB::commit();

            Cache::forget('shops');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.shop')
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();

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

    /**
     * @param UpdateShopRequest $request
     * @return JsonResponse
     */
    public function update(UpdateShopRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $shop = Shop::findOrFail($request->input('id'));
            $shop->fill($request->validated());

            $params = $request->all();

            $shop->save();

            DB::commit();

            Cache::forget('shops');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.shop')
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'errors' => [
                        'main' => [
                            'Nie możemy zaktualizować rekordu, aby rozwiązać problem skontaktuj się z administratorem serwisu.'
                        ]
                    ],
                    'message' => 'Wewnętrzny błąd serwisu.'
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * @param Shop $shop
     * @return JsonResponse
     */
    public function delete(Shop $shop): JsonResponse
    {
        DB::beginTransaction();

        try {
            $shop->delete();

            DB::commit();

            Cache::forget('shops');

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Rekord został pomyślnie usunięty.'
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'errors' => [
                        'main' => [
                            'Nie możemy usunąć rekordu, aby rozwiązać problem skontaktuj się z administratorem serwisu.'
                        ]
                    ],
                    'message' => 'Wewnętrzny błąd serwisu.'
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
