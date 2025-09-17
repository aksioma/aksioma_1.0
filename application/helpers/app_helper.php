<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

    /*
     * Outputs an array in a user-readable JSON format
     *
     * @param array $array
     */
    if (!function_exists('display_json')) {
        function display_json($array)
        {
            $data = json_indent($array);

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-type: application/json');

            echo $data;
        }
    }

    if (!function_exists('cetak_r')) {
        function cetak_r($data, $die = true)
        {
            echo '<pre>';
            print_r($data);
            if ($die) {
                die();
            }
        }
    }

    if (!function_exists('generate_nama')) {
        function generate_nama($first_name = '', $last_name = '')
        {
            if ($first_name != '' && $last_name != '') {
                return ucfirst(strtolower($first_name)).' '.ucfirst(strtolower($last_name));
            } else {
                return ucfirst(strtolower($first_name)).ucfirst(strtolower($last_name));
            }
        }
    }

    /*
     * Convert an array to a user-readable JSON string
     *
     * @param array $array - The original array to convert to JSON
     * @return string - Friendly formatted JSON string
     */
    if (!function_exists('json_indent')) {
        function json_indent($array = array())
        {
            // make sure array is provided
            if (empty($array)) {
                return null;
            }

            //Encode the string
            $json = json_encode($array);

            $result = '';
            $pos = 0;
            $str_len = strlen($json);
            $indent_str = '  ';
            $new_line = "\n";
            $prev_char = '';
            $out_of_quotes = true;

            for ($i = 0; $i <= $str_len; ++$i) {
                // grab the next character in the string
                $char = substr($json, $i, 1);

                // are we inside a quoted string?
                if ($char == '"' && $prev_char != '\\') {
                    $out_of_quotes = !$out_of_quotes;
                }
                // if this character is the end of an element, output a new line and indent the next line
                elseif (($char == '}' or $char == ']') && $out_of_quotes) {
                    $result .= $new_line;
                    --$pos;

                    for ($j = 0; $j < $pos; ++$j) {
                        $result .= $indent_str;
                    }
                }

                // add the character to the result string
                $result .= $char;

                // if the last character was the beginning of an element, output a new line and indent the next line
                if (($char == ',' or $char == '{' or $char == '[') && $out_of_quotes) {
                    $result .= $new_line;

                    if ($char == '{' or $char == '[') {
                        ++$pos;
                    }

                    for ($j = 0; $j < $pos; ++$j) {
                        $result .= $indent_str;
                    }
                }

                $prev_char = $char;
            }

            // return result
            return $result.$new_line;
        }
    }

    if (!function_exists('convert_ke_bulan')) {
        function convert_ke_bulan($idbulan, $full = false)
        {
            $shortName = array(
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Ags',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des',
            );

            if ($full) {
                $fullName = array(
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember',
            );

                return $fullName[$idbulan - 1];
            }

            return $shortName[$idbulan - 1];
        }
    }

    if (!function_exists('tglIndonesia')) {
        function tglIndonesia($tgldb, $separator_asal = '-', $separator_tujuan = ' ', $full = false)
        {
            if (empty($tgldb) && (strlen($tgldb) < 4)) {
                return null;
            }
            /* $tgldb formatnya 2015-05-29 , rubah menjadi 29-Mei-2015 */
            /* cek apakah mengandung jam atau detik, panjang max = 10 karakter */
            $tgldb = substr($tgldb, 0, 10);

            $tgl = explode($separator_asal, $tgldb);
            if (!(count($tgl) > 1)) {
                return $tgldb;
            }
            $newTgl = array(
                    $tgl[2],
                    convert_ke_bulan($tgl[1], $full),
                    $tgl[0],
            );

            return implode($separator_tujuan, $newTgl);
        }
    }

    if (!function_exists('dateFormatter')) {
        function dateFormatter($tgl, $format = 'Y-m-d')
        {
            if (empty($tgl)) {
                return null;
            }
            /* $tgl formatnya d-m-Y , rubah menjadi Y-m-d atau yang lain */
            $date = new DateTime($tgl);

            $new_date = $date->format($format);

            return $new_date;
        }
    }

    if (!function_exists('prev_date')) {
        function prev_date($date, $minus = 1)
        {
            return date('Y-m-d', strtotime('-'.$minus.' day', strtotime($date)));
        }
    }

    if (!function_exists('next_date')) {
        function next_date($date, $plus = 1)
        {
            return date('Y-m-d', strtotime('+'.$plus.' day', strtotime($date)));
        }
    }

    if (!function_exists('angkaRibuan')) {
        function angkaRibuan($angka, $default = 0)
        {
            if (isset($angka)) {
                if (is_numeric($angka)) {
                    return number_format($angka, 0, '', '.');
                } else {
                    return $angka;
                }
            } else {
                return $default;
            }
        }
    }

    if (!function_exists('angkaDecimal')) {
        function angkaDecimal($angka, $default = 0)
        {
            if (isset($angka)) {
                if (is_numeric($angka)) {
                    return number_format(($angka * 1), $default, ',', '.');
                } else {
                    return $angka;
                }
            } else {
                return $default;
            }
        }
    }

    if (!function_exists('ubahNama')) {
        function ubahNama($filename)
        {
            $ext_pos = strrpos($filename, '.');
            $ext = substr($filename, $ext_pos);
            $filename = substr($filename, 0, $ext_pos);
            $filename = preg_replace('/\s+/', '_', $filename);

            return str_replace('.', '_', $filename).$ext;
            $filename = preg_replace('/\s+/', '_', $filename);

            return str_replace(',', '_', $filename).$ext;
        }
    }

    if (!function_exists('outputJson')) {
        function outputJson($data)
        {
            $CI = &get_instance();
            $CI->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
        }
    }

    if (!function_exists('jamIndonesia')) {
        function jamIndonesia($tgldb, $jmlChar = 5)
        {
            if (empty($tgldb)) {
                return null;
            }
            /* $tgldb formatnya 2015-05-29 , rubah menjadi 29-Mei-2015 */
            /* cek apakah mengandung jam atau detik, panjang max = 10 karakter */
            $tgldb = substr($tgldb, 0, $jmlChar);

            return $tgldb;
        }
    }

    if (!function_exists('dateDifference')) {
        function dateDifference($date_1, $date_2, $differenceFormat = '%a')
        {
            $datetime1 = date_create($date_1);
            $datetime2 = date_create($date_2);

            $interval = date_diff($datetime1, $datetime2);

            return $interval->format($differenceFormat);
        }
    }
    /* convert hari menjadi minggu + hari */
    if (!function_exists('convertUmur')) {
        function convertUmur($hari)
        {
            if (empty($hari)) {
                return 0;
            }

            return strval(floor($hari / 7)).'+'.strval($hari % 7);
        }
    }

    if (!function_exists('convertElemenTglWaktuIndonesia')) {
        function convertElemenTglWaktuIndonesia($a, $detik = false)
        {
            $tgl = null;
            if (!empty($a)) {
                /* cek apakah mengandung waktu */
                $t = explode(' ', $a);
                $tgl = tglIndonesia($t[0], '-', ' ');
                if (!empty($t[1])) {
                    if (!$detik) {
                        $t[1] = substr($t[1], 0, 5);
                    }
                    $tgl .= ' '.$t[1];
                }
            }

            return $tgl;
        }
    }

    if (!function_exists('arr2to1D')) {
        function arr2to1D($arr, $key)
        {
            $tmp = array();
            foreach ($arr as $k) {
                array_push($tmp, $k[$key]);
            }

            return $tmp;
        }
    }

    if (!function_exists('convertArr')) {
        function convertArr($arr, $key)
        {
            $tmp = array();
            foreach ($arr as $val) {
                $id = $val[$key];
                $tmp[$id] = $val;
            }

            return $tmp;
        }
    }

    if (!function_exists('dropdown')) {
        function dropdown($arr, $key, $keytext)
        {
            $tmp = array();
            foreach ($arr as $val) {
                $id = $val[$key];
                $tmp[$id] = $val[$keytext];
            }

            return $tmp;
        }
    }

    if (!function_exists('mapTree')) {
        /** * Assign high numeric IDs to a config item to force appending.
         * * * @param array $array
         *
         * * @return array */
        function mapTree($dataset, $parent = 0)
        {
            $tree = array();
            foreach ($dataset as $id => $node) {
                if ($node->parent_id != $parent) {
                    continue;
                }
                $node->children = mapTree($dataset, $node->id);
                $tree[$id] = $node;
            }

            return $tree;
        }
    }
        if (!function_exists('prepareMenu')) {
            function prepareMenu($tree, $level = 0)
            {
                $data = '
		<ul class="nav side-menu">';
                if ($level > 0) {
                    $data = '
		<ul class="nav child_menu">';
                }

                foreach ($tree as $item) {
                    $classTree = (count($item->children) > 0 && $level == 0) ? 'nav' : 'nav';
                    $spanTree = '';
                    if (count($item->children) > 0) {
                        $spanTree = '<span class="fa fa-chevron-down"></span>';
                    }
                    if (isset($item->header) && !empty($item->header)) {
                        $data .= '
				<li class="header">'.strtoupper($item->header).'</li>
		';
                    }

                    $data .= '
				<li class="'.$classTree.'"><a class="ajax" href="#'.$item->route.'"><i class="'.$item->icon.' dark"></i> '.$item->name.$spanTree.'</a>';

                    if (count($item->children) > 0) {
                        $data .= prepareMenu($item->children, ++$level);
                    }
                    $data .= '</li>
		';
                }

                $data .= '</ul>
		';

                return $data;
            }
        }
        if (!function_exists('generateMenu')) {
            function generateMenu($arr)
            {
                return prepareMenu(mapTree($arr));
            }
        }

        if (!function_exists('convertAction')) {
            function convertAction($value)
            {
                if (empty($value)) {
                    return null;
                }
                $actionDesc = [
                    'T' => 'Telepone',
                    'D' => 'Datang',
                    'I' => 'Info KP',
                    'E' => 'Email',
                ];
                $value = trim($value);

                return isset($actionDesc[$value]) ? $actionDesc[$value] : 'Not defined';
            }
        }

        if (!function_exists('convertTipePembayaran')) {
            function convertTipePembayaran($value)
            {
                if (empty($value)) {
                    return null;
                }
                $description = [
                    'T' => 'Tunai',
                    'KU' => 'kiriman uang/transfer',
                    'C' => 'Cek',
                    'G' => 'Giro',
                ];

                return isset($description[$value]) ? $description[$value] : 'Not defined';
            }
        }

        if (!function_exists('generateLabelStatus')) {
            function generateLabelStatus($data,$status){
                
                $statusLabel = "";
                $elm = '';
                $approval = $data['urutan'] == $data['approval_count'] ? 'Approved' : ($data['urutan']+1);
                    switch ($data['status']) {
                        case $status['active']:
                            $statusLabel = 'Active';
                            $elm = '<span class="label label-warning">'.$statusLabel.' - Persetujuan '.$approval.'</span>';
                            break;
                        case $status['rejected']:
                            $statusLabel = 'Active';
                            $elm = '<span class="label" style="background: #c310fd;">Rejected For Revision</span>';
                            break;
                        case $status['inactive']:
                            $statusLabel = 'Closed';
                            $elm = '<span class="label label-success">'.$statusLabel.' - '.$approval.'</span>';
                            break;
                        case $status['void']:
                            $statusLabel = 'Closed - Cancel';
                            $elm = '<span class="label label-danger"> '.$statusLabel.' </span>';
                            break;
                    }
                    
                return $elm;
            }
        }

        if (!function_exists('sekarang')) {
            function sekarang()
            {
                return new Datetime();
            }
        }

        if (!function_exists('tglSetelah')) {
            function tglSetelah($hari, $tgl = null)
            {
                $date = new \DateTime($tgl);

                return $date->add(new \DateInterval('P'.$hari.'D'));
            }
        }

        if (!function_exists('tglSebelum')) {
            function tglSebelum($hari, $tgl = null)
            {
                $date = new \DateTime($tgl);

                return $date->sub(new \DateInterval('P'.$hari.'D'));
            }
        }

        if (!function_exists('indexDay')) {
            function indexDay($date)
            {
                return date('N', strtotime($date));
            }
        }

        if (!function_exists('form_dropdown2')) {
            /**
             * Drop-down Menu.
             *
             * @param mixed $data
             * @param mixed $options
             * @param mixed $selected
             * @param mixed $extra
             *
             * @return string
             */
            function form_dropdown2($data = '', $options = array(), $selected = array(), $extra = '')
            {
                $defaults = array();

                if (is_array($data)) {
                    if (isset($data['selected'])) {
                        $selected = $data['selected'];
                        unset($data['selected']); // select tags don't have a selected attribute
                    }

                    if (isset($data['options'])) {
                        $options = $data['options'];
                        unset($data['options']); // select tags don't use an options attribute
                    }
                } else {
                    $defaults = array('name' => $data);
                }

                is_array($selected) or $selected = array($selected);
                is_array($options) or $options = array($options);

                // If no selected state was submitted we will attempt to set it automatically
                if (empty($selected)) {
                    if (is_array($data)) {
                        if (isset($data['name'], $_POST[$data['name']])) {
                            $selected = array($_POST[$data['name']]);
                        }
                    } elseif (isset($_POST[$data])) {
                        $selected = array($_POST[$data]);
                    }
                }

                $extra = _attributes_to_string($extra);

                $multiple = (count($selected) > 1 && stripos($extra, 'multiple') === false) ? ' multiple="multiple"' : '';

                $form = '<select '.rtrim(_parse_form_attributes($data, $defaults)).$extra.$multiple.">\n";

                foreach ($options as $key => $val) {
                    $key = (string) $key;

                    if (is_array($val)) {
                        if (empty($val)) {
                            continue;
                        }

                        $form .= '<optgroup label="'.$key."\">\n";

                        foreach ($val as $optgroup_key => $optgroup_val) {
                            $extraOptions = '';
                            if (is_array($optgroup_val)) {
                                $tmpValue = $optgroup_val['text'];
                                $extraOptions = _attributes_to_string($optgroup_val['extra']);
                            } else {
                                $tmpValue = $optgroup_val;
                            }
                            $sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
                            $form .= '<option value="'.html_escape($optgroup_key).'"'.$sel.' '.$extraOptions.'>'
                        .(string) $tmpValue."</option>\n";
                        }

                        $form .= "</optgroup>\n";
                    } else {
                        $form .= '<option value="'.html_escape($key).'"'
                    .(in_array($key, $selected) ? ' selected="selected"' : '').'>'
                    .(string) $val."</option>\n";
                    }
                }

                return $form."</select>\n";
            }
        }

        if (!function_exists('angkaRomawi')) {
            function angkaRomawi($num) {
                $n = intval($num);
                $res = '';
        
                $roman_numerals = array(
                            'M'  => 1000,
                            'CM' => 900,
                            'D'  => 500,
                            'CD' => 400,
                            'C'  => 100,
                            'XC' => 90,
                            'L'  => 50,
                            'XL' => 40,
                            'X'  => 10,
                            'IX' => 9,
                            'V'  => 5,
                            'IV' => 4,
                            'I'  => 1);
            
                foreach ($roman_numerals as $roman => $number) {
                    $matches = intval($n / $number);
            
                    $res .= str_repeat($roman, $matches);
            
                    $n = $n % $number;
                }
            
                return $res;
            }
        }
    if (!function_exists('parseDateTime')) {
        function parseDateTime($string, $timeZone=null) {
            $date = new DateTime(
              $string,
              $timeZone ? $timeZone : new DateTimeZone('UTC')
                // Used only when the string is ambiguous.
                // Ignored if string has a timeZone offset in it.
            );
            if ($timeZone) {
              // If our timeZone was ignored above, force it.
              $date->setTimezone($timeZone);
            }
            return $date;
          }
        }      
          
    
