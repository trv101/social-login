<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Gmail;
use Google_Service_Tasks;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    private function getClient()
{
    $token = json_decode(Auth::user()->google_token, true);

    $client = new Google_Client();
    $client->setAccessToken($token);

    if ($client->isAccessTokenExpired()) {
        // Refresh the token if we have a refresh_token
        if (isset($token['refresh_token'])) {
            $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
            
            // Update DB with new token
            Auth::user()->google_token = json_encode($client->getAccessToken());
            Auth::user()->save();
        } else {
            // No refresh token → force re-login
            return redirect()->route('google-auth');
        }
    }

    return $client;
}


    public function calendar()
    {
        $client = $this->getClient();
        if ($client instanceof \Illuminate\Http\RedirectResponse) {
            return $client; // Redirect if token expired
        }

        $service = new Google_Service_Calendar($client);

        $events = $service->events->listEvents('primary', ['maxResults' => 10]);

        return view('google.calendar', ['events' => $events->getItems()]);
    }

    public function emails()
    {
        $client = $this->getClient();
        if ($client instanceof \Illuminate\Http\RedirectResponse) {
            return $client;
        }

        $service = new Google_Service_Gmail($client);

        $messages = $service->users_messages->listUsersMessages('me', ['maxResults' => 10]);

        $emailData = [];
        foreach ($messages->getMessages() as $message) {
            $msg = $service->users_messages->get('me', $message->getId(), ['format' => 'metadata']);
            $headers = $msg->getPayload()->getHeaders();
            $subject = collect($headers)->firstWhere('name', 'Subject')->value ?? '';
            $from = collect($headers)->firstWhere('name', 'From')->value ?? '';
            $date = collect($headers)->firstWhere('name', 'Date')->value ?? '';

            $emailData[] = ['subject' => $subject, 'from' => $from, 'date' => $date];
        }

        return view('google.emails', ['emails' => $emailData]);
    }

    public function todos()
    {
        $client = $this->getClient();
        if ($client instanceof \Illuminate\Http\RedirectResponse) {
            return $client;
        }

        $service = new Google_Service_Tasks($client);

        $taskLists = $service->tasklists->listTasklists(['maxResults' => 5]);
        $allTasks = [];

        foreach ($taskLists->getItems() as $taskList) {
            $tasks = $service->tasks->listTasks($taskList->getId());
            foreach ($tasks->getItems() as $task) {
                $allTasks[] = [
                    'title' => $task->getTitle(),
                    'due' => $task->getDue(),
                    'status' => $task->getStatus()
                ];
            }
        }

        return view('google.todos', ['todos' => $allTasks]);
    }
}
