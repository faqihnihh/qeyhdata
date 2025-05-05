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

// Ambil data mahasiswa berdasarkan ID
$id = $_GET['id'];
$query = "SELECT * FROM mahasiswa WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        :root {
            --primary-color: #2ecc71; /* Hijau lebih segar */
            --secondary-color: #27ae60; /* Hijau lebih gelap */
            --accent-color: #f1c40f; /* Kuning */
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --danger-color: #e74c3c;
            --text-color: #34495e;
            --gray-color: #95a5a6;
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
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 0 0 10px 10px;
        }

        header h1 {
            text-align: center;
            margin-bottom: 1rem;
            font-weight: 600;
            font-size: 2.2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
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
            display: inline-block;
        }

        nav ul li a:hover {
            background-color: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        nav ul li.active a {
            background-color: var(--accent-color);
            color: var(--dark-color);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 3rem;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .card h2 {
            margin-bottom: 1.5rem;
            color: var(--secondary-color);
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--accent-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.8rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
            color: var(--dark-color);
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
            background-color: white;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 2.5rem;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .btn i {
            margin-right: 8px;
            font-size: 1rem;
        }

        .btn.submit {
            background-color: var(--primary-color);
            color: white;
        }

        .btn.submit:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }

        .btn.cancel {
            background-color: var(--gray-color);
            color: white;
        }

        .btn.cancel:hover {
            background-color: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }

        /* Footer Styles */
        footer {
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 3rem;
            color: #7f8c8d;
            border-top: 1px solid #e0e0e0;
            font-size: 0.9rem;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            
            nav ul li {
                margin: 8px 0;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 12px;
            }
            
            .btn {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Sistem Informasi Mahasiswa</h1>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="create.php"><i class="fas fa-user-plus"></i> Tambah Mahasiswa</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="card">
                <h2><i class="fas fa-user-edit"></i> Edit Data Mahasiswa</h2>
                
                <form action="process.php?action=update" method="POST">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    
                    <div class="form-group">
                        <label for="npm"><i class="fas fa-id-card"></i> NPM</label>
                        <input type="text" id="npm" name="npm" value="<?= htmlspecialchars($row['npm']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama"><i class="fas fa-user"></i> Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="program_studi"><i class="fas fa-graduation-cap"></i> Program Studi</label>
                        <select id="program_studi" name="program_studi" required>
                            <option value="SI" <?= $row['program_studi'] == 'SI' ? 'selected' : ''; ?>>Sistem Informasi</option>
                            <option value="TI" <?= $row['program_studi'] == 'TI' ? 'selected' : ''; ?>>Teknik Informatika</option>
                            <option value="RPL" <?= $row['program_studi'] == 'RPL' ? 'selected' : ''; ?>>Rekayasa Perangkat Lunak</option>
                            <option value="MI" <?= $row['program_studi'] == 'MI' ? 'selected' : ''; ?>>Manajemen Informatika</option>
                            <option value="PI" <?= $row['program_studi'] == 'PI' ? 'selected' : ''; ?>>Pendidikan Informatika</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($row['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($row['alamat']); ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn submit"><i class="fas fa-save"></i> Update</button>
                        <a href="index.php" class="btn cancel"><i class="fas fa-times"></i> Batal</a>
                    </div>
                </form>
            </div>
        </main>

        <footer>
            <p>&copy; <?= date('Y'); ?> Sistem Informasi Mahasiswa. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>