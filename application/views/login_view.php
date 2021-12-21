<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CloudPeta!</title>

    <!-- Font Icon -->
    <link rel="icon" href="<?=base_url('login-temp/')?>images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?=base_url('login-temp/')?>fonts/material-icon/css/material-design-iconic-font.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main css -->
    <link rel="stylesheet" href="<?=base_url('login-temp/')?>css/style.css">


    <style>
        .notify {
            position: absolute;
            top: 60px;
            right: 10px;
            z-index: 555;
        }
    </style>


</head>
<body style="position: relative;">

<div class="notify">
    <?php if ($NOTIFY['msg'] !== null) { ?>
        <div class="alert alert-<?= $NOTIFY['type'] ?> alert-dismissible text-white d-flex align-items-center" role="alert">
            <span class="mx-2">
                <?= match ($NOTIFY['type']) {
                    'danger' => '<i class="fas fa-exclamation-circle fa-2x"></i>',
                    'success' => '<i class="fas fa-check-circle fa-2x"></i>',
                    'warning' => '<i class="fas fa-exclamation-circle fa-2x"></i>',
                    'info' => '<i class="fas fa-info-circle fa-2x"></i>',
                } ?>
            </span>
            <span><?= $NOTIFY['msg'] ?></span>
            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>

<div class="main">

    <div class="paneller" id="girisyap">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="<?=base_url('login-temp/')?>images/cloud1.png" alt="sing up image"></figure>
                        <a onclick="kayit()" class="signup-image-link redHref">Hesap Oluştur</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Hosgeldiniz!</h2>
                        <form method="POST" action="<?=base_url('login/in')?>">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="user" placeholder="Kullanıcı Adı"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" placeholder="Şifre"/>
                            </div>
                            <br>
                            <?= $CAPTCHA['image']?>
                            <div class="form-group">
                                <input type="text" name="captcha" placeholder="captcha"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Giriş Yap"/>
                            </div>

                        </form>
                        <span><button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#sifreModal">Sifremi unuttum</button></span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="paneller" id="kayitol" style="display: none;">

        <!-- Sign up form -->
        <section class="signup" >
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Kayıt Ol</h2>
                        <form method="POST" class="register-form" action="<?=base_url('login/signup')?>">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Kullanıcı Adı"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="E-Posta Adresi"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Şifre"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Şifreyi Tekrar Girin"/>
                            </div>
                            <?= $CAPTCHA['image']?>
                            <div class="form-group">
                                <input type="text" name="captcha" placeholder="captcha"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term form-check-inline"  style="display: inline;"/>
                                <label for="agree-term" class="label-agree-term">
                                    <a id="kvkkOku" class="redHref" style="font-size:unset;">
                                        Tüm hüküm ve koşulları kabul ediyorum.
                                    </a>
                                </label>

                            </div>
                            <div class="form-group form-button">
                                <button type="submit" name="signup" id="signup" class="form-submit" disabled>Kayıt Ol</button>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="<?=base_url('login-temp/')?>images/world.png" alt="sing up image"></figure>
                        <a onclick="giris()" class="signup-image-link redHref">Ben Zaten Üyeyim</a>
                    </div>
                </div>
            </div>
        </section>


    </div>


</div>



<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="kvkkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kişisel Verilerin Korunması Kanunu</h5>
            </div>
            <div class="modal-body">
                DataPeta ŞİRKETİ
                KİŞİSEL VERİLERİN İŞLENMESİNE İLİŞKİN AYDINLATMA METNİ



                İşbu Aydınlatma Metni, DataPeta  Şirketi (“”Şirket”) tarafından Şirket’in müşterilerinin 6698 sayılı Kişisel Verilerin Korunması Kanunu (“Kanun”) kapsamında kişisel verilerinin Şirket tarafından işlenmesine ilişkin olarak aydınlatılması amacıyla hazırlanmıştır.

                Kişisel verilerinizin işbu Aydınlatma Metni kapsamında işlenmesine ilişkin detaylı bilgilere [www…………………….com] adresinde yer alan ……………………………..Şirketi Kişisel Verilerin Korunması ve İşlenmesi Politikası’ndan ulaşabilirsiniz.

                a) Kişisel Verilerin Elde Edilme Yöntemleri ve Hukuki Sebepleri
                Kişisel verileriniz, elektronik veya fiziki ortamda toplanmaktadır. İşbu Aydınlatma Metni’nde belirtilen hukuki sebeplerle toplanan kişisel verileriniz Kanun’un 5. ve 6. maddelerinde belirtilen kişisel veri işleme şartları çerçevesinde işlenebilmekte ve paylaşılabilmektedir.

                b) Kişisel Verilerin İşleme Amaçları
                Kişisel verileriniz, Kanun’un 5. ve 6. maddelerinde belirtilen kişisel veri işleme şartları çerçevesinde Şirket tarafından sunulan ürün ve hizmetlerin ilgili kişilerin beğeni, kullanım alışkanlıkları ve ihtiyaçlarına göre özelleştirilerek ilgili kişilere önerilmesi ve tanıtılması için gerekli olan aktivitelerin planlanması ve icrası, Şirket tarafından sunulan ürün ve hizmetlerden ilgili kişileri faydalandırmak için gerekli çalışmaların iş birimleri tarafından yapılması ve ilgili iş süreçlerinin yürütülmesi, Şirket tarafından yürütülen ticari faaliyetlerin gerçekleştirilmesi için ilgili iş birimleri tarafından gerekli çalışmaların yapılması ve buna bağlı iş süreçlerinin yürütülmesi, Şirket‘in ticari ve/veya iş stratejilerinin planlanması ve icrası ve Şirket‘in ve Şirket‘le iş ilişkisi içerisinde olan ilgili kişilerin hukuki, teknik ve ticari-iş güvenliğinin temini amaçlarıyla işlenmektedir.

                c) Kişisel Verilerin Paylaşılabileceği Taraflar ve Paylaşım Amaçları
                Kişisel verileriniz, Kanun’un 8. ve 9. maddelerinde belirtilen kişisel veri işleme şartları ve amaçları çerçevesinde, Şirket tarafından sunulan ürün ve hizmetlerin ilgili kişilerin beğeni, kullanım alışkanlıkları ve ihtiyaçlarına göre özelleştirilerek ilgili kişilere önerilmesi ve tanıtılması için gerekli olan aktivitelerin planlanması ve icrası, Şirket tarafından sunulan ürün ve hizmetlerden ilgili kişileri faydalandırmak için gerekli çalışmaların iş birimleri tarafından yapılması ve ilgili iş süreçlerinin yürütülmesi, Şirket tarafından yürütülen ticari faaliyetlerin gerçekleştirilmesi için ilgili iş birimleri tarafından gerekli çalışmaların yapılması ve buna bağlı iş süreçlerinin yürütülmesi, Şirket‘in ticari ve/veya iş stratejilerinin planlanması ve icrası ve Şirket‘in ve Şirket‘le iş ilişkisi içerisinde olan ilgili kişilerin hukuki, teknik ve ticari-iş güvenliğinin temini amaçları dahilinde Şirket’in iş ortakları ve tedarikçileri ile hukuken yetkili kurum ve kuruluşlar ile hukuken yetkili özel hukuk tüzel kişileriyle paylaşılabilecektir.

                d) Veri Sahiplerinin Hakları ve Bu Hakların Kullanılması
                Kişisel veri sahipleri olarak aşağıda belirtilen haklarınıza ilişkin taleplerinizi Veri Sahipleri Tarafından Hakların Kullanılması başlığı altında belirtilen yöntemlerle Şirket’e iletmeniz durumunda talepleriniz Şirketimiz tarafından mümkün olan en kısa sürede ve her halde 30 (otuz) gün içerisinde değerlendirilerek sonuçlandırılacaktır.

                Kanun’un 11. maddesi uyarınca kişisel veri sahibi olarak aşağıdaki haklara sahipsiniz:

                Kişisel verilerinizin işlenip işlenmediğini öğrenme,
                Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme,
                Kişisel verilerinizin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme,
                Yurt içinde veya yurt dışında kişisel verilerinizin aktarıldığı üçüncü kişileri bilme,
                Kişisel verilerinizin eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini isteme ve bu kapsamda yapılan işlemin kişisel verilerin aktarıldığı üçüncü kişilere bildirilmesini isteme,
                Kanun ve ilgili diğer kanun hükümlerine uygun olarak işlenmiş olmasına rağmen, işlenmesini gerektiren sebeplerin ortadan kalkması hâlinde kişisel verilerinizin silinmesini veya yok edilmesini isteme ve bu kapsamda yapılan işlemin kişisel verilerin aktarıldığı üçüncü kişilere bildirilmesini isteme,
                İşlenen verilerinizin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle kişinin kendisi aleyhine bir sonucun ortaya çıkmasına itiraz etme,
                Kişisel verilerinizin kanuna aykırı olarak işlenmesi sebebiyle zarara uğraması hâlinde zararın giderilmesini talep etme.
                Kanun’un 28. maddesinin 2. fıkrası veri sahiplerinin talep hakkı bulunmayan halleri sıralamış olup bu kapsamda;
                Kişisel veri işlemenin suç işlenmesinin önlenmesi veya suç soruşturması için gerekli olması,
                İlgili kişinin kendisi tarafından alenileştirilmiş kişisel verilerin işlenmesi,
                Kişisel veri işlemenin kanunun verdiği yetkiye dayanılarak görevli ve yetkili kamu kurum ve kuruluşları ile kamu kurumu niteliğindeki meslek kuruluşlarınca, denetleme veya düzenleme görevlerinin yürütülmesi ile disiplin soruşturma veya kovuşturması için gerekli olması,
                Kişisel veri işlemenin bütçe, vergi ve mali konulara ilişkin olarak Devletin ekonomik ve mali çıkarlarının korunması için gerekli olması,
                hallerinde verilere yönelik olarak yukarıda belirlenen haklar kullanılamayacaktır.
                Kanun’un 28. maddesinin 1. fıkrasına göre ise aşağıdaki durumlarda veriler Kanun kapsamı dışında olacağından, veri sahiplerinin talepleri bu veriler bakımından da işleme alınmayacaktır:
                Kişisel verilerin, üçüncü kişilere verilmemek ve veri güvenliğine ilişkin yükümlülüklere uyulmak kaydıyla gerçek kişiler tarafından tamamen kendisiyle veya aynı konutta yaşayan aile fertleriyle ilgili faaliyetler kapsamında işlenmesi.
                Kişisel verilerin resmi istatistik ile anonim hâle getirilmek suretiyle araştırma, planlama ve istatistik gibi amaçlarla işlenmesi.
                Kişisel verilerin millî savunmayı, millî güvenliği, kamu güvenliğini, kamu düzenini, ekonomik güvenliği, özel hayatın gizliliğini veya kişilik haklarını ihlal etmemek ya da suç teşkil etmemek kaydıyla, sanat, tarih, edebiyat veya bilimsel amaçlarla ya da ifade özgürlüğü kapsamında işlenmesi.
                Kişisel verilerin millî savunmayı, millî güvenliği, kamu güvenliğini, kamu düzenini veya ekonomik güvenliği sağlamaya yönelik olarak kanunla görev ve yetki verilmiş kamu kurum ve kuruluşları tarafından yürütülen önleyici, koruyucu ve istihbari faaliyetler kapsamında işlenmesi.
                Kişisel verilerin soruşturma, kovuşturma, yargılama veya infaz işlemlerine ilişkin olarak yargı makamları veya infaz mercileri tarafından işlenmesi.
                Veri Sahipleri Tarafından Hakların Kullanılması

                Veri sahipleri, yukarıda bahsi geçen hakları kullanmak için [ww……………..………..com] linkinde yer alan “ Kişisel Veri Sahibi Tarafından Veri Sorumlusuna Yapılacak Başvurulara ilişkin Form ”u kullanabileceklerdir.
                Başvurular, ilgili veri sahibinin kimliğini tespit edecek belgelerle birlikte, aşağıdaki yöntemlerden biri ile gerçekleştirilecektir:
                Formun doldurularak ıslak imzalı kopyasının elden, noter aracılığı ile veya iadeli taahhütlü mektupla [………………………………………………………..-Türkiye] adresine iletilmesi,
                Formun 5070 sayılı Elektronik İmza Kanunu kapsamında düzenlenen güvenli elektronik imza ile imzalanarak [……………………..@hs02].kep.tr adresine kayıtlı elektronik posta ile gönderilmesi,
                Kişisel Verileri Koruma Kurulu tarafından öngörülen bir yöntemin izlenmesi.
                Şirket, Kanun’da öngörülmüş sınırlar çerçevesinde söz konusu hakları kullanmak isteyen veri sahiplerine, yine Kanun’da öngörülen şekilde azami otuz (30) gün içerisinde cevap vermektedir. Kişisel veri sahipleri adına üçüncü kişilerin başvuru talebinde bulunabilmesi için veri sahibi tarafından başvuruda bulunacak kişi adına noter kanalıyla düzenlenmiş özel vekâletname bulunmalıdır.
                Veri sahibi başvuruları kural olarak ücretsiz olarak işleme alınmakla birlikte, Kişisel Verileri Koruma Kurulu tarafından öngörülen ücret tarifesi[1] üzerinden ücretlendirme yapılabilecektir.
                Şirket, başvuruda bulunan kişinin kişisel veri sahibi olup olmadığını tespit etmek adına ilgili kişiden bilgi talep edebilir, başvuruda belirtilen hususları netleştirmek adına, kişisel veri sahibine başvurusu ile ilgili soru yöneltebilir.




                [1] 10.03.2018 tarih ve 30356 sayılı Resmi Gazete’de yayınlanan “Veri Sorumlusuna Başvuru Usul ve Esasları Hakkında Tebliğ” uyarınca, veri sahiplerinin başvurusuna yazılı olarak cevap verilecekse, on sayfaya kadar ücret alınmaz. On sayfanın üzerindeki her sayfa için 1 Türk Lirası işlem ücreti alınabilir. Başvuruya cevabın CD, flash bellek gibi bir kayıt ortamında verilmesi halinde Kurum tarafından talep edilebilecek ücret kayıt ortamının maliyetini geçemez.
            </div>
            <div class="modal-footer">
                <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>

            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="sifreModal" tabindex="-1" aria-labelledby="sifreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sifreModalLabel">Şifremi unuttum!?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?=base_url('login/forgotpassword')?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="mail" name="mail" class="form-control" placeholder="Email adresiniz...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- JS -->
<script src="<?=base_url('login-temp/')?>vendor/jquery/jquery.min.js"></script>
<script src="<?=base_url('login-temp/')?>js/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>

    const kayitol = document.getElementById('kayitol');
    const girisyap = document.getElementById('girisyap');

    function giris(){
        kayitol.style.display = 'none';
        girisyap.style.display = 'flex';
    }

    function kayit(){
        kayitol.style.display = 'flex';
        girisyap.style.display = 'none';
    }

</script>


<script>
    $('#kvkkOku').on('click', function(){
        $('#kvkkModal').modal('show');
    });

    $('#closeModal').on('click', function(){
        $('#kvkkModal').modal('hide');
    })
</script>

<script>
    $('#agree-term').click(function () {
        /* document.getElementById("RegisterBtn").style.visibility = 'hidden';*/
        if (document.getElementById("agree-term").checked) {
            document.getElementById("signup").disabled = false;
        } else {
            document.getElementById("signup").disabled = true;
        }

        /*swal("Teşekkür Ederiz!", "Siparişiniz Alınmıştır!", "success");*/
    })
</script>

</body>
</html>