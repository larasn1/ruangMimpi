<!DOCTYPE html>
<html>
    <head>
        <title>Ruang Mimpi</title>
        
    </head>
    <body>
        <table>
            <tr>
                <th>Nama</th>
                <th>Bukti</th>
                <th>Opsi</th>
            </tr>
            @foreach($data as $d)
            <tr>
                <td>{{ $d -> nama }}</td>
                <td><img id = "myImg" src="{{ ($d->gambar)}}" height = "42" width = "42" alt=""></td>
				<td><a href="/verifikasi-pembayaran/gantiStatus/{{ $d->kode }}">Ganti Status</a></td>
            </tr>
            @endforeach
        </table>
    </body>
</html>