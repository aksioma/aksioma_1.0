<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : table_layout.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
?>
<table class="table table-striped table-bordered table-hover">
    <thead>
       <?php if (isset($jumrow) && $jumrow != ''): // Multi Row Table Head ?>
         <?php for ($i= 1; $i <= $jumrow ; $i++) : ?>
         <tr>
               <?php foreach($tabel_head as $item): ?>
                   <?php if ($item[3] == $i) :?>
                       <th 
                       <?php
                            if ($item[0] != "") echo "id=\"".$item[0]."\"";
                            if ($item[1] != "") echo "width=\"".$item[1]."\"";
                            if ($item[4] != "") echo $item[4];
                       ?>
                       ><?php echo $item[2];?></th>
                   <?php endif;?>
               <?php endforeach;?>
         </tr>
         <?php endfor;?>
      <?php else : // Normal Table Head ?>
         <tr>
               <?php foreach($tabel_head as $item):?>
               <th 
               <?php
                    if ($item[0] != "") echo "id=\"".$item[0]."\"";
                    if ($item[1] != "") echo "width=\"".$item[1]."\"";
               ?>
               ><?php echo $item[2];?></th>
               <?php endforeach;?>
         </tr>
      <?php endif; ?>
    </thead>
    <tbody class="tbl_body"></tbody>
</table>