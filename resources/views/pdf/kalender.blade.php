<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Akademik</title>
    <style>
        /* Tambahkan CSS sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            text-align: center; /* Center text for the whole body */
        }
        img {
            max-width: 150px; /* Set a maximum width for the logo */
            margin-bottom: 10px; /* Space below the logo */

        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color:brown;
            color: whitesmoke;
            align-content: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
<img src="{{ public_path('logo.webp') }}" alt="Image">
    <h4>Kalender Akademik Tahun Akademik {{ $tahunAkademik }} Semester {{ $semester }} 
        <br>Insitut Islam Muaro Jambi</h1>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Agenda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kalenderData as $item)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }} s.d 
                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}
                    </td>
                    <td>{{ $item->nama_event }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>