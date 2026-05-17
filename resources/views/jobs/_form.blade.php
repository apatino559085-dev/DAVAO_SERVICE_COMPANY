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
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-input" placeholder="e.g. Davao City, PH" value="{{ old('location', $job->location ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label">Department / Industry</label>
        <select name="industry" class="form-input" required>
            <option value="Technology" {{ (old('industry', $job->industry ?? '') == 'Technology') ? 'selected' : '' }}>Technology</option>
            <option value="Administration" {{ (old('industry', $job->industry ?? '') == 'Administration') ? 'selected' : '' }}>Administration</option>
            <option value="Security" {{ (old('industry', $job->industry ?? '') == 'Security') ? 'selected' : '' }}>Security & Safety</option>
            <option value="Maintenance" {{ (old('industry', $job->industry ?? '') == 'Maintenance') ? 'selected' : '' }}>Facility Maintenance</option>
            <option value="Other" {{ (old('industry', $job->industry ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label">Employment Type</label>
        <select name="type" class="form-input" required>
            <option value="full-time" {{ (old('type', $job->type ?? '') == 'full-time') ? 'selected' : '' }}>Full-time</option>
            <option value="part-time" {{ (old('type', $job->type ?? '') == 'part-time') ? 'selected' : '' }}>Part-time</option>
            <option value="remote" {{ (old('type', $job->type ?? '') == 'remote') ? 'selected' : '' }}>Remote</option>
            <option value="contract" {{ (old('type', $job->type ?? '') == 'contract') ? 'selected' : '' }}>Contractual</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label">Monthly Salary (₱)</label>
        <input type="text" name="salary" class="form-input" placeholder="e.g. 25,000 - 30,000" value="{{ old('salary', $job->salary ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label">Application Deadline</label>
        <input type="date" name="expires_at" class="form-input" value="{{ old('expires_at', (isset($job->expires_at) ? $job->expires_at->format('Y-m-d') : '')) }}">
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Job Description</label>
        <textarea name="description" class="form-input" placeholder="Describe the core responsibilities..." required>{{ old('description', $job->description ?? '') }}</textarea>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Key Requirements (Optional)</label>
        <textarea name="requirements" class="form-input" placeholder="Outline the qualifications and skills...">{{ old('requirements', $job->requirements ?? '') }}</textarea>
    </div>
</div>