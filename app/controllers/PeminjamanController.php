<?php

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = $this->model('Peminjaman')->getPinjam();
        $this->view('peminjaman/home', $data);
    }

    public function pinjam($id)
    {
        $data = $this->model('Buku')->getById($id);
        $this->view('peminjaman/pinjam', $data);
    }

    public function store()
    {
        // Mendapatkan tanggal sekarang
        $currentDate = date('Y-m-d');

        // Mendapatkan tanggal pengembalian (7 hari setelah tanggal peminjaman)
        $returnDate = date('Y-m-d', strtotime($currentDate . ' + 7 days'));

        // Menambahkan peminjaman dengan batas waktu pengembalian 7 hari
        if ($this->model('Peminjaman')->create([
            'UserID'              => $_SESSION['UserID'],
            'BukuID'              => $_POST['BukuID'],
            'TanggalPeminjaman'   => $currentDate,
            'TanggalPengembalian' => $returnDate,
            'StatusPeminjaman'    => 'Belum di Kembalikan'
        ]) > 0) {
            redirectTo('success', 'Selamat, Buku berhasil dipinjam. Batas pengembalian: ' . $returnDate, '/peminjaman');
        } else {
            redirectTo('error', 'Maaf, Buku gagal dipinjam', '/peminjaman');
        }
    }

    public function kembalikan($id)
    {
        if ($this->model('Peminjaman')->update($id) > 0) {
            redirectTo('success', 'Selamat, Buku berhasil dikembalikan!', '/peminjaman');
        } else {
            redirectTo('error', 'Maaf, Buku gagal dikembalikan!', '/peminjaman');
        }
    }
}
