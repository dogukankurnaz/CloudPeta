<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require FCPATH . "vendor/autoload.php";



class Login extends CI_Controller
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
            'pool'          => '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ',

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
                $this->session->set_userdata('authcode', "0");


                $code = rand(100000, 999999);
                $this->login_model->setAuthCode($account[0]['id'], $code);
                $this->sendMail($account[0]['mail'], 'CloudPeta Doğrulama Kodunuz', $this->getHTMLmail("CloudPeta doğrulama kodunuz : ", $code));

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
                $this->sendMail($mail, "CloudPeta Şifreniz", $this->getHTMLmail('Şifre değişimi işlemi yaptığınız için sizin için bir şifre oluşturduk.Şifrenizi girdikten sonra kullanıcı bölümünden değiştirebilirsiniz.', $pass));
            }else{
                $this->setNotify('Email gönderilemedi-mysql, tekrar deneyin', 'danger');
            }
        }else{
            $this->setNotify('Bu mail adresi kayıtlı değil', 'warning');
        }

        redirect(base_url('login'));
    }

    public function sendMail($mail, $subject, $body){
        $objMail = new PHPMailer(true);
        try {
            //Server settings
            $objMail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
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
            $objMail->Subject = $subject;
            $objMail->Body    = $body;

            $objMail->send();
            $this->setNotify('Yeni şifreniz mail adresinize gönderildi. ', 'success');
        } catch (Exception $e) {
            $this->setNotify('Mail gönderilemedi : ' . $objMail->ErrorInfo, 'danger');
        }
    }
    
    
    
    
    
    
