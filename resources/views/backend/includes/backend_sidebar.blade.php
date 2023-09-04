<aside class="sidebar sidebar-dark sidebar-fixed bg-gradient-sidebar" id="sidebar">
    <?php
    $isTransaksi = strpos(url()->current(), 'transaksi') !== false;
    ?>
    {!! $backend_sidebar->asUl(
        ['class' => 'sidebar-nav', 'id' => 'sidebar-nav'],
        ['class' => 'nav-content ' . ($isTransaksi ? '' : 'collapse'), 'id' => 'report-nav'],
    ) !!}
</aside>
