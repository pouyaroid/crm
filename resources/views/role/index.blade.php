<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Roles List</title>
</head>
<body>
    <h1>لیست نقش‌ها</h1>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام نقش</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
