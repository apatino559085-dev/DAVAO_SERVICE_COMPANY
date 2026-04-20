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
    
    <div>
        <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Company Logo <span style="color: #94a3b8;">(optional, max 2MB)</span></label>
        <input type="file" name="logo" accept="image/*"
               style="width: 100%; border: 2px dashed #cbd5e1; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #475569; outline: none; transition: all 0.2s; cursor: pointer;">
        @error('logo')<p style="color: #ef4444; font-size: 12px; font-weight: 700; margin-top: 6px;">{{ $message }}</p>@enderror
        @if(isset($job) && $job->logo_path)
            <div style="margin-top: 10px; font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 8px;">
                <img src="{{ asset('storage/' . $job->logo_path) }}" alt="Logo" style="width: 32px; height: 32px; border-radius: 8px; object-fit: contain; border: 1px solid #e2e8f0;">
                Current Logo
            </div>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
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
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px;">Industry</label>
            <select name="industry" id="industrySelect" style="width: 100%; border: 2px solid #eef2f7; border-radius: 14px; padding: 13px 18px; font-size: 15px; font-weight: 500; color: #0f172a; background: #fafbfc; outline: none; font-family: inherit; cursor: pointer;" required>
                <option value="" disabled {{ old('industry', $job->industry ?? '') === '' ? 'selected' : '' }}>Select Industry...</option>
                @foreach(['Technology','Healthcare','Finance','Education','Retail','Manufacturing','Hospitality','Food & Beverage','Logistics'] as $ind)
                <option value="{{ $ind }}" {{ old('industry', $job->industry ?? '') === $ind ? 'selected' : '' }}>{{ $ind }}</option>
                @endforeach
                
                @if(isset($job) && $job->industry && !in_array($job->industry, ['Technology','Healthcare','Finance','Education','Retail','Manufacturing','Hospitality','Food & Beverage','Logistics']))
                    <option value="{{ $job->industry }}" selected>{{ $job->industry }}</option>
                @endif
                
                <option value="Other" style="font-weight: 800; color: #6366f1;">+ Other (Add Custom...)</option>
            </select>
            @error('industry')<p style="color: #ef4444; font-size: 12px; font-weight: 700; margin-top: 6px;">{{ $message }}</p>@enderror
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

<!-- Custom Industry Modal -->
<div id="customIndustryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15,23,42,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; width: 100%; max-width: 400px; padding: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); transform: translateY(-20px); animation: modalIn 0.3s forwards;">
        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Add Custom Industry</h3>
        <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Enter the name of your specific industry below.</p>
        
        <input type="text" id="customIndustryInput" placeholder="e.g. Agriculture, Media..."
               style="width: 100%; border: 2px solid #eef2f7; border-radius: 12px; padding: 12px 16px; font-size: 15px; font-weight: 500; color: #0f172a; outline: none; margin-bottom: 24px; font-family: inherit;"
               onfocus="this.style.borderColor='#6366f1';" onblur="this.style.borderColor='#eef2f7';">
               
        <div style="display: flex; justify-content: flex-end; gap: 12px;">
            <button type="button" onclick="closeCustomIndustryModal()" style="background: white; border: 1px solid #e2e8f0; color: #64748b; padding: 10px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">Cancel</button>
            <button type="button" onclick="saveCustomIndustry()" style="background: #6366f1; border: none; color: white; padding: 10px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(99,102,241,0.2);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Add Industry</button>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    to { transform: translateY(0); }
}
</style>

<script>
    let previousIndustryValue = document.getElementById('industrySelect') ? document.getElementById('industrySelect').value : '';

    const indSelect = document.getElementById('industrySelect');
    if(indSelect) {
        indSelect.addEventListener('change', function(e) {
            if(e.target.value === 'Other') {
                document.getElementById('customIndustryModal').style.display = 'flex';
                document.getElementById('customIndustryInput').focus();
            } else {
                previousIndustryValue = e.target.value;
            }
        });
    }

    function closeCustomIndustryModal() {
        document.getElementById('customIndustryModal').style.display = 'none';
        document.getElementById('customIndustryInput').value = '';
        // Revert selection to previous
        document.getElementById('industrySelect').value = previousIndustryValue;
    }

    function saveCustomIndustry() {
        const inputVal = document.getElementById('customIndustryInput').value.trim();
        if(!inputVal) {
            alert('Please enter an industry name or click cancel.');
            return;
        }

        const select = document.getElementById('industrySelect');
        // Check if option already exists
        let exists = false;
        for(let i=0; i<select.options.length; i++){
            if(select.options[i].value.toLowerCase() === inputVal.toLowerCase()) {
                select.value = select.options[i].value;
                exists = true;
                break;
            }
        }

        if(!exists) {
            // Create new option
            const newOption = document.createElement('option');
            newOption.value = inputVal;
            newOption.text = inputVal;
            // Insert right before 'Other'
            select.insertBefore(newOption, select.options[select.options.length - 1]);
            select.value = inputVal;
        }

        previousIndustryValue = select.value;
        document.getElementById('customIndustryModal').style.display = 'none';
        document.getElementById('customIndustryInput').value = '';
    }
</script>