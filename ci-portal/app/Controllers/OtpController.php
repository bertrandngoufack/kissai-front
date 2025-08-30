<?php

namespace App\Controllers;

use App\Models\OtpCodeModel;
use App\Models\ApplicationModel;
use App\Models\AccessLogModel;

class OtpController extends BaseController
{
    private function generateCode(int $length = 6): string
    {
        $digits = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $digits[random_int(0, strlen($digits) - 1)];
        }
        return $code;
    }

    public function send()
    {
        $email = trim((string) $this->request->getPost('email'));
        $type  = trim((string) $this->request->getPost('type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $applicationId = (int) $this->request->getPost('application_id');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email invalide.');
        }
        if (! in_array($type, ['web', 'exe'], true)) {
            return redirect()->back()->with('error', 'Type invalide.');
        }

        $app = null;
        if ($applicationId > 0) {
            $app = (new ApplicationModel())->find($applicationId);
            if (! $app || (string)$app['type'] !== $type) {
                return redirect()->back()->with('error', 'Application introuvable.');
            }
        }

        $code = $this->generateCode();
        $hash = password_hash($code, PASSWORD_DEFAULT);

        $otpModel = new OtpCodeModel();
        $otpModel->insert([
            'email'          => $email,
            'code_hash'      => $hash,
            'target_type'    => $type,
            'application_id' => $applicationId ?: null,
            'expires_at'     => date('Y-m-d H:i:s', time() + 300),
            'ip_address'     => $this->request->getIPAddress(),
            'user_agent'     => (string) $this->request->getUserAgent(),
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        // TODO: Configure SMTP in .env to really send. For now, log.
        log_message('info', 'OTP envoyé à ' . $email . ' code: ' . $code);

        (new AccessLogModel())->insert([
            'email'      => $email,
            'action'     => 'otp_send',
            'target_type'=> $type,
            'target_id'  => $applicationId ?: null,
            'status'     => 'success',
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => (string) $this->request->getUserAgent(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/otp/request?type=' . $type . '&id=' . $applicationId)
            ->with('message', 'OTP envoyé. Consultez votre email.');
    }

    public function request()
    {
        $type = (string) $this->request->getGet('type');
        $id   = (int) $this->request->getGet('id');
        $app  = $id ? (new ApplicationModel())->find($id) : null;
        return view('front/verify_otp', [
            'title' => 'Vérifier OTP',
            'type'  => $type,
            'app'   => $app,
        ]);
    }

    public function verify()
    {
        $email = trim((string) $this->request->getPost('email'));
        $type  = trim((string) $this->request->getPost('type'));
        $applicationId = (int) $this->request->getPost('application_id');
        $code  = trim((string) $this->request->getPost('code'));

        $otpModel = new OtpCodeModel();
        $otp = $otpModel->where('email', $email)
            ->where('target_type', $type)
            ->where('application_id', $applicationId ?: null)
            ->orderBy('id', 'DESC')
            ->first();

        if (! $otp || strtotime($otp['expires_at']) < time() || $otp['used_at'] !== null || ! password_verify($code, (string)$otp['code_hash'])) {
            (new AccessLogModel())->insert([
                'email'      => $email,
                'action'     => 'otp_verify',
                'target_type'=> $type,
                'target_id'  => $applicationId ?: null,
                'status'     => 'failure',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => (string) $this->request->getUserAgent(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back()->with('error', 'OTP invalide ou expiré.');
        }

        $otpModel->update($otp['id'], ['used_at' => date('Y-m-d H:i:s')]);
        (new AccessLogModel())->insert([
            'email'      => $email,
            'action'     => 'otp_verify',
            'target_type'=> $type,
            'target_id'  => $applicationId ?: null,
            'status'     => 'success',
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => (string) $this->request->getUserAgent(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Redirect based on type
        if ($type === 'web') {
            $app = (new ApplicationModel())->find($applicationId);
            if ($app && ! empty($app['url'])) {
                return redirect()->to($app['url']);
            }
        } else {
            $app = (new ApplicationModel())->find($applicationId);
            if ($app && ! empty($app['file_path'])) {
                return $this->response->download($app['file_path'], null);
            }
        }

        return redirect()->to('/')->with('message', 'OTP vérifié.');
    }
}

