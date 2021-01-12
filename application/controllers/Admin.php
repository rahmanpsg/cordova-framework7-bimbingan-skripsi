<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('session');
        $this->db->query("SET sql_mode = '' ");

        if (!$this->session->has_userdata('hasLogin')) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['totalDosen'] = $this->Model->cekTotalData('tbl_dosen');
        $data['totalMhs'] = $this->Model->cekTotalData('tbl_mahasiswa');
        $this->load->view('admin/index', $data);
    }

    public function dosen()
    {
        $data['URL_TBL'] = base_url('api/getData?') . http_build_query(array('tabel' => 'tbl_dosen'));
        $this->load->view('admin/dosen', $data);
    }

    public function mahasiswa()
    {
        $data['URL_TBL'] = base_url('api/getData?') . http_build_query(array('tabel' => 'tbl_mahasiswa'));
        $this->load->view('admin/mahasiswa', $data);
    }

    public function pembimbing()
    {
        $data['URL_TBL'] = base_url('api/getData?') . http_build_query(
            array('select' => 'a.*, b.nama, c.nama as nama_pembimbing_satu, d.nama as nama_pembimbing_dua', 'tabel' => 'tbl_pembimbing a', 'join' => json_encode([['tbl' => 'tbl_mahasiswa b', 'on' => 'a.nim = b.nim'], ['tbl' => 'tbl_dosen c', 'on' => 'a.pembimbing_satu = c.nbm'], ['tbl' => 'tbl_dosen d', 'on' => 'a.pembimbing_dua = d.nbm']]))
        );
        $data['dataMhs'] = $this->Model->ambilData('tbl_mahasiswa', 'nim, nama');
        $data['dataDosen'] = $this->Model->ambilData('tbl_dosen', 'nbm, nama');

        $this->load->view('admin/pembimbing', $data);
    }

    public function manajemen()
    {
        if ($this->input->post('manajemen') !== NULL) {
            $form = strtolower($this->input->post('form'));
            if ($this->input->post('manajemen') == 'tambah') {
                $data = $this->input->post('data');

                $keys = array_column($data, 'name');
                $values = array_column($data, 'value');

                $tambah = $this->Model->setTambah('tbl_' . $form, array_combine($keys, $values));

                echo json_encode(array($tambah, array_combine($keys, $values)));
            } else
			if ($this->input->post('manajemen') == 'update') {
                // $id = $this->input->post('id');
                $data = $this->input->post('data');
                $where = $this->input->post('where');

                $keys = array_column($data, 'name');
                $values = array_column($data, 'value');

                // $where = array('id'=>$id);
                $update = $this->Model->setUpdate(array_combine($keys, $values), $where, 'tbl_' . $form);

                echo json_encode(array($update, array_combine($keys, $values)));
            } else
			if ($this->input->post('manajemen') == "hapus") {
                $where = $this->input->post('where');

                $hapus = $this->Model->setHapus('tbl_' . $form, $where);

                echo json_encode($hapus);
            }
        } else {
            redirect('admin');
        }
    }

    public function manajemenBimbingan()
    {
        if ($this->input->post('manajemen') !== NULL) {
            $form = strtolower($this->input->post('form'));
            if ($this->input->post('manajemen') == 'tambah') {
                foreach ($_POST as $key => $value) {
                    if ($key !== 'manajemen' && $key !== 'sk') {
                        $data[$key] = $value;
                    }
                }                

                //Proses Upload
                $target_dir = "./sk/" . $data['nim'] . "/";
                $upload = $this->Model->uploadFile($target_dir);

                if ($upload == 1) {
                    $data['SK'] = basename($_FILES['sk']["name"]);
                    $tambah = $this->Model->setTambah('tbl_pembimbing', $data);

                    if ($tambah) {
                        echo json_encode(array($tambah, $data));
                    }
                }
            } else
            if ($this->input->post('manajemen') == 'update') {
                foreach ($_POST as $key => $value) {
                    if ($key !== 'manajemen' && $key !== 'sk' && $key !== 'where') {
                        $data[$key] = $value;
                    }
                }
                $where = $this->input->post('where');

                if (count($_FILES) > 0) {
                    if (is_uploaded_file($_FILES['sk']['tmp_name'])) {

                        //Proses Upload
                        $target_dir = "./sk/" . $data['nim'] . "/";
                        $upload = $this->Model->uploadFile($target_dir);

                        if ($upload == 1) {
                            $data['sk'] = basename($_FILES['sk']["name"]);
                        }
                    }
                }

                $update = $this->Model->setUpdate($data, $where, 'tbl_pembimbing');

                if ($update) {
                    echo json_encode(array($update, $data));
                }
            } else
            if ($this->input->post('manajemen') == "hapus") {
                $where = $this->input->post('where');

                $hapus = $this->Model->setHapus('tbl_' . $form, $where);

                if ($hapus) {
                    $target_dir = "./sk/" . $where['nim'] . "/";
                    $this->Model->delete_files($target_dir);

                    echo json_encode($hapus);
                }
            }
        } else {
            redirect('admin');
        }
    }
}
