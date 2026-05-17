@extends('layouts.app')
@section('title', 'User Management')
@section('content')

    <style>
        :root {
            --dash-bg: #f3f4f6;
        }

        body {
            background-color: var(--dash-bg) !important;
        }

        .bento-card {
            background: white;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .premium-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
        }

        .header-title {
            font-size: 36px;
            font-weight: 900;
            letter-spacing: -1.5px;
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.1;
        }

        .header-subtitle {
            font-size: 15px;
            color: #64748b;
            font-weight: 500;
            margin-top: 8px;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .modern-table th {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 20px 12px;
            border-bottom: 2px solid #f1f5f9;
            text-align: left;
        }

        .modern-table td {
            background: white;
            padding: 20px;
            transition: all 0.2s;
        }

        .modern-table tr td:first-child {
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
        }

        .modern-table tr td:last-child {
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .modern-table tbody tr {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .modern-table tbody tr:hover td {
            background: #f8fafc;
        }

        .role-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin {
            background: #fee2e2;
            color: #ef4444;
        }

        .role-hr {
            background: #dbeafe;
            color: #3b82f6;
        }

        .role-applicant {
            background: #f1f5f9;
            color: #475569;
        }
    </style>



    <div class="bento-card">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Account Details</th>
                    <th>Role</th>
                    <th>Joined Date</th>
                    <th style="text-align: right;">Access Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div
                                    style="width: 44px; height: 44px; border-radius: 12px; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #0f172a; border: 1px solid #e2e8f0; font-size: 18px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-size: 15px; font-weight: 800; color: #0f172a;">{{ $user->name }}</div>
                                    <div style="font-size: 13px; color: #94a3b8; font-weight: 500;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge role-{{ strtolower($user->role) }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 14px; color: #64748b; font-weight: 600;">
                                {{ $user->created_at->format('M d, Y') }}</div>
                            <div style="font-size: 12px; color: #cbd5e1; font-weight: 500;">
                                {{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                @csrf @method('PATCH')
                                <button
                                    style="border: none; background: {{ $user->is_active ? '#ecfdf5' : '#fef2f2' }}; color: {{ $user->is_active ? '#059669' : '#dc2626' }}; padding: 10px 20px; border-radius: 12px; font-size: 12px; font-weight: 800; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);"
                                    onmouseover="this.style.transform='translateY(-1px)'"
                                    onmouseout="this.style.transform='translateY(0)'">
                                    {{ $user->is_active ? 'Active Account' : 'Disabled' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 32px;">
            {{ $users->links() }}
        </div>
    </div>

@endsection