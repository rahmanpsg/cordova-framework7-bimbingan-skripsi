<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');

/**
 * 
 */
class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");
    }

    public function index()
    {
        // $this->sendGCM('Anda memiliki permintaan bimbingan baru','Silahkan lihat di menu permintaan bimbingan','c1QdSYZ6SSE:APA91bEhm8WUL86GKm3l5oaiPLagXMBs3keFmks_7V8D34h3F0Mn4B96kI8QXJUGYheWIZIk-f4RlJea9YvpgVwg5G6dg4lNsLXYs39LURu6-QCcB2857G2MqRLODS4MoUvx_8Ms9u5q');
        $token = $this->Model->query("SELECT b.token FROM tbl_bimbingan a LEFT JOIN tbl_dosen b ON a.nbm = b.nbm WHERE a.id = 'BB-00001'")[0]['token'];

        echo json_encode($token);
    }

    public function getWaktu()
    {
        echo $this->Model->getWaktu();
    }

    public function login()
    {
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $get = array(
            $this->db->get_where('tbl_mahasiswa', array('nim' => $user, 'password' => $pass))->result_array(),
            $this->db->get_where('tbl_dosen', array('username' => $user, 'password' => $pass))->result_array()
        );

        foreach ($get as $value) {
            $cek[] = $value;
        }

        if (count($cek[0]) >= 1) {
            $res = array(true, 'mahasiswa', $cek[0][0]['nim']);
        } else
        if (count($cek[1]) >= 1) {
            $res = array(true, 'dosen', $cek[1][0]['nbm']);
        } else {
            $res = array(false);
        }

        echo json_encode($res);
    }

    public function manajemenBB()
    {
        if ($this->input->post('manajemen') !== NULL) {
            $form = strtolower($this->input->post('tbl'));
            if ($this->input->post('manajemen') == 'tambah') {
                $data = $this->input->post('data');

                $keys = array_column($data, 'name');
                $values = array_column($data, 'value');

                $tambah = array_combine($keys, $values);

                $query = $this->Model->setTambah('tbl_' . $form, $tambah);

                if ($query) {
                    $token = $this->Model->query("SELECT token FROM tbl_dosen WHERE nbm = '$tambah[nbm]'")[0]['token'];

                    $this->Model->sendGCM("Anda memiliki permintaan bimbingan baru", "Silahkan lihat di menu permintaan", $token);
                }

                echo json_encode($query);
            } else
            if ($this->input->post('manajemen') == 'update') {
                $data = $this->input->post('data');
                $where = $this->input->post('where');

                $keys = array_column($data, 'name');
                $values = array_column($data, 'value');

                $set = array_combine($keys, $values);

                //History
                if ($set['status'] !== NULL) {
                    $history = json_encode(array($set['status'] => $this->Model->getWaktu()));
                    $this->db->set("history", "JSON_MERGE_PATCH(history, '$history')", false);
                }

                $this->db->set($set);

                $this->db->where($where);

                $update = $this->db->update("tbl_{$form}");

                if ($update) {
                    if ($set['status'] !== NULL) {
                        $token = $this->Model->query("SELECT b.token FROM tbl_bimbingan a LEFT JOIN tbl_mahasiswa b ON a.nim = b.nim WHERE a.id = '$where[id]'")[0]['token'];

                        switch ($set['status']) {
                            case 'diterima':
                                $title = 'Bimbingan Skripsi Online';
                                $teks = 'Permintaan bimbingan anda telah diterima oleh pembimbing';
                                $this->Model->sendGCM($title, $teks, $token);
                                break;
                            case 'ditolak':
                                $title = 'Permintaan bimbingan anda ditolak oleh pembimbing';                                
                                $teks = 'Silahkan coba lain waktu';
                                $this->Model->sendGCM($title, $teks, $token);
                                break;
                            case 'diperiksa':
                                $title = 'Dokumen anda telah diperiksa oleh pembimbing';
                                $teks = 'Silahkan lihat hasil pemeriksaan di menu bimbingan';
                                $this->Model->sendGCM($title, $teks, $token);
                                break;
                        }                        
                    }
                }

                echo json_encode($update);
            }
        } else {
            return null;
        }
    }

    public function getDataBimbingan()
    {
        $nbm = $this->input->get('nbm');
        $dataBimbingan = $this->Model->query("SELECT a.nim, b.nama, IF(c.nbm = a.pembimbing_satu,'Pembimbing 1','Pembimbing 2') as pembimbing, SUM(IF(JSON_EXTRACT(history, '$.diterima') IS NULL, 0, 1)) as total, SUM(IF(status = 'diupload', 1, 0)) as total_upload, b.judul FROM tbl_pembimbing a LEFT JOIN tbl_mahasiswa b ON a.nim = b.nim LEFT JOIN tbl_bimbingan c ON a.nim = c.nim WHERE a.pembimbing_satu = '$nbm' OR a.pembimbing_dua = '$nbm' GROUP BY b.nim ORDER BY b.nama ASC");

        echo json_encode($dataBimbingan);
    }

    public function getDaftarDokumen()
    {
        $nim = $this->input->get('nim');
        $nbm = $this->input->get('nbm');

        $data = $this->Model->query("SELECT id, file, JSON_UNQUOTE(JSON_EXTRACT(history, '$.diupload')) as waktu, hasil_periksa FROM tbl_bimbingan WHERE (nim = '$nim' AND nbm = '$nbm') AND (status = 'diupload' OR status = 'diperiksa')");

        echo json_encode($data);
    }

    public function getPermintaanBimbingan()
    {
        $nbm = $this->input->get('nbm');
        $data = $this->Model->query("SELECT a.id, a.nim, b.nama, b.judul, JSON_UNQUOTE(JSON_EXTRACT(a.history, '$.meminta')) as waktu FROM tbl_bimbingan a LEFT JOIN tbl_mahasiswa b ON a.nim = b.nim WHERE a.nbm = '$nbm' AND a.status = 'meminta'");

        echo json_encode($data);
    }

    public function getHistoryBimbingan()
    {
        $nim = $this->input->get('nim');
        $dataBimbingan = $this->Model->query("SELECT a.*, IF(a.nbm = b.pembimbing_satu,'Pembimbing 1','Pembimbing 2') as pembimbing, a.hasil_periksa FROM tbl_bimbingan a LEFT JOIN tbl_pembimbing b ON a.nim = b.nim WHERE a.nim = '$nim'");

        $dataHistory = [];

        foreach ($dataBimbingan as $value) {
            $data = json_decode($value['history']);

            foreach ($data as $k => $v) {
                switch ($k) {
                    case 'meminta':
                        $status = "Meminta bimbingan kepada {$value['pembimbing']}";
                        break;
                    case 'diterima':
                        $status = "Permintaan bimbingan diterima oleh {$value['pembimbing']} dan diarahkan untuk bimbingan {$value['jenis']}";
                        if ($value['jenis'] == 'offline') {
                            $status .= " pada tanggal {$value['waktu']}";
                        }
                        break;
                    case 'ditolak':
                        $status = "Permintaan bimbingan ditolak oleh {$value['pembimbing']}";
                        break;
                    case 'diupload':
                        $status = "Dokumen telah diupload";
                        break;
                    case 'diperiksa':
                        $status = "Dokumen telah diperiksa";
                        break;
                }
                $tgl = $this->Model->formatTanggal($v);

                array_push($dataHistory, array('tanggal' => $tgl[0], 'jam' => $tgl[1], 'status' => $status, 'hasil' => $value['hasil_periksa'], 'id' => $value['id'], 'datetime' => $v));
            }
        }

        // function sortJam($a, $b)
        // {
        //     return strtotime($b["jam"]) - strtotime($a["jam"]);
        // }
        // usort($dataHistory, "sortJam");

        usort($dataHistory, function($a, $b) {
          $ad = new DateTime($a['datetime']);
          $bd = new DateTime($b['datetime']);

          if ($ad == $bd) {
            return 0;
          }

          return $ad > $bd ? -1 : 1;
        });

        $res = [];
        foreach ($dataHistory as $key => $value) {
            $res[$value['tanggal']][$key] = $value;
        }

        // krsort($res);

        echo json_encode($res);
    }

    public function getImgSK()
    {
        $nim = $this->input->get('nim');

        $query = $this->Model->query("SELECT SK FROM tbl_pembimbing WHERE nim = '$nim'")[0]['SK'];

        echo json_encode(base_url('sk/') . $nim . '/' . $query);
    }

    public function uploadDokumen()
    {
        //Proses ke database
        foreach ($_POST as $key => $value) {
            if ($key !== 'manajemen' && $key !== 'nama') {
                $data[$key] = $value;
            }else
            if ($key == 'nama') {
                $nama = $value;
            }
        }

        foreach ($_FILES as $key => $value) {
            $data['file'] = $value['name'];
        }

        //filter file extension
        $fileExtension = ['DOC', 'DOCX'];


        //Proses Upload
        $target_dir = "./berkas/" . $data['id'] . "/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $uploadOk = 1;
        foreach ($_FILES as $key => $value) {
            $target_file = $target_dir . basename($_FILES[$key]["name"]);
            $FileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Check file size
            if ($_FILES[$key]["size"] > 4096000) {
                echo json_encode(array(false, "File terlalu besar (Max 4MB)"));
                $uploadOk = 0;
            } else
                // Check extension
                if (!in_array(strtoupper($FileType), $fileExtension)) {
                    echo json_encode(array(false, "Format file harus (" . join(', ', $fileExtension) . ")"));
                    $uploadOk = 0;
                } else
            if (move_uploaded_file($_FILES[$key]["tmp_name"], $target_file)) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                    echo json_encode(array(false, "File gagal diupload"));
                }
        }

        if ($uploadOk == 1) {
            $where = array('id' => $data['id']);

            //History
            $history = json_encode(array('diupload' => $this->Model->getWaktu()));

            $this->db->set("history", "JSON_MERGE_PATCH(history, '$history')", false);

            $this->db->set($data);

            $this->db->where($where);

            $update = $this->db->update("tbl_bimbingan");

            // $update = $this->Model->setUpdate($data, $where, 'tbl_bimbingan');

            if ($update) {
                $config = $this->Model->query("SELECT b.token, c.nama FROM tbl_bimbingan a LEFT JOIN tbl_dosen b ON a.nbm = b.nbm LEFT JOIN tbl_mahasiswa c ON a.nim = c.nim WHERE a.id = '$data[id]'")[0];
                $this->Model->sendGCM("File dokumen dari $config[nama] telah diupload", "Silahkan periksa dokumen di menu bimbingan", $config['token']);
                echo json_encode(array(true, "File Dokumen berhasil diupload"));
            }
        }
    }


    public function getKodeUpload()
    {
        $nim = $this->input->get('nim');

        $dataUpload = $this->Model->query("SELECT id FROM tbl_bimbingan WHERE nim = '$nim' AND status = 'diterima' AND jenis = 'online'");

        echo json_encode($dataUpload);
    }

    public function cekData()
    {
        $tbl = $this->input->post('tabel');
        $data = $this->input->post('data');

        $keys = array_column($data, 'name');
        $values = array_column($data, 'value');

        $where = array_combine($keys, $values);

        $cek = $this->Model->cekData("tbl_{$tbl}", $where);

        if ($cek > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function getData()
    {
        $tbl = $this->input->get('tabel');
        $select = ($this->input->get('select') !== NULL) ? $this->input->get('select') : '';
        $join = ($this->input->get('join') !== NULL) ? json_decode($this->input->get('join')) : '';
        $where = ($this->input->get('where') !== NULL) ? $this->input->get('where') : '';
        $order = ($this->input->get('sort') !== NULL) ? $this->input->get('sort') : '';

        $data = $this->Model->ambilData($tbl, $select, $join, $where, $order);

        echo json_encode($data);
    }

    public function generate_id()
    {
        if ($this->input->post('tabel') !== NULL) {
            $tbl = $this->input->post('tabel');
            $kode = $this->input->post('kode');
            $panjang = $this->input->post('panjang');

            if ($this->input->post('kolom') !== NULL) {
                $kolom = $this->input->post('kolom');
            } else {
                $kolom = 'id';
            }

            $id = $this->Model->cekRow($tbl, $kolom, $kode, $panjang);

            echo json_encode($id);
        } else {
            redirect('admin');
        }
    }    
}
