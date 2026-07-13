<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ZoomService
{
    private $accountId;
    private $clientId;
    private $clientSecret;
    private $baseUrl;

    public function __construct()
    {
        $siteSettingDetail = SiteSetting::first();
        if (!empty($siteSettingDetail)) {
            $this->accountId    = $siteSettingDetail->zoom_account_id ?? '';
            $this->clientId     = $siteSettingDetail->zoom_client_id ?? '';
            $this->clientSecret = $siteSettingDetail->zoom_client_secret ?? '';
            $this->baseUrl = $siteSettingDetail->zoom_api_url ?? '';
        } else {
            $this->accountId    = config('services.zoom.account_id');
            $this->clientId     = config('services.zoom.client_id');
            $this->clientSecret = config('services.zoom.client_secret');
            $this->baseUrl      = config('services.zoom.base_url');
        }
    }

    /**
     * Fail fast on a misconfigured Server-to-Server OAuth app, instead of letting Zoom
     * answer a bad credential with an opaque {"error":"invalid_request"}.
     */
    private function assertCredentialsAreConfigured(): void
    {
        $missing = [];
        foreach (['ZOOM_ACCOUNT_ID' => $this->accountId, 'ZOOM_CLIENT_ID' => $this->clientId, 'ZOOM_CLIENT_SECRET' => $this->clientSecret] as $key => $value) {
            if (empty($value)) {
                $missing[] = $key;
            }
        }

        if ($missing) {
            throw new \Exception(
                'Zoom is not configured: ' . implode(', ', $missing) . ' missing from .env. '
                    . 'Copy these from Zoom App Marketplace > Manage > your Server-to-Server OAuth app > App Credentials.'
            );
        }

        // Zoom issues Account ID and Client ID as different values, and they sit next to
        // each other on the credentials page — pasting the wrong one is the usual cause.
        if ($this->accountId === $this->clientId) {
            throw new \Exception(
                'Zoom ZOOM_ACCOUNT_ID is identical to ZOOM_CLIENT_ID, so it is not a valid account ID. '
                    . 'On Zoom App Marketplace > Manage > your Server-to-Server OAuth app > App Credentials, '
                    . 'copy the "Account ID" field (the first one, above Client ID) into ZOOM_ACCOUNT_ID in .env.'
            );
        }
    }

    // Get Access Token (cached)
    private function getAccessToken()
    {
        $this->assertCredentialsAreConfigured();

        return Cache::remember('zoom_access_token', 3300, function () {
            $response = Http::asForm()->withBasicAuth(
                $this->clientId,
                $this->clientSecret
            )->post("https://zoom.us/oauth/token", [
                'grant_type' => 'account_credentials',
                'account_id' => $this->accountId,
            ]);

            if ($response->failed()) {
                throw new \Exception(
                    'Zoom Auth failed (HTTP ' . $response->status() . '): ' . $response->body() . ' '
                        . 'Verify ZOOM_ACCOUNT_ID, ZOOM_CLIENT_ID and ZOOM_CLIENT_SECRET in .env match the '
                        . 'App Credentials of your Server-to-Server OAuth app.'
                );
            }

            return $response->json()['access_token'];
        });
    }

    // Create Meeting
    public function createMeeting($userId = 'me', $data = [])
    {
        $response = Http::withToken($this->getAccessToken())
            ->post("{$this->baseUrl}/users/{$userId}/meetings", $data);

        return $response->json();
    }

    // Update Meeting
    public function updateMeeting($meetingId, $data = [])
    {
        $response = Http::withToken($this->getAccessToken())
            ->patch("{$this->baseUrl}/meetings/{$meetingId}", $data);

        return $response->json();
    }

    // Delete Meeting
    public function deleteMeeting($meetingId)
    {
        $response = Http::withToken($this->getAccessToken())
            ->delete("{$this->baseUrl}/meetings/{$meetingId}");

        return $response->status() === 204;
    }

    // List Meetings
    public function listMeetings($userId = 'me')
    {
        $response = Http::withToken($this->getAccessToken())
            ->get("{$this->baseUrl}/users/{$userId}/meetings");

        return $response->json();
    }
}
