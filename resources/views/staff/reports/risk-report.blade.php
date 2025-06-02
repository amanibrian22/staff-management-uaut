<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UAUT Risk Management Report</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
            color: #1a1c23;
            margin: 0;
            padding: 40px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2e7d32;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2e7d32;
            font-size: 24px;
            margin: 0;
        }
        .header p {
            color: #1976d2;
            font-size: 14px;
            margin: 5px 0;
        }
        h2 {
            color: #1976d2;
            font-size: 18px;
            border-left: 4px solid #2e7d32;
            padding-left: 10px;
            margin: 20px 0 10px;
        }
        .metrics {
            margin-bottom: 30px;
        }
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .metric-card {
            background: #f5f7fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .metric-card strong {
            display: block;
            font-size: 14px;
            color: #1a1c23;
        }
        .metric-card span {
            font-size: 20px;
            color: #2e7d32;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background: #1976d2;
            color: #ffffff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f5f7fa;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .status-resolved { color: #4caf50; }
        .status-pending { color: #ff9800; }
        .status-in-progress { color: #0288d1; }
        .status-unresolved { color: #f44336; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UAUT Risk Management Report</h1>
            <p>Generated on {{ now()->format('F d, Y') }}</p>
            <p>Prepared for: Admin Dashboard</p>
        </div>

        <div class="metrics">
            <h2>Risk Metrics</h2>
            <div class="metrics-grid">
                <div class="metric-card">
                    <strong>Total Risks</strong>
                    <span>{{ $metrics['total_risks'] }}</span>
                </div>
                <div class="metric-card">
                    <strong>Resolved Risks</strong>
                    <span class="status-resolved">{{ $metrics['resolved_risks'] }}</span>
                </div>
                <div class="metric-card">
                    <strong>Pending Risks</strong>
                    <span class="status-pending">{{ $metrics['pending_risks'] }}</span>
                </div>
                <div class="metric-card">
                    <strong>In Progress</strong>
                    <span class="status-in-progress">{{ $metrics['in_progress_risks'] }}</span>
                </div>
                <div class="metric-card">
                    <strong>Unresolved Risks</strong>
                    <span class="status-unresolved">{{ $metrics['unresolved_risks'] }}</span>
                </div>
            </div>
        </div>

        <h2>Risk Details</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>Urgency</th>
                    <th>Status</th>
                    <th>Reported By</th>
                    <th>Response</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($risks as $risk)
                    <tr>
                        <td>{{ $risk->id }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($risk->description, 100) }}</td>
                        <td>{{ ucfirst($risk->type) }}</td>
                        <td>{{ ucfirst($risk->urgency) }}</td>
                        <td class="status-{{ str_replace('_', '-', $risk->status) }}">{{ ucfirst(str_replace('_', ' ', $risk->status)) }}</td>
                        <td>{{ $risk->reporter->name ?? 'N/A' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($risk->response ?? 'N/A', 100) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>UAUT Risk Management System | Generated on {{ now()->format('F d, Y H:i') }}</p>
            <p>Confidential - For Internal Use Only</p>
        </div>
    </div>
</body>
</html>
