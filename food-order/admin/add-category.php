<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="category title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan=2>
                        <input type="submit" value="Add Category" name="submit" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <!-- Add Category Form Ends -->

        <?php
            if (isset($_POST['submit'])) {

                // 1. Get the values from category form
                $title = $_POST['title'];

                // For radio buttons, we need to check if a value is selected or not

                if (isset($_POST['featured'])) {
                    $featured = $_POST['featured'];
                } else {
                    $featured = "No";
                }

                if (isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    $active = "No";
                }

                // Check whether image is uploaded and set value for image name accordingly
                // print_r($_FILES['image']);
                // die();

                if (isset($_FILES['image']['name'])) {

                    // Upload the image
                    // To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    // Auto Rename the Image

                    // Get the extension of our image (jpg, png, gif, etc.)
                    $ext = end(explode('.', $image_name));

                    // Rename the image
                    date_default_timezone_set('Asia/Kolkata');
                    echo date_default_timezone_get();
                    echo $date = date('m-d-Y-h-i-s-a', time());
                    $image_name = 'Food_Category_'.$date.'.'.$ext;

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    // upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check whether the image is uploaded or not
                    if ($upload==FALSE) {
                        $_SESSION['upload'] = "<div class = 'error'>Failed to Upload Image</div>";
                        header("location:".SITEURL."admin/add-category.php");
                        die();
                    }


                } else {
                    // Don't upload image and set the image_name value as blank
                    $image_name = "";
                }

                // 2. Create sql query to insert category into database
                $sql = "INSERT INTO tbl_category SET 
                title = '$title',
                image_name = '$image_name',
                active = '$active',
                featured = '$featured'
                ";

                // 3. Execute the query
                $res = mysqli_query($conn, $sql);

                // 4. Check whether query is executed
                if ($res == TRUE) {
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    header("location:".SITEURL."admin/manage-category.php");
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                }
            }   
        ?>

    </div>
</div>

<?php include("partials/footer.php"); ?>