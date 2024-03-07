<?php include '../app/views/templates/header.php'; ?>
<div class="col-md-6">
  <div class="card card-primary">
    <div class="card-body">
      <form action="<?= urlTo('/perpustakaan/ulasanstore'); ?>" method="post">
        <input type="hidden" name="UserID" value="<?= $_SESSION['UserID']; ?>">
        <input type="hidden" name="BukuID" value="<?= $data['BukuID']; ?>">
        <div class="form-group">
          <label for="Judul">Judul Buku</label>
          <input type="text" id="Judul" class="form-control" value="<?= $data['Judul'] ?>" readonly>
        </div>

        <div class="form-group">
          <label for="Penulis">Penulis</label>
          <input type="text" id="Penulis" class="form-control" value="<?= $data['Penulis'] ?>" readonly>
        </div>

        <div class="form-group">
          <label for="Ulasan">Ulasan</label>
          <input type="text" id="Ulasan" name="Ulasan" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="Rating">Rating</label>
          <select name="Rating" id="Rating" class="form-control">
            <option value="5">5</option>
            <option value="4">4</option>
            <option value="3">3</option>
            <option value="2">2</option>
            <option value="1">1</option>
          </select>
        </div>

        <div class="form-group">
          <?php
          // Database connection parameters
          $hostname = "localhost";
          $username = "root";
          $password = "";
          $database = "perpus_digital";

          // Create connection
          $mysqli = new mysqli($hostname, $username, $password, $database);

          // Check connection
          if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
          }

          // Assuming $_SESSION['UserID'] and $data['BukuID'] are integers, adjust data types if needed
          $userID = (int) $_SESSION['UserID'];
          $bukuID = (int) $data['BukuID'];

          $checkpinjam = "SELECT * FROM peminjaman WHERE UserID = ? AND BukuID = ?";
          $stmt = $mysqli->prepare($checkpinjam);

          if ($stmt) {
            $stmt->bind_param("ii", $userID, $bukuID);
            $stmt->execute();

            $result = $stmt->get_result();

            // Check if there is more than 0 rows (not more than 1)
            if ($result->num_rows > 0) {
              echo '<button type="submit" class="btn btn-primary float-right">Tambah Ulasan</button>';
            } else {
              echo '<button style="display:none" type="submit" class="btn btn-primary float-right">Tambah Ulasan</button>';
            }

            $stmt->close();
          } else {
            die("Prepare failed: " . $mysqli->error);
          }

          // Close the database connection when you're done
          $mysqli->close();
          ?>

          <a href="<?= urlTo('/buku'); ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include '../app/views/templates/footer.php'; ?>