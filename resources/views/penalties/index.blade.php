{{-- You should extend your main layout file --}}
{{-- e.g., @extends('layouts.app') --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Books and Penalties</title>
    {{-- Add your CSS here --}}
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>

    <h1>Overdue Books</h1>

    @if($overdueLoans->isEmpty())
        <p>No overdue books at the moment.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Book Title</th>
                    <th>Due Date</th>
                    <th>Days Overdue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overdueLoans as $loan)
                    <tr>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->due_at ? $loan->due_at->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $loan->days_overdue }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>