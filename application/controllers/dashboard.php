<?php 

    class Dashboard extends CI_Controller{

        //ini adalah controller dengan nama file dashboard disimpan di folder C:\xampp\htdocs\asisten\application\controllers\

        public function __construct(){
            parent::__construct();
   
            if($this->session->userdata('role_id') != '2'){
               $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
               Anda belum login!
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>');
             redirect('auth/login');
            
        }      
        }

        public function tambah_ke_keranjang($id)
        {
            $asisten = $this->model_asisten->find($id);

            $data = array(
                'id'      => $asisten->id_art,
                'qty'     => 1,
                'price'   => $asisten->harga,
                'name'    => $asisten->nama_art,
);

        $this->cart->insert($data);
        redirect('welcome');
     }

     public function detail_keranjang()
     {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('keranjang');
        $this->load->view('templates/footer');
     }

     public function hapus_keranjang()
     {
         $this->cart->destroy();
         redirect('welcome');
     }

     public function pembayaran()
     {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('pembayaran');
        $this->load->view('templates/footer');
     }

     public function proses_pesanan()
     {
        $is_processed = $this->model_invoice->index();
        if($is_processed){

            $this->cart->destroy();
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('proses_pesanan');
            $this->load->view('templates/footer');
        } else {
            echo "Maaf, Pesanan Asisten Anda Gagal diroses!!!";
        }
     }

     public function detail($id_art)
     {
         $data['asisten'] = $this->model_asisten->detail_art($id_art);
            
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('detail_asisten',$data);
            $this->load->view('templates/footer');
     }
}

    