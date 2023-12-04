<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <title>Information</title>
    <style>
        body {
            padding: 20px;
            background-color: #36393f;
            color: #ffffff;
        }

        form,
        .list-container {
            max-width: 500px;
            margin: auto;
            background-color: #40444b;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            overflow: hidden;
        }

        h1, h2 {
            margin-top: 40px;
        }

        label {
            color: #b9bbbe;
        }

        input.form-control,
        select.form-select,
        button.btn {
            background-color: #4f545c;
            border: 1px solid #6e7681;
            color: #ffffff;
        }

        input.form-control::placeholder {
            color: #8e9297;
        }

        .btn-primary {
            background-color: #5865f2;
            border: 1px solid #6e7681;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #7289da;
            border: 1px solid #6e7681;
            color: #ffffff;
        }

        .list-group-item {
            background-color: #40444b;
            color: #ffffff;
            border: 1px solid #6e7681;
            margin-top: 10px;
            border-radius: 8px;
            padding: 10px;
        }

        .badge.bg-secondary {
            background-color: #5865f2;
        }

        .list-container {
            overflow-y: auto;
            scrollbar-width: thin;
            transition: max-height 0.5s ease;
            max-height: 200px;
        }

        .list-container:hover {
            max-height: 400px;
        }

        .list-container::-webkit-scrollbar {
            width: 8px;
        }

        .list-container::-webkit-scrollbar-thumb {
            background-color: #5865f2;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .list-container::-webkit-scrollbar-thumb:hover {
            background-color: #7289da;
        }
    </style>

</head>

<body>
    <div class="container">
        <form action="/" method="GET">
             <div class="mb-3">
                <label for="city" class="form-label">City:</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Enter city"
                    value="{{ $city }}" required>
            </div>
            <div class="mb-3">
                <label for="country_code" class="form-label">Country:</label>
                <select class="form-select" name="country_code" id="country_code" required>
                    @foreach ($countries as $country)
                        <option value="{{ $country->code }}" {{ $country->code === $countryCode ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category:</label>
                <input type="text" name="category" id="category" class="form-control" placeholder="Enter category"
                    value="{{ $category }}" required>
            </div>
            <div class="mb-3">
                <label for="limit_result" class="form-label">Nearby Location Limit:</label>
                <input type="number" name="limit_result" id="limit_result" class="form-control" placeholder="Enter limit"
                    value="{{ $limitResult }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <h2 class="mt-4 text-center">Nearby Location</h2>

        <ul class="list-group list-container">
            @foreach ($foursquareData['results'] as $venue)
                <li class="list-group-item">
                    <strong>{{ $venue['name'] }}</strong>
                    <p>{{ $venue['location']['formatted_address'] }}</p>
                    <p>Distance: {{ $venue['distance'] }} meters</p>
                    <p>Categories:
                        @foreach ($venue['categories'] as $category)
                            <span class="badge bg-secondary">{{ $category['name'] }}</span>
                        @endforeach
                    </p>
                </li>
            @endforeach
        </ul>

        <h2 class="mt-4 text-center">Weather Information</h2>

        <ul class="list-group list-container">
            @foreach($openweathermapData['list'] as $weather)
                <li class="list-group-item">
                    <strong>{{ \Carbon\Carbon::parse($weather['dt_txt'])->format('F d, Y h:i A') }}</strong>
                    <p>Temperature: {{ $weather['main']['temp'] }} &deg;C</p>
                    <p>Description: {{ $weather['weather'][0]['description'] }}</p>
                    <p>Humidity: {{ $weather['main']['humidity'] }}%</p>
                    <p>Wind Speed: {{ $weather['wind']['speed'] }} m/s</p>
                </li>
            @endforeach
        </ul>
    </div>
</body>

</html>
