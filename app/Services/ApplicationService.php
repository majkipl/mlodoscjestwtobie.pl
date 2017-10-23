<?php

namespace App\Services;

use App\Http\Requests\StoreApplicationRequest ;
use App\Mails\ApplicationMail;
use App\Models\Application;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApplicationService
{

    /** @var VideoService */
    private $videoService;

    public function __construct()
    {
        $this->videoService = new VideoService();
    }

    /**
     * @param array $data
     * @param StoreApplicationRequest $request
     * @return Application
     * @throws Exception
     */
    public function store(array $data, StoreApplicationRequest $request): Application
    {
        DB::beginTransaction();

        try {
            $application = new Application($data);

            if( $request->file('img_receipt') ) {
                $application->img_receipt = $request->file('img_receipt')->store('public/receipts');
            }
            if( $request->file('img_ean') ) {
                $application->img_ean = $request->file('img_ean')->store('public/eans');
            }

            $params = $request->all();

            $application->category_id = $params['category'];
            $application->product_id = $params['product'];
            $application->shop_id = $params['shop'];
            $application->whence_id = $params['whence'];

            $application->legal_1 = array_key_exists('legal_1', $params);
            $application->legal_2 = array_key_exists('legal_2', $params);
            $application->legal_3 = array_key_exists('legal_3', $params);
            $application->legal_4 = array_key_exists('legal_4', $params);

            $application->token = Str::random(32);

            if( $params['i_want'] ) {
                if( $request->file('img_tip') ) {
                    $application->img_tip = $request->file('img_tip')->store('public/tips');
                }

                $application->video_type = $this->videoService->getVideoServiceType($params['video_url']);
                $application->video_id = $this->videoService->getVideoIdFromUrl($params['video_url']);
                $application->video_image_id = $this->videoService->getVideoImageID($params['video_url']);
                $application->contest = true;
            }

            $application->save();

            DB::commit();

            return $application;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('Nie można zapisać zgłoszenia');
        }
    }

    /**
     * @param string $email
     * @param array $data
     * @param bool $contest
     * @return void
     */
    public function sendMail(string $email, array $data, bool $contest): void
    {
        if ($contest) {
            Mail::to($email)->send(new ApplicationMail($data, 'emails.contest.html', 'emails.contest.text'));
        } else {
            Mail::to($email)->send(new ApplicationMail($data, 'emails.promotion.html', 'emails.promotion.text'));
        }
    }
}
