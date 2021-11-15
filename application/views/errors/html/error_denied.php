<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow" >
    <title>Access Denied</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Chango" rel="stylesheet">

    <style type="text/css">
        body {
          padding: 0;
          margin: 0;
        }
        
        #notfound {
          position: relative;
          height: 100vh;
        }
        
        #notfound .notfound {
          position: absolute;
          left: 50%;
          top: 50%;
          -webkit-transform: translate(-50%, -50%);
              -ms-transform: translate(-50%, -50%);
                  transform: translate(-50%, -50%);
        }
        
        .notfound {
          max-width: 520px;
          width: 100%;
          line-height: 1.4;
        }
        
        .notfound>div:first-child {
          padding-left: 200px;
          padding-top: 12px;
          height: 170px;
          margin-bottom: 20px;
        }
        
        .notfound .notfound-404 {
          position: absolute;
          left: 0;
          top: 0;
          width: 170px;
          height: 170px;
          background: #e01818;
          border-radius: 7px;
          -webkit-box-shadow: 0px 0px 0px 10px #e01818 inset, 0px 0px 0px 20px #fff inset;
                  box-shadow: 0px 0px 0px 10px #e01818 inset, 0px 0px 0px 20px #fff inset;
        }
        
        .notfound .notfound-404 h1 {
          font-family: 'Chango', cursive;
          color: #fff;
          font-size: 118px;
          margin: 0px;
          position: absolute;
          left: 50%;
          top: 50%;
          -webkit-transform: translate(-50%, -50%);
              -ms-transform: translate(-50%, -50%);
                  transform: translate(-50%, -50%);
          display: inline-block;
          height: 60px;
          line-height: 60px;
        }
        
        .notfound h2 {
          font-family: 'Chango', cursive;
          font-size: 68px;
          color: #222;
          font-weight: 400;
          text-transform: uppercase;
          margin: 0px;
          line-height: 1.1;
        }
        
        .notfound p {
          font-family: 'Montserrat', sans-serif;
          font-size: 16px;
          font-weight: 400;
          color: #222;
          margin-top: 5px;
        }
        
        .notfound a {
          font-family: 'Montserrat', sans-serif;
          color: #e01818;
          font-weight: 400;
          text-decoration: none;
        }
        .button-home{
            width: 100px;
            padding: 10px 15px;
            background: #e01818;
            color: #fff !important;
            text-align: center;
            display: block;
            margin-left: auto;
            margin-right: auto;;
        }
        
        @media only screen and (max-width: 480px) {
          .notfound {
            padding-left: 15px;
            padding-right: 15px;
          }
          .notfound>div:first-child {
            padding: 0px;
            height: auto;
          }
          .notfound .notfound-404 {
            position: relative;
            margin-bottom: 15px;
          }
          .notfound h2 {
            font-size: 42px;
          }
        }
    </style>

</head>

<body>

    <div id="notfound">
        <div class="notfound">
            <div>
                <div class="notfound-404">
                    <h1>!</h1>
                </div>
                <h2>Access<br>Denied</h2>
            </div>
            <p>Anda tidak berhak mengakses halaman ini, Silahkan hubungi administrator untuk mendapatkan hak akses lebih.</p>
            <p><strong><i>Segala Ativitas Hacking dilarang dan bisa kena tindak pidana sesuai Undang-Undang Nomor 11 Tahun 2008 Tentang Internet & Transaksi Elektronik </i></strong></p>
            <br>
            <a href="<?php echo base_url();?>administrator/dashboard/" class="button-home">KEMBALI</a>
        </div>
    </div>


</body>

</html>
