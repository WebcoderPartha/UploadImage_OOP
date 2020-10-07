<?php include 'inc/header.php';
    include 'lib/config.php';
    include 'lib/Database.php';
    $db = new Database();
?>
    <div class="myform">
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){

                $permited = array('jpg', 'jpeg', 'png', 'gif');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $div = explode('.', $file_name);
                $extension = end($div);
                $img = time().'.'.$extension;
                $folder = "uploads/";
                move_uploaded_file($file_tmp, $folder.$img);
                $query = "INSERT INTO image(photo) VALUES ('$img')";
                $insert_image = $db->create($query);

                if ($insert_image){
                    echo "<span class='color:green'>Inserted successfully</span>";
                }else{
                    echo "<span class='color:red'>Image not Inserted</span>";
                }

            }
//        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Select Image</td>
                    <td><input type="file" name="image"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Upload"/></td>
                </tr>
            </table>
        </form>
    </div>
<?php include 'inc/footer.php';?>