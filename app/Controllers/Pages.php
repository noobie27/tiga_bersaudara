<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\Ukuran;
use App\Models\PemesananModel;
use KategoriModel as GlobalKategoriModel;

class Pages extends BaseController
{
    protected $Produk;
    protected $Kategori;
    protected $Pemesanan;

    public function __construct()
    {
        $this->Produk = new ProdukModel();
        $this->Kategori = new KategoriModel();
        $this->Pemesanan = new PemesananModel();
    }


    public function index()
    {
        $data = [
            'title' => 'Tiga Bersaudara',
            'produk' => $this->Produk->getProduk(),
            'kategori' => $this->Kategori->getKategori()
        ];

        return view('pages/home', $data);
    }

    public function produk($id_produk)
    {
        $ukuran = new \App\Models\Ukuran();
        $data = [
            'title' => 'produk',
            'produk' => $this->Produk->getDetailProduk($id_produk),
            'ukuran' => $ukuran->where('produk_id', $id_produk)->findAll()
        ];
        return view('pages/produk', $data);
    }

    public function cekSize()
    {
        //DB
        $a = "100cm x 150cm";
        //User
        $b = "150cm x 100cm";

        $c = explode(" ", $a);
        $c = implode(" ", array($c[0], $c[1], $c[2]));

        echo $b . "<br>" . $c;

        //SELECT `ukuran`, `harga` FROM `ukuran` WHERE ukuran = $b

        //SELECT `ukuran`, `harga` FROM `ukuran` WHERE ukuran = $c
    }

    public function kategori()
    {
        $data = [
            'title' => 'kategori'
        ];

        return view('pages/kategori', $data);
    }
    public function keranjang()
    {
        $data = [
            'title' => 'keranjang'
        ];

        return view('pages/keranjang', $data);
    }

    public function checkout()
    {
        $data = [
            'title' => 'checkout'
        ];

        return view('pages/checkout', $data);
    }
    public function kontak()
    {
        $data = [
            'title' => 'kontak'
        ];

        return view('pages/kontak', $data);
    }
    public function register()
    {
        $data = [
            'title' => 'register'
        ];

        return view('pages/register', $data);
    }
    public function login()
    {
        $data = [
            'title' => 'login'
        ];

        return view('pages/login', $data);
    }
    public function shopNow()
    {
        $data = [
            'title' => 'pesan'
        ];
        // dd($this->request->getVar());

        $pemesanan = [
            'id_user' => 1,
            'id_produk' => $this->request->getVar('id_produk'),
            'desain' => $this->request->getVar('desain'),
            'ket_pemesanan' => $this->request->getVar('ukuran') . ' ' . $this->request->getVar('deskripsi'),
            'pembayaran' => $this->request->getVar('pembayaran'),
            'status_pemesanan' => 'cart',
            'status_pembayaran' => 'belum dibayar',
            'bukti_pembayaran' => '',
            'tgl' => date("Y/m/d")
        ];

        $this->Pemesanan->save($pemesanan);
        return redirect()->to('/pages/produk/' .  $this->request->getVar('id_produk'));
    }

    //--------------------------------------------------------------------

}
