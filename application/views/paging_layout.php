<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : paging_layout.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
?>
<div class="paging_wrap pagination pagination-large">
    <span class="pg_first"><img src="assets/images/button-first.png" /></span>
    <span class="pg_pre"><img src="assets/images/button-prev.png" /></span>
    [ Hal : <input style="text-align: center;" size="4" class="pg_hal input-small" value="1"/> / <span class="pg_total"></span> ]
    <span class="pg_next"><img src="assets/images/button-next.png" /></span>
    <span class="pg_last"><img src="assets/images/button-last.png" /></span>&nbsp;|&nbsp;Limit
        <select class="pg_row input-small">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    &nbsp;<?php if (isset($printer) && $printer != '') echo "<img class=\"pg_printer\" src=\"assets/images/printer.png\" />";?>
    &nbsp;<?php if (isset($excel) && $excel != '') echo "<img class=\"".$excelclass."\" src=\"assets/images/excel.png\" />";?>
</div>