<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\MentorRequest;
use App\Http\Resources\MentorDetailResource;
use App\Http\Resources\MentorResource;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\MentorInfoRepository;
use Illuminate\Http\Request;

class MentorInfoController extends BaseController
{
  public function __construct(
    private MentorInfoRepository $mentorInfoRepository,
    private AccountRepository $accountRepository
  ) {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $mentor = $this->mentorInfoRepository->getMentor(auth()->id());
    $subjects = $mentor->subjects;

    return $this->sendResponse([
      'mentorInfo'    => new MentorResource($mentor),
      'subjects'      => MentorDetailResource::collection($subjects)
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\MentorRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(MentorRequest $request)
  {
    try {

      $data = $request->validated();

      $mentorInfo = $this->mentorInfoRepository->getMentor(auth()->id())
        ? $this->mentorInfoRepository->getMentor(auth()->id())
        : $this->mentorInfoRepository->create($data);

      foreach ($mentorInfo->subjects as $subject) {
        if ($subject->id == $data['subject_id']) {
          return $this->sendResponse(['messages' => __('messages.error.mentor_exist')]);
        }
      }

      $mentorInfo->subjects()->attach($data['subject_id'], [
        'cv_link'   => $data['cv_link'],
        'active'    => config('mentor.active.false')
      ]);

      return $this->sendResponse([
        'message' => __('messages.success.create')
      ]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.create'));
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\MentorRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(MentorRequest $request, $id)
  {
    try {
      $mentor = $this->mentorInfoRepository->find($id);
      $this->mentorInfoRepository->update($id, $request->only('smart_banking'));

      $data = $request->validated();
      foreach ($mentor->subjects as $subject) {
        if ($subject->id == $data['subject_id']) {
          $subject->pivot->cv_link = $data['cv_link'];
          $subject->pivot->save();
        }
      }

      return $this->sendResponse([
        'message' => __('messages.success.update')
      ]);
    } catch (\Exception $e) {
      Log::error($e);
      return $this->sendError(__('messages.error.update'));
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}