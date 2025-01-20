@php
    // Prepare data for the chart
    $labels = [];
    $series = [];
    foreach ($materielstype as $item) {
        $labels[] = $item->type;
        $series[] = $item->count;
    }

    // If no data is available, provide default values to avoid errors
    if (empty($labels)) {
        $labels = ['No Data'];
        $series = [1]; // Provide a single value to prevent chart render errors
    }

    // Prepare data for the chart
    $labelsetat = [];
    $seriesetat = [];
    foreach ($materielsetat as $item) {
        $labelsetat[] = $item->etat;
        $seriesetat[] = $item->count;
    }

    // If no data is available, provide default values to avoid errors
    if (empty($labelsetat)) {
        $labelsetat = ['No Data'];
        $seriesetat = [1]; // Provide a single value to prevent chart render errors
    }

@endphp
@extends('layouts.index')
@section('csslink')
    <style>
        /* Ajoutez ces styles dans votre fichier CSS */
        .quote-container {
            background-color: #f9fafb;
            border-left: 4px solid #3b82f6;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .quote-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .quote-text {
            font-size: 1.25rem;
            color: #374151;
            font-style: italic;
        }

        .quote-author {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }
    </style>
@endsection
@section('title', 'Tableau de bord')
@section('content')
    <main class="h-full overflow-y-auto  max-w-full  pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        @if (session()->has('just_logged_in') && session('just_logged_in') === true)
            <div class="mt-8 text-center px-4">
                @php
                    $quote = strip_tags(\Illuminate\Foundation\Inspiring::quote());
                    // Split the quote into text and author
                    $parts = explode('-', $quote);
                    $quoteText = trim($parts[0]);
                    $author = isset($parts[1]) ? trim($parts[1]) : '';
                    // Remove the session flag after displaying the quote
                    session()->forget('just_logged_in');
                @endphp
                <div id="quote-container"
                    class="animate-fade-in-up bg-white p-6 rounded-lg shadow-lg border-l-4 border-blue-500">
                    <p class="text-gray-700 italic text-lg">“{{ $quoteText }}”</p>
                    @if ($author)
                        <footer class="text-gray-500 text-sm mt-2">— {{ $author }}</footer>
                    @endif
                </div>
                <script>
                    setTimeout(function() {
                        const quoteContainer = document.getElementById('quote-container');
                        quoteContainer.style.opacity = '0';
                        quoteContainer.style.transition = 'opacity 0.5s';
                        setTimeout(function() {
                            quoteContainer.remove();
                        }, 500);
                    }, 5000);
                </script>
            </div>
        @endif
        <div class="p-5">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="sm:flex block justify-between mb-5">
                                <h4 class="text-gray-600 text-lg font-semibold sm:mb-0 mb-2">Matériaux par état</h4>
                                <select id="month-filter"
                                    class="border-gray-400 text-gray-500 rounded-md text-sm border-[1px] focus:ring-0 sm:w-auto w-full">
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ date('n') == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($month)->locale('fr')->monthName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-gray-600 text-lg font-semibold mb-5">Matériaux par type</h4>
                            <div class="flex gap-6 items-center justify-between">
                                <div class="flex flex-col gap-4">
                                    <h5 class="text-base font-semibold text-gray-600">Matériaux totaux :
                                        <?= array_sum($series) ?></h5>
                                </div>
                                <div class="flex items-center">
                                    <div id="materieltype"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-gray-600 text-lg font-semibold mb-5">Matériaux par état</h4>
                            <div class="flex gap-6 items-center justify-between">
                                <div class="flex flex-col gap-4">
                                    <h5 class="text-base font-semibold text-gray-600">Matériaux totaux :
                                        <?= array_sum($seriesetat) ?></h5>
                                </div>
                                <div class="flex items-center">
                                    <div id="materieletat"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="flex gap-6 items-center justify-between">
                                <div class="flex flex-col gap-5">
                                    <h4 class="text-gray-600 text-lg font-semibold">Monthly Earnings</h4>
                                    <div class="flex flex-col gap-[18px]">
                                        <h3 class="text-[21px] font-semibold text-gray-600">$6,820</h3>
                                        <div class="flex items-center gap-1">
                                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-red-400">
                                                <i class="ti ti-arrow-down-right text-red-500"></i>
                                            </span>
                                            <p class="text-gray-600 text-sm font-normal ">+9%</p>
                                            <p class="text-gray-500 text-sm font-normal">last year</p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="w-11 h-11 flex justify-center items-center rounded-full bg-cyan-500 text-white self-start">
                                    <i class="ti ti-currency-dollar text-xl"></i>
                                </div>

                            </div>
                        </div>
                        <div id="earning"></div>
                    </div> --}}
                </div>
            </div>
            <div class="mt-2 grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-gray-600 text-lg font-semibold mb-6 flex justify-between items-center">
                            <span>Derniers Mouvements</span>
                            <a href="{{ route('dashboard.Movements') }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye ml-2"></i>
                            </a>
                        </h4>
                        <ul class="timeline-widget relative">
                            <!-- Entries (Réceptionné) -->
                            <h5 class="text-sm font-semibold text-gray-800 py-2">Réceptionné, Colis fermé</h5>
                            @forelse($recentMovements['entries'] as $entry)
                                <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                                    <div class="timeline-time text-gray-600 text-sm min-w-[90px] py-[6px] pr-4 text-end">
                                        {{ \Carbon\Carbon::parse($entry->date_inscription)->format('d/m/Y') }}
                                    </div>
                                    <div class="timeline-badge-wrap flex flex-col items-center">
                                        <div
                                            class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-blue-600 my-[10px]">
                                        </div>
                                        <div class="timeline-badge-border block h-full w-[1px] bg-gray-100"></div>
                                    </div>
                                    <div class="timeline-desc py-[6px] px-4">
                                        <p class="text-gray-600 text-sm font-normal">
                                            <a href="{{ route('materiels.show', $entry->id) }}">{{ $entry->num_inventaire }}
                                                | {{ $entry->designation }}</a>
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <p>Aucune donnée trouvée</p>
                            @endforelse
                            <hr>
                            <!-- Outputs (Affecté, En mouvement, Réformé) -->
                            <h5 class="text-sm font-semibold text-gray-800 py-2">Affecté, En mouvement, Réformé</h5>
                            @forelse($recentMovements['outputs'] as $output)
                                <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                                    <div class="timeline-time text-gray-600 text-sm min-w-[90px] py-[6px] pr-4 text-end">
                                        {{ \Carbon\Carbon::parse($output->date_inscription)->format('d/m/Y') }}

                                    </div>
                                    <div class="timeline-badge-wrap flex flex-col items-center">
                                        <div
                                            class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-blue-600 my-[10px]">
                                        </div>
                                        <div class="timeline-badge-border block h-full w-[1px] bg-gray-100"></div>
                                    </div>
                                    <div class="timeline-desc py-[6px] px-4">
                                        <p class="text-gray-600 text-sm font-normal">
                                            <a href="{{ route('materiels.show', $output->id) }}">{{ $output->num_inventaire }}
                                                | {{ $output->designation }}</a>
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <p>Aucune donnée trouvée</p>
                            @endforelse
                            <hr>
                        </ul>
                    </div>
                </div>
                @can('view-activity-logs')
                    <div class="col-span-2">
                        <div class="card h-full">
                            <div class="card-body">
                                <h4 class="text-gray-600 text-lg font-semibold mb-6">Journal des Activités</h4>
                                <div class="relative overflow-x-auto">

                                    <table id="table" class="text-left w-full whitespace-nowrap text-sm">
                                        <thead class="text-gray-700">
                                            <tr class="font-semibold text-gray-600">
                                                <th scope="col" class="p-4 text-center">Id</th>
                                                <th scope="col" class="p-4 text-center">Fait par</th>
                                                <th scope="col" class="p-4 text-center">Action</th>
                                                <th scope="col" class="p-4 text-center">Table</th>
                                                <th scope="col" class="p-4 text-center">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logs as $log)
                                                <tr>
                                                    <td class="p-4 font-semibold text-gray-600 text-center">
                                                        {{ $log['numero_inventaire'] ?? $log['id'] }}
                                                    </td>
                                                    <td class="p-4 text-center">
                                                        <div class="flex flex-col gap-1">
                                                            <h3 class="font-semibold text-gray-600">{{ $log['user'] }}</h3>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 text-center">
                                                        @if (
                                                            $log['action'] == 'export' &&
                                                                $log['record_id'] == '0' &&
                                                                ($log['table_name'] == 'bon_decharges' || $log['table_name'] == 'avis__mvts'))
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-red-500">Exporter
                                                                PDF</span>
                                                        @elseif ($log['action'] == 'export' && $log['record_id'] == '0')
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-teal-500">Exporter
                                                                Excel</span>
                                                        @elseif ($log['action'] == 'export' && $log['record'] == '1')
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-teal-500">Exporter
                                                                PDF</span>
                                                        @elseif ($log['action'] == 'update')
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-blue-600">Modifier</span>
                                                        @elseif ($log['action'] == 'create')
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold bg-cyan-500 text-white">Ajouter</span>
                                                        @elseif ($log['action'] == 'import')
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-blue-600">Importer</span>
                                                        @elseif ($log['action'] == 'delete')
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-red-500">Supprimer</span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-red-500">Exporter
                                                                PDF</span>
                                                        @endif
                                                    </td>
                                                    <td class="p-4 text-center">
                                                        <span class="font-normal text-gray-500">
                                                            @switch($log['table_name'])
                                                                @case('services')
                                                                    Service
                                                                @break

                                                                @case('users')
                                                                    Utilisateur
                                                                @break

                                                                @case('materials')
                                                                    Matériel
                                                                @break

                                                                @case('feuille_reformes')
                                                                    Feuille de réforme
                                                                @break

                                                                @case('avis__mvts')
                                                                    Avis de mouvement
                                                                @break

                                                                @case('bon_decharges')
                                                                    Bon de décharge
                                                                @break

                                                                @default
                                                                    {{ $log['table_name'] }}
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="p-4 text-center">
                                                        <span
                                                            class="font-semibold text-base text-gray-600">{{ $log['performed_at'] }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
            <x-footer />
        </div>
        {{-- </div> --}}
    </main>
@endsection

@section('jslink')
    <script>
        var materieltype = {
            color: "#adb5bd",
            series: <?= json_encode($series) ?>, // Use PHP to pass data to JS
            labels: <?= json_encode($labels) ?>, // Use PHP to pass data to JS
            chart: {
                width: 200,
                type: "donut",
                fontFamily: "Plus Jakarta Sans', sans-serif",
                foreColor: "#adb0bb",
            },
            plotOptions: {
                pie: {
                    startAngle: 0,
                    endAngle: 360,
                    donut: {
                        size: '75%',
                    },
                },
            },
            stroke: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: true, // Show the legend
                position: 'bottom' // Position the legend
            },
            // Use more distinct colors or a color palette
            colors: ['#1e90ff', '#ffeb3b', '#32cd32', '#20b2aa', '#ff7f50'],
            responsive: [{
                breakpoint: 991,
                options: {
                    chart: {
                        width: 150,
                    },
                },
            }, ],
            tooltip: {
                theme: "dark",
                fillSeriesColor: false,
            },
        };

        var chart = new ApexCharts(document.querySelector("#materieltype"), materieltype);
        chart.render();

        var materieletat = {
            color: "#adb5bd",
            series: <?= json_encode($seriesetat) ?>, // Use PHP to pass data to JS
            labels: <?= json_encode($labelsetat) ?>, // Use PHP to pass data to JS
            chart: {
                width: 200,
                type: "donut",
                fontFamily: "Plus Jakarta Sans', sans-serif",
                foreColor: "#adb0bb",
            },
            plotOptions: {
                pie: {
                    startAngle: 0,
                    endAngle: 360,
                    donut: {
                        size: '75%',
                    },
                },
            },
            stroke: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: true, // Show the legend
                position: 'bottom' // Position the legend
            },
            // Use more distinct colors or a color palette
            colors: ['#1e90ff', '#ffeb3b', '#32cd32', '#20b2aa', '#ff7f50'],
            responsive: [{
                breakpoint: 991,
                options: {
                    chart: {
                        width: 150,
                    },
                },
            }, ],
            tooltip: {
                theme: "dark",
                fillSeriesColor: false,
            },
        };

        var chart = new ApexCharts(document.querySelector("#materieletat"), materieletat);
        chart.render();


        document.getElementById('month-filter').addEventListener('change', function() {
            const selectedMonth = this.value;

            fetch(`/dashboard/chart-data?month=${selectedMonth}`)
                .then(response => response.json())
                .then(data => {
                    // Update the chart with the new data
                    chart.updateSeries([{
                        data: data.series
                    }]);
                    chart.updateOptions({
                        xaxis: {
                            categories: data.labels
                        }
                    });
                });
        });

        var chartOptions = {

            series: [{
                data: <?= json_encode($seriesetat) ?>
            }],
            chart: {
                type: "bar",
                height: 352,
                offsetX: -15,
                toolbar: {
                    show: true
                },
                foreColor: "#adb0bb",
                fontFamily: 'inherit',
                sparkline: {
                    enabled: false
                },
            },
            colors: ["#5D87FF"],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "35%",
                    borderRadius: [6],
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'all'
                },
            },
            markers: {
                size: 0
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            xaxis: {
                type: "category",
                categories: <?= json_encode($labelsetat) ?>,
                labels: {
                    style: {
                        cssClass: "grey--text lighten-2--text fill-color"
                    }
                },
            },
            yaxis: {
                show: true,
                min: 0,
                tickAmount: 4,
                labels: {
                    style: {
                        cssClass: "grey--text lighten-2--text fill-color"
                    }
                },
            },
            stroke: {
                show: true,
                width: 3,
                lineCap: "butt",
                colors: ["transparent"]
            },
            tooltip: {
                theme: "light"
            },
            responsive: [],
        };

        var chartElement = document.querySelector("#chart");
        var chart = new ApexCharts(chartElement, chartOptions); // Use the stored options
        chart.render();
    </script>
@endsection
