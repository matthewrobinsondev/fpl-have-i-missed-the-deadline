<?php

namespace App\Http\Controllers;

use App\Services\DeadlineService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index(DeadlineService $deadlineService): \Inertia\Response
    {
        $deadlineTime = $deadlineService->getDeadlineTime();
        $missedDeadline = $deadlineService->hasDeadlinePassed($deadlineTime);

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'missedDeadline' => $missedDeadline,
            'deadlineTime' => $deadlineTime,
        ]);
    }
}
