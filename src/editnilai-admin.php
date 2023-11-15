<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | SMP Negeri 35 Bandar Lampung</title>
    <!-- style vanilla css -->
    <link rel="stylesheet" type="text/css" href="../styles/styles.css" />
    <!-- iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="logo-text">
            <a href="#">
                <img src="../assets/LogoSMPN35.png" alt="LogoSMPN35" width="80px" />
            </a>
        </div>
        <div class="title-text">
            <a href="#">
                <h1>SIAKAD | Admin</h1>
                <span>SMP Negeri 35 Bandar Lampung</span>
            </a>
        </div>
        <div class="profile-button">
            <a href="profile-admin.php"><iconify-icon icon="material-symbols:person" width="35"
                    class="align-middle p-3"></iconify-icon>
                Admin
            </a>
        </div>
        <div class="logout-button">
            <a href="login.php"><iconify-icon icon="material-symbols:logout" width="35"
                    class="align-middle p-3"></iconify-icon>Logout</a>
        </div>
    </header>

    <nav>
        <ul class="side-menu">
            <li class="menu-disabled"><span>Menu</span></li>
            <li>
                <a href="#"><img src="../assets/transcript.svg" alt="Daftar-Guru" />Daftar
                    Guru</a>
            </li>
            <li>
                <a href="#"><img src="../assets/transcript.svg" alt="Daftar-Siswa" />Daftar
                    Siswa</a>
            </li>
            <li>
                <a href="datanilai-admin.php" class="active"><img src="../assets/transcript.svg" alt="Data-Nilai" />Data
                    Nilai</a>
            </li>
            <li>
                <a href="#" class="menu-end"><img src="../assets/transcript.svg" alt="Edit-Modul" />Edit Modul</a>
            </li>
        </ul>
    </nav>

    <!-- content -->
    <div class="kotak-isi">
        <div class="container">
            <p class="fw-bold">Nama siswa : Aqsal</p>
            <!-- Bagian tabel rincian nilai -->
            <div class="container">
                <table class="table table-striped table-fixed text-center">
                    <thead style="background-color: #C6D8AF;">
                        <tr>
                            <th scope="col">Mata Pelajaran</th>
                            <th scope="col">Nilai Tugas</th>
                            <th scope="col">Nilai UTS</th>
                            <th scope="col">Nilai UAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                        <tr>
                            <td>mapel 1</td>
                            <td>12</td>
                            <td>23</td>
                            <td>34</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /table -->

            <!-- button simpan -->
            <div class="container-fluid d-flex justify-content-end">
                <a href="datanilai-admin.php" class="btn" role="button">
                    <button class="btn" style="background-color: #CFF59F;">
                        <iconify-icon icon="mingcute:save-line" width="15"></iconify-icon>
                        Simpan
                    </button>
                </a>
            </div>
            <!-- /button simpan -->
        </div>
    </div>
    <!-- /content -->
</body>

</html>