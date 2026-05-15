@extends('layouts.app')
@section('title', 'Manage Candidates')
@section('content')

<style>
    /* Premium Animations & Effects */
    @keyframes pulse-ring {
        0% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.8); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    
    .badge-new {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white; padding: 4px 10px; border-radius: 100px;
        font-size: 10px; font-weight: 900; letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(239,68,68,0.3);
        animation: pulse-ring 2s infinite;
        position: absolute; top: 24px; right: 24px; border: 2px solid white; z-index: 10;
    }

    .candidate-card {
        background: white; border-radius: 32px; padding: 0; border: 1px solid #f1f5f9;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; overflow: hidden; display: flex; flex-direction: column;
    }
    .candidate-card:hover { transform: translateY(-8px); box-shadow: 0 30px 60px rgba(0,0,0,0.06); border-color: #cbd5e1; }

    .action-btn {
        flex: 1; display: flex; align-items: center; justify-content: center;
        gap: 8px; padding: 16px; font-size: 13px; font-weight: 800;
        cursor: pointer; transition: all 0.2s; border: none; text-decoration: none;
    }
    .btn-interview { background: #f0f9ff; color: #0369a1; border-right: 1px solid #e0f2fe; }
    .btn-interview:hover { background: #e0f2fe; color: #0284c7; }
    .btn-approve { background: #f0fdf4; color: #15803d; border-right: 1px solid #dcfce7; }
    .btn-approve:hover { background: #dcfce7; color: #16a34a; }
    .btn-reject { background: #fff1f2; color: #be123c; }
    .btn-reject:hover { background: #ffe4e6; color: #e11d48; }

    .search-input {
        width: 320px; padding: 14px 14px 14px 44px; border-radius: 16px; border: 2px solid #f1f5f9;
        background: white; font-size: 14px; font-weight: 600; outline: none; transition: all 0.2s;
    }
    .search-input:focus { border-color: #022c22; box-shadow: 0 0 0 4px rgba(2, 44, 34, 0.05); }

    .filter-select {
        padding: 14px 24px; border-radius: 16px; border: 2px solid #f1f5f9;
        background: white; font-size: 14px; font-weight: 800; color: #0f172a; outline: none; cursor: pointer;
    }
</style>

<div style="max-width: 1300px; margin: 0 auto;">
    
    <!-- Clean Management Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 48px;">
        <div>
            <h1 style="font-size: 32px; font-weight: 900; color: #022c22; letter-spacing: -1px;">Manage Applicants</h1>
        </div>

        <div style="display: flex; gap: 16px;">
            <div style="position: relative;">
                <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="applicantSearch" class="search-input" placeholder="Search by name or email...">
            </div>
            <select id="statusFilter" class="filter-select">
                <option value="all">All Status</option>
                <option value="pending">⏳ Pending Review</option>
                <option value="for interview">📅 Scheduled</option>
                <option value="approved">✅ Hired</option>
                <option value="rejected">❌ Rejected</option>
            </select>
        </div>
    </div>

    <!-- Candidate Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 32px;">
        @forelse($applications as $app)
        <div class="candidate-card applicant-card" data-name="{{ strtolower($app->applicant->name) }}" data-email="{{ strtolower($app->applicant->email) }}" data-status="{{ $app->status }}">
            
            @if($app->status === 'pending')
                <div class="badge-new">NEW</div>
            @endif

            <div style="padding: 40px;">
                <div style="display: flex; gap: 24px; align-items: center; margin-bottom: 32px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #022c22, #064e3b); display: flex; align-items: center; justify-content: center; color: #fbbf24; font-weight: 900; font-size: 32px; flex-shrink: 0; box-shadow: 0 10px 25px rgba(2,44,34,0.15); border: 4px solid white;">
                        {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
                    </div>
                    
                    <div style="flex: 1;">
                        <h2 style="font-size: 22px; font-weight: 900; color: #022c22; margin-bottom: 4px;">{{ $app->applicant->name }}</h2>
                        <p style="font-size: 14px; color: #64748b; font-weight: 600;">{{ $app->applicant->email }}</p>
                        <div style="margin-top: 10px; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Applied {{ $app->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <div style="margin-bottom: 32px; padding: 20px; background: #f8fafc; border-radius: 24px; border: 1px solid #f1f5f9;">
                    <p style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Applying For</p>
                    <a href="{{ route('jobs.show', $app->jobPost) }}" style="font-size: 16px; font-weight: 800; color: #022c22; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                        <svg style="width: 18px; height: 18px; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $app->jobPost->title }}
                    </a>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    @if($app->resume_path)
                        <button onclick="previewResume('{{ asset('storage/' . $app->resume_path) }}')" style="background: white; border: 2px solid #e2e8f0; color: #022c22; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            View Resume
                        </button>
                    @endif

                    @if($app->rating)
                        <div style="display: flex; gap: 2px;">
                            @for($i=1; $i<=5; $i++)
                                <span style="font-size: 18px; color: {{ $i <= $app->rating ? '#fbbf24' : '#e2e8f0' }};">★</span>
                            @endfor
                        </div>
                    @endif
                </div>
            </div>

            <div style="margin-top: auto; border-top: 1px solid #f1f5f9;">
                @if($app->status === 'pending' || $app->status === 'for interview')
                    <div style="display: flex; width: 100%;">
                        @if($app->status === 'pending')
                            <button onclick="openInterviewModal({{ $app->id }}, '{{ $app->applicant->name }}')" class="action-btn btn-interview">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Interview
                            </button>
                        @endif
                        <form method="POST" action="{{ route('applications.updateStatus', $app) }}" style="flex: 1; display: flex;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="action-btn btn-approve">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('applications.updateStatus', $app) }}" style="flex: 1; display: flex;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="action-btn btn-reject">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Reject
                            </button>
                        </form>
                    </div>
                @else
                    <div style="padding: 20px 40px; background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.2px;
                            {{ $app->status === 'approved' ? 'color: #059669;' : 'color: #dc2626;' }}">
                            ● {{ $app->status === 'approved' ? 'Hired / Approved' : 'Application Rejected' }}
                        </span>
                        
                        <form method="POST" action="{{ route('applications.archive', $app) }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: white; border: 2px solid #e2e8f0; padding: 8px 16px; border-radius: 12px; font-size: 11px; font-weight: 800; color: #64748b; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.background='#022c22'; this.style.color='white'; this.style.borderColor='#022c22'">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                Archive
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 120px 40px; background: white; border-radius: 40px; border: 2px dashed #e2e8f0;">
            <div style="font-size: 80px; margin-bottom: 24px;">📥</div>
            <h3 style="font-size: 28px; font-weight: 900; color: #022c22; margin-bottom: 12px;">Waiting for candidates</h3>
            <p style="font-size: 16px; color: #64748b; font-weight: 500; max-width: 450px; margin: 0 auto;">
                All new applications will appear here in real-time. Start by promoting your job listings.
            </p>
        </div>
        @endforelse
    </div>
</div>

<!-- Interview Scheduling Modal -->
<div id="interviewModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px); z-index: 1000; padding: 40px; align-items: center; justify-content: center;">
    <div style="background: white; width: 100%; max-width: 450px; border-radius: 32px; position: relative; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 30px 60px rgba(0,0,0,0.4); animation: modalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 18px; font-weight: 900; color: #022c22;">Schedule Interview</h3>
                <p id="applicantNameDisplay" style="font-size: 13px; color: #64748b; font-weight: 500;"></p>
            </div>
            <button onclick="closeInterviewModal()" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 10px; color: #64748b; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444'" onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b'">✕</button>
        </div>
        <form id="interviewForm" method="POST" action="" style="padding: 32px;">
            @csrf
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Interview Date & Time</label>
                <input type="datetime-local" name="interview_at" required 
                    style="width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none; transition: all 0.2s; font-family: inherit;">
            </div>
            <div style="margin-bottom: 32px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Location / Zoom Link</label>
                <input type="text" name="interview_location" required placeholder="e.g. Conference Room A"
                    style="width: 100%; padding: 14px; border: 2px solid #e2e8f0; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none; transition: all 0.2s; font-family: inherit;">
            </div>
            <button type="submit" style="width: 100%; background: #022c22; color: #fbbf24; border: none; padding: 16px; border-radius: 14px; font-size: 14px; font-weight: 800; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(2,44,34,0.2);">
                Confirm Schedule
            </button>
        </form>
    </div>
</div>

<!-- Resume Preview Modal -->
<div id="resumeModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px); z-index: 1000; padding: 40px; align-items: center; justify-content: center;">
    <div style="background: white; width: 100%; max-width: 1100px; height: 100%; border-radius: 40px; position: relative; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
        <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: white; z-index: 10;">
            <h3 style="font-size: 20px; font-weight: 900; color: #022c22;">Candidate Portfolio</h3>
            <button onclick="closeResume()" style="background: #f1f5f9; border: none; width: 40px; height: 40px; border-radius: 12px; color: #64748b; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444'" onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b'">✕</button>
        </div>
        <div style="flex: 1; background: #f8fafc; position: relative;">
            <iframe id="resumeFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
    </div>
</div>

<script>
function previewResume(url) {
    const modal = document.getElementById('resumeModal');
    const frame = document.getElementById('resumeFrame');
    frame.src = url;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeResume() {
    const modal = document.getElementById('resumeModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function openInterviewModal(appId, applicantName) {
    const modal = document.getElementById('interviewModal');
    const form = document.getElementById('interviewForm');
    const nameDisplay = document.getElementById('applicantNameDisplay');
    
    nameDisplay.innerText = "Scheduling for: " + applicantName;
    form.action = "{{ url('/') }}/applications/" + appId + "/schedule";
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeInterviewModal() {
    const modal = document.getElementById('interviewModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Real-time Filtering Logic
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('applicantSearch');
    const statusFilter = document.getElementById('statusFilter');
    const cards = document.querySelectorAll('.applicant-card');

    function filter() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const email = card.getAttribute('data-email');
            const status = card.getAttribute('data-status');

            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            const matchesStatus = statusTerm === 'all' || status === statusTerm;

            if (matchesSearch && matchesStatus) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filter);
    statusFilter.addEventListener('change', filter);
});
</script>
@endsection
