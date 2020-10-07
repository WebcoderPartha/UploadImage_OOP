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
                $extension = strtolower(end($div));
                $img = time().'.'.$extension;
                $upload_image = "uploads/".$img;

                if (empty($file_name)){
                    echo "<span style='color:red'>Please Select any Image!</span>";
                }elseif($file_size > 1234567){
                    echo "<span style='color:red'>Image size should be less then 1 KB!</span>";
                }elseif(in_array($extension,$permited) === false){
                    echo "<span style='color:red'>You can upload only".implode(',', $permited)."</span>";
                }else{

                    move_uploaded_file($file_tmp, $upload_image);
                    $query = "INSERT INTO image(photo) VALUES ('$upload_image')";
                    $insert_image = $db->create($query);

                    if ($insert_image){
                        echo "<span class='color:green'>Inserted successfully</span>";
                    }else{
                        echo "<span class='color:red'>Image not Inserted</span>";
                    }
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
        <?php
            $query = "SELECT * FROM image ORDER BY id DESC LIMIT 1";
            $showImage = $db->select($query);
        foreach ( $showImage as $image) { ?>
            <img src="<?php echo  $image['photo']; ?>" height="150" alt="">
           <?php }
        ?>
    </div>
<?php include 'inc/footer.php';?>