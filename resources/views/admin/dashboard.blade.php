@extends('layouts.admin.app')

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.dashboard') }}"
        :items="[
            ['label' => __('dashboard.sidebar.dashboard')]
        ]"
    />
@endsection

@section('content_2')
    @php
        $summaryConfig = [
            'missions' => ['icon' => 'fa-bullseye', 'accent' => 'primary'],
            'domains' => ['icon' => 'fa-layer-group', 'accent' => 'success'],
            'services' => ['icon' => 'fa-briefcase', 'accent' => 'warning'],
            'destinations' => ['icon' => 'fa-location-dot', 'accent' => 'info'],
        ];
    @endphp

    <div class="dashboard-overview">
        <div class="row g-4">
            @foreach (['missions', 'domains', 'services', 'destinations'] as $key)
                @php
                    $card = $summaryCards[$key];
                    $config = $summaryConfig[$key];
                @endphp
                <div class="col-xxl-3 col-md-6">
                    <article class="card stretch stretch-full dashboard-stat-card dashboard-stat-card--{{ $config['accent'] }}">
                        <div class="card-body">
                            <div class="dashboard-stat-card__head">
                                <div class="dashboard-stat-card__icon">
                                    <i class="fa-solid {{ $config['icon'] }}"></i>
                                </div>
                                <div>
                                    <p class="dashboard-stat-card__label">{{ __("dashboard.overview.cards.{$key}.title") }}</p>
                                    <h3 class="dashboard-stat-card__value">{{ $card['total'] }}/{{ $card['interested'] }}</h3>
                                </div>
                            </div>
                            <p class="dashboard-stat-card__meta">
                                {{ __('dashboard.overview.cards.meta', ['total' => $card['total'], 'interested' => $card['interested']]) }}
                            </p>
                            <div class="progress mt-3 ht-6">
                                <div
                                    class="progress-bar bg-{{ $config['accent'] }}"
                                    role="progressbar"
                                    style="width: {{ $card['ratio'] }}%"
                                    aria-valuenow="{{ $card['ratio'] }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="row g-4 mt-1">
            <div class="col-xxl-8">
                <div class="card stretch stretch-full dashboard-panel">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title">{{ __('dashboard.overview.charts.services.title') }}</h5>
                            <p class="card-subtitle">{{ __('dashboard.overview.charts.services.subtitle') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="services-interest-chart" class="dashboard-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="card stretch stretch-full dashboard-panel">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title">{{ __('dashboard.overview.best_testimonies.title') }}</h5>
                            <p class="card-subtitle">{{ __('dashboard.overview.best_testimonies.subtitle') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dashboard-list">
                            @forelse ($bestTestimonies as $testimony)
                                <div class="dashboard-list__item">
                                    <div class="dashboard-list__top">
                                        <strong>{{ trim($testimony->name . ' ' . $testimony->surname) }}</strong>
                                        <span class="dashboard-rating">{{ str_repeat('★', max(1, min(5, (int) $testimony->note))) }}</span>
                                    </div>
                                    <p>{{ \Illuminate\Support\Str::limit($testimony->message, 110) }}</p>
                                </div>
                            @empty
                                <p class="dashboard-empty">{{ __('dashboard.overview.empty.best_testimonies') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            @foreach (['missions', 'domains', 'destinations'] as $key)
                <div class="col-xl-4">
                    <div class="card stretch stretch-full dashboard-panel">
                        <div class="card-header">
                            <div>
                                <h5 class="card-title">{{ __("dashboard.overview.charts.{$key}.title") }}</h5>
                                <p class="card-subtitle">{{ __("dashboard.overview.charts.{$key}.subtitle") }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="{{ $key }}-interest-chart" class="dashboard-chart dashboard-chart--compact"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4 mt-1">
            <div class="col-xxl-4">
                <div class="card stretch stretch-full dashboard-panel">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title">{{ __('dashboard.overview.worst_testimonies.title') }}</h5>
                            <p class="card-subtitle">{{ __('dashboard.overview.worst_testimonies.subtitle') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dashboard-list">
                            @forelse ($worstTestimonies as $testimony)
                                <div class="dashboard-list__item dashboard-list__item--alert">
                                    <div class="dashboard-list__top">
                                        <strong>{{ trim($testimony->name . ' ' . $testimony->surname) }}</strong>
                                        <span class="dashboard-rating dashboard-rating--low">{{ str_repeat('★', max(1, min(5, (int) $testimony->note))) }}</span>
                                    </div>
                                    <p>{{ \Illuminate\Support\Str::limit($testimony->message, 110) }}</p>
                                </div>
                            @empty
                                <p class="dashboard-empty">{{ __('dashboard.overview.empty.worst_testimonies') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="{{ $isSuperAdmin ? 'col-xxl-4' : 'col-xxl-8' }}">
                <div class="card stretch stretch-full dashboard-panel">
                    <div class="card-header">
                        <div>
                            <h5 class="card-title">{{ __('dashboard.overview.most_solicited.title') }}</h5>
                            <p class="card-subtitle">{{ __('dashboard.overview.most_solicited.subtitle') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dashboard-list">
                            @forelse ($mostSolicited as $item)
                                <div class="dashboard-list__item">
                                    <div class="dashboard-list__top">
                                        <strong>{{ $item['label'] }}</strong>
                                        <span class="dashboard-badge">{{ __('dashboard.overview.most_solicited.count', ['count' => $item['count']]) }}</span>
                                    </div>
                                    <p>{{ __("dashboard.overview.cards.{$item['type']}.title") }}</p>
                                </div>
                            @empty
                                <p class="dashboard-empty">{{ __('dashboard.overview.empty.most_solicited') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            @if ($isSuperAdmin)
                <div class="col-xxl-4">
                    <div class="card stretch stretch-full dashboard-panel">
                        <div class="card-header">
                            <div>
                                <h5 class="card-title">{{ __('dashboard.overview.user_activity.title') }}</h5>
                                <p class="card-subtitle">{{ __('dashboard.overview.user_activity.subtitle') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-list">
                                @forelse ($userActivity as $item)
                                    <div class="dashboard-list__item">
                                        <div class="dashboard-list__top">
                                            <strong>{{ $item['name'] }}</strong>
                                            <span class="dashboard-badge">{{ $item['percentage'] }}%</span>
                                        </div>
                                        <p>{{ $item['role'] }}</p>
                                        <div class="progress mt-2 ht-6">
                                            <div
                                                class="progress-bar bg-dark"
                                                role="progressbar"
                                                style="width: {{ $item['percentage'] }}%"
                                                aria-valuenow="{{ $item['percentage'] }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                            ></div>
                                        </div>
                                        <small class="dashboard-breakdown">
                                            {{ __('dashboard.overview.user_activity.breakdown', [
                                                'missions' => $item['missions'],
                                                'domains' => $item['domains'],
                                                'services' => $item['services'],
                                                'destinations' => $item['destinations'],
                                            ]) }}
                                        </small>
                                    </div>
                                @empty
                                    <p class="dashboard-empty">{{ __('dashboard.overview.empty.user_activity') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('css_2')
    <style>
        .dashboard-overview .card-subtitle {
            margin: .35rem 0 0;
            color: #7d8894;
            font-size: .92rem;
        }

        .dashboard-panel,
        .dashboard-stat-card {
            border: 0;
            box-shadow: 0 18px 45px rgba(15, 35, 52, .08);
        }

        .dashboard-stat-card__head {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dashboard-stat-card__icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
        }

        .dashboard-stat-card--primary .dashboard-stat-card__icon { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
        .dashboard-stat-card--success .dashboard-stat-card__icon { background: linear-gradient(135deg, #10b981, #047857); }
        .dashboard-stat-card--warning .dashboard-stat-card__icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .dashboard-stat-card--info .dashboard-stat-card__icon { background: linear-gradient(135deg, #06b6d4, #0e7490); }

        .dashboard-stat-card__label {
            margin: 0;
            color: #7d8894;
            font-size: .92rem;
        }

        .dashboard-stat-card__value {
            margin: .2rem 0 0;
            font-size: 1.9rem;
            line-height: 1;
        }

        .dashboard-stat-card__meta {
            margin: 1rem 0 0;
            color: #55616d;
            font-size: .93rem;
        }

        .dashboard-chart {
            min-height: 360px;
        }

        .dashboard-chart--compact {
            min-height: 320px;
        }

        .dashboard-list {
            display: grid;
            gap: 1rem;
        }

        .dashboard-list__item {
            padding: 1rem;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
        }

        .dashboard-list__item--alert {
            background: #fff7f7;
            border-color: #fde3e3;
        }

        .dashboard-list__top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: .45rem;
        }

        .dashboard-list__item p,
        .dashboard-breakdown {
            margin: 0;
            color: #687684;
        }

        .dashboard-empty {
            margin: 0;
            color: #7d8894;
        }

        .dashboard-rating {
            color: #f59e0b;
            font-size: .95rem;
            letter-spacing: .08em;
        }

        .dashboard-rating--low {
            color: #ef4444;
        }

        .dashboard-badge {
            padding: .35rem .7rem;
            border-radius: 999px;
            background: #e8f1ff;
            color: #1d4ed8;
            font-size: .78rem;
            font-weight: 700;
        }
    </style>
@endsection

@section('js_2')
    <script>
        const dashboardCharts = @json($chartSeries);
        const chartTexts = @json([
            'noData' => __('dashboard.overview.chart_no_data'),
            'interest' => __('dashboard.overview.interest_label'),
        ]);

        function mountDashboardBarChart(elementId, labels, values, color) {
            const node = document.querySelector(elementId);

            if (!node) {
                return;
            }

            const hasData = values.some((value) => value > 0);

            const chart = new ApexCharts(node, {
                chart: {
                    type: 'bar',
                    height: '100%',
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                series: [{
                    name: chartTexts.interest,
                    data: hasData ? values : [0]
                }],
                colors: [color],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 8,
                        distributed: false,
                        barHeight: '55%'
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: hasData ? labels : [chartTexts.noData],
                    labels: { style: { colors: '#687684' } }
                },
                yaxis: {
                    labels: { style: { colors: '#687684' } }
                },
                grid: {
                    borderColor: '#edf2f7',
                    strokeDashArray: 4
                },
                tooltip: {
                    y: {
                        formatter: (value) => `${value} ${chartTexts.interest.toLowerCase()}`
                    }
                },
                noData: {
                    text: chartTexts.noData
                }
            });

            chart.render();
        }

        document.addEventListener('DOMContentLoaded', function () {
            mountDashboardBarChart('#services-interest-chart', dashboardCharts.services.labels, dashboardCharts.services.values, '#f59e0b');
            mountDashboardBarChart('#missions-interest-chart', dashboardCharts.missions.labels, dashboardCharts.missions.values, '#2563eb');
            mountDashboardBarChart('#domains-interest-chart', dashboardCharts.domains.labels, dashboardCharts.domains.values, '#10b981');
            mountDashboardBarChart('#destinations-interest-chart', dashboardCharts.destinations.labels, dashboardCharts.destinations.values, '#06b6d4');
        });
    </script>
@endsection
