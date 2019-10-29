<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : angsuran.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Angsuran extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksiumum";
        $this->menuactsub = "angsuran";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('angsuran',$data);
	}
    function _loadMenu($parent)
    {
        $hasil = $this->master->getAllMenu($parent);
        if ($hasil)
        {
            $this->isi[] = "<ul>";
            foreach($hasil as $item)
            {
                $groupx = unserialize($item['groups']);
                if (in_array($this->nama_group, $groupx))
                {
                    if($this->menuact == $item['css']){$active = "active";}else{$active = "";}
                    if($item['href'] == "."){
                        $this->isi[] = "<li class=\"start $active\"><a href=\".\"><i class=\"icon-home\"></i> <span class=\"title\">Dashboard</span></a>";
                    }else{
                        $this->isi[] = "<li class=\"has-sub $active\"><a href=\"javascript:;\">".$item['icon']."<span class=\"title\">".$item['nama']."</span><span class=\"arrow\"></span></a>";
                    }
                    $submenu = $this->master->getAllMenu($item['menu_id']);
                    if ($submenu)
                    {
                        $this->isi[] = "<ul class=\"sub\">";
                        foreach($submenu as $item1)
                        {
                            $groupx = unserialize($item['groups']);
                            if (in_array($this->nama_group, $groupx))
                            {
                                if($this->menuactsub == $item1['sub']){$activesub = "class='active'";}else{$activesub = "";}
                                $this->isi[] = "<li $activesub><a href=\"".$item1['href']."\">".$item1['nama']."</a></li>";
                            }
                        }
                        $this->isi[] = "</ul>";
                    }
                }
            }
             $this->isi[] = "</ul>";
        } else {
            $this->isi[] = "</li>";
        }
    }
    //---- Fungsi mengisi option Wilayah
    function isi_wilayah()
    {
        $hasil = $this->db->select('wilayah_id,kode,wilayah_kerja')->get('bmt_wilayah')->result();
        $i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->wilayah_id."\">".$row->kode." - ".$row->wilayah_kerja."</option>";
            $i++;
		}
    }
    function savetunai(){
        $data = $this->allfunct->securePost();
        $realangsuran = $data['pokok'] + $data['margin'];
        $pokok = $data['pokokinfo'];
        $margin = $data['margininfo'];
        
        $data1['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data1['accounttrans_code'] = $data['nomor_ref']." - ".$data['nomor_jurnal'];
        $data1['accounttrans_desc'] = $data['ket'];
        $data1['accounttrans_user'] = $data['nomor_rekening'];
        $data1['create_date'] = date("Y-m-d H:i:s");
        $data1['create_by'] = $this->session->userdata('username');
        $data1['update_by'] = $this->session->userdata('username');
        //$data1['accounttrans_curency'] = $this->session->userdata('cbg');
        
        $data2['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data2['accounttrans_code'] = $data['nomor_ref']." - ".$data['nomor_jurnal'];
        $data2['accounttrans_desc'] = $data['ket'];
        $data2['accounttrans_user'] = $data['nomor_rekening'];
        $data2['create_date'] = date("Y-m-d H:i:s");
        $data2['create_by'] = $this->session->userdata('username');
        $data2['update_by'] = $this->session->userdata('username');
        //$data2['accounttrans_curency'] = $this->session->userdata('cbg');
        
        $data3['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data3['accounttrans_code'] = $data['nomor_ref']." - ".$data['nomor_jurnal'];
        $data3['accounttrans_desc'] = $data['ket'];
        $data3['accounttrans_user'] = $data['nomor_rekening'];
        $data3['create_date'] = date("Y-m-d H:i:s");
        $data3['create_by'] = $this->session->userdata('username');
        $data3['update_by'] = $this->session->userdata('username');
        //$data3['accounttrans_curency'] = $this->session->userdata('cbg');
        
        $data4['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data4['accounttrans_code'] = $data['nomor_ref']." - ".$data['nomor_jurnal'];
        $data4['accounttrans_desc'] = $data['ket'];
        $data4['accounttrans_user'] = $data['nomor_rekening'];
        $data4['create_date'] = date("Y-m-d H:i:s");
        $data4['create_by'] = $this->session->userdata('username');
        $data4['update_by'] = $this->session->userdata('username');
        //$data4['accounttrans_curency'] = $this->session->userdata('cbg');
        
        if($data['jenis_pembiayaan'] == "MURABAHAH"){
            $data1['accounttrans_listid'] = "19";
            $data1['accounttrans_type'] = '02';
            $data1['accounttrans_value'] = $data['jumlah'];
            
            $data2['accounttrans_listid'] = $data['id_jurnal'];
            $data2['accounttrans_type'] = '01';
            $data2['accounttrans_value'] = $data['jumlah'];
            
            $data3['accounttrans_listid'] = $data['gl_marginditangguhkan'];
            $data3['accounttrans_type'] = '02';
            $data3['accounttrans_value'] = $margin;
            
            $data4['accounttrans_listid'] = $data['gl_pendapatanmargin'];
            $data4['accounttrans_type'] = '01';
            $data4['accounttrans_value'] = $margin;
            
            $this->master->simpan('tb_accounttrans',$data1);
        	$this->master->simpan('tb_accounttrans',$data2);
        	$this->master->simpan('tb_accounttrans',$data3);
        	$this->master->simpan('tb_accounttrans',$data4);
            
        }elseif(($data['jenis_pembiayaan'] == "MUDHARABAH")||($data['jenis_pembiayaan'] == "MUSYARAKAH")){
            $data1['accounttrans_listid'] = "19";
            $data1['accounttrans_type'] = '02';
            $data1['accounttrans_value'] = $data['jumlah'];
            
            $data2['accounttrans_listid'] = $data['id_jurnal'];
            $data2['accounttrans_type'] = '01';
            $data2['accounttrans_value'] = $pokok;
            
            $data3['accounttrans_listid'] = $data['gl_pendapatanbagihasil'];
            $data3['accounttrans_type'] = '01';
            $data3['accounttrans_value'] = $margin;
            /*
            $data4['accounttrans_listid'] = '19';
            $data4['accounttrans_type'] = '02';
            $data4['accounttrans_value'] = $margin;
            */
            $this->master->simpan('tb_accounttrans',$data1);
            $this->master->simpan('tb_accounttrans',$data2);
            $this->master->simpan('tb_accounttrans',$data3);
            //$this->master->simpan('tb_accounttrans',$data4);
        }elseif($data['jenis_pembiayaan'] == "AL-QARDH"){
            $data1['accounttrans_listid'] = "19";
            $data1['accounttrans_type'] = '02';
            $data1['accounttrans_value'] = $data['jumlah'];
            
            $data2['accounttrans_listid'] = $data['id_jurnal'];
            $data2['accounttrans_type'] = '01';
            $data2['accounttrans_value'] = $data['jumlah'];
            
            $this->master->simpan('tb_accounttrans',$data1);
            $this->master->simpan('tb_accounttrans',$data2);
        }
        
        $data1['accounttrans_posted'] = "1";
        $data2['accounttrans_posted'] = "1";
        $data3['accounttrans_posted'] = "1";
        $data4['accounttrans_posted'] = "1";
        $this->master->simpan('tb_accounttemp',$data1);
        $this->master->simpan('tb_accounttemp',$data2);
        $this->master->simpan('tb_accounttemp',$data3);
        //$this->master->simpan('tb_accounttemp',$data4);
        
        $id = $data['nomor_jurnal'];
        $data5['status'] = '1';
        $where = array('pembiayaandetail_id' => $id);
        if($data['jumlah'] >= $realangsuran){
        	$this->master->update("tb_pembiayaandetail",$data5,$where);
        }
        echo $this->master->simpan('tb_accounttemp',$data4)."#".$id;
    }
    function run_code()
    {
        $num = $this->db->count_all_results('tb_transaksi') + 1;
        $paddedNum = sprintf("%06d", $num);
        echo  date('m')."".date('y')."".$paddedNum;
    }
    function get_transview()
    {
        $id = $this->input->post('id');
        $coaid = $this->input->post('idproduk');
        $query = $this->db->query("SELECT accounttrans_code,accounttrans_date,accounttrans_value FROM tb_accounttrans WHERE accounttrans_ref=0 AND accounttrans_listid ='".$coaid."' AND accounttrans_user='".$id."' order by accounttrans_date desc");
        $data = $query->result_array();
        //echo $data;
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
    function jumlahangsuran()
    {
        $objord = $this->input->post('id');
        $query = $this->db->query("SELECT pembiayaandetail_id,`jumlah`,pokok,margin FROM tb_pembiayaandetail WHERE id_pembiayaan='".$objord."' AND status='0'");
        $data = $query->result_array();
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
    function jurnalall()
    {
        $data           = $this->allfunct->securePost();
        $id	= $data['id'];
        $query = $this->db->query("SELECT * FROM master_pembiayaan WHERE kode_produk='".$id."'");
        $data = $query->result_array();
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
	function cetak()
    {
    	$query = $this->db->query("SELECT wilayah_kerja FROM bmt WHERE bmt_id =1");
    	$data = $query->result_array();
    	$data1['code_cabang'] = $data[0]["wilayah_kerja"];
    	$data1['teller'] = $this->session->userdata('username');
    	$this->load->view('cetak/validasi',$data1);
    }
    function login()
	{
		$data = $this->allfunct->securePost();
        $login = array($data['username'], $data['password']);
		$resp = $this->authlib->login1($login);
		echo $resp;
	}
    
}

/* End of file */