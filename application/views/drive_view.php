
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>/depends/folder.css">
    <link rel="stylesheet" href="<?=base_url()?>/depends/upload.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>

        .dropbtn {
            background-color: var(--bs-danger);
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {background-color: #ddd; color:black}

        .logo{
            font-size: 2rem;
        }
        .logo .dot{
            height: 0.4rem;
            width: 0.4rem;
            background-color: var(--bs-danger);
            display: inline-block;
        }


        /* -----------------------------------------------------
       CSS Progress Bars
    -------------------------------------------------------- */
        .cssProgress {
            width: 100%;
        }
        .cssProgress .progress1,
        .cssProgress .progress2,
        .cssProgress .progress3 {
            position: relative;
            overflow: hidden;
            width: 100%;
            font-family: "Roboto", sans-serif;
        }
        .cssProgress .cssProgress-bar {
            display: block;
            float: left;
            width: 0%;
            height: 100%;
            background: #3798d9;
            box-shadow: inset 0px -1px 2px rgba(0, 0, 0, 0.1);
            -webkit-transition: width 0.8s ease-in-out;
            transition: width 0.8s ease-in-out;
        }
        .cssProgress .cssProgress-label {
            position: absolute;
            overflow: hidden;
            left: 0px;
            right: 0px;
            color: rgba(0, 0, 0, 0.6);
            font-size: 0.7em;
            text-align: center;
            text-shadow: 0px 1px rgba(0, 0, 0, 0.3);
        }
        .cssProgress .cssProgress-info {
            background-color: #9575cd !important;
        }
        .cssProgress .cssProgress-danger {
            background-color: #ef5350 !important;
        }
        .cssProgress .cssProgress-success {
            background-color: #66bb6a !important;
        }
        .cssProgress .cssProgress-warning {
            background-color: #ffb74d !important;
        }
        .cssProgress .cssProgress-right {
            float: right !important;
        }
        .cssProgress .cssProgress-label-left {
            margin-left: 10px;
            text-align: left !important;
        }
        .cssProgress .cssProgress-label-right {
            margin-right: 10px;
            text-align: right !important;
        }
        .cssProgress .cssProgress-label2 {
            display: block;
            margin: 2px 0;
            padding: 0 8px;
            font-size: 0.8em;
        }
        .cssProgress .cssProgress-label2.cssProgress-label2-right {
            text-align: right;
        }
        .cssProgress .cssProgress-label2.cssProgress-label2-center {
            text-align: center;
        }
        .cssProgress .cssProgress-stripes,
        .cssProgress .cssProgress-active,
        .cssProgress .cssProgress-active-right {
            background-image: -webkit-linear-gradient(135deg, rgba(255, 255, 255, 0.125) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.125) 50%, rgba(255, 255, 255, 0.125) 75%, transparent 75%, transparent);
            background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.125) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.125) 50%, rgba(255, 255, 255, 0.125) 75%, transparent 75%, transparent);
            background-size: 35px 35px;
        }
        .cssProgress .cssProgress-active {
            -webkit-animation: cssProgressActive 2s linear infinite;
            -ms-animation: cssProgressActive 2s linear infinite;
            animation: cssProgressActive 2s linear infinite;
        }
        .cssProgress .cssProgress-active-right {
            -webkit-animation: cssProgressActiveRight 2s linear infinite;
            -ms-animation: cssProgressActiveRight 2s linear infinite;
            animation: cssProgressActiveRight 2s linear infinite;
        }
        @-webkit-keyframes cssProgressActive {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 35px 35px;
            }
        }
        @-ms-keyframes cssProgressActive {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 35px 35px;
            }
        }
        @keyframes cssProgressActive {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 35px 35px;
            }
        }
        @-webkit-keyframes cssProgressActiveRight {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: -35px -35px;
            }
        }
        @-ms-keyframes cssProgressActiveRight {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: -35px -35px;
            }
        }
        @keyframes cssProgressActiveRight {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: -35px -35px;
            }
        }
        /* -----------------------------------------------------
          Progress Bar 1
        -------------------------------------------------------- */
        .progress1 {
            background-color: #EEE;
            box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.2);
        }
        .progress1 .cssProgress-bar {
            height: 18px;
        }
        .progress1 .cssProgress-label {
            line-height: 18px;
        }

        /* -----------------------------------------------------
           Progress Bar 2
        -------------------------------------------------------- */
        .progress2 {
            background-color: #EEE;
            border-radius: 9px;
            box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.2);
        }
        .progress2 .cssProgress-bar {
            height: 18px;
            border-radius: 9px;
        }
        .progress2 .cssProgress-label {
            line-height: 18px;
        }

        /* -----------------------------------------------------
           Progress Bar 3
        -------------------------------------------------------- */
        .progress3 {
            width: auto !important;
            padding: 4px;
            background-color: rgba(0, 0, 0, 0.1);
            box-shadow: inset 0px 1px 2px rgba(0, 0, 0, 0.2);
            border-radius: 3px 0 0 3px;
        }
        .progress3 .cssProgress-bar {
            height: 16px;
            border-radius: 3px;
        }
        .progress3 .cssProgress-label {
            line-height: 16px;
        }

        /* -----------------------------------------------------
          Progress Bar 4
        -------------------------------------------------------- */
        .progress4 {
            position: relative;
            width: 100%;
            background-color: #EEE;
        }
        .progress4.cssProgress-bg {
            background-color: #bbdefb !important;
        }
        .progress4.cssProgress-bg-info {
            background-color: #d1c4e9 !important;
        }
        .progress4.cssProgress-bg-danger {
            background-color: #ffcdd2 !important;
        }
        .progress4.cssProgress-bg-success {
            background-color: #c8e6c9 !important;
        }
        .progress4.cssProgress-bg-warning {
            background-color: #ffecb3 !important;
        }
        .progress4 .cssProgress-bar {
            display: block;
            float: none;
            width: 0%;
            height: 4px;
            background: #3798d9;
        }
        .progress4 .cssProgress-bar.cssProgress-lg {
            height: 6px;
        }
        .progress4 .cssProgress-bar.cssProgress-2x {
            height: 8px;
        }
        .progress4 .cssProgress-bar.cssProgress-3x {
            height: 10px;
        }
        .progress4 .cssProgress-bar.cssProgress-4x {
            height: 12px;
        }
        .progress4 .cssProgress-bar.cssProgress-5x {
            height: 14px;
        }
        .progress4 .cssProgress-bar.cssProgress-glow {
            box-shadow: 5px 0px 15px 0px #3798D9;
        }
        .progress4 .cssProgress-bar.cssProgress-glow.cssProgress-info {
            box-shadow: 5px 0px 15px 0px #9575cd;
        }
        .progress4 .cssProgress-bar.cssProgress-glow.cssProgress-danger {
            box-shadow: 5px 0px 15px 0px #ef5350;
        }
        .progress4 .cssProgress-bar.cssProgress-glow.cssProgress-success {
            box-shadow: 5px 0px 15px 0px #66bb6a;
        }
        .progress4 .cssProgress-bar.cssProgress-glow.cssProgress-warning {
            box-shadow: 5px 0px 15px 0px #ffb74d;
        }
        .progress4 .cssProgress-bar.cssProgress-glow-active {
            -webkit-animation: cssProgressGlowActive1 3s linear infinite;
            -ms-animation: cssProgressGlowActive1 3s linear infinite;
            animation: cssProgressGlowActive1 3s linear infinite;
        }
        .progress4 .cssProgress-bar.cssProgress-glow-active.cssProgress-info {
            -webkit-animation: cssProgressGlowActive2 3s linear infinite;
            -ms-animation: cssProgressGlowActive2 3s linear infinite;
            animation: cssProgressGlowActive2 3s linear infinite;
        }
        .progress4 .cssProgress-bar.cssProgress-glow-active.cssProgress-danger {
            -webkit-animation: cssProgressGlowActive3 3s linear infinite;
            -ms-animation: cssProgressGlowActive3 3s linear infinite;
            animation: cssProgressGlowActive3 3s linear infinite;
        }
        .progress4 .cssProgress-bar.cssProgress-glow-active.cssProgress-success {
            -webkit-animation: cssProgressGlowActive4 3s linear infinite;
            -ms-animation: cssProgressGlowActive4 3s linear infinite;
            animation: cssProgressGlowActive4 3s linear infinite;
        }
        .progress4 .cssProgress-bar.cssProgress-glow-active.cssProgress-warning {
            -webkit-animation: cssProgressGlowActive5 3s linear infinite;
            -ms-animation: cssProgressGlowActive5 3s linear infinite;
            animation: cssProgressGlowActive5 3s linear infinite;
        }
        @-webkit-keyframes cssProgressGlowActive1 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #3798D9;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #3798D9;
            }
        }
        @-ms-keyframes cssProgressGlowActive1 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #3798D9;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #3798D9;
            }
        }
        @keyframes cssProgressGlowActive1 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #3798D9;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #3798D9;
            }
        }
        @-webkit-keyframes cssProgressGlowActive2 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #9575cd;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #9575cd;
            }
        }
        @-ms-keyframes cssProgressGlowActive2 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #9575cd;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #9575cd;
            }
        }
        @keyframes cssProgressGlowActive2 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #9575cd;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #9575cd;
            }
        }
        @-webkit-keyframes cssProgressGlowActive3 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #ef5350;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #ef5350;
            }
        }
        @-ms-keyframes cssProgressGlowActive3 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #ef5350;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #ef5350;
            }
        }
        @keyframes cssProgressGlowActive3 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #ef5350;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #ef5350;
            }
        }
        @-webkit-keyframes cssProgressGlowActive4 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #66bb6a;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #66bb6a;
            }
        }
        @-ms-keyframes cssProgressGlowActive4 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #66bb6a;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #66bb6a;
            }
        }
        @keyframes cssProgressGlowActive4 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #66bb6a;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #66bb6a;
            }
        }
        @-webkit-keyframes cssProgressGlowActive5 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #ffb74d;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #ffb74d;
            }
        }
        @-ms-keyframes cssProgressGlowActive5 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #ffb74d;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #ffb74d;
            }
        }
        @keyframes cssProgressGlowActive5 {
            0%, 100% {
                box-shadow: 5px 0px 15px 0px #ffb74d;
            }
            45% {
                box-shadow: 1px 0px 4px 0px #ffb74d;
            }
        }

        #percent-span{
            width: auto !important;
            background-color: rgba(0, 0, 0, 0.1);
            box-shadow: inset 0px 1px 2px rgba(0, 0, 0, 0.2);
            border-radius: 0 3px 3px 0;
        }

        .card-file{
            position: relative;
        }
        .card-file .delete{
            content: "";
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            top: 0;
            right: 10px;
        }

        .logout{
            color: white;
            transition: 0.5s;
        }
        .logout:hover{
            color: red;
        }

        .delete{
            cursor: pointer;
        }

    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@700&display=swap" rel="stylesheet">

