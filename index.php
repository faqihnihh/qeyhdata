<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'siswa_db';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data mahasiswa
$query = "SELECT * FROM mahasiswa";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ======= STYLING ======= */
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --accent-color: #f1c40f;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --danger-color: #e74c3c;
            --text-color: #34495e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: var(--text-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        header h1 {
            text-align: center;
            font-weight: 600;
            font-size: 2.2rem;
        }

        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        nav ul li a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        nav ul li.active a {
            background-color: var(--accent-color);
            color: var(--dark-color);
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .card h2 {
            color: var(--secondary-color);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        table th, table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e0e0e0;
        }

        table th {
            background-color: var(--primary-color);
            color: white;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tr:hover {
            background-color: #f1f8e9;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn i {
            margin-right: 5px;
        }

        .btn.edit {
            background-color: var(--accent-color);
            color: var(--dark-color);
        }

        .btn.edit:hover {
            background-color: #f39c12;
        }

        .btn.delete {
            background-color: var(--danger-color);
            color: white;
        }

        .btn.delete:hover {
            background-color: #c0392b;
        }

        footer {
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 3rem;
            color: #7f8c8d;
            border-top: 1px solid #e0e0e0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        /* ======= TOAST STYLES ======= */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 14px 24px;
            border-radius: 8px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            z-index: 9999;
            font-weight: 500;
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.4s ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <!-- Toast Element -->
    <div id="toast" class="toast" style="display: none;"></div>

    <div class="container">
        <header>
            <h1>Sistem Informasi Mahasiswa</h1>
            <nav>
                <ul>
                    <li class="active"><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="create.php"><i class="fas fa-user-plus"></i> Tambah Mahasiswa</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="card">
                <h2><i class="fas fa-users"></i> Daftar Mahasiswa</h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>E-mail</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['npm']); ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['program_studi']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['alamat']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn delete" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <footer>
            <p>&copy; <?= date('Y'); ?> Sistem Informasi Mahasiswa. All rights reserved.</p>
        </footer>
    </div>

    <!-- Toast Script -->
    <script>
        function showToast(message) {
            const toast = document.getElementById("toast");
            toast.textContent = message;
            toast.style.display = "block";
            setTimeout(() => toast.classList.add("show"), 100);

            setTimeout(() => {
                toast.classList.remove("show");
                setTimeout(() => toast.style.display = "none", 400);
            }, 4000);
        }

        const params = new URLSearchParams(window.location.search);
        if (params.get("status") === "created") {
            showToast("Data berhasil ditambahkan!");
        } else if (params.get("status") === "updated") {
            showToast("Data berhasil diperbarui!");
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>
