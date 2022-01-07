<!DOCTYPE html>
<html>

<head>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        h2,
        table tr td {
            text-align: center;
        }

    </style>
</head>

<body>

    <h2>Toko Solafide</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>ID Transaksi</th>
                <th>Nama Pembeli</th>
                <th>Nama Barang</th>
                <th>Harga Satuan (Rp)</th>
                <th>Jumlah</th>
                <th>Total Bayar (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data->tanggal }}</td>
                <td>{{ $data->id_transaksi }}</td>
                <td>{{ $data->nama_pembeli }}</td>
                <td>{{ $data->nama_barang }}</td>
                <td>{{ $data->harga }}</td>
                <td>{{ $data->jumlah }}</td>
                <td>{{ $data->harga * $data->jumlah }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