</head>
<body>


<div class="page-wrapper">
    <div class="top-div p-3 text-white" style="background-color: rgb(98 34 204)">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">
                <span style="font-family: 'Jost',sans-serif;">CloudPeta</span>


            </div>
            <div>
                    <div class="dropzone">
                        <div class="dropzone-form">
                            <input type="file" id="file">
                            <p>Dosyalarınızı buraya sürükleyin ya da seçmek için tıklayın!</p>
                        </div>

                    </div>
            </div>
            <div class="dropdown">
                <span class="p-2"><i class="fas fa-user mx-1"></i><?=$USER->USERNAME?></span>
                <a class="p-2 logout" href="<?=base_url('login/logout')?>"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>

    <div class="container py-4" style="position: relative;">

        <div class="row">


            <?php
            if (count($FILES) > 0){
                foreach ($FILES as $file) {
                    ?>
                    <div class="col-2">
                        <div class="d-inline-flex card-file">
                            <a class="delete" id="<?=$file['id']?>">
                                <i class="fas fa-times text-danger"></i>
                            </a>
                            <a class="folder-container"
                               href="<?=base_url('drive/download/') . $file['id'] ?>" target="_blank"
                               data-toggle="tooltip" data-placement="right" data-html="true" title="Oluşturma Tarihi : <?= $file['date'] ?>">
                                <div class="folder-icon">
                                    <i class="fa <?= $file['icon'] ?> folder-icon-color"></i>
                                </div>
                                <div class="folder-name"><?= $file['filename'] ?></div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>


<!--    PROGRESS BAR BEGIN  -->
    <div id="statusarea" class="d-none" style="position: absolute; width: 50%; bottom: 0; right: 0; left: 0; padding: 1rem; margin: auto">
        <div id="uploadStatus" class="d-flex justify-content-center"></div>
        <div class="upload-progress d-flex justify-content-between align-items-center">
            <div class="cssProgress">
                <div class="progress3">
                    <div class="cssProgress-bar cssProgress-warning cssProgress-active"
                         data-percent="55" style="transition: none 0s ease 0s; width: 0%;">

                        <span class="cssProgress-label">
                            <i class="fas fa-cog fa-spin" aria-hidden="true" style="font-size: 1.4em"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div id="percent-span" class="px-2 bg-success text-white font-weight-bolder">
                <span class="text-nowrap">50 %</span>
            </div>
        </div>
    </div>

<!--    PROGRESS BAR END    -->

</div>


<div id="notify" class="toast" style="position: absolute; top: 0; right: 0;">
    <div class="toast-header">
        <img src="..." class="rounded mr-2" alt="...">
        <strong class="mr-auto">DriverPro</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Yükleme başladı.
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dosya Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Dosyanız silinecektir. Bu işlem geri alınamaz. Emin misiniz?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                <a id="deleteButton" href="<?=base_url('drive/delete/')?>" class="btn btn-danger">Sil</a>
            </div>
        </div>
    </div>
</div>

<script>

    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});

    $('.delete').on('click', function (){
        let id = $(this).attr('id');
        $('#deleteButton').attr('href', "<?=base_url('drive/delete/')?>" + id);
        myModal.show();
    });
</script>

<script>
    const MAX_UPLOAD_SIZE = <?=str_replace('M', null, ini_get('upload_max_filesize')) * 1024 * 1024?>
</script>
<script src="https://kit.fontawesome.com/565f08baaf.js" crossorigin="anonymous"></script>


<script>
    const status = $('#statusarea');
    const progress = $('#progress');
    const progressBar = $('#progressFile');

    $(document).ready(function () {
        $("#file").on('change', function (e) {
            let fd = new FormData;
            fd.append('file', $('#file')[0].files[0]);
            $.ajax({
                // Yükleme yüzdesi veren fonksiyon XHR
                xhr: function () {
                    $("#statusarea").removeClass('d-none');
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            $(".cssProgress-bar").width(percentComplete + '%');
                            $("#percent-span span").text(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '<?=base_url('drive/loadfile')?>',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $(".progress-bar").width('0%');
                },
                error: function () {
                    $('#uploadStatus').html('<p class="bg-danger text-white">File upload failed, please try again.</p>');
                },
                success: function (x) {
                    window.location.replace('<?=base_url('drive')?>');
                }
            });
        });
    });
</script>



<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

</body>
</html>