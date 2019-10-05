<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : filterlayout.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
?>
<form id="ffilter">
    <div class="control-group">
    &nbsp;&nbsp;
    <?php if (isset($tombol) && $tombol != '') echo $tombol;?>
    <?php if (isset($option) && $option != '') : ?>
    </div>
    <select name="ff" class="jns_filter input-large">
            <?php foreach($option as $item):?>
                <option value=<?php echo $item[0];?>><?php echo $item[1];?></option>
            <?php endforeach;?>
    </select>
    <input  name="if" type="text" class="isi_filter input-xlarge" placeholder="Search">
    <?php endif;?>
    <?php if (isset($periode) && $periode != '') : ?>
        Periode :
        <input name="pawal" size="10" class="tgl m-wrap m-ctrl-medium date-picker" value=""/>
        s/d
        <input name="pakhir" size="10" class="tgl m-wrap m-ctrl-medium date-picker" value=""/>
    <?php endif;?>
    <button data-original-title="Reset" data-placement="Reset" class="reset btn tooltips">GO</button>
</form>