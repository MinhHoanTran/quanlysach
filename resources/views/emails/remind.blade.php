<!DOCTYPE html>
<html>
<head>
    <title>Thông báo sách đến hạn trả</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        
        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Thông báo sách đến hạn trả</h1>
    <p>Xin chào {{ $user->name }},</p>

    <p>Dưới đây là danh sách các sách sắp đến hạn trả:</p>
    
    <table>
        <thead>
            <tr>
                <th width="30%"><center>Name</center></th>
                <th width="20%"><center>Date</center></th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td><center>{{ $book->book->name }}</center></td>
                <td><center>{{ \Carbon\Carbon::parse($book->return_date)->format('d/m/Y') }}</center></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Vui lòng bạn trả sách đúng hạn!</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    <p>Trân trọng,</p>
</body>
</html>
