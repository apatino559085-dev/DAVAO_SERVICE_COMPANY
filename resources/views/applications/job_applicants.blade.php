@extends('layouts.app')
@section('title', 'Applicants Kanban — ' . $job->title)
@section('content')

<!-- SortableJS for Drag and Drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<style>
    /* Premium Kanban Design System */
    .kanban-board {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        padding-bottom: 24px;
        min-height: 70vh;
        align-items: flex-start;
    }

    .kanban-column {
        min-width: 340px;
        width: 340px;
        background: rgba(248,250,252,0.6);
        border: 1px solid rgba(0,0,0,0.04);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .kanban-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .kanban-title {
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .kanban-count {
        background: white;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 800;
        color: #64748b;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .kanban-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        cursor: grab;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    
    .kanban-card:active { cursor: grabbing; }
    
    .kanban-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .sortable-ghost { opacity: 0.4; background: #e2e8f0; border: 2px dashed #94a3b8; }
    .sortable-drag { cursor: grabbing !important; box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important; transform: scale(1.02); }

    .kanban-list {
        min-height: 150px; /* Empty drop target space */
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Modal for scheduling */
    .schedule-modal {
        display: none;
        position: fixed; inset: 0; background: rgba(15,23,42,0.5);
        backdrop-filter: blur(4px); z-index: 50;
        align-items: center; justify-content: center;
    }
</style>

<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Breadcrumb -->
<div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 28px;">
    <a href="{{ route('home') }}" style="color: #94a3b8; text-decoration: none;">Home</a>
    <span>›</span>
    <a href="{{ route('admin.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Dashboard</a>
    <span>›</span>
    <span style="color: #0f172a;">Applicant Tracking Board</span>
</div>

<!-- Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 32px; font-weight: 900; color: #0f172a; letter-spacing: -1px; margin-bottom: 8px;">Kanban Board: {{ $job->title }}</h1>
        <p style="font-size: 15px; color: #64748b; font-weight: 500;">
            Drag and drop applicant cards to update their hiring stage in real-time.
        </p>
    </div>
    <a href="{{ route('admin.dashboard') }}" style="background: white; color: #334155; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 800; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        ← Back to Dashboard
    </a>
</div>

<!-- KANBAN BOARD -->
<div class="kanban-board">
    
    @php
        $columns = [
            'pending' => ['title' => '📥 Pending Review', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
            'for interview' => ['title' => '📅 For Interview', 'color' => '#3b82f6', 'bg' => '#dbeafe'],
            'approved' => ['title' => '🎉 Hired / Approved', 'color' => '#10b981', 'bg' => '#d1fae5'],
            'rejected' => ['title' => '❌ Rejected', 'color' => '#ef4444', 'bg' => '#fee2e2']
        ];
    @endphp

    @foreach($columns as $status => $col)
        <div class="kanban-column">
            <div class="kanban-header">
                <div class="kanban-title" style="color: {{ $col['color'] }};">
                    {{ $col['title'] }}
                </div>
                <div class="kanban-count" id="count-{{ Str::slug($status) }}">
                    {{ $applications->where('status', $status)->count() }}
                </div>
            </div>
            
            <div class="kanban-list" id="list-{{ Str::slug($status) }}" data-status="{{ $status }}">
                @foreach($applications->where('status', $status) as $app)
                    <div class="kanban-card" data-id="{{ $app->id }}">
                        <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, {{ $col['color'] }}, {{ $col['bg'] }}); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 16px;">
                                {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; line-height: 1.2;">{{ $app->applicant->name }}</h3>
                                <p style="font-size: 11px; color: #94a3b8; font-weight: 600; margin-top: 2px;">Applied {{ $app->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        <div style="font-size: 12px; color: #64748b; font-weight: 500; margin-bottom: 12px;">
                            📍 {{ $app->applicant->address ?? 'Location not provided' }}
                        </div>
                        
                        <!-- Attachments Pills -->
                        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px;">
                            @if($app->resume_path) <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; color: #475569;">📄 Resume</span> @endif
                            @if($app->rating) <span style="background: #fffbeb; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; color: #d97706;">⭐ {{ $app->rating }}/5</span> @endif
                        </div>
                        
                        @if($status === 'for interview')
                            @if($app->interview_at)
                                <div style="font-size: 11px; background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; padding: 6px; border-radius: 8px; font-weight: 700; text-align: center;">
                                    ⏰ {{ $app->interview_at->format('M d @ h:i A') }}
                                </div>
                            @else
                                <button onclick="openScheduleModal('{{ $app->id }}', '{{ $app->applicant->name }}')" style="width: 100%; background: white; border: 1px solid #3b82f6; color: #3b82f6; padding: 6px; border-radius: 8px; font-size: 11px; font-weight: 800; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#eff6ff'">+ Set Interview</button>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>

<!-- Schedule Interview Modal -->
<div id="scheduleModal" class="schedule-modal">
    <div style="background: white; border-radius: 24px; padding: 32px; width: 100%; max-width: 400px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
        <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin-bottom: 4px;">Schedule Interview</h3>
        <p style="font-size: 14px; color: #64748b; margin-bottom: 24px; font-weight: 500;">Set a date and location for <span id="modalApplicantName" style="font-weight: 800; color: #0f172a;"></span>.</p>
        
        <form id="scheduleForm" method="POST" action="">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #64748b; margin-bottom: 8px;">Date & Time</label>
                <input type="datetime-local" name="interview_at" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #cbd5e1; font-family: inherit; outline: none;" onfocus="this.style.borderColor='#3b82f6'">
            </div>
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #64748b; margin-bottom: 8px;">Location</label>
                <input type="text" name="interview_location" placeholder="e.g. HR Office / Zoom Link" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #cbd5e1; font-family: inherit; outline: none;" onfocus="this.style.borderColor='#3b82f6'">
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button type="submit" style="flex: 1; background: #3b82f6; color: white; border: none; padding: 12px; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer;">Save Schedule</button>
                <button type="button" onclick="closeScheduleModal()" style="flex: 1; background: #f1f5f9; color: #475569; border: none; padding: 12px; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- AJAX and Kanban Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lists = document.querySelectorAll('.kanban-list');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        lists.forEach(list => {
            new Sortable(list, {
                group: 'kanban',
                animation: 150,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function (evt) {
                    const itemEl = evt.item;
                    const newStatus = evt.to.getAttribute('data-status');
                    const appId = itemEl.getAttribute('data-id');

                    // Update counts
                    updateCounts();

                    // Send AJAX request to update status in DB
                    updateApplicationStatus(appId, newStatus);
                    
                    // If moved to 'for interview', maybe we want to reload or show modal.
                    if (newStatus === 'for interview') {
                        setTimeout(() => window.location.reload(), 800);
                    }
                },
            });
        });

        function updateCounts() {
            document.getElementById('count-pending').innerText = document.getElementById('list-pending').children.length;
            document.getElementById('count-for-interview').innerText = document.getElementById('list-for-interview').children.length;
            document.getElementById('count-approved').innerText = document.getElementById('list-approved').children.length;
            document.getElementById('count-rejected').innerText = document.getElementById('list-rejected').children.length;
        }

        function updateApplicationStatus(appId, status) {
            fetch(`/applications/${appId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'PATCH',
                    status: status
                })
            })
            .then(response => {
                if(!response.ok) {
                    console.error('Failed to update status');
                }
            });
        }
    });

    function openScheduleModal(appId, name) {
        document.getElementById('scheduleModal').style.display = 'flex';
        document.getElementById('modalApplicantName').innerText = name;
        document.getElementById('scheduleForm').action = `{{ url('/') }}/applications/${appId}/schedule`;
    }

    function closeScheduleModal() {
        document.getElementById('scheduleModal').style.display = 'none';
    }
</script>

@endsection
