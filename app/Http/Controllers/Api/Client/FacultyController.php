<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\FacultyResource;
use App\Repositories\Contracts\FacultyRepository;
use Illuminate\Http\Request;

class FacultyController extends BaseController
{
  public function __construct(
    public FacultyRepository $facultyRepository
  ) {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $faculties = $this->facultyRepository->getListFaculty($request->all());

    return $this->sendResponse([
        'data' => FacultyResource::collection($faculties)
    ]);
  }
}
