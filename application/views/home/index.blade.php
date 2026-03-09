@extends('layouts/template')

@section('contents')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-base-content">Management Overview</h1>
            <p class="text-base-content/70">Strategic Procurement & Financial KPIs</p>
        </div>
        <button class="btn btn-primary">Download Monthly Report</button>
    </div>

    <div class="stats shadow w-full mb-8">
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                    </path>
                </svg>
            </div>
            <div class="stat-title">Total Spend (MTD)</div>
            <div class="stat-value text-primary" id="kpi-spend">$0</div>
            <div class="stat-desc">↗︎ 12% more than last month</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
            </div>
            <div class="stat-title">Pending Approvals</div>
            <div class="stat-value text-secondary" id="kpi-approvals">0</div>
            <div class="stat-desc text-error">Requires immediate attention</div>
        </div>

        <div class="stat">
            <div class="stat-title">P2P Cycle Time</div>
            <div class="stat-value" id="kpi-cycle">0 Days</div>
            <div class="stat-desc">Average time from P/R to Payment</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">High-Value P/R Approvals (>$10k)</h2>
                <div class="overflow-x-auto mt-4">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Requestor</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="approval-list">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Spend by Department</h2>
                <div
                    class="w-full h-48 bg-base-200 rounded-box flex items-center justify-center mt-4 border-2 border-dashed border-base-300">
                    <span class="text-base-content/50">[Chart.js or ApexCharts Canvas Goes Here]</span>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/home.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
