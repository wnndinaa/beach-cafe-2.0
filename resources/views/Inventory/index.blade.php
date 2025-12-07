@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inventory Summary</h2>

    <!-- Filter Options -->
    <div class="mb-2">
    <label for="filter-type">Filter Type:</label>
    <select id="filter-type" class="form-select">
            <option value="day">Day</option>
            <option value="week">Week</option><!-- Added Date Range Option -->
        </select>

        <!-- Date Range Filters (only for Date Range selection) -->
        <div id="week-filters" class="d-none mt-2">
            <input type="date" id="filter-start-date" class="form-control" placeholder="Start Date" />
            <input type="date" id="filter-end-date" class="form-control mt-2" placeholder="End Date" />
        </div>

     <!-- Single Date Filter (Day) -->
     <input type="date" id="filter-date" class="form-control mt-2" />
    </div>


    <!-- Chart Container -->
    <canvas id="barChart"></canvas>

    <!-- Form to Update Inventory -->
    <form action="{{ route('inventory.update') }}" method="POST" class="mt-4">
        @csrf
        <input type="date" name="date" class="form-control mb-3" required>
        
        @foreach(['Mee', 'Kopi', 'Telur', 'Ayam', 'Sayur (taugeh)', 'Sayur (bayam)', 'Sosej', 'Cili', 'Garam'] as $item)
            <div class="mb-2">
            <label for="item-{{ $loop->index }}" class="form-label">{{ $item }}</label>
                            <input type="number" id="item-{{ $loop->index }}" name="items[{{ $item }}]" class="form-control @error('items.' . $item) is-invalid @enderror" placeholder="Enter quantity">
                            @error('items.' . $item)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($data['labels']),  // Labels passed from the backend
            datasets: [{
                label: 'Inventory Levels',
                data: @json($data['data']),  // Data passed from the backend
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('filter-date').addEventListener('change', fetchFilteredData);
    document.getElementById('filter-type').addEventListener('change', fetchFilteredData);
    document.getElementById('filter-start-date').addEventListener('change', fetchFilteredData);
    document.getElementById('filter-end-date').addEventListener('change', fetchFilteredData);

    function fetchFilteredData() {
        const type = document.getElementById('filter-type').value;
        const date = document.getElementById('filter-date').value;
        const startDate = document.getElementById('filter-start-date').value;
        const endDate = document.getElementById('filter-end-date').value;

        // Show week filters if the "week" option is selected
        if (type === 'week') {
            document.getElementById('week-filters').classList.remove('d-none');
            if (!startDate || !endDate) return; // Don't fetch if no range is selected
        } else {
            document.getElementById('week-filters').classList.add('d-none');
        }

        // Make sure there's a date selected for day, or week
        if (type === 'day' && !date) return;
        if (type === 'week' && (!startDate || !endDate)) return;

        let url = `/inventory/filter?type=${type}`;

        if (type === 'day') {
            url += `&date=${date}`;
        } else if (type === 'week') {
            url += `&start_date=${startDate}&end_date=${endDate}`;
        }

        // Fetch filtered data from the server
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    // Update the chart with the filtered data
                    myChart.data.datasets[0].data = data.map(item => item.quantity);
                    myChart.data.labels = data.map(item => item.date);  // Optional: Update labels if needed
                    myChart.update();
                } else {
                    // Handle case where no data is found
                    alert('No data found for the selected filter.');
                    myChart.data.datasets[0].data = [];  // Clear data if no results
                    myChart.update();
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }
</script>
@endsection