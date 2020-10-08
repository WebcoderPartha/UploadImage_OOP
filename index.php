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
                        echo "<span style='color:green'>Inserted successfully</span>";
                    }else{
                        echo "<span style='color:red'>Image not Inserted</span>";
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
            <table width="100%">
                <tr>
                    <th>No.</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <?php
                    if (isset($_GET['del'])){
                        $id = $_GET['del'];
                     $imageQuery = "select * from image where id = '$id' ";
                     $getImage = $db->select($imageQuery);

                     if ($getImage){
                         while ($exist_img = $getImage->fetch_assoc()){
                             $deleteImg = $exist_img['photo'];
                             unlink($deleteImg);
                         }
                     }
                    $query = "delete from image where id = '$id'";
                    $deleteImage = $db->delete($query);
                    if ($deleteImage){
                            echo "<span style='color:green'>Image Deleted successfully</span>";
                    }else{
                        echo "<span style='color:red'>Image not deleted</span>";
                        }
                   }
                ?>
                <?php
                $query = "SELECT * FROM image ORDER BY id DESC";
                $showImage = $db->select($query);
                if($showImage){
                foreach ( $showImage as $image) { ?>
                <tr>
                    <td><?php echo $image['id']; ?></td>
                    <td> <img src="<?php echo  $image['photo']; ?>" height="50" alt=""></td>
                    <td><a href="?del=<?php echo $image['id']; ?>" style="background:red; padding:5px 20px; color:#fff; text-decoration:none">Delete</a></td>
                </tr>
                <?php } } ?>
            </table>

    </div>
<?php include 'inc/footer.php';?>