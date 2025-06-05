<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UAUT Risk Management Report</title>
    <style>
        @page {
            margin: 40px;
        }
        body {
            font-family: 'Helvetica Neue', 'Arial', sans-serif;
            font-size: 12pt;
            color: #333333;
            line-height: 1.6;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        /* Cover Page */
        .cover-page {
            text-align: center;
            margin-top: 100px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .cover-page h1 {
            color: #1a3c34;
            font-size: 36pt;
            margin: 0;
        }
        .cover-page p {
            color: #4a6f68;
            font-size: 16pt;
            margin: 10px 0;
        }
        .cover-page .logo {
            width: 150px;
            margin-bottom: 20px;
        }
        /* Header */
        .header {
            border-bottom: 3px solid #1a3c34;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .header h2 {
            color: #1a3c34;
            font-size: 24pt;
            margin: 0;
        }
        /* Sections */
        h3 {
            color: #1a3c34;
            font-size: 18pt;
            border-left: 5px solid #4a6f68;
            padding-left: 10px;
            margin: 30px 0 15px;
        }
        /* Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .metric-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .metric-card strong {
            display: block;
            font-size: 12pt;
            color: #333333;
        }
        .metric-card span {
            font-size: 18pt;
            font-weight: bold;
        }
        /* Charts */
        .chart-container {
            margin: 20px 0;
            text-align: center;
        }
        .chart-container img {
            max-width: 600px;
            width: 100%;
        }
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
            font-size: 11pt;
        }
        th {
            background: #1a3c34;
            color: #ffffff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f8fafc;
        }
        /* Status Colors */
        .status-resolved { color: #2f855a; }
        .status-pending { color: #d69e2e; }
        .status-in-progress { color: #3182ce; }
        .status-unresolved { color: #c53030; }
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10pt;
            color: #666666;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            position: running(footer);
        }
        @page {
            @bottom-center {
                content: element(footer);
            }
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Cover Page -->
    <div class="cover-page">
        {{-- <img src="{{ url('/img/uaut-logo.jpg') }}" alt="UAUT Logo" class="logo"> --}}
        <h1>UAUT Risk Management Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
        <p>Prepared for: Admin Dashboard</p>
    </div>

    <div class="page-break"></div>

    <!-- Table of Contents -->
    <div class="container">
        <div class="header">
            <h2>Table of Contents</h2>
        </div>
        <ul style="list-style: none; padding: 0;">
            <li><a href="#overview">1. Overview</a></li>
            <li><a href="#metrics">2. Risk Metrics</a></li>
            <li><a href="#details">3. Risk Details</a></li>
        </ul>
    </div>

    <div class="page-break"></div>

    <!-- Overview -->
    <div class="container" id="overview">
        <div class="header">
            <h2>Risk Management Overview</h2>
        </div>
        <p>
            This report provides a comprehensive overview of risks reported within the UAUT Risk Management System as of {{ now()->format('F d, Y') }}. 
            It includes key metrics, visualizations, and detailed risk information to support strategic decision-making.
        </p>
    </div>

    <!-- Metrics -->
    <div class="container" id="metrics">
        <h3>Risk Metrics</h3>
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

    <div class="page-break"></div>

    <!-- Risk Details -->
    <div class="container" id="details">
        <h3>Risk Details</h3>
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
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>UAUT Risk Management System | Generated on {{ now()->format('F d, Y H:i') }}</p>
        <p>Confidential - For Internal Use Only</p>
    </div>
</body>
</html>