//    Şifre değişimi işlemi yaptığınız için sizin için bir şifre oluşturduk.Şifrenizi girdikten sonra kullanıcı bölümünden değiştirebilirsiniz.
    
    
    
    
    private function getHTMLmail($message, $code){


        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;font-family:lato,  helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta name="x-apple-disable-message-reformatting">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="telephone=no" name="format-detection">
<title>CloudPeta</title>
<!--[if (mso 16)]>
<style type="text/css">
a {text-decoration: none;}
</style>
<![endif]-->
<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
<!--[if gte mso 9]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG></o:AllowPNG>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->
<!--[if !mso]> -->
<link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">
<!--<![endif]-->
<style type="text/css">
#outlook a {
padding:0;
}
.ExternalClass {
width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
line-height:100%;
}
.es-button {
mso-style-priority:100!important;
text-decoration:none!important;
}
a[x-apple-data-detectors] {
color:inherit!important;
text-decoration:none!important;
font-size:inherit!important;
font-family:inherit!important;
font-weight:inherit!important;
line-height:inherit!important;
}
.es-desk-hidden {
display:none;
float:left;
overflow:hidden;
width:0;
max-height:0;
line-height:0;
mso-hide:all;
}
[data-ogsb] .es-button {
border-width:0!important;
padding:15px 25px 15px 25px!important;
}
@media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120%!important } h1 { font-size:30px!important; text-align:center } h2 { font-size:26px!important; text-align:center } h3 { font-size:20px!important; text-align:center } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button, button.es-button { font-size:20px!important; display:block!important; border-width:15px 25px 15px 25px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
</style>
</head>
<body style="width:100%;font-family:lato,  helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<div class="es-wrapper-color" style="background-color:#F4F4F4">
<!--[if gte mso 9]>
<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
<v:fill type="tile" color="#f4f4f4"></v:fill>
</v:background>
<![endif]-->
<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top">
<tr class="gmail-fix" height="0" style="border-collapse:collapse">
<td style="padding:0;Margin:0">
<table cellspacing="0" cellpadding="0" border="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:600px">
<tr style="border-collapse:collapse">
<td cellpadding="0" cellspacing="0" border="0" style="padding:0;Margin:0;line-height:1px;min-width:600px" height="0"><img src="https://kucbed.stripocdn.email/content/guids/CABINET_837dc1d79e3a5eca5eb1609bfe9fd374/images/41521605538834349.png" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;max-height:0px;min-height:0px;min-width:600px;width:600px" alt width="600" height="1"></td>
</tr>
</table></td>
</tr>
<tr style="border-collapse:collapse">
<td valign="top" style="padding:0;Margin:0">
<table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
<tr style="border-collapse:collapse">
<td align="left" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px">
<!--[if mso]><table style="width:580px" cellpadding="0" cellspacing="0"><tr><td style="width:282px" valign="top"><![endif]-->
<table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;width:282px">
</td>
</tr>
</table>
<!--[if mso]></td><td style="width:20px"></td><td style="width:278px" valign="top"><![endif]-->
<table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;width:278px">
</td>
</tr>
</table>
<!--[if mso]></td></tr></table><![endif]--></td>
</tr>
</table></td>
</tr>
</table>
<table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:#FFA73B;background-repeat:repeat;background-position:center top">
<tr style="border-collapse:collapse">
<td align="center" bgcolor="#6222CC" style="padding:0;Margin:0;background-color:#6222cc">
<table class="es-header-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
<tr style="border-collapse:collapse">
<td align="left" style="Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td valign="top" align="center" style="padding:0;Margin:0;width:580px">
<table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://kucbed.stripocdn.email/content/guids/3221e643-0fa3-4d93-b491-e206d3077302/images/logo.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="279"></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
<tr style="border-collapse:collapse">
<td style="padding:0;Margin:0;background-color:#6222cc" bgcolor="#6222CC" align="center">
<table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td valign="top" align="center" style="padding:0;Margin:0;width:600px">
<table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#ffffff;border-radius:4px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation">
<tr style="border-collapse:collapse">
<td align="center" style="Margin:0;padding-bottom:5px;padding-left:30px;padding-right:30px;padding-top:35px"><h1 style="Margin:0;line-height:58px;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;font-size:48px;font-style:normal;font-weight:normal;color:#111111">Hoşgeldiniz!</h1></td>
</tr>
<tr style="border-collapse:collapse">
<td bgcolor="#ffffff" align="center" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px;font-size:0">
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td style="padding:0;Margin:0;border-bottom:1px solid #ffffff;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td valign="top" align="center" style="padding:0;Margin:0;width:600px">
<table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:4px;background-color:#ffffff" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff" role="presentation">
<tr style="border-collapse:collapse">
<td class="es-m-txt-l" bgcolor="#ffffff" align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">' . $message . '</p></td>
</tr>
<tr style="border-collapse:collapse">
<td class="es-m-txt-l" align="center" style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:30px">'. $code .'</p></td>
</tr>
<tr style="border-collapse:collapse">
<td class="es-m-txt-l" align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:30px;padding-right:30px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">Bu işlemi siz oluşturmadıysanız lütfen dikkate almayın.</p></td>
</tr>
<tr style="border-collapse:collapse">
<td class="es-m-txt-l" align="left" style="Margin:0;padding-top:20px;padding-left:30px;padding-right:30px;padding-bottom:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">Teşekkür ederiz.</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;line-height:27px;color:#666666;font-size:18px">CloudPeta!</p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td valign="top" align="center" style="padding:0;Margin:0;width:600px">
<table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td align="center" style="Margin:0;padding-top:10px;padding-bottom:20px;padding-left:20px;padding-right:20px;font-size:0">
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td style="padding:0;Margin:0;border-bottom:1px solid #f4f4f4;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px"></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td valign="top" align="center" style="padding:0;Margin:0;width:600px">
<table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#6222cc;border-radius:4px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#6222cc" role="presentation">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-top:30px;padding-left:30px;padding-right:30px"><h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#ffffff">Yardıma ihtiyacınız mı var?</h3></td>
</tr>
<tr style="border-collapse:collapse">
<td esdev-links-color="#ffa73b" align="center" style="padding:0;Margin:0;padding-bottom:30px;padding-left:30px;padding-right:30px"><h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#ffffff!important;"><a href="mailto:cloudpeta@dogukankurnaz.com" style="color: #fff!important;">cloudpeta@dogukankurnaz.com</a></h3></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
<tr style="border-collapse:collapse">
<td align="left" style="Margin:0;padding-top:30px;padding-bottom:30px;padding-left:30px;padding-right:30px">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td valign="top" align="center" style="padding:0;Margin:0;width:540px">
<table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;line-height:21px;color:#666666;font-size:14px"><strong><a target="_blank" href="https://viewstripo.email" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#111111;font-size:14px">Anasayfa</a> - <a target="_blank" href="https://viewstripo.email" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#111111;font-size:14px">İletişim</a>&nbsp;</strong></p></td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;padding-top:25px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato,  helvetica, arial, sans-serif;line-height:21px;color:#666666;font-size:14px;text-align:center">Elazığ/Türkiye</p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
<tr style="border-collapse:collapse">
<td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td valign="top" align="center" style="padding:0;Margin:0;width:560px">
<table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;display:none"></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
</div>
</body>
</html>';
    }
}