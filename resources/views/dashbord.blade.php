@extends("layouts.master_app")
@section("content")
    <div>
        <h4>{{ trans("menu.dashboard") }}</h4>
    </div>
    <div class="">
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;" class="icon"><i class="fa fa-calendar"></i></div>
                    <div class="count">{{ $booking_count }}</div>
                    <h3>{{ trans("menu.totalBookings") }}</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;" class="icon"><i class="fa fa-sign-in"></i></div>
                    <div class="count">{{ $checkInsToday }}</div>
                    <h3>Today's Check-ins</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;" class="icon"><i class="fa fa-sign-out"></i></div>
                    <div class="count">{{ $checkOutsToday ?? 0 }}</div>
                    <h3>{{ trans("menu.check_Out") }}</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;" class="icon"><i class="fa fa-user"></i></div>
                    <div class="count">{{ $users }}</div>
                    <h3>{{ trans("menu.userManagement") }}</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;" class="icon"><i class="fa fa-book"></i></div>
                    <div class="count">{{ $availableRooms }}</div>
                    <h3>Available Rooms</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px; margin-right: 15px;" class="icon"><i class="fa fa-bed"></i></div>
                    <div class="count">{{ $rooms }}</div>
                    <h3>All Room</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;  margin-right: 15px;" class="icon"><i class="fa fa-tools"></i></i></div>
                    <div class="count">{{ $maintenanceRooms }}</div>
                    <h3>Maintenance</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;  margin-right: 15px;" class="icon"><i class="fa fa-bed"></i></div>
                    <div class="count">{{ $checkInsToday }}</div>
                    <h3>កំពុងស្នាក់នៅ</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;" class="icon">
                        <i class="fas fa-money-bill-wave fa-2x" style="margin-bottom: 44px;"></i>
                    </div>
                    <div class="count">${{ number_format($totalRevenue, 2) }}</div>
                    <h3>Today's Revenue</h3>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div style="margin-top: 14px;" class="icon"><i class="fa fa-user"></i></div>
                    <!-- Changed icon to represent testimonials -->
                    <div class="count">{{ $customers }}</div>
                    <h3>Customers</h3>
                </div>
            </div>
        </div>
    </div><br>
    <div>
        <a href="{{ route("dashbord") }}" class="btn btn-primary"><i class="fa fa-refresh"></i>
            {{ trans("menu.reset") }}</a>
    </div>
    <div class="">
        <div class="row">
            <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="row mb-3 navbar-right">
                    <div class="col-md-6">
                        <label for="yearFilter"></label>
                        <select id="yearFilter" class="form-control"></select>
                    </div>
                    <div class="col-md-6">
                        <label for="monthFilter"></label>
                        <select id="monthFilter" class="form-control">
                            <option value="">{{ trans("menu.all_months") }}</option>
                            <option value="1">{{ trans("menu.january") }}</option>
                            <option value="2">{{ trans("menu.february") }}</option>
                            <option value="3">{{ trans("menu.march") }}</option>
                            <option value="4">{{ trans("menu.april") }}</option>
                            <option value="5">{{ trans("menu.may") }}</option>
                            <option value="6">{{ trans("menu.june") }}</option>
                            <option value="7">{{ trans("menu.july") }}</option>
                            <option value="8">{{ trans("menu.august") }}</option>
                            <option value="9">{{ trans("menu.september") }}</option>
                            <option value="10">{{ trans("menu.october") }}</option>
                            <option value="11">{{ trans("menu.november") }}</option>
                            <option value="12">{{ trans("menu.december") }}</option>
                        </select>
                    </div>
                </div>
                <div class="x_panel">
                    <h2>{{ trans("menu.reservationStatistics") }}</h2>
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="reservationBarChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="row mb-3 navbar-right">
                    <div class="col-md-6">
                        <!-- Year Filter -->
                        <select id="filter_year" class="form-control">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $year == now()->year ? "selected" : "" }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- Month Filter -->
                        <select id="filter_month" class="form-control">
                            <option value="">{{ trans("menu.all_months") }}</option> <!-- Default option -->
                            @foreach ($months as $index => $month)
                                <option value="{{ $index + 1 }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="x_panel">
                    <h2>{{ trans("menu.check-InandCheck-OutPercentages") }}</h2>
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- Chart -->
                        <canvas id="checkInOutBarChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <h2>{{ trans("menu.bookedRoomSummary") }}</h2>
                    <div class="x_title">
                        <ul class="nav panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- Responsive table -->
                        <div class="table-responsive">
                            <table id="datatable-checkbox" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dailyBookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        {{ $booking->date }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        {{ $booking->user_count }}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>               --}}
    </div>
