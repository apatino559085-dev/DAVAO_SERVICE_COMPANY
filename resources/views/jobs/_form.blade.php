<div style="display: flex; flex-direction: column; gap: 20px;">
    <div>
        <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Job Title</label>
        <input type="text" name="title" value="{{ old('title', $job->title ?? '') }}"
               style="width: 100%; border: 2px solid #eef2f7; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #0f172a; background: #fafbfc; outline: none; font-family: inherit;"
               placeholder="e.g. Frontend Developer" required>
        @error('title')<p style="color: #ef4444; font-size: 12px; font-weight: 700; margin-top: 6px;">{{ $message }}</p>@enderror
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Company</label>
            <input type="text" name="company" value="{{ old('company', $job->company ?? '') }}"
                   style="width: 100%; border: 2px solid #eef2f7; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #0f172a; background: #fafbfc; outline: none; font-family: inherit;" required>
        </div>
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Location</label>
            <input type="text" name="location" value="{{ old('location', $job->location ?? '') }}"
                   style="width: 100%; border: 2px solid #eef2f7; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #0f172a; background: #fafbfc; outline: none; font-family: inherit;" required>
        </div>
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Salary <span style="color: #94a3b8;">(optional)</span></label>
            <input type="text" name="salary" value="{{ old('salary', $job->salary ?? '') }}"
                   style="width: 100%; border: 2px solid #eef2f7; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #0f172a; background: #fafbfc; outline: none; font-family: inherit;"
                   placeholder="e.g. ₱25,000/month">
        </div>
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Job Type</label>
            <select name="type" style="width: 100%; border: 2px solid #eef2f7; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #0f172a; background: #fafbfc; outline: none; font-family: inherit;">
                @foreach(['full-time','part-time','remote','contract'] as $type)
                <option value="{{ $type }}" {{ old('type', $job->type ?? 'full-time') === $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Job Description</label>
        <textarea name="description" rows="6"
                  style="width: 100%; border: 2px solid #eef2f7; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #0f172a; background: #fafbfc; outline: none; resize: vertical; font-family: inherit;"
                  placeholder="Describe the role, requirements, and responsibilities..." required>{{ old('description', $job->description ?? '') }}</textarea>
        @error('description')<p style="color: #ef4444; font-size: 12px; font-weight: 700; margin-top: 6px;">{{ $message }}</p>@enderror
    </div>
</div>