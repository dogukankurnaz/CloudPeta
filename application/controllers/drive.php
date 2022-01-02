<?php
define('FILE_ENCRYPTION_BLOCKS', 10000);

class Drive extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('drive_model');

        $sess = $this->session->all_userdata();
        if (isset($sess['USERNAME'])) {

            $this->USER = (object)array(
                'USERNAME' => $this->session->userdata('USERNAME'),
                'MAIL' => $this->session->userdata('MAIL'),
                'ID' => $this->session->userdata('ID'),
                'CODE' => $this->session->userdata('authcode'),
            );



        } else {
            redirect(base_url('login'));
        }

        //Codeigniter File işlemleri için helper
        $this->load->helper('file');
    }

    private $USER = array();

    private function setNotify($msg, $type)
    {
        $this->session->set_tempdata('msg', $msg);
        $this->session->set_tempdata('type', $type);
    }

    public function index()
    {
        if ($this->USER->CODE !== $this->drive_model->getUserAuth($this->USER->ID)){
            redirect(base_url('drive/auth'));
        }

        $NOTIFY = array(
            "msg" => $this->session->tempdata('msg'),
            'type' => $this->session->tempdata('type'),
        );
        $this->session->unset_tempdata('msg');
        $this->session->unset_tempdata('type');


        $data = array(
            "NOTIFY" => $NOTIFY,
            "USER" => $this->USER,
            "FILES" => $this->addFileIcon($this->drive_model->getFiles($this->USER->ID)),
            "AUTH" => true,
        );

        $this->load->view('drive_view', $data);
    }

    public function verification(){
        $this->session->set_userdata('authcode', $this->input->post('mailcode'));
//            echo $this->USER->CODE;
            redirect(base_url('drive'));
    }


    public function auth(){

        $NOTIFY = array(
            "msg" => $this->session->tempdata('msg'),
            'type' => $this->session->tempdata('type'),
        );
        $this->session->unset_tempdata('msg');
        $this->session->unset_tempdata('type');

        $data = array(
            "NOTIFY" => $NOTIFY,
            "USER" => $this->USER,
            "FILES" => array(),
            "AUTH" => false,
        );
        $this->load->view('drive_view', $data);
    }

    public function changepass(){
        $pass1 = $this->input->post('pass1');
        $pass2 = $this->input->post('pass2');

        if ($pass1 === $pass2){
            $pass = md5($pass1);

            $update = $this->drive_model->changepass($this->USER->ID, $pass);
            if ($update){
                $this->setNotify('Şifreniz Güncellendi', 'success');
            }else{
                $this->setNotify('Şifreniz Güncellenemedi', 'danger');
            }

        }else{
            $this->setNotify('Şifreler birbiriyle aynı değildi...', 'danger');
        }
        redirect(base_url('drive'));
    }

    private function addFileIcon($data)
    {
        $res = array();
        foreach ($data as $datum) {
            $ext = pathinfo($datum['filename'], PATHINFO_EXTENSION);
            $datum['icon'] = $this->getIcon($ext);
            array_push($res, $datum);
        }
        return $res;
    }

    private function getIcon($ext)
    {
        return match ($ext) {
            'rar', 'zip' => 'fa-file-archive',
            'docx', 'doc' => 'fa-file-word',
            'mp4', 'webm', 'mkv', 'flv', 'avi', 'mov', 'wmv', '3gp' => 'fa-file-video',
            'pptx', 'ppt' => 'fa-file-powerpoint',
            'pdf' => 'fa-file-pdf',
            'jpg', 'jpeg', 'png', 'tiff', 'jfif', 'bmp', 'gif', 'eps', => 'fa-file-image',
            'xlsx', 'xls' => 'fa-file-excel',
            'csv' => 'fa-file-csv',
            'html', 'php', 'cs', 'cpp', 'css', 'js', 'scss', 'py', 'asp', 'aspx' => 'fa-file-code',
            'mp3' => 'fa-file-audio',
            default => 'fa-file-alt'
        };
    }

    public function loadfile()
    {
        $KEY = md5(uniqid()); // PHP uniqid() fonksiyonu ile 13 haneli key oluşturup bunu md5 ile değişkene aktarıyoruz
        $path = APPPATH . "../drivebase/" . $this->USER->ID . "/";
        if (!is_dir($path)) {
            mkdir($path);
        }

        $filename = $_FILES['file']['name'];

//        CODEIGNITER FILE UPLOAD KÜTÜPHANESİ
        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $newFileName = "en_" . $filename;
            $this->encryptFile($path . $filename, $KEY, $path . $newFileName);
            unlink($path . $filename);

            $data = array(
                'filename' => $filename,
                'filedecrypt' => $KEY,
                'date' => date('Y-m-d H:i:s'),
                'userID' => $this->USER->ID,
            );
            $insert = $this->drive_model->insert($data);
            if ($insert) {
                $this->setNotify("Başarılı! Dosya Yüklendi", 'success');
            } else {
                $this->setNotify("Hata! Veritabanına kaydedilemedi..", 'danger');
            }
        } else {
            $this->setNotify($this->upload->display_errors(), 'danger');
        }

        echo true;
    }

    public function download($id)
    {
        $fileArray = $this->drive_model->getFile($id);


        $key = $fileArray['filedecrypt'];

        $path = APPPATH . "../drivebase/" . $this->USER->ID . "/";
        $fileName = $fileArray['filename'];
        $fileNameEn = "en_" . $fileName;
        $pathEn = $path . $fileNameEn;
        $this->decryptFile($pathEn, $key, $path . $fileName);

        $this->downloadFile($path . $fileName);

        unlink($path . $fileName);

        redirect(base_url('drive'));
    }

    public function delete($id){
        $file = $this->drive_model->getFile($id);
        $path = APPPATH . "../drivebase/" . $this->USER->ID . "/";
        unlink($path . "en_" . $file['filename']);
        $this->drive_model->delete($id);
        redirect(base_url('drive'));
    }

// şifreleme işlemleri
    private function encryptFile($source, $key, $dest)
    {
        $key = substr(sha1($key, true), 0, 16);
        $iv = openssl_random_pseudo_bytes(16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($source, 'rb')) { // READ BYTE İLE DOSYAYI AÇIYORUZ
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, 16 * FILE_ENCRYPTION_BLOCKS);
                    $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $dest;
    }

    private function decryptFile($source, $key, $dest)
    {
        $key = substr(sha1($key, true), 0, 16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            if ($fpIn = fopen($source, 'rb')) {
                $iv = fread($fpIn, 16);
                while (!feof($fpIn)) {
                    $ciphertext = fread($fpIn, 16 * (FILE_ENCRYPTION_BLOCKS + 1));
                    $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $plaintext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $dest;
    }

    private function downloadFile($filename)
    {

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Content-Length: ' . filesize($filename));
            header('Pragma: public');

            flush();

            readfile($filename);
    }
}