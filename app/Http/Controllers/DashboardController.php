<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Google\Client as GoogleClient;
use Google\Service\Calendar as GCalendar;
use Google\Service\Gmail as GGmail;
use Google\Service\Tasks as GTasks;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $client = $this->makeGoogleClient($user);

        // Calendar (next events)
        $cal = new GCalendar($client);
        $calItems = $cal->events->listEvents('primary', [
            'singleEvents' => true,
            'orderBy'      => 'startTime',
            'timeMin'      => now()->toRfc3339String(),
            'maxResults'   => 10,
        ])->getItems() ?? [];
        $events = collect($calItems)->take(3);

        // Gmail (recent 3)
        $gmail = new GGmail($client);
        $msgs  = $gmail->users_messages->listUsersMessages('me', ['maxResults' => 10])->getMessages() ?? [];
        $emails = collect($msgs)->take(3)->map(function ($m) use ($gmail) {
            $full = $gmail->users_messages->get('me', $m->getId(), [
                'format' => 'metadata',
                'metadataHeaders' => ['Subject','From','Date'],
            ]);
            $hdrs = collect($full->getPayload()->getHeaders())->keyBy('name');
            return [
                'from'    => optional($hdrs->get('From'))->getValue(),
                'subject' => optional($hdrs->get('Subject'))->getValue(),
                'date'    => optional($hdrs->get('Date'))->getValue(),
            ];
        });

        // Tasks (top 3)
        $tasks = new GTasks($client);
        $tItems = $tasks->tasks->listTasks('@default', ['maxResults' => 10])->getItems() ?? [];
        $todos = collect($tItems)->take(3)->map(fn($t) => [
            'title'  => $t->getTitle(),
            'due'    => $t->getDue() ? Carbon::parse($t->getDue())->format('Y-m-d') : null,
            'status' => $t->getStatus(), // 'needsAction' | 'completed'
        ]);

        return view('dashboard', compact('events','emails','todos'));
    }

    private function makeGoogleClient($user): GoogleClient
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        // Not strictly required here, but fine to keep:
        $client->setAccessType('offline');

        // ⬇️ Replace with however you store tokens.
        // Example if you saved the raw token JSON from Socialite into users.google_token:
        $token = json_decode($user->google_token ?? '{}', true);

        if (!empty($token)) {
            $client->setAccessToken($token);
        }

        // Refresh if expired (and persist the new token)
        if ($client->isAccessTokenExpired() && !empty($token['refresh_token'])) {
            $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
            $user->google_token = json_encode($client->getAccessToken());
            $user->save();
        }

        return $client;
    }
}
