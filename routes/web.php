<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

Route::get('/test-auth', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'role' => auth()->user()?->role,
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public job listing
Route::get('/jobs', [JobPostController::class, 'index'])->name('jobs.index');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Employer: manage own job posts
    Route::middleware(['role:staff,admin,employer,hr'])->group(function () {
        Route::get('/my-jobs', [JobPostController::class, 'myJobs'])->name('jobs.my');
        Route::get('/jobs/create', [JobPostController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobPostController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobPostController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobPostController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobPostController::class, 'destroy'])->name('jobs.destroy');

        // Employer: manage applicants
        Route::get('/received-applications', [ApplicationController::class, 'receivedApplications'])->name('applications.received');
        Route::get('/archived-applications', [ApplicationController::class, 'archivedApplications'])->name('applications.archived');
        Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'jobApplicants'])->name('jobs.applicants');
        Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
        Route::post('/applications/{application}/undo', [ApplicationController::class, 'undoStatus'])->name('applications.undo');
        Route::post('/applications/{application}/archive', [ApplicationController::class, 'archive'])->name('applications.archive');
        Route::post('/applications/{application}/schedule', [ApplicationController::class, 'scheduleInterview'])->name('applications.scheduleInterview');
        Route::post('/applications/{application}/rate', [ApplicationController::class, 'rateApplicant'])->name('applications.rate');
    });

    // Test route without role middleware
    Route::get('/jobs/create-test', function () {
        return 'Test route works! Authenticated as: ' . auth()->user()->name;
    })->name('jobs.create-test');

    // Applicant: apply for jobs
    Route::middleware(['role:applicant'])->group(function () {
        Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my');
    });

    // Admin Only
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/archived-jobs', [AdminController::class, 'archivedJobs'])->name('archived-jobs');
        Route::get('/report', [AdminController::class, 'generateReport'])->name('report');
        Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
        Route::delete('/jobs/{job}/force', [AdminController::class, 'destroyJob'])->name('jobs.destroy');
    });
});

// Public job show - comes after specific routes
Route::get('/jobs/{job}', [JobPostController::class, 'show'])->name('jobs.show');

require __DIR__.'/auth.php';