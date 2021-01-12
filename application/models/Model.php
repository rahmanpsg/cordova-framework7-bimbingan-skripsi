<?php

/**
 * 
 */
class Model extends CI_Model
{
    function query($query)
    {
        $res = $this->db->query($query)->result_array();
        return $res;
    }

    function ambilData($tbl, $select = '*', $join = [], $where = [], $order = '')
    {
        $this->db->select($select);
        $this->db->from($tbl);
        if (!empty($join)) {
            foreach ($join as $val) {
                $this->db->join($val->tbl, $val->on, 'left');
            }
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($order != '') {
            $this->db->order_by($order);
        }
        $res = $this->db->get()->result_array();

        return $res;
    }

    function setTambah($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function setUpdate($data, $where, $table)
    {
        $this->db->set($data);
        $this->db->where($where);
        return $this->db->update($table);
    }

    function setHapus($table, $data)
    {
        return $this->db->delete($table, $data);
    }

    function cekData($tbl, $where)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get_where($tbl, $where);
        return $res->result_array()[0]['total'];
    }

    function cekTotalData($tbl)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get($tbl);
        return $res->result_array()[0]['total'];
    }

    function cekRow($table, $kolom, $val, $panjang)
    {
        $query = "SELECT * FROM $table";
        $row = $this->db->query($query)->num_rows() + 1;

        do {
            $no = str_pad($row, $panjang, '0', STR_PAD_LEFT);
            $id = $val . '-' . $no;
            $cek = "SELECT * FROM $table where $kolom = '$id'";
            $query_cek = $this->db->query($cek)->num_rows();
            $row++;
        } while ($query_cek > 0);
        return $id;
    }

    function sendGCM($title,$body, $token) {
        $config = $this->ambilData('tbl_firebase')[0];
        $url = $config['URL'];

        $serverKey = $config['API_KEY'];

        $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');

        $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');

        $json = json_encode($arrayToSend);

        $headers = array();

        $headers[] = 'Content-Type: application/json';

        $headers[] = 'Authorization: key='. $serverKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Send the request
        curl_exec($ch);
        
        curl_close($ch);
    }

    function uploadFile($target_dir)
    {
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $uploadOk = 1;
        foreach ($_FILES as $key => $value) {
            $target_file = $target_dir . basename($_FILES[$key]["name"]);

            // Check file size
            if ($_FILES[$key]["size"] > 2097152) {
                echo json_encode(array("gagal", "File " . basename($_FILES[$key]["name"]) . " terlalu besar (Max 2MB)"));
                $uploadOk = 0;
                break;
            } else
                    if (move_uploaded_file($_FILES[$key]["tmp_name"], $target_file)) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                echo json_encode(array("gagal", "File gagal diupload"));
                break;
            }
        }

        return $uploadOk;
    }

    function delete_files($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

            foreach ($files as $file) {
                $this->delete_files($file);
            }

            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
    }

    function getWaktu()
    {
        date_default_timezone_set('Asia/Makassar');
        $waktu = date('Y-m-d H:i:s');

        return $waktu;
    }

    function formatTanggal($tanggal)
    {
        $bulan = array(
            1 =>   'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        );
        $tanggal = explode(' ', $tanggal);
        $split    = explode('-', $tanggal[0]);
        $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]];

        return array($tgl_indo, $tanggal[1]);
    }
}
