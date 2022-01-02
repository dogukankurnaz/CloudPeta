<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CloudPeta!</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" href="<?=base_url('login-temp/')?>images/favicon.ico" type="image/x-icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?=base_url('peta/')?>lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?=base_url('peta/')?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?=base_url('peta/')?>lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?=base_url('peta/')?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?=base_url('peta/')?>css/style.css" rel="stylesheet">

    <style>
        .crew-p{
            min-height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
<div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar & Hero Start -->
    <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <h1 class="m-0">CloudPeta</h1>
                <!-- <img src="img/logo.png" alt="Logo"> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="<?=base_url('home')?>" class="nav-item nav-link active">Ana Sayfa</a>
                    <a href="<?=base_url('contact')?>" class="nav-item nav-link">İletişim</a>
                </div>
                <a href="<?=base_url('login')?>" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Giriş</a>
            </div>
        </nav>

        <div class="container-xxl bg-primary hero-header">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-end">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="text-white mb-4 animated slideInDown">CloudPeta nedir?</h1>
                        <p class="text-white pb-3 animated slideInDown">İnternetin olduğu her yerden tüm büyük cihazlardan ve platformlardan kullanılabilen bulut tabanlı bir hizmettir.CloudPeta, uçtan uca şifrelemeyi düzgün bir şekilde uygulayarak, tasarım gereği gerçek gizliliğe ulaşır.</p>

                    </div>
                    <div class="col-lg-6 text-center text-lg-start">
                        <img class="img-fluid animated zoomIn" src="<?=base_url('peta/')?>img/hero.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->


    <!-- Feature Start -->
    <div class="container-xxl py-5">
        <div class="container py-5 px-lg-5">
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded text-center p-4">
                        <i class="fa fa-3x fa-mail-bulk text-primary mb-4"></i>
                        <h5 class="mb-3">Hızlı Transfer</h5>
                        <p class="m-0">Güvenli bulut depolamayı basit, hızlı ve kullanışlı hale getiriyoruz.</p>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded text-center p-4">
                        <i class="fa fa-3x fa-search text-primary mb-4"></i>
                        <h5 class="mb-3">Kullanılabilir Veriler</h5>
                        <p class="m-0">CloudPath, verilerinizin her zaman kullanılabilir durumda kalmasını sağlayar.</p>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="feature-item bg-light rounded text-center p-4">
                        <i class="fa fa-3x fa-laptop-code text-primary mb-4"></i>
                        <h5 class="mb-3">Güvenlik</h5>
                        <p class="m-0">CloudPath, kullanıcıları için en yüksek güvenlik seviyesini sağlamak üzere özenle tasarlanmıştır.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container py-5 px-lg-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-secondary">Hakkımızda<span></span></p>
                    <h1 class="mb-5">Yazılım Mühendisliği Güncel Konular</h1>
                    <p class="mb-4">YMGK dersimizde proje olarak geliştiridiğimiz Bulut Depolama Sistemi final sürümü.</p>

                </div>
                <div class="col-lg-6">
                    <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="<?=base_url('peta/')?>img/about.png">
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Facts Start -->
    <div class="container-xxl bg-primary fact py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 px-lg-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                    <i class="fa fa-certificate fa-3x text-secondary mb-3"></i>
                    <h1 class="text-white mb-2" data-toggle="counter-up">2021</h1>
                    <p class="text-white mb-0">Kuruluş Yılımız</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                    <i class="fa fa-users-cog fa-3x text-secondary mb-3"></i>
                    <h1 class="text-white mb-2" data-toggle="counter-up">25</h1>
                    <p class="text-white mb-0">Ekip Üyelerimiz</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                    <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                    <h1 class="text-white mb-2" data-toggle="counter-up">900.234</h1>
                    <p class="text-white mb-0">Kullanıcı Sayımız</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                    <i class="fa fa-check fa-3x text-secondary mb-3"></i>
                    <h1 class="text-white mb-2" data-toggle="counter-up">40.539</h1>
                    <p class="text-white mb-0">Toplam Dosya Sayısı</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Facts End -->




    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container py-5 px-lg-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <p class="section-title text-secondary justify-content-center"><span></span>Takım<span></span></p>
                <h1 class="text-center mb-5">Ekip Üyelerimiz</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <div class="crew-p">
                                <img class="img-fluid mb-4" src="<?=base_url('peta/')?>img/crew/dogukan.jpeg" alt="">
                            </div>
                            <h5>Doğukan Kurnaz</h5>
                            <span>Team Lead</span>
                        </div>
                        <div class="d-flex justify-content-center p-4">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <div class="crew-p">
                            <img class="img-fluid mb-4" src="<?=base_url('peta/')?>img/crew/yusa.jpeg" alt="">
                            </div>
                            <h5>Yuşa Oruç</h5>
                            <span>Database System Developer</span>
                        </div>
                        <div class="d-flex justify-content-center p-4">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <div class="crew-p">
                            <img class="img-fluid mb-4" src="<?=base_url('peta/')?>img/crew/burak.jpeg" alt="">
                            </div>
                            <h5>Burak Sayılgan</h5>
                            <span>Backend-Developer</span>
                        </div>
                        <div class="d-flex justify-content-center p-4">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light rounded">
                        <div class="text-center border-bottom p-4">
                            <div class="crew-p">
                            <img class="img-fluid mb-4" src="<?=base_url('peta/')?>img/crew/alifuat.jpeg" alt="">
                            </div>
                            <h5>Ali Fuat Arslan</h5>
                            <span>Backend-Developer</span>
                        </div>
                        <div class="d-flex justify-content-center p-4">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">

        <div class="container px-lg-5">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">www.cloudpeta.com</a>

                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Ana Sayfa</a>
                            <a href="">İletişim</a>
                            <a href="">Giriş</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url('peta/')?>lib/wow/wow.min.js"></script>
<script src="<?=base_url('peta/')?>lib/easing/easing.min.js"></script>
<script src="<?=base_url('peta/')?>lib/waypoints/waypoints.min.js"></script>
<script src="<?=base_url('peta/')?>lib/counterup/counterup.min.js"></script>
<script src="<?=base_url('peta/')?>lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?=base_url('peta/')?>lib/isotope/isotope.pkgd.min.js"></script>
<script src="<?=base_url('peta/')?>lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="<?=base_url('peta/')?>js/main.js"></script>
</body>

</html>