@endsection
<style>

</style>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- checkInOutBarChart --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('checkInOutBarChart').getContext('2d');
        const currentYear = new Date().getFullYear();

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                        label: 'Check-In Count',
                        data: [],
                        backgroundColor: 'rgba(250, 164, 27, 0.9)',
                        borderColor: 'rgba(200, 130, 20, 1)',
                        borderWidth: 2,
                    },
                    {
                        label: 'Check-Out Count',
                        data: [],
                        backgroundColor: 'rgba(229, 57, 53, 0.9)',
                        borderColor: 'rgba(180, 40, 40, 1)',
                        borderWidth: 2,
                    },
                ],

            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        function updateChart() {
            const year = document.getElementById('filter_year').value || currentYear;
            const month = document.getElementById('filter_month').value;

            fetch(`/getCheckInOutData?year=${year}&month=${month}`)
                .then(response => response.json())
                .then(data => {
                    if (month) {
                        // Handle single month response
                        const monthName = new Date(year, month - 1).toLocaleString('default', {
                            month: 'long'
                        });
                        myChart.data.labels = [monthName];
                        myChart.data.datasets[0].data = [data.checkInCount];
                        myChart.data.datasets[1].data = [data.checkOutCount];
                    } else {
                        // Handle full year response (array)
                        myChart.data.labels = data.map(item =>
                            new Date(year, item.month - 1).toLocaleString('default', {
                                month: 'long'
                            })
                        );
                        myChart.data.datasets[0].data = data.map(item => item.checkInCount);
                        myChart.data.datasets[1].data = data.map(item => item.checkOutCount);
                    }

                    myChart.update();
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                });
        }

        document.getElementById('filter_year').addEventListener('change', updateChart);
        document.getElementById('filter_month').addEventListener('change', updateChart);

        updateChart();
    });
</script>


{{-- reservationLineChart --}}
<script>
    $(document).ready(function() {
        let chartInstance;

        // Populate year dropdown
        const currentYear = new Date().getFullYear();
        const yearFilter = $('#yearFilter');
        for (let year = currentYear; year >= 2000; year--) {
            yearFilter.append(`<option value="${year}">${year}</option>`);
        }
        yearFilter.val(currentYear);

        // Function to update the chart
        function updateChart() {
            const selectedYear = $('#yearFilter').val();
            const selectedMonth = $('#monthFilter').val();

            $.ajax({
                url: '/get-reservation-statistics',
                method: 'GET',
                data: {
                    year: selectedYear,
                    month: selectedMonth,
                },
                success: function(response) {
                    const months = response.months;
                    const bookings = response.bookings;
                    const maxMonthIndex = response.maxMonthIndex;

                    if (!months.length || !bookings.length) {
                        // Handle empty data
                        alert('No data available for the selected filter.');
                        return;
                    }

                    const barColor = '#3498DB';
                    const maxBarColor = '#FF5733';

                    const chartData = {
                        labels: months,
                        datasets: [{
                            label: 'User Bookings',
                            data: bookings,
                            backgroundColor: bookings.map((booking, index) =>
                                index === maxMonthIndex ? maxBarColor : barColor
                            ),
                            borderColor: '#2c3e50',
                            borderWidth: 1,
                        }]
                    };

                    const ctx = document.getElementById('reservationBarChart').getContext('2d');

                    if (chartInstance) {
                        chartInstance.destroy();
                    }

                    // Create a new chart instance
                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' +
                                                tooltipItem.raw + ' bookings';
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function() {
                    alert('An error occurred while fetching the data.');
                }
            });
        }

        // Trigger chart update on filter change
        $('#yearFilter, #monthFilter').change(updateChart);

        // Initial chart load
        updateChart();
    });
</script>

{{-- table --}}
<script>
    $(document).ready(function() {
        $('#datatable-checkbox').DataTable({
            responsive: true,
            pageLength: 10, // Adjust page length as needed
            columnDefs: [{
                    orderable: false,
                    targets: [0]
                } // Disable sorting for specific columns if needed
            ]
        });
    });
</script>