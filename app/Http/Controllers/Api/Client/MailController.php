<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\InviteMentorRequest;
use App\Jobs\SendMailInviteMentor;
use App\Repositories\Contracts\MentorInfoRepository;
use Illuminate\Support\Facades\Log;

class MailController extends BaseController
{

    public function __construct(
        private MentorInfoRepository $mentorInfoRepository
    ) {
    }

    public function sendEmail(InviteMentorRequest $request)
    {
        try {
            $data = $request->validated();

            $mentor = $this->mentorInfoRepository->getMentor($data['mentor_id']);

            SendMailInviteMentor::dispatch($mentor->account->email, $data['invite_link']);

            return $this->sendResponse([
                'message' => __('messages.success.invite_mentor')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->sendError(__('messages.error.invite_mentor'));
        }
    }
}
