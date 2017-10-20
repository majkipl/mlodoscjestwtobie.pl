<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\IndexApplicationRequest;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicationController extends Controller
{
    public function index(IndexApplicationRequest $request): JsonResponse
    {
        $search = $request->input('search');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $searchable = $request->input('searchable', []);
        $filter = $request->input('filter', []);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $query = Application::with(['shop','category','product','whence'])->search($search, $searchable)->filter($filter)->orderBy($sort, $order);

        $applicationsCount = $query->count('id');
        $applications = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $applicationsCount,
            'rows' => $applications
        ], Response::HTTP_OK);
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
}