<style>
    .form-group { margin-bottom: 32px; }
    .form-label { display: block; font-size: 11px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; padding-left: 4px; }
    .form-input { 
        width: 100%; padding: 18px 24px; border: 2px solid #f1f5f9; border-radius: 20px; 
        font-size: 15px; font-weight: 600; color: var(--primary); outline: none; transition: all 0.3s;
        background: #fcfdfe;
    }
    .form-input:focus { border-color: var(--accent); background: white; box-shadow: 0 10px 25px rgba(251, 191, 36, 0.1); }
    textarea.form-input { min-height: 150px; resize: vertical; }
</style>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Job Title / Position</label>
        <input type="text" name="title" class="form-input" placeholder="e.g. Senior Security Specialist" value="{{ old('title', $job->title ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label">Department</label>
        <select name="department" class="form-input">
            <option value="IT" {{ (old('department', $job->department ?? '') == 'IT') ? 'selected' : '' }}>Technology</option>
            <option value="Admin" {{ (old('department', $job->department ?? '') == 'Admin') ? 'selected' : '' }}>Administration</option>
            <option value="Security" {{ (old('department', $job->department ?? '') == 'Security') ? 'selected' : '' }}>Security & Safety</option>
            <option value="Maintenance" {{ (old('department', $job->department ?? '') == 'Maintenance') ? 'selected' : '' }}>Facility Maintenance</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label">Employment Type</label>
        <select name="type" class="form-input">
            <option value="Full-time">Full-time</option>
            <option value="Part-time">Part-time</option>
            <option value="Contract">Contractual</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label">Monthly Salary (₱)</label>
        <input type="number" name="salary" class="form-input" placeholder="0.00" value="{{ old('salary', $job->salary ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label">Application Deadline</label>
        <input type="date" name="deadline" class="form-input" value="{{ old('deadline', $job->deadline ?? '') }}">
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Key Requirements & Description</label>
        <textarea name="requirements" class="form-input" placeholder="Outline the responsibilities and qualifications...">{{ old('requirements', $job->requirements ?? '') }}</textarea>
    </div>
</div>