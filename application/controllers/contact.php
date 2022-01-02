<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require FCPATH . "vendor/autoload.php";


class Contact extends CI_Controller {


    public function index()
    {

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
        );

        $this->load->view('contact_view', $data);
    }

    //sessionlardan bildirimleri çekiyoruz
    private function setNotify($msg, $type)
    {
        $this->session->set_tempdata('msg', $msg);
        $this->session->set_tempdata('type', $type);
    }


    public function contactmail(){
        $name = $this->input->post('name');
        $replyMail = $this->input->post('email');
        $subject = $this->input->post('subject');
        $body = $this->input->post('message');





        $mail = $this->sendMail($replyMail, $subject, $body, $name);

        if ($mail){
            $this->setNotify('İletişim mesajınız kaydedildi. En kısa zamanda tarafınıza dönüş sağlanacaktır', 'success');
        }else{
            $this->setNotify('İletişim maili gönderilemedi', 'danger');
        }
//        redirect(base_url('contact'));
    }




    public function sendMail($replyMail, $subject, $body, $name){
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
            $objMail->setFrom($replyMail, $name);
            $objMail->addAddress('talhacgdem@gmail.com');     //Add a recipient


            //Content
            $objMail->isHTML(true);                                  //Set email format to HTML
            $objMail->Subject = $subject;
            $objMail->Body    = $body;

            $objMail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
