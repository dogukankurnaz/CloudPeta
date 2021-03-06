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
                        <a onclick="kayit()" class="signup-image-link redHref">Hesap Olu??tur</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Hosgeldiniz!</h2>
                        <form method="POST" action="<?=base_url('login/in')?>">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="user" placeholder="Kullan??c?? Ad??"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" placeholder="??ifre"/>
                            </div>
                            <br>
                            <?= $CAPTCHA['image']?>
                            <div class="form-group">
                                <input type="text" name="captcha" placeholder="captcha"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Giri?? Yap"/>
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
                        <h2 class="form-title">Kay??t Ol</h2>
                        <form method="POST" class="register-form" action="<?=base_url('login/signup')?>">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Kullan??c?? Ad??"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="E-Posta Adresi"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="??ifre"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="??ifreyi Tekrar Girin"/>
                            </div>
                            <?= $CAPTCHA['image']?>
                            <div class="form-group">
                                <input type="text" name="captcha" placeholder="captcha"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term form-check-inline"  style="display: inline;"/>
                                <label for="agree-term" class="label-agree-term">
                                    <a id="kvkkOku" class="redHref" style="font-size:unset;">
                                        T??m h??k??m ve ko??ullar?? kabul ediyorum.
                                    </a>
                                </label>

                            </div>
                            <div class="form-group form-button">
                                <button type="submit" name="signup" id="signup" class="form-submit" disabled>Kay??t Ol</button>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="<?=base_url('login-temp/')?>images/world.png" alt="sing up image"></figure>
                        <a onclick="giris()" class="signup-image-link redHref">Ben Zaten ??yeyim</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Ki??isel Verilerin Korunmas?? Kanunu</h5>
            </div>
            <div class="modal-body">
                DataPeta ????RKET??
                K??????SEL VER??LER??N ????LENMES??NE ??L????K??N AYDINLATMA METN??



                ????bu Ayd??nlatma Metni, DataPeta  ??irketi (????????irket???) taraf??ndan ??irket???in m????terilerinin 6698 say??l?? Ki??isel Verilerin Korunmas?? Kanunu (???Kanun???) kapsam??nda ki??isel verilerinin ??irket taraf??ndan i??lenmesine ili??kin olarak ayd??nlat??lmas?? amac??yla haz??rlanm????t??r.

                Ki??isel verilerinizin i??bu Ayd??nlatma Metni kapsam??nda i??lenmesine ili??kin detayl?? bilgilere [www????????????????????????.com] adresinde yer alan ?????????????????????????????????..??irketi Ki??isel Verilerin Korunmas?? ve ????lenmesi Politikas?????ndan ula??abilirsiniz.

                a) Ki??isel Verilerin Elde Edilme Y??ntemleri ve Hukuki Sebepleri
                Ki??isel verileriniz, elektronik veya fiziki ortamda toplanmaktad??r. ????bu Ayd??nlatma Metni???nde belirtilen hukuki sebeplerle toplanan ki??isel verileriniz Kanun???un 5. ve 6. maddelerinde belirtilen ki??isel veri i??leme ??artlar?? ??er??evesinde i??lenebilmekte ve payla????labilmektedir.

                b) Ki??isel Verilerin ????leme Ama??lar??
                Ki??isel verileriniz, Kanun???un 5. ve 6. maddelerinde belirtilen ki??isel veri i??leme ??artlar?? ??er??evesinde ??irket taraf??ndan sunulan ??r??n ve hizmetlerin ilgili ki??ilerin be??eni, kullan??m al????kanl??klar?? ve ihtiya??lar??na g??re ??zelle??tirilerek ilgili ki??ilere ??nerilmesi ve tan??t??lmas?? i??in gerekli olan aktivitelerin planlanmas?? ve icras??, ??irket taraf??ndan sunulan ??r??n ve hizmetlerden ilgili ki??ileri faydaland??rmak i??in gerekli ??al????malar??n i?? birimleri taraf??ndan yap??lmas?? ve ilgili i?? s??re??lerinin y??r??t??lmesi, ??irket taraf??ndan y??r??t??len ticari faaliyetlerin ger??ekle??tirilmesi i??in ilgili i?? birimleri taraf??ndan gerekli ??al????malar??n yap??lmas?? ve buna ba??l?? i?? s??re??lerinin y??r??t??lmesi, ??irket???in ticari ve/veya i?? stratejilerinin planlanmas?? ve icras?? ve ??irket???in ve ??irket???le i?? ili??kisi i??erisinde olan ilgili ki??ilerin hukuki, teknik ve ticari-i?? g??venli??inin temini ama??lar??yla i??lenmektedir.

                c) Ki??isel Verilerin Payla????labilece??i Taraflar ve Payla????m Ama??lar??
                Ki??isel verileriniz, Kanun???un 8. ve 9. maddelerinde belirtilen ki??isel veri i??leme ??artlar?? ve ama??lar?? ??er??evesinde, ??irket taraf??ndan sunulan ??r??n ve hizmetlerin ilgili ki??ilerin be??eni, kullan??m al????kanl??klar?? ve ihtiya??lar??na g??re ??zelle??tirilerek ilgili ki??ilere ??nerilmesi ve tan??t??lmas?? i??in gerekli olan aktivitelerin planlanmas?? ve icras??, ??irket taraf??ndan sunulan ??r??n ve hizmetlerden ilgili ki??ileri faydaland??rmak i??in gerekli ??al????malar??n i?? birimleri taraf??ndan yap??lmas?? ve ilgili i?? s??re??lerinin y??r??t??lmesi, ??irket taraf??ndan y??r??t??len ticari faaliyetlerin ger??ekle??tirilmesi i??in ilgili i?? birimleri taraf??ndan gerekli ??al????malar??n yap??lmas?? ve buna ba??l?? i?? s??re??lerinin y??r??t??lmesi, ??irket???in ticari ve/veya i?? stratejilerinin planlanmas?? ve icras?? ve ??irket???in ve ??irket???le i?? ili??kisi i??erisinde olan ilgili ki??ilerin hukuki, teknik ve ticari-i?? g??venli??inin temini ama??lar?? dahilinde ??irket???in i?? ortaklar?? ve tedarik??ileri ile hukuken yetkili kurum ve kurulu??lar ile hukuken yetkili ??zel hukuk t??zel ki??ileriyle payla????labilecektir.

                d) Veri Sahiplerinin Haklar?? ve Bu Haklar??n Kullan??lmas??
                Ki??isel veri sahipleri olarak a??a????da belirtilen haklar??n??za ili??kin taleplerinizi Veri Sahipleri Taraf??ndan Haklar??n Kullan??lmas?? ba??l?????? alt??nda belirtilen y??ntemlerle ??irket???e iletmeniz durumunda talepleriniz ??irketimiz taraf??ndan m??mk??n olan en k??sa s??rede ve her halde 30 (otuz) g??n i??erisinde de??erlendirilerek sonu??land??r??lacakt??r.

                Kanun???un 11. maddesi uyar??nca ki??isel veri sahibi olarak a??a????daki haklara sahipsiniz:

                Ki??isel verilerinizin i??lenip i??lenmedi??ini ????renme,
                Ki??isel verileriniz i??lenmi??se buna ili??kin bilgi talep etme,
                Ki??isel verilerinizin i??lenme amac??n?? ve bunlar??n amac??na uygun kullan??l??p kullan??lmad??????n?? ????renme,
                Yurt i??inde veya yurt d??????nda ki??isel verilerinizin aktar??ld?????? ??????nc?? ki??ileri bilme,
                Ki??isel verilerinizin eksik veya yanl???? i??lenmi?? olmas?? h??linde bunlar??n d??zeltilmesini isteme ve bu kapsamda yap??lan i??lemin ki??isel verilerin aktar??ld?????? ??????nc?? ki??ilere bildirilmesini isteme,
                Kanun ve ilgili di??er kanun h??k??mlerine uygun olarak i??lenmi?? olmas??na ra??men, i??lenmesini gerektiren sebeplerin ortadan kalkmas?? h??linde ki??isel verilerinizin silinmesini veya yok edilmesini isteme ve bu kapsamda yap??lan i??lemin ki??isel verilerin aktar??ld?????? ??????nc?? ki??ilere bildirilmesini isteme,
                ????lenen verilerinizin m??nhas??ran otomatik sistemler vas??tas??yla analiz edilmesi suretiyle ki??inin kendisi aleyhine bir sonucun ortaya ????kmas??na itiraz etme,
                Ki??isel verilerinizin kanuna ayk??r?? olarak i??lenmesi sebebiyle zarara u??ramas?? h??linde zarar??n giderilmesini talep etme.
                Kanun???un 28. maddesinin 2. f??kras?? veri sahiplerinin talep hakk?? bulunmayan halleri s??ralam???? olup bu kapsamda;
                Ki??isel veri i??lemenin su?? i??lenmesinin ??nlenmesi veya su?? soru??turmas?? i??in gerekli olmas??,
                ??lgili ki??inin kendisi taraf??ndan alenile??tirilmi?? ki??isel verilerin i??lenmesi,
                Ki??isel veri i??lemenin kanunun verdi??i yetkiye dayan??larak g??revli ve yetkili kamu kurum ve kurulu??lar?? ile kamu kurumu niteli??indeki meslek kurulu??lar??nca, denetleme veya d??zenleme g??revlerinin y??r??t??lmesi ile disiplin soru??turma veya kovu??turmas?? i??in gerekli olmas??,
                Ki??isel veri i??lemenin b??t??e, vergi ve mali konulara ili??kin olarak Devletin ekonomik ve mali ????karlar??n??n korunmas?? i??in gerekli olmas??,
                hallerinde verilere y??nelik olarak yukar??da belirlenen haklar kullan??lamayacakt??r.
                Kanun???un 28. maddesinin 1. f??kras??na g??re ise a??a????daki durumlarda veriler Kanun kapsam?? d??????nda olaca????ndan, veri sahiplerinin talepleri bu veriler bak??m??ndan da i??leme al??nmayacakt??r:
                Ki??isel verilerin, ??????nc?? ki??ilere verilmemek ve veri g??venli??ine ili??kin y??k??ml??l??klere uyulmak kayd??yla ger??ek ki??iler taraf??ndan tamamen kendisiyle veya ayn?? konutta ya??ayan aile fertleriyle ilgili faaliyetler kapsam??nda i??lenmesi.
                Ki??isel verilerin resmi istatistik ile anonim h??le getirilmek suretiyle ara??t??rma, planlama ve istatistik gibi ama??larla i??lenmesi.
                Ki??isel verilerin mill?? savunmay??, mill?? g??venli??i, kamu g??venli??ini, kamu d??zenini, ekonomik g??venli??i, ??zel hayat??n gizlili??ini veya ki??ilik haklar??n?? ihlal etmemek ya da su?? te??kil etmemek kayd??yla, sanat, tarih, edebiyat veya bilimsel ama??larla ya da ifade ??zg??rl?????? kapsam??nda i??lenmesi.
                Ki??isel verilerin mill?? savunmay??, mill?? g??venli??i, kamu g??venli??ini, kamu d??zenini veya ekonomik g??venli??i sa??lamaya y??nelik olarak kanunla g??rev ve yetki verilmi?? kamu kurum ve kurulu??lar?? taraf??ndan y??r??t??len ??nleyici, koruyucu ve istihbari faaliyetler kapsam??nda i??lenmesi.
                Ki??isel verilerin soru??turma, kovu??turma, yarg??lama veya infaz i??lemlerine ili??kin olarak yarg?? makamlar?? veya infaz mercileri taraf??ndan i??lenmesi.
                Veri Sahipleri Taraf??ndan Haklar??n Kullan??lmas??

                Veri sahipleri, yukar??da bahsi ge??en haklar?? kullanmak i??in [ww???????????????..?????????..com] linkinde yer alan ??? Ki??isel Veri Sahibi Taraf??ndan Veri Sorumlusuna Yap??lacak Ba??vurulara ili??kin Form ???u kullanabileceklerdir.
                Ba??vurular, ilgili veri sahibinin kimli??ini tespit edecek belgelerle birlikte, a??a????daki y??ntemlerden biri ile ger??ekle??tirilecektir:
                Formun doldurularak ??slak imzal?? kopyas??n??n elden, noter arac??l?????? ile veya iadeli taahh??tl?? mektupla [???????????????????????????????????????????????????????????????..-T??rkiye] adresine iletilmesi,
                Formun 5070 say??l?? Elektronik ??mza Kanunu kapsam??nda d??zenlenen g??venli elektronik imza ile imzalanarak [????????????????????????..@hs02].kep.tr adresine kay??tl?? elektronik posta ile g??nderilmesi,
                Ki??isel Verileri Koruma Kurulu taraf??ndan ??ng??r??len bir y??ntemin izlenmesi.
                ??irket, Kanun???da ??ng??r??lm???? s??n??rlar ??er??evesinde s??z konusu haklar?? kullanmak isteyen veri sahiplerine, yine Kanun???da ??ng??r??len ??ekilde azami otuz (30) g??n i??erisinde cevap vermektedir. Ki??isel veri sahipleri ad??na ??????nc?? ki??ilerin ba??vuru talebinde bulunabilmesi i??in veri sahibi taraf??ndan ba??vuruda bulunacak ki??i ad??na noter kanal??yla d??zenlenmi?? ??zel vek??letname bulunmal??d??r.
                Veri sahibi ba??vurular?? kural olarak ??cretsiz olarak i??leme al??nmakla birlikte, Ki??isel Verileri Koruma Kurulu taraf??ndan ??ng??r??len ??cret tarifesi[1] ??zerinden ??cretlendirme yap??labilecektir.
                ??irket, ba??vuruda bulunan ki??inin ki??isel veri sahibi olup olmad??????n?? tespit etmek ad??na ilgili ki??iden bilgi talep edebilir, ba??vuruda belirtilen hususlar?? netle??tirmek ad??na, ki??isel veri sahibine ba??vurusu ile ilgili soru y??neltebilir.




                [1] 10.03.2018 tarih ve 30356 say??l?? Resmi Gazete???de yay??nlanan ???Veri Sorumlusuna Ba??vuru Usul ve Esaslar?? Hakk??nda Tebli????? uyar??nca, veri sahiplerinin ba??vurusuna yaz??l?? olarak cevap verilecekse, on sayfaya kadar ??cret al??nmaz. On sayfan??n ??zerindeki her sayfa i??in 1 T??rk Liras?? i??lem ??creti al??nabilir. Ba??vuruya cevab??n CD, flash bellek gibi bir kay??t ortam??nda verilmesi halinde Kurum taraf??ndan talep edilebilecek ??cret kay??t ortam??n??n maliyetini ge??emez.
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
                <h5 class="modal-title" id="sifreModalLabel">??ifremi unuttum!?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?=base_url('login/forgotpassword')?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="mail" name="mail" class="form-control" placeholder="Email adresiniz...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">G??nder</button>
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

        /*swal("Te??ekk??r Ederiz!", "Sipari??iniz Al??nm????t??r!", "success");*/
    })
</script>

</body>
</html>