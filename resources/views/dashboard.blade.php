{{-- @can('view', 'admin-permission') --}}
@extends('layouts.index')
@section('title', 'Tableau de bord')
@section('content')

    <main class="h-full overflow-y-auto  max-w-full  pt-4">
        {{-- <div class="container full-container py-5 flex flex-col gap-6"> --}}
        <div class="p-5">
            {{-- <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="sm:flex block justify-between mb-5">
                                <h4 class="text-gray-600 text-lg font-semibold sm:mb-0 mb-2">Sales Overview
                                </h4>
                                <select name="cars" id="cars"
                                    class=" border-gray-400 text-gray-500 rounded-md text-sm border-[1px] focus:ring-0 sm:w-auto w-full">
                                    <option value="volvo">March2023</option>
                                    <option value="saab">April2023</option>
                                    <option value="mercedes">May2023</option>
                                    <option value="audi">June2023</option>
                                </select>
                            </div>
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-gray-600 text-lg font-semibold mb-5">Yearly Breakup</h4>
                            <div class="flex gap-6 items-center justify-between">
                                <div class="flex flex-col gap-4">
                                    <h3 class="text-[21px] font-semibold text-gray-600">$36,358</h3>
                                    <div class="flex items-center gap-1">
                                        <span class="flex items-center justify-center w-5 h-5 rounded-full bg-teal-400">
                                            <i class="ti ti-arrow-up-left text-teal-500"></i>
                                        </span>
                                        <p class="text-gray-600 text-sm font-normal ">+9%</p>
                                        <p class="text-gray-500 text-sm font-normal text-nowrap">last year
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <div class="flex gap-2 items-center">
                                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                            <p class="text-gray-500 font-normal text-xs">2023</p>
                                        </div>
                                        <div class="flex gap-2 items-center">
                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                            <p class="text-gray-500 font-normal text-xs">2023</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex  items-center">
                                    <div id="breakup"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
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
                    </div>
                </div>


            </div> --}}
            <div class="mt-2 grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-gray-600 text-lg font-semibold mb-6">Recent Transactions</h4>
                        <ul class="timeline-widget relative">
                            <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                                <div class="timeline-time text-gray-600 text-sm min-w-[90px] py-[6px] pr-4 text-end">
                                    9:30 am
                                </div>
                                <div class="timeline-badge-wrap flex flex-col items-center ">
                                    <div
                                        class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-blue-600 my-[10px]">
                                    </div>
                                    <div class="timeline-badge-border block h-full w-[1px] bg-gray-100">
                                    </div>
                                </div>
                                <div class="timeline-desc py-[6px] px-4">
                                    <p class="text-gray-600 text-sm font-normal">Payment received from John
                                        Doe of $385.90</p>
                                </div>
                            </li>
                            <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                                <div class="timeline-time text-gray-600 min-w-[90px] py-[6px] text-sm pr-4 text-end">
                                    10:00 am
                                </div>
                                <div class="timeline-badge-wrap flex flex-col items-center ">
                                    <div
                                        class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-blue-300 my-[10px]">
                                    </div>
                                    <div class="timeline-badge-border block h-full w-[1px] bg-gray-100">
                                    </div>
                                </div>
                                <div class="timeline-desc py-[6px] px-4 text-sm">
                                    <p class="text-gray-600  font-semibold">New sale recorded</p>
                                    <a href="javascript:void('')" class="text-blue-600">#ML-3467</a>
                                </div>
                            </li>

                            <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                                <div class="timeline-time text-gray-600 min-w-[90px] text-sm py-[6px] pr-4 text-end">
                                    12:00 am
                                </div>
                                <div class="timeline-badge-wrap flex flex-col items-center ">
                                    <div
                                        class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-teal-500 my-[10px]">
                                    </div>
                                    <div class="timeline-badge-border block h-full w-[1px] bg-gray-100">
                                    </div>
                                </div>
                                <div class="timeline-desc py-[6px] px-4">
                                    <p class="text-gray-600 text-sm font-normal">Payment was made of $64.95
                                        to Michael</p>
                                </div>
                            </li>

                            <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                                <div class="timeline-time text-gray-600 min-w-[90px] text-sm py-[6px] pr-4 text-end">
                                    9:30 am
                                </div>
                                <div class="timeline-badge-wrap flex flex-col items-center ">
                                    <div
                                        class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-yellow-500 my-[10px]">
                                    </div>
                                    <div class="timeline-badge-border block h-full w-[1px] bg-gray-100">
                                    </div>
                                </div>
                                <div class="timeline-desc py-[6px] px-4 text-sm">
                                    <p class="text-gray-600 font-semibold">New sale recorded</p>
                                    <a href="javascript:void('')" class="text-blue-600">#ML-3467</a>
                                </div>
                            </li>

                            <li class="timeline-item flex relative overflow-hidden min-h-[70px]">
                                <div class="timeline-time text-gray-600 text-sm min-w-[90px] py-[6px] pr-4 text-end">
                                    9:30 am
                                </div>
                                <div class="timeline-badge-wrap flex flex-col items-center ">
                                    <div
                                        class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-red-500 my-[10px]">
                                    </div>
                                    <div class="timeline-badge-border block h-full w-[1px] bg-gray-100">
                                    </div>
                                </div>
                                <div class="timeline-desc py-[6px] px-4">
                                    <p class="text-gray-600 text-sm font-semibold">New arrival recorded</p>
                                </div>
                            </li>
                            <li class="timeline-item flex relative overflow-hidden">
                                <div class="timeline-time text-gray-600 text-sm min-w-[90px] py-[6px] pr-4 text-end">
                                    12:00 am
                                </div>
                                <div class="timeline-badge-wrap flex flex-col items-center ">
                                    <div
                                        class="timeline-badge w-3 h-3 rounded-full shrink-0 bg-transparent border-2 border-teal-500 my-[10px]">
                                    </div>
                                    <div class="timeline-badge-border block h-full w-[1px] bg-gray-100">
                                    </div>
                                </div>
                                <div class="timeline-desc py-[6px] px-4">
                                    <p class="text-gray-600 text-sm font-normal">Payment Done</p>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                 @can('viewAny', App\Models\User::class)
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
                                                    @if ($log['action'] == 'create')
                                                        <span
                                                            class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold bg-cyan-500 text-white">Ajouter</span>
                                                    @elseif ($log['action'] == 'update')
                                                        <span
                                                            class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-blue-600">Modifier</span>
                                                    @elseif ($log['action'] == 'delete')
                                                        <span
                                                            class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-red-500">Supprimer</span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center py-[3px] px-[10px] rounded-2xl font-semibold text-white bg-teal-500">Exporter</span>
                                                    @endif
                                                </td>
                                                <td class="p-4 text-center">
                                                    <span class="font-normal text-gray-500">
                                                        @if ($log['table_name'] == 'services')
                                                            Service
                                                        @elseif ($log['table_name'] == 'users')
                                                            Utilisateur
                                                        @elseif ($log['table_name'] == 'materials')
                                                            Matériel
                                                        @elseif ($log['table_name'] == 'feuille_reformes')
                                                            Feuille de réforme
                                                        @elseif ($log['table_name'] == 'avis__mvts')
                                                            Avis de mouvement
                                                        @elseif ($log['table_name'] == 'bon_decharges')
                                                            Bon de décharge
                                                        @endif
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
{{-- @endcan --}}
