<?php

namespace Altum\Controllers;

class CronQuick extends Controller
{

    public function index()
    {
        die();
    }

    private function initiate()
    {       
        set_time_limit(0);      
        if (!isset($_GET['key']) || (isset($_GET['key']) && $_GET['key'] != settings()->cron->key)) {
            die();
        }
        
    }

    

    public function reset()
    {
        $this->initiate(); 
        try {
            $this->check_dpf_user_status();
        } catch (\Throwable $th) {
            echo 'check_dpf_user_status';
        }
    }



    private function check_dpf_user_status()
    {
        $currentTime = date('Y-m-d H:i:s', strtotime('-1 minutes'));
        $query  = "SELECT * FROM `dpf_online` WHERE `last_activity` < '{$currentTime}' ORDER BY `id` ASC";
        $data = db()->query($query);

        foreach ($data as $offlineUser) {
            $user = db()->where('user_id', $offlineUser->user_id)->getOne('users');
            if ($user && ($user->payment_processor == null || empty($user->payment_processor))) {
                try {
                    send_download_qr_email($user->user_id);
                } catch (\Throwable $th) {
                }

                db()->where('user_id', $user->user_id)->delete('dpf_online');
            }
        }
    }
}
