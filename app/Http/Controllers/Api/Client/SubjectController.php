<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\SubjectResource;
use App\Repositories\Contracts\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends BaseController
{
    public function __construct(
        public SubjectRepository $subjectRepository
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjects = $this->subjectRepository->getListSubject($request->all());

        return $this->sendResponse(SubjectResource::collection($subjects));
    }
}
