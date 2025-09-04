    <!-- Sidebar Bootstrap -->
    <div class="sidebar">
        <h4>Admin ASE</h4>
        <hr>

        <?php
        $query = "SELECT * FROM rbac a, menu b WHERE a.role_id = ".$_SESSION['role']." AND a.menu_id = b.id";
        $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                // echo $row['url'].$row['namaMenu'];
                // echo "<a href='".$row['url']."'><i class='fas fa-user'></i>'.$row['namaMenu'].'</a>";
                echo '<a href="'.$row['url'].'"><i class="fas fa-user"></i>'.$row['namaMenu'].'</a>';
            }
        ?>
        <!--<a href="../mhs/tampilDatamhs.php"><i class="fas fa-user"></i> Data Mahasiswa</a>
        <a href="../dsn/tampilDatadsn.php"><i class="fas fa-user"></i> Data Dosen</a>
        <a href="../matkul/tampilDatamatkul.php"><i class="fas fa-cogs"></i> Data Matakuliah</a>-->
        
        <div class="logout">
            <a href="../../auth/logout.php" class="logout-icon">
                <i class=""><i>logout</a>            
        </div>
    </div>