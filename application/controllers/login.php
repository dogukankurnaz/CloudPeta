<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require FCPATH . "vendor/autoload.php";



class login extends CI_Controller
{
    //Login modeli conscructur yardımıyla controllera çağırıyoruz.
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');


    }

    private function captcha(){
        $this->load->helper('captcha');

        $vals = array(
//            'word'          => 'ss',
            'img_path'      => './captcha/',
            'img_url'       => base_url() . '/captcha/',
            'font_path'     => base_url() . '/fonts/texb.ttf',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 4,
            'font_size'     => 16,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        $this->session->set_userdata('captcha', $cap['word']);
        return array('image' => $cap['image'], 'word' => $cap['word']);
    }


    //sessionlardan bildirimleri çekiyoruz
    private function setNotify($msg, $type)
    {
        $this->session->set_tempdata('msg', $msg);
        $this->session->set_tempdata('type', $type);
    }


    public function index()
    {
        $sess = $this->session->all_userdata();
        if (isset($sess['USERNAME'])) {
            redirect(base_url('drive'));
        }
        //Bildirim varsa değişkene çekiyoruz
        $NOTIFY = array(
            "msg" => $this->session->tempdata('msg'),
            'type' => $this->session->tempdata('type'),
        );
        $this->session->unset_tempdata('msg');
        $this->session->unset_tempdata('type');

        //View'e veri gönderiyoruz
        $data = array(
            "NOTIFY" => $NOTIFY,
            'CAPTCHA' => $this->captcha(),
        );


        $this->load->view('login_view', $data);
    }

    public function in()
    {
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $pass = md5($pass);
        $captcha = $this->input->post('captcha');

        if ($captcha === $this->session->userdata('captcha')){


            $account = $this->login_model->verify($user, $pass);

            if ($account) {
                $this->session->set_userdata('USERNAME', $account[0]['username']);
                $this->session->set_userdata('MAIL', $account[0]['mail']);
                $this->session->set_userdata('ID', $account[0]['id']);
                redirect(base_url('drive'));
            } else {
                $this->setNotify('Yanlış kullanıcı adı veya şifre', 'danger');
                redirect(base_url('login'));
            }
        }else{
            $this->setNotify('Yanlış captcha', 'danger');
            redirect(base_url('login'));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
//        print_r($this->session->all_userdata());
        redirect(base_url('home'));
    }

    public function signup()
    {
        $captcha = $this->input->post('captcha');
        if ($captcha === $this->session->userdata('captcha')){
            $data = array(
                'username' => $this->input->post('name'),
                'mail' => $this->input->post('email'),
                'password' => md5($this->input->post('pass')),
                're_pass' => md5($this->input->post('re_pass')),
            );
            if ($data['re_pass'] === $data['password']) {
                unset($data['re_pass']);
                $kayit = $this->login_model->signup($data);
                if ($kayit) {
                    $this->setNotify('Kayıt başarılı. Giriş Yapabilirisiniz', 'success');
                } else {
                    $this->setNotify('Kaydınız oluşturulumadı', 'danger');
                }
            } else {
                $this->setNotify('Şifreler aynı değil!', 'danger');
            }

        }else{
            $this->setNotify('CAPTCHA geçerli değil!', 'danger');
        }
        redirect(base_url('login'));
    }

    public function forgotpassword(){

        $mail = $this->input->post('mail');


        $checkMail = $this->login_model->checkMail($mail);
        if ($checkMail){
            $pass = uniqid();
            $passMD5 = md5($pass);

            $update = $this->login_model->forgotpassword($mail, array('password' => $passMD5));

            if ($update){
                $objMail = new PHPMailer(true);
                try {
                    //Server settings
                    $objMail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $objMail->isSMTP();                                            //Send using SMTP
                    $objMail->Host       = 'mail.dogukankurnaz.com';                     //Set the SMTP server to send through
                    $objMail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $objMail->Username   = 'cloudpeta@dogukankurnaz.com';                     //SMTP username
                    $objMail->Password   = ';!bK!78p!9u7';                               //SMTP password
                    $objMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $objMail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $objMail->CharSet = 'utf-8';

                    //Recipients
                    $objMail->setFrom('cloudpeta@dogukankurnaz.com', 'CLOUDPETA Drive');
                    $objMail->addAddress($mail);     //Add a recipient
                    $objMail->addReplyTo('cloudpeta@dogukankurnaz.com', 'CLOUDPETA Info');


                    //Content
                    $objMail->isHTML(true);                                  //Set email format to HTML
                    $objMail->Subject = 'CloudPeta Şifreniz';
                    $objMail->Body    = "Yeni şifreniz : <br> <h1>$pass</h1>";

                    $objMail->send();
                    $this->setNotify('Yeni şifreniz mail adresinize gönderildi. ', 'success');
                } catch (Exception $e) {
                    $this->setNotify('Mail gönderilemedi : ' . $objMail->ErrorInfo, 'danger');
                }
            }else{
                $this->setNotify('Email gönderilemedi-mysql, tekrar deneyin', 'danger');
            }
        }else{
            $this->setNotify('Bu mail adresi kayıtlı değil', 'warning');
        }

        redirect(base_url('login'));
    }
}