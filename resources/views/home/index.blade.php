@extends('layouts.app-top-nav')

@section('title')
  Home
@endsection

@section('content')
  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>{{ config('app.name') }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item">{{ config('app.name') }}</div>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">Halaman Perkenalan</h2>
        <p class="section-lead">Ini adalah halaman perkenalan saya.</p>
        <div class="card">
          <div class="card-header">
            <h4>Biografi</h4>
          </div>
          <div class="card-body">
            Perkenalkan nama saya Hairul Anam. Berasal dari Kabupaten Jember, kelahiran 98. Kuliah di Universitas Jember
            mengambil jurusan Sistem Informasi.
            <p>
              Saya adalah seorang web developer asal Indonesia. Menggeluti dunia pengembangan
              web sejak tahun 2016. Karya-karya atau portofolio yang pernah dibuat meliputi
            <ol>
              <li><a href="https://aksiberbagi.com" target="_blank">aksiberbagi.com</a> sebuah website donasi ternama
                di
                Indonesia</li>
              <li><a href="https://aksiberbagi.org" target="_blank">aksiberbagi.og</a> sebuah website donasi ternama
                di
                Indonesia (berbeda tampilan dan payment)
              </li>
              <li><a href="https://nusalink.asia" target="_blank">nusalink.asia</a> sebuah website booking properti di
                Indonesia
              </li>
              <li><a href="https://bajaga.online" target="_blank">bajaga.online</a> sebuah website e-commerce
                multiseller di
                Indonesia
              </li>
              <li><a href="https://bantukerja.com" target="_blank">bantukerja.com</a> sebuah website freelancer dan
                study untuk murid SMK/SMA di
                Indonesia
              </li>
              <li><a href="https://hrms.nururrohmah.com/" target="_blank">hrms.nururrohmah.com</a> sebuah website
                untuk penghitungan gaji pegawai
              </li>
              <li><a href="https://sipad.nururrohmah.com/" target="_blank">sipad.nururrohmah.com</a> sebuah website
                untuk arsip dan dokumen
              </li>
              </p>
          </div>
          <div class="card-footer bg-whitesmoke">
            Manusia terbaik adalah manusia yang bermanfaat bagi sesama :)
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
