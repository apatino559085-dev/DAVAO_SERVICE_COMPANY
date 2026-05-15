<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Hiring Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #064e3b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #022c22;
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .header p {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }
        
        .stats-container {
            width: 100%;
            margin-bottom: 40px;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats-table td {
            width: 33.33%;
            padding: 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .stats-value {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }
        .stats-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }

        .section-title {
            color: #0f172a;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 12px;
            text-align: left;
            font-size: 13px;
        }
        .data-table th {
            background-color: #0f172a;
            color: #fff;
            font-weight: bold;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .status-badge {
            font-weight: bold;
        }
        .text-green { color: #059669; }
        .text-blue { color: #2563eb; }
        .text-red { color: #dc2626; }
        .text-yellow { color: #d97706; }
        
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Davao Central Services Company</h1>
        <p>Comprehensive Hiring & Applicant Tracking Report</p>
        <p style="margin-top: 5px;">Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <div class="stats-container">
        <table class="stats-table">
            <tr>
                <td>
                    <div class="stats-value">{{ $stats['total_applications'] }}</div>
                    <div class="stats-label">Total Applications</div>
                </td>
                <td>
                    <div class="stats-value">{{ $stats['total_jobs'] }}</div>
                    <div class="stats-label">Active Job Posts</div>
                </td>
                <td>
                    <div class="stats-value">{{ $stats['total_users'] }}</div>
                    <div class="stats-label">Registered Users</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Application Status Overview</div>
    <table class="data-table">
        <tr>
            <th>Status Category</th>
            <th>Count</th>
            <th>Percentage</th>
        </tr>
        <tr>
            <td><span class="status-badge text-green">Approved / Hired</span></td>
            <td>{{ $stats['approved'] }}</td>
            <td>{{ $stats['total_applications'] > 0 ? round(($stats['approved'] / $stats['total_applications']) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-badge text-blue">For Interview</span></td>
            <td>{{ $stats['interview'] }}</td>
            <td>{{ $stats['total_applications'] > 0 ? round(($stats['interview'] / $stats['total_applications']) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-badge text-yellow">Pending Review</span></td>
            <td>{{ $stats['pending'] }}</td>
            <td>{{ $stats['total_applications'] > 0 ? round(($stats['pending'] / $stats['total_applications']) * 100, 1) : 0 }}%</td>
        </tr>
        <tr>
            <td><span class="status-badge text-red">Rejected</span></td>
            <td>{{ $stats['rejected'] }}</td>
            <td>{{ $stats['total_applications'] > 0 ? round(($stats['rejected'] / $stats['total_applications']) * 100, 1) : 0 }}%</td>
        </tr>
    </table>

    <div class="section-title">Job Postings Breakdown</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Department / Industry</th>
                <th>Type</th>
                <th>Applicants Received</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr>
                <td><strong>{{ $job->title }}</strong></td>
                <td>{{ $job->industry }}</td>
                <td>{{ $job->type }}</td>
                <td style="text-align: center;">{{ $job->applications_count }}</td>
            </tr>
            @endforeach
            @if($jobs->isEmpty())
            <tr>
                <td colspan="4" style="text-align: center; color: #64748b;">No active jobs found.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>This is a system-generated report from the DCS Hiring Management System.</p>
        <p>&copy; {{ date('Y') }} Davao Central Services Company. All rights reserved.</p>
    </div>

</body>
</html>
