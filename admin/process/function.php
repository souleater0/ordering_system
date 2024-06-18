<?php
function loginProcess($pdo)
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username= ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        //login success
        // session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION['logged_in'] = true;
        $_SESSION['user_role'] = $user["role_id"];
        return true;
    } else {
        return false;
    }
}
function getRole($pdo)
{
    try {
        $query = "SELECT * FROM roles";
        $stmt = $pdo->prepare($query);

        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $roles;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function getCategory($pdo)
{
    try {
        $query = "SELECT * FROM category";
        $stmt = $pdo->prepare($query);

        $stmt->execute();
        $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $category;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function getVariations($pdo)
{
    try {
        $query = "SELECT * FROM variations";
        $stmt = $pdo->prepare($query);

        $stmt->execute();
        $variations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $variations;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function getVariationsbyID($pdo)
{
    try {

        $query = "SELECT * FROM variations";
        $stmt = $pdo->prepare($query);

        $stmt->execute();
        $variations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $variations;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function addUser($pdo)
{
    try {
        $user_display = $_POST['user_display'];
        $username = $_POST['username'];
        $password = password_hash('ecadmin', PASSWORD_BCRYPT);
        $user_role = $_POST['user_role'];
        $loginEnabled = !empty($_POST['loginEnabled']) ? '1' : '0';

        // Check if Users with the same name already exists
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR display_name = :display_name");
        $stmt_check->bindParam(':username', $username);
        $stmt_check->bindParam(':display_name', $user_display);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            // Users already exists, return false
            return false;
        }

        $stmt = $pdo->prepare("INSERT INTO users (username, password, display_name, role_id, isEnabled) VALUES (:username, :password, :display_name, :role_id , :isEnabled)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':display_name', $user_display);
        $stmt->bindParam(':role_id', $user_role, PDO::PARAM_INT);
        $stmt->bindParam(':isEnabled', $loginEnabled, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Users added successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function updateUser($pdo)
{
    try {
        $user_display = $_POST['user_display'];
        $username = $_POST['username'];
        $user_role = $_POST['user_role'];
        $loginEnabled = !empty($_POST['loginEnabled']) ? '1' : '0';
        $update_ID = $_POST['update_id'];
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE (username = :username OR display_name = :display_name) AND id != :user_id");
        $stmt_check->bindParam(':username', $username);
        $stmt_check->bindParam(':display_name', $user_display);
        $stmt_check->bindParam(':user_id', $update_ID, PDO::PARAM_INT);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            // Category already exists, return false
            return false;
        }

        $stmt = $pdo->prepare("UPDATE users SET username = :username, display_name = :display_name, role_id = :role_id, isEnabled = : WHERE id = :user_id");
        //bind parameters
        $stmt->bindParam(':display_name', $user_display);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role_id', $user_role, PDO::PARAM_INT);
        $stmt->bindParam(':isEnabled', $loginEnabled, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function updateUserPassword($pdo)
{
    try {
        $update_ID = $_POST['update_id'];
        $password = password_hash($_POST['c_password'], PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        //bind parameters
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $update_ID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function addFood($pdo)
{
    try {
        $food_name = $_POST['food_name'];
        $category_id = $_POST['category_id'];
        $foodOption = $_POST['foodOption'] ? $_POST['foodOption'] : '';

        //check if Food is Enabled
        if ($foodOption === 'on') {
            $foodOption = 1;
        } else {
            $foodOption = 0;
        }

        // Check if food item already exists
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE menu_name = :food_name");
        $stmt_check->bindParam(':food_name', $food_name);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();
        if ($count > 0) {
            return false; // Food already exists
        }

        // Handle file upload
        $target_dir = "../../assets/images/menu/"; // Directory where the file will be saved
        $target_file = $target_dir . basename($_FILES["foodImg"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $file_name = basename($_FILES["foodImg"]["name"]); // Just the file name

        $check = getimagesize($_FILES["foodImg"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["foodImg"]["size"] > 2000000) { // Limit to 2000KB
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            return false;
        } else {
            // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["foodImg"]["tmp_name"], $target_file)) {
                // File uploaded successfully

                // Insert food details along with the image file name into the database
                $stmt = $pdo->prepare("INSERT INTO menu (menu_name, category_id, menu_img, isEnabled) VALUES (:food_name, :category_id, :menu_img, :foodOption)");
                $stmt->bindParam(':food_name', $food_name);
                $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $stmt->bindParam(':foodOption', $foodOption, PDO::PARAM_INT);
                $stmt->bindParam(':menu_img', $file_name);

                if ($stmt->execute()) {
                    $menu_id = $pdo->lastInsertId();

                    // Handle variations
                    foreach ($_POST['variations'] as $variation) {
                        $variation_name = $variation['name'];
                        $variation_price = $variation['price'];

                        // Get or create variation id
                        $stmt_var = $pdo->prepare("SELECT id FROM variations WHERE variation_name = :variation_name");
                        $stmt_var->bindParam(':variation_name', $variation_name);
                        $stmt_var->execute();
                        $variation_id = $stmt_var->fetchColumn();

                        if (!$variation_id) {
                            // Insert new variation
                            $stmt_var_insert = $pdo->prepare("INSERT INTO variations (variation_name) VALUES (:variation_name)");
                            $stmt_var_insert->bindParam(':variation_name', $variation_name);
                            $stmt_var_insert->execute();
                            $variation_id = $pdo->lastInsertId();
                        }

                        // Insert into menu_variations
                        $stmt_mv = $pdo->prepare("INSERT INTO menu_variations (menu_id, variation_id, price) VALUES (:menu_id, :variation_id, :price)");
                        $stmt_mv->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
                        $stmt_mv->bindParam(':variation_id', $variation_id, PDO::PARAM_INT);
                        $stmt_mv->bindParam(':price', $variation_price);

                        $stmt_mv->execute();
                    }

                    return true; // Food and variations added successfully
                } else {
                    // Error occurred
                    echo "Failed to insert food into database.";
                    return false;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return false;
    }
}


// function addFood($pdo){
//     try {
//         $food_name = $_POST['food_name'];
//         $food_price = $_POST['food_price'];
//         $category_id = $_POST['category_id'];
//         // Check if category with the same name already exists
//         $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE menu_name = :food_name");
//         $stmt_check->bindParam(':food_name', $food_name);
//         $stmt_check->execute();
//         $count = $stmt_check->fetchColumn();
//         if ($count > 0) {
//             // Food already exists, return false
//             return false;
//         }
//         // Handle file upload
//         $target_dir = "../../assets/images/menu/"; // Directory where the file will be saved
//         $target_file = $target_dir . basename($_FILES["foodImg"]["name"]);
//         $uploadOk = 1;
//         $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//         $file_name = basename($_FILES["foodImg"]["name"]); // Just the file name

//         $check = getimagesize($_FILES["foodImg"]["tmp_name"]);
//         if ($check !== false) {
//             $uploadOk = 1;
//         } else {
//             echo "File is not an image.";
//             $uploadOk = 0;
//         }

//         // Check if file already exists
//         if (file_exists($target_file)) {
//             echo "Sorry, file already exists.";
//             $uploadOk = 0;
//         }

//         // Check file size
//         if ($_FILES["foodImg"]["size"] > 2000000) { // Limit to 2000KB
//             echo "Sorry, your file is too large.";
//             $uploadOk = 0;
//         }

//         // Allow certain file formats
//         if ($imageFileType != "jpg" && $imageFileType != "png") {
//             echo "Sorry, only JPG, JPEG, PNG files are allowed.";
//             $uploadOk = 0;
//         }

//         // Check if $uploadOk is set to 0 by an error
//         if ($uploadOk == 0) {
//             echo "Sorry, your file was not uploaded.";
//             return false;
//         } else {
//             // if everything is ok, try to upload file
//             if (move_uploaded_file($_FILES["foodImg"]["tmp_name"], $target_file)) {
//                 // File uploaded successfully

//                 // Insert food details along with the image file name into the database
//                 $stmt = $pdo->prepare("INSERT INTO menu (menu_name, menu_price, category_id, menu_img) VALUES (:food_name, :food_price, :category_id, :menu_img)");
//                 $stmt->bindParam(':food_name', $food_name);
//                 $stmt->bindParam(':food_price', $food_price);
//                 $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
//                 $stmt->bindParam(':menu_img', $file_name);

//                 if ($stmt->execute()) {
//                     // Food added successfully
//                     return true;
//                 } else {
//                     // Error occurred
//                     echo "Failed to insert food into database.";
//                     return false;
//                 }
//             } else {
//                 echo "Sorry, there was an error uploading your file.";
//                 return false;
//             }
//         }
//     }catch(PDOException $e){
//         // Handle database connection error
//         echo "Error: " . $e->getMessage();
//         return array(); // Return an empty array if an error occurs
//     }
// }
function updateFood($pdo)
{
    try {
        $food_name = $_POST['food_name'];
        $food_price = $_POST['food_price'];
        $category_id = $_POST['category_id'];
        $update_ID = $_POST['update_id'];
        // Check if category with the same name already exists
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE menu_name = :food_name AND id != :food_id");
        $stmt_check->bindParam(':food_name', $food_name);
        $stmt_check->bindParam(':food_id', $update_ID);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();
        if ($count > 0) {
            // Food already exists, return false
            return false;
        }
        $stmt = $pdo->prepare("UPDATE menu SET menu_name = :food_name, menu_price = :food_price, category_id = :category_id WHERE id = :food_id");
        //bind parameters
        $stmt->bindParam(':food_name', $food_name);
        $stmt->bindParam(':food_price', $food_price);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':food_id', $update_ID);
        if ($stmt->execute()) {
            // Food update successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function deleteFood($pdo)
{
    try {
        $delete_id = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM menu WHERE id = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Food delete successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
//add_variation
function addVariation($pdo)
{
    try {
        $variation_name = $_POST['variation_name'];
        // Check if category with the same name already exists
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM variations WHERE variation_name = :variation_name");
        $stmt_check->bindParam(':variation_name', $variation_name);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();
        if ($count > 0) {
            // variations already exists, return false
            return false;
        }
        $stmt = $pdo->prepare("INSERT INTO variations (variation_name) VALUES (:variation_name)");
        //bind parameters
        $stmt->bindParam(':variation_name', $variation_name);
        if ($stmt->execute()) {
            // variations added successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function updateVariation($pdo)
{
    try {
        $variation_name = $_POST['variation_name'];
        $update_ID = $_POST['update_id'];
        // Check if category with the same name already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM variations WHERE variation_name = :variation_name AND id != :variation_id");
        $stmt->bindParam(':variation_name', $variation_name);
        $stmt->bindParam(':variation_id', $update_ID, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            // variation already exists, return false
            return false;
        }
        $stmt = $pdo->prepare("UPDATE variations SET variation_name = :variation_name WHERE id = :variation_id");
        //bind parameters
        $stmt->bindParam(':variation_name', $variation_name);
        $stmt->bindParam(':variation_id', $update_ID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // variation Update successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function deleteVariation($pdo)
{
    try {
        $delete_id = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM variations WHERE id = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Food delete successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
//add_category
function addCategory($pdo)
{
    try {
        $category_name = $_POST['category_name'];
        // Check if category with the same name already exists
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM category WHERE category_name = :category_name");
        $stmt_check->bindParam(':category_name', $category_name);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            // category already exists, return false
            return false;
        }

        $stmt = $pdo->prepare("INSERT INTO category (category_name) VALUES (:category_name)");
        $stmt->bindParam(':category_name', $category_name);
        if ($stmt->execute()) {
            // category added successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function updateCategory($pdo)
{
    try {
        $category_name = $_POST['category_name'];
        $update_ID = $_POST['update_id'];
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM category WHERE category_name = :category_name AND category_id != :category_id");
        $stmt_check->bindParam(':category_name', $category_name);
        $stmt_check->bindParam(':category_id', $update_ID, PDO::PARAM_INT);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            // Category already exists, return false
            return false;
        }

        $stmt = $pdo->prepare("UPDATE category SET category_name = :category_name WHERE category_id = :category_id");
        //bind parameters
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':category_id', $update_ID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function deleteCategory($pdo)
{
    try {
        $delete_id = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM category WHERE category_id = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Food delete successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
