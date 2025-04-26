<!DOCTYPE html>
<html lang='fa'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>فرم گزارش سفارشی</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                <div class='card shadow'>
                    <div class='card-header bg-primary text-white text-center'>
                        <h4>گزارش سفارشی</h4>
                    </div>
                    <div class='card-body'>
                        <form method='POST' action='{{ route('reports.custom.generate') }}' class='rtl' dir='rtl'>
                            @csrf

                            <div class='mb-4'>
                                <label for='start_date' class='form-label fw-bold'>تاریخ شروع:</label>
                                <input type='date' 
                                    class='form-control' 
                                    id='start_date' 
                                    name='start_date' 
                                    value='{{ $defaultStartDate }}'
                                    max='{{ now()->format('Y-m-d') }}'>
                            </div>

                            <div class='mb-4'>
                                <label for='end_date' class='form-label fw-bold'>تاریخ پایان:</label>
                                <input type='date' 
                                    class='form-control' 
                                    id='end_date' 
                                    name='end_date' 
                                    value='{{ $defaultEndDate }}'
                                    max='{{ now()->format('Y-m-d') }}'>
                            </div>

                            <div class='d-grid gap-2'>
                                <button type='submit' class='btn btn-success'>تولید گزارش</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
