<!-- Start: 2 Rows 1+4 Columns -->
<div class="container-fluid">
    <div class="row" data-aos="fade-up" data-aos-delay="100" style="margin-right: 10px;margin-left: 21px;">

        <?php foreach ($barang as $brg => $value) { ?>
            <div class="col-md-3 mt-4">
                <form action="<?= base_url('add_to_cart') ?>" method="post">
                    <div class="card border rounded shadow" style="width: 18rem;"><img class="img-fluid card-img-top w-100 d-block border rounded card-img-top" src="<?= base_url('gambar/' . $value['namafilesparepart']) ?>" alt="..." style="min-height: 280px;max-height: 300px;opacity: 1;" loading="auto">
                        <div class="card-body">
                            <h5 class="text-capitalize fs-4 fw-normal text-center text-primary card-title card-title"><strong><?= $value['nama'] ?></strong></h5>
                        </div>
                        <ul class="list-group list-group-flush list-group-flush">
                            <?php
                            $harga = $value['harga'];
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start"><span class="text-primary">Rp<?= number_format($harga, 0, ',', '.') ?></span><span class="fs-6 fw-semibold text-light badge rounded-pill bg-primary" data-bs-toggle="tooltip" data-bss-tooltip="" data-bs-placement="right" title="Stok"><?= $value['stok'] ?></span></li>
                        </ul>
                        <div class="card-body text-center mt-2">
                            <input type="hidden" name="id_<?= $value['idbrg']  ?>" value="<?= $value['idbrg']  ?>">
                            <input type="hidden" name="idbrg" value="<?= $value['idbrg']  ?>">

                            <?php if ($value['stok'] > 0) { ?>
                                <div class="d-grid mx-auto"><button type="submit" class="btn btn-outline-info btn-sm text-capitalize fs-5 fw-semibold link-primary border rounded" id="add_to_cart">
                                        add to Cart
                                    </button>
                                </div>
                            <?php } else { ?>
                                <div class="d-grid mx-auto"><button type="button" class="btn btn-primary btn-sm text-capitalize fs-5 fw-semibold link-white border rounded disabled">
                                        Sold Out
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>

</div><!-- End: 2 Rows 1+4 Columns -->