<?php
include 'header.php';
include 'koneksi.php'; // Pastikan koneksi.php ada dan mengatur koneksi ke database

// Mendapatkan data kasir dan produk untuk dropdown
$kasir_query = "SELECT * FROM kasir";
$kasir_result = mysqli_query($koneksi, $kasir_query);

$produk_query = "SELECT * FROM produk";
$produk_result = mysqli_query($koneksi, $produk_query);
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Tambah Penjualan</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="penjualan.php">Penjualan</a></li>
      <li class="active">Tambah Penjualan</li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title">Form Tambah Penjualan</h3>
      </div>
      <form method="post" action="penjualan_act.php">
        <div class="box-body">
          <!-- Form untuk tambah penjualan -->
			      <div class="col-lg-3">
                  <div class="form-group">
                  <label>No. Invoice</label>
                  <?php 
                        // mencari kode Produk dengan nilai paling besar
                  $hasil = mysqli_query($koneksi,"SELECT max(invoice_nomor) as maxKode FROM invoice");
                  $kp = mysqli_fetch_array($hasil);
                  $kodeInvoice = $kp['maxKode'];
                  // echo $kodeInvoice;
                  // echo "<br/>";
                  $noUrut = substr($kodeInvoice, 6, 3);
                  // echo $noUrut;
                  $noUrut++;
                  // echo $noUrut;
                  $thn = date('y');
                  $bln = date('m');
                  $tgl = date('d');
                  $char = $thn.$bln.$tgl;
                  $noInvoice = $char . sprintf("%02s", $noUrut);
                  // echo $noInvoice;
                  ?>
                  <input type="text" class="form-control" name="nomor" required="required" placeholder="Masukkan Nomor Invoice" value="<?php echo $noInvoice; ?>" readonly>
                </div>

              </div>

              <div class="col-lg-3">

              <div class="form-group">
                  <label>Tanggal Invoice</label>
                  <input type="date" class="form-control" name="tanggal" required="required" placeholder="Masukkan Tanggal Pembelian .. (Wajib)" value="<?php echo date('Y-m-d') ?>">
                </div>

              </div>

           <div class="col-lg-3">
			   
           <div class="form-group">
              <label>Pelanggan</label>
              <input type="text" class="form-control" name="pelanggan" required="required" placeholder="Masukkan Nama Pelanggan .. (Wajib)">
                </div>
			   
              </div>
		  
          <div class="col-lg-3">
			  
          <div class="form-group">
            <label for="invoice_alamat">Alamat</label>
            <input type="text" class="form-control" id="invoice_alamat" name="invoice_alamat" required="required" placeholder="Masukkan Alamat Pelanggan .. (Wajib)">
            </div>
		  </div>

		  <div class="col-lg-3">
			  
          <div class="form-group">
            <label for="invoice_tlp">Telepon</label>
            <input type="text" class="form-control" id="invoice_tlp" name="invoice_tlp" required="required" placeholder="Masukkan Tlp Pelanggan .. (Wajib)">
          </div>
	     </div>  
			  
          <div class="col-lg-3">
          <div class="form-group">
            <label for="invoice_tanggalkirim">Tanggal Pemasangan</label>
            <input type="date" class="form-control" id="invoice_tanggalkirim" name="invoice_tanggalkirim" required>
          </div>
		  </div>
			
		<div class="col-lg-3">

                <input type="hidden" name="kasir" value="<?php echo $_SESSION['id']; ?>">

                <div class="form-group">
                  <label>Kasir</label>
                  <input type="text" class="form-control"id="invoice_kasir" name="invoice_kasir" required="required" value="<?php echo $_SESSION['nama']; ?>" readonly>
				<?php while ($kasir = mysqli_fetch_array($kasir_result)) { ?>
              <?php } ?>
                </div>

              </div>
			  
            </div>
            <hr>  


            <div class="row">

              <div class="col-lg-3">
                <h3>Tambah Pembelian</h3>

                <div class="row">

                 <div class="form-group col-lg-7">
                  <label>Kode Produk</label>
                  <input type="hidden" class="form-control" id="tambahkan_id">
                  <input type="text" class="form-control" id="tambahkan_kode" placeholder="Masukkan Kode Produk ..">
                </div>

                <div class="col-lg-5">

                  <button style="margin-top: 27px" type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#cariProduk">
                    <i class="fa fa-search"></i> &nbsp Cari Produk
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="cariProduk" tabindex="-1" role="dialog" aria-labelledby="cariProdukLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          Pilih Pembelian produk
                        </div>
                        <div class="modal-body">


                          <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="table-datatable-produk">
                              <thead>
                                <tr>
                                  <th class="text-center">NO</th>
                                  <th>KODE</th>
                                  <th>PRODUK</th>
                                  <th class="text-center">SATUAN</th>
                                  <th class="text-center">STOK</th>
                                  <th class="text-center">HARGA JUAL</th>
                                  <th>KETERANGAN</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                $no=1;
                                $data = mysqli_query($koneksi,"SELECT * FROM produk, kategori where produk_kategori=kategori_id order by produk_id desc");
                                while($d = mysqli_fetch_array($data)){
                                  ?>
                                  <tr>
                                    <td width="1%" class="text-center"><?php echo $no++; ?></td>
                                    <td width="1%"><?php echo $d['produk_kode']; ?></td>
                                    <td>
                                      <?php echo $d['produk_nama']; ?>
                                      <br>
                                      <small class="text-muted"><?php echo $d['kategori']; ?></small>
                                    </td>
                                    <td width="1%" class="text-center"><?php echo $d['produk_satuan']; ?></td>
                                    <td width="1%" class="text-center"><?php echo $d['produk_stok']; ?></td>
                                    <td width="20%" class="text-center"><?php echo "Rp.".number_format($d['produk_harga_jual']).",-"; ?></td>
                                    <td width="15%"><?php echo $d['produk_keterangan']; ?></td>
                                    <td width="1%">              
                                      <?php 
                                      if($d['produk_stok'] > 0){
                                        ?>          
                                        <input type="hidden" id="kode_<?php echo $d['produk_id']; ?>" value="<?php echo $d['produk_kode']; ?>">
                                        <input type="hidden" id="nama_<?php echo $d['produk_id']; ?>" value="<?php echo $d['produk_nama']; ?>">
                                        <input type="hidden" id="harga_<?php echo $d['produk_id']; ?>" value="<?php echo $d['produk_harga_jual']; ?>">
                                        <button type="button" class="btn btn-success btn-sm modal-pilih-produk" id="<?php echo $d['produk_id']; ?>" data-dismiss="modal">Pilih</button>
                                        <?php 
                                      }
                                      ?>
                                    </td>
                                  </tr>
                                  <?php 
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
				  
		 
			 <div class="form-group">
                <label>Produk</label>
                <input type="text" class="form-control" id="tambahkan_nama" disabled>
              </div>

              <div class="form-group">
                <label>Harga</label>
                <input type="text" class="form-control" id="tambahkan_harga" disabled>
              </div>

              <div class="form-group">
                <label>Jumlah</label>
                <input type="number" class="form-control" id="tambahkan_jumlah" min="1">
              </div>

              <div class="form-group">
                <label>Total</label>
                <input type="text" class="form-control" id="tambahkan_total" disabled>
              </div>

              <div class="form-group">
                <span class="btn btn-sm btn-primary pull-right btn-block" id="tombol-tambahkan">TAMBAHKAN</span>
              </div>

            </div>


            <div class="col-lg-9">

              <h3>Daftar Pembelian</h3>

              <table class="table table-bordered table-striped table-hover" id="table-pembelian">
                <thead>
                  <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th style="text-align: center;">Harga</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Total</th>
                    <th style="text-align: center;" width="1%">OPSI</th>
                  </tr>
                </thead>
                <tbody> 
                </tbody>
                <tfoot>
                  <tr class="bg-info">
                    <td style="text-align: right;" colspan="2"><b>Total</b></td>
                    <td style="text-align: center;"><span class="pembelian_harga" id="0">Rp.0,-</span></td>
                    <td style="text-align: center;"><span class="pembelian_jumlah" id="0">0</span></td>
                    <td style="text-align: center;"><span class="pembelian_total" id="0">Rp.0,-</span></td>
                    <td style="text-align: center;"></td>
                  </tr>
                </tfoot>
              </table>

              <br>

              <div class="row">
                <div class="col-lg-6">
                  <table class="table table-bordered table-striped">
                    <tr>
                      <th width="50%">Sub Total Pembelian</th>
                      <td>
                        <input type="hidden" name="sub_total" class="sub_total_form" value="0">
                        <span class="sub_total_pembelian" id="0">Rp.0,-</span>
                      </td>
                    </tr>
                    <tr>
                      <th>Diskon</th>
                      <td>
                        <div class="row">
                          <div class="col-lg-10">
                            <input class="form-control total_diskon" type="number" min="0" max="100" id="0" name="diskon" value="0" required="required">
                          </div>
                          <div class="col-lg-2">%</div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Total Pembelian</th>
                      <td>
                        <input type="hidden" name="total" class="total_form" value="0">
                        <span class="total_pembelian" id="0">Rp.0,-</span>
                      </td>
                    </tr>
                    <tr>
                      <th>Downpayment</th>
                      <td>
						<span class="total_pembelian" id="0">Rp</span>
                        <input type="number" name="total_downpayment" class="downpayment_form" value="0">
                      </td>
                    </tr>
                    <tr>
                      <th>Sisa Total</th>
                      <td>
                        <span class="total_sisatotal" id="0">Rp</span>
                        <input type="number" name="total_sisatotal" class="sisatotal_form" value="0">
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <br>
          <div class="form-group">
            <a href="penjualan_tambah.php" class="btn btn-danger"><i class="fa fa-close"></i> Batalkan Transaksi</a>
            <button class="btn btn-success pull-right"><i class="fa fa-check"></i> Buat Transaksi</button>
          </div>

          <br>
          <br>
        </div>
      </form>
    </div>
  </section>
</div>

<?php include 'footer.php'; ?>