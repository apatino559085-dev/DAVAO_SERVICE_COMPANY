<?php
namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with('employer')->latest();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('salary') && $request->salary) {
            if ($request->salary == '10k') {
                $query->whereRaw('CAST(salary AS UNSIGNED) BETWEEN 10000 AND 20000');
            } elseif ($request->salary == '20k') {
                $query->whereRaw('CAST(salary AS UNSIGNED) BETWEEN 20000 AND 50000');
            } elseif ($request->salary == '50k') {
                $query->whereRaw('CAST(salary AS UNSIGNED) >= 50000');
            }
        }

        $jobs = $query->paginate(5)->withQueryString();
        
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'salary'      => 'nullable|string|max:100',
            'type'        => 'required|in:full-time,part-time,remote,contract',
        ]);

        auth()->user()->jobPosts()->create($data);

        return redirect()->route('jobs.index')->with('success', 'Job post created!');
    }

    public function show(JobPost $job)
    {
        $job->load('employer', 'applications');
        return view('jobs.show', compact('job'));
    }

    public function edit(JobPost $job)
    {
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));   
    }

    public function update(Request $request, JobPost $job)
    {
        $this->authorize('update', $job);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'salary'      => 'nullable|string|max:100',
            'type'        => 'required|in:full-time,part-time,remote,contract',
        ]);

        $job->update($data);

        return redirect()->route('jobs.index')->with('success', 'Job post updated!');
    }

    public function destroy(JobPost $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job post deleted!');
    }
}