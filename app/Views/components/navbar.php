<nav class="navbar navbar-dark bg-dark navbar-expand-md py-3">
    <div class="container"><a class="navbar-brand d-flex align-items-center" href="/"><span style="color:#FFFF;">KiwPart</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="/" style="color:#FFFF;">Barang</a></li>
            </ul>
            <a class="btn btn-secondary" role="button" href="<?= base_url('cart') ?>">
                <i class="fas">Keranjang</i>
                <?php
                $products_count = 0;
                if (session()->has('cart')) {
                    $products_count = count(session()->get('cart'));
                } else {
                    $products_count = 0;
                }
                ?>
                <?= $products_count ?>
            </a>
            <!-- <a href="<?= base_url('login') ?>" role="button" class="btn btn-link">Login</a> -->
        </div>
    </div>
</nav>