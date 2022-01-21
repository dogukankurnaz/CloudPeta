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

    //------------------------Şifreyi Değiştir----------------------------
    public function changepass(){
        //Kullanıcıdan yeni şifresini ve şifre tekrarını girmesini istiyoruz.
        $pass1 = $this->input->post('pass1');
        $pass2 = $this->input->post('pass2');

        if ($pass1 === $pass2){//Girmiş olduğu iki şifre eşleşiyor mu diye kontrol ediyoruz.
            $pass = md5($pass1);//Kullanıcının yeni şifresini md5 ile şifreliyoruz.

            $update = $this->drive_model->changepass($this->USER->ID, $pass);//Yeni şifreyi veri tabanına kaydediyoruz.
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
    //------------------------END--------------------------------------

    //------------------------Dosya Resmi------------------------------
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
    //------------------------END--------------------------------------

    //--------------------Dosya Resim Ayarları-------------------------
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
    //------------------------END--------------------------------------


    //------------------------Upload--------------------------------
    public function loadfile()
    {
        $KEY = md5(uniqid()); // PHP uniqid() fonksiyonu ile 13 haneli key oluşturup bunu md5 şifreliyoruz.
        $path = APPPATH . "../drivebase/" . $this->USER->ID . "/";//Kullanıcının upload etmek istediği dosya için bir yol belirliyoruz.
        if (!is_dir($path)) {//Eğer bu dosya yolu yoksa oluşturuyoruz.
            mkdir($path);
        }

        $filename = $_FILES['file']['name'];//Dosyanın adını alıyoruz.

        //CODEIGNITER FILE UPLOAD KÜTÜPHANESİNİ kullanarak upload işlemini yapıyoruz.
        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $newFileName = "en_" . $filename;//Dosyanın adının başına "en_" koyuyoruz.Şifreli dosyamızın adı bu olacak.
            $this->encryptFile($path . $filename, $KEY, $path . $newFileName);//Şifrelemek istediğimiz dosyayı,yolunu ve şifreli dosyayı nereye kaydedeceğimizi belirtip.
            //"encryptFile" fonksyonuna yolluyoruz.
            unlink($path . $filename);//Şifresiz dosyayı siliyoruz.

            $data = array(
                'filename' => $filename,
                'filedecrypt' => $KEY,
                'date' => date('Y-m-d H:i:s'),
                'userID' => $this->USER->ID,
            );
            $insert = $this->drive_model->insert($data);//Upload edilen dosyanın bilgilerini veri tabanına kaydediyoruz.
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
    //------------------------END--------------------------------------

    //------------------------Download--------------------------------------
    public function download($id)
    {
        $fileArray = $this->drive_model->getFile($id);//İndirmek istediği dosyanın bilgilerini alıyoruz.


        $key = $fileArray['filedecrypt'];

        $path = APPPATH . "../drivebase/" . $this->USER->ID . "/";
        $fileName = $fileArray['filename'];
        $fileNameEn = "en_" . $fileName;
        $pathEn = $path . $fileNameEn;
        $this->decryptFile($pathEn, $key, $path . $fileName);//Dosyanın şifresini çözmek için "decryptFile" fonksyonuna gönderiyoruz.

        $this->downloadFile($path . $fileName);//Şifresi çözülmüş dosyayı indiriyoruz.

        unlink($path . $fileName);//Şifresi çözülmüş dosyayı siliyoruz.Sadece elimizde şifreli dosya kalıyor.

        redirect(base_url('drive'));
    }
    //------------------------END--------------------------------------

    //------------------------Delete--------------------------------------
    public function delete($id){
        $file = $this->drive_model->getFile($id);//Silmek istediğimiz dosyanın bilgilerini alıyoruz.
        $path = APPPATH . "../drivebase/" . $this->USER->ID . "/";
        unlink($path . "en_" . $file['filename']);//Dosyayı siliyoruz.
        $this->drive_model->delete($id);//Dosya bilgilerini veri tabanından siliyoruz.
        redirect(base_url('drive'));
    }    //------------------------END--------------------------------------

    //-----------------------Şifreleme---------------------------------
    private function encryptFile($source, $key, $dest)
    {
        $key = substr(sha1($key, true), 0, 16);//Dosyaya özel oluşturduğumuz şifreyi sha1 algoritması ile tekrar şifreliyoruz.
        $iv = openssl_random_pseudo_bytes(16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {//Dosyayı şifrelemek için yazma modunda açıyoruz.
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($source, 'rb')) { // READ BYTE İLE DOSYAYI AÇIYORUZ
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, 16 * FILE_ENCRYPTION_BLOCKS);
                    $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);//AES algoritması ve oluşturduğumuz keyi kullanarak şifreliyoruz.
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
    //------------------------END--------------------------------------

    //------------------------Şifre Çözme----------- ------------------
    private function decryptFile($source, $key, $dest)
    {
        $key = substr(sha1($key, true), 0, 16);//Dosyaya özel oluşturduğumuz şifreyi sha1 algoritması ile tekrar şifreliyoruz.

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {//Dosyanın şifresini çözmek için yazma modunda açıyoruz.
            if ($fpIn = fopen($source, 'rb')) {
                $iv = fread($fpIn, 16);
                while (!feof($fpIn)) {
                    $ciphertext = fread($fpIn, 16 * (FILE_ENCRYPTION_BLOCKS + 1));
                    $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);// AES algoritması ve oluşturduğumuz keyi kullanarak şifresini çözüyoruz.
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
    //------------------------END--------------------------------------

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