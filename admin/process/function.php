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
function getFoodOrderbyID($pdo)
{
    try {
        $order_no = isset($_POST['order_no']) ? $_POST['order_no'] : null;

        if ($order_no) {
            $query = "SELECT
            c.id,
            c.menu_id,
            a.menu_name,
            c.variation_id,
            b.variation_name,
            c.qty,
            c.price
            FROM menu a
            INNER JOIN variations b
            INNER JOIN ordered_menu c ON c.menu_id = a.id AND c.variation_id = b.id
            WHERE c.order_no = :order_no";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':order_no', $order_no, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                return $results;
            } else {
                return json_encode(['success' => false, 'message' => 'No menu items found for ORDER NO: ' . $order_no]);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Menu ID is missing']);
        }
    } catch (PDOException $e) {
        // Handle database connection or query error
        return json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
function getFoodList($pdo){
    try {
        $query = "SELECT
        a.id AS menu_id,
        a.menu_name,
        b.variation_name,
        c.price
        FROM menu a
        INNER JOIN variations b
        INNER JOIN menu_variations c ON c.menu_id = a.id AND c.variation_id = b.id";
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
        $food_description = $_POST['food_description'];
        $category_id = $_POST['category_id'];
        $foodOption = isset($_POST['foodOption']) ? $_POST['foodOption'] : '';

        // Check if Food is Enabled
        $isEnabled = ($foodOption === 'on') ? 1 : 0;

        // Check if food item already exists
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE menu_name = :food_name");
        $stmt_check->bindParam(':food_name', $food_name);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();
        if ($count > 0) {
            return false; // Food already exists
        }

        // Handle file upload
        if (!empty($_FILES["foodImg"]["name"])) {
            $target_dir = "../../assets/images/menu/"; // Directory where the file will be saved
            $file_name = basename($_FILES["foodImg"]["name"]);
            $target_file = $target_dir . $file_name;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if it's a valid image
            $check = getimagesize($_FILES["foodImg"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["foodImg"]["size"] > 2000000) { // Limit to 2000KB
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                return false;
            } else {
                // if everything is ok, try to upload file
                if (!move_uploaded_file($_FILES["foodImg"]["tmp_name"], $target_file)) {
                    echo "Sorry, there was an error uploading your file.";
                    return false;
                }
            }
        } else {
            // No file uploaded, use default image
            $file_name = 'default.png';
        }

        // Insert food details along with the image file name into the database
        $stmt = $pdo->prepare("INSERT INTO menu (menu_name, menu_description, category_id, menu_img, isEnabled) VALUES (:food_name, :food_description, :category_id, :menu_img, :isEnabled)");
        $stmt->bindParam(':food_name', $food_name);
        $stmt->bindParam(':food_description', $food_description);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':menu_img', $file_name);
        $stmt->bindParam(':isEnabled', $isEnabled, PDO::PARAM_INT);

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
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return false;
    }
}


function updateFood($pdo)
{
    try {
        $updateId = $_POST['update-id'];
        $food_name = $_POST['food_name'];
        $food_description = $_POST['food_description'];
        $category_id = $_POST['category_id'];
        $foodOption = isset($_POST['foodOption']) ? $_POST['foodOption'] : '';

        // Convert foodOption to integer for database
        $foodOption = ($foodOption === 'on') ? 1 : 0;

        // Handle file upload if a new image is selected
        if ($_FILES["foodImg"]["name"]) {
            $target_dir = "../../assets/images/menu/";
            $target_file = $target_dir . basename($_FILES["foodImg"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file already exists
            if (file_exists($target_file)) {
                // Use the existing file if it already exists
                $file_name = basename($_FILES["foodImg"]["name"]);
            } else {
                // Perform additional checks and validations for the uploaded file
                $check = getimagesize($_FILES["foodImg"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
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
                        $file_name = basename($_FILES["foodImg"]["name"]);
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        return false;
                    }
                }
            }

            // Update menu record with new image file name
            $stmt_update_img = $pdo->prepare("UPDATE menu SET menu_name = :food_name, menu_description = :food_description, category_id = :category_id, menu_img = :menu_img, isEnabled = :foodOption WHERE id = :updateId");
            $stmt_update_img->bindParam(':menu_img', $file_name);
        } else {
            // Update menu record without changing the image
            $stmt_update = $pdo->prepare("UPDATE menu SET menu_name = :food_name, menu_description = :food_description, category_id = :category_id, isEnabled = :foodOption WHERE id = :updateId");
        }

        // Bind parameters and execute the update query
        if (isset($stmt_update)) {
            $stmt_update->bindParam(':food_name', $food_name);
            $stmt_update->bindParam(':food_description', $food_description);
            $stmt_update->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt_update->bindParam(':foodOption', $foodOption, PDO::PARAM_INT);
            $stmt_update->bindParam(':updateId', $updateId, PDO::PARAM_INT);

            if ($stmt_update->execute()) {
                // Handle variations update or delete
                // Get existing variations associated with the menu item
                $stmt_existing_variations = $pdo->prepare("SELECT mv.variation_id FROM menu_variations mv WHERE mv.menu_id = :updateId");
                $stmt_existing_variations->bindParam(':updateId', $updateId, PDO::PARAM_INT);
                $stmt_existing_variations->execute();
                $existing_variations = $stmt_existing_variations->fetchAll(PDO::FETCH_COLUMN, 0);

                $updated_variations = $_POST['variations'];

                // Prepare array to track existing variation IDs to be deleted if not in updated variations
                $existing_variation_ids = $existing_variations;

                // Insert or update variations
                foreach ($updated_variations as $variation) {
                    $variation_name = $variation['name'];
                    $variation_price = $variation['price'];

                    // Check if the variation already exists
                    $stmt_var = $pdo->prepare("SELECT id FROM variations WHERE variation_name = :variation_name");
                    $stmt_var->bindParam(':variation_name', $variation_name);
                    $stmt_var->execute();
                    $variation_id = $stmt_var->fetchColumn();

                    if ($variation_id) {
                        // If the variation exists, check if it's already associated with the menu
                        if (in_array($variation_id, $existing_variations)) {
                            // Update the existing association
                            $stmt_update_variation = $pdo->prepare("UPDATE menu_variations SET price = :price WHERE menu_id = :updateId AND variation_id = :variation_id");
                            $stmt_update_variation->bindParam(':price', $variation_price);
                            $stmt_update_variation->bindParam(':updateId', $updateId, PDO::PARAM_INT);
                            $stmt_update_variation->bindParam(':variation_id', $variation_id, PDO::PARAM_INT);
                            $stmt_update_variation->execute();

                            // Remove from existing variation IDs list (for tracking deletions)
                            unset($existing_variation_ids[array_search($variation_id, $existing_variation_ids)]);
                        } else {
                            // If the variation exists but is not associated with the menu, insert the association
                            $stmt_insert_menu_variation = $pdo->prepare("INSERT INTO menu_variations (menu_id, variation_id, price) VALUES (:updateId, :variation_id, :price)");
                            $stmt_insert_menu_variation->bindParam(':updateId', $updateId, PDO::PARAM_INT);
                            $stmt_insert_menu_variation->bindParam(':variation_id', $variation_id, PDO::PARAM_INT);
                            $stmt_insert_menu_variation->bindParam(':price', $variation_price);
                            $stmt_insert_menu_variation->execute();
                        }
                    }
                }

                // Delete variations that are no longer present in updated_variations
                foreach ($existing_variation_ids as $delete_variation_id) {
                    $stmt_delete_variation = $pdo->prepare("DELETE FROM menu_variations WHERE menu_id = :updateId AND variation_id = :variation_id");
                    $stmt_delete_variation->bindParam(':updateId', $updateId, PDO::PARAM_INT);
                    $stmt_delete_variation->bindParam(':variation_id', $delete_variation_id, PDO::PARAM_INT);
                    $stmt_delete_variation->execute();
                }

                return true; // Food and variations updated successfully
            } else {
                // Handle update failure
                return false;
            }
        } elseif (isset($stmt_update_img)) {
            $stmt_update_img->bindParam(':food_name', $food_name);
            $stmt_update_img->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt_update_img->bindParam(':foodOption', $foodOption, PDO::PARAM_INT);
            $stmt_update_img->bindParam(':updateId', $updateId, PDO::PARAM_INT);

            if ($stmt_update_img->execute()) {
                // Handle variations update similar to the section above
                return true; // Food and variations updated successfully
            } else {
                // Handle update failure
                return false;
            }
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return false;
    }
}



// function updateFood($pdo)
// {
//     try {
//         $updateId = $_POST['update-id'];
//         $food_name = $_POST['food_name'];
//         $category_id = $_POST['category_id'];
//         $foodOption = isset($_POST['foodOption']) ? $_POST['foodOption'] : '';

//         // Convert foodOption to integer for database
//         $foodOption = ($foodOption === 'on') ? 1 : 0;

//         // Handle file upload if a new image is selected
//         if ($_FILES["foodImg"]["name"]) {
//             $target_dir = "../../assets/images/menu/";
//             $target_file = $target_dir . basename($_FILES["foodImg"]["name"]);

//             // Perform checks and validations similar to addFood function for file upload
//             // ...

//             // if (move_uploaded_file($_FILES["foodImg"]["tmp_name"], $target_file)) {
//             //     // Update menu record with new image file name
//             //     $stmt_update_img = $pdo->prepare("UPDATE menu SET menu_name = :food_name, category_id = :category_id, menu_img = :menu_img, isEnabled = :foodOption WHERE id = :updateId");
//             //     $stmt_update_img->bindParam(':menu_img', $file_name);
//             // }
//         } else {
//             // Update menu record without changing the image
//             $stmt_update = $pdo->prepare("UPDATE menu SET menu_name = :food_name, category_id = :category_id, isEnabled = :foodOption WHERE id = :updateId");
//         }

//         // Bind parameters and execute the update query
//         if (isset($stmt_update)) {
//             $stmt_update->bindParam(':food_name', $food_name);
//             $stmt_update->bindParam(':category_id', $category_id, PDO::PARAM_INT);
//             $stmt_update->bindParam(':foodOption', $foodOption, PDO::PARAM_INT);
//             $stmt_update->bindParam(':updateId', $updateId, PDO::PARAM_INT);

//             if ($stmt_update->execute()) {
//                 // Handle variations update or delete
//                 // Get existing variations associated with the menu item
//                 $stmt_existing_variations = $pdo->prepare("SELECT mv.id AS mv_id, mv.variation_id, mv.price, v.variation_name FROM menu_variations mv JOIN variations v ON mv.variation_id = v.id WHERE mv.menu_id = :updateId");
//                 $stmt_existing_variations->bindParam(':updateId', $updateId, PDO::PARAM_INT);
//                 $stmt_existing_variations->execute();
//                 $existing_variations = $stmt_existing_variations->fetchAll(PDO::FETCH_ASSOC);

//                 // Prepare arrays to track which variations to update, delete, or insert
//                 $existing_variation_ids = array_map(function ($var) {
//                     return $var['variation_id'];
//                 }, $existing_variations);
//                 $existing_variation_map = array_combine($existing_variation_ids, $existing_variations);

//                 $updated_variations = $_POST['variations'];

//                 // Update existing variations
//                 foreach ($updated_variations as $variation) {
//                     $variation_id = $variation['id'];
//                     $variation_name = $variation['name'];
//                     $variation_price = $variation['price'];

//                     if (in_array($variation_id, $existing_variation_ids)) {
//                         // Update existing variation
//                         $stmt_update_variation = $pdo->prepare("UPDATE menu_variations SET price = :price WHERE id = :mv_id");
//                         $stmt_update_variation->bindParam(':price', $variation_price);
//                         $stmt_update_variation->bindParam(':mv_id', $existing_variation_map[$variation_id]['mv_id'], PDO::PARAM_INT);
//                         $stmt_update_variation->execute();

//                         // Remove from existing variation IDs list (for tracking deletions)
//                         unset($existing_variation_ids[array_search($variation_id, $existing_variation_ids)]);
//                     } else {
//                         // Variation doesn't exist, insert as new
//                         $stmt_insert_variation = $pdo->prepare("INSERT INTO menu_variations (menu_id, variation_id, price) VALUES (:updateId, :variation_id, :price)");
//                         $stmt_insert_variation->bindParam(':updateId', $updateId, PDO::PARAM_INT);
//                         $stmt_insert_variation->bindParam(':variation_id', $variation_id, PDO::PARAM_INT);
//                         $stmt_insert_variation->bindParam(':price', $variation_price);
//                         $stmt_insert_variation->execute();
//                     }
//                 }

//                 // Delete variations that are no longer present in updated_variations
//                 foreach ($existing_variation_ids as $delete_variation_id) {
//                     $stmt_delete_variation = $pdo->prepare("DELETE FROM menu_variations WHERE id = :mv_id");
//                     $stmt_delete_variation->bindParam(':mv_id', $existing_variation_map[$delete_variation_id]['mv_id'], PDO::PARAM_INT);
//                     $stmt_delete_variation->execute();
//                 }

//                 return true; // Food and variations updated successfully
//             } else {
//                 // Handle update failure
//                 return false;
//             }
//         } elseif (isset($stmt_update_img)) {
//             $stmt_update_img->bindParam(':food_name', $food_name);
//             $stmt_update_img->bindParam(':category_id', $category_id, PDO::PARAM_INT);
//             $stmt_update_img->bindParam(':foodOption', $foodOption, PDO::PARAM_INT);
//             $stmt_update_img->bindParam(':updateId', $updateId, PDO::PARAM_INT);

//             if ($stmt_update_img->execute()) {
//                 // Handle variations update similar to the section above
//                 return true; // Food and variations updated successfully
//             } else {
//                 // Handle update failure
//                 return false;
//             }
//         } else {
//             return false;
//         }
//     } catch (PDOException $e) {
//         // Handle database connection error
//         return false;
//     }
// }


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
function Order_to_Process($pdo)
{
    try {
        $order_no = $_POST['order_no'];
        // Begin a transaction
        $pdo->beginTransaction();

        // SQL query to insert data into customer_process
        $insertQuery = "INSERT INTO customer_process (order_no, table_no, customer_name, created_at)
            SELECT order_no, table_no, customer_name, created_at
            FROM customer_order
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the insert query
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([':order_no' => $order_no]);

        // SQL query to delete data from customer_order
        $deleteQuery = "DELETE FROM customer_order
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the delete query
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':order_no' => $order_no]);

        // Commit the transaction
        $pdo->commit();

        return true; // Return true if the transaction is successful
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();

        return false; // Return false if the transaction fails
    }
}

function Order_to_Cancel($pdo)
{
    try {
        $order_no = $_POST['order_no'];
        // Begin a transaction
        $pdo->beginTransaction();

        // SQL query to insert data into customer_process
        $insertQuery = "INSERT INTO customer_canceled (order_no, table_no, customer_name, created_at)
            SELECT order_no, table_no, customer_name, created_at
            FROM customer_order
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the insert query
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([':order_no' => $order_no]);

        // SQL query to delete data from customer_order
        $deleteQuery = "DELETE FROM customer_order
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the delete query
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':order_no' => $order_no]);

        // Commit the transaction
        $pdo->commit();

        return true; // Return true if the transaction is successful
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();

        return false; // Return false if the transaction fails
    }
}
function Process_to_Serve($pdo)
{
    try {
        $order_no = $_POST['order_no'];
        // Begin a transaction
        $pdo->beginTransaction();

        // SQL query to insert data into customer_process
        $insertQuery = "INSERT INTO customer_serve (order_no, table_no, customer_name, created_at)
            SELECT order_no, table_no, customer_name, created_at
            FROM customer_process
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the insert query
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([':order_no' => $order_no]);

        // SQL query to delete data from customer_order
        $deleteQuery = "DELETE FROM customer_process
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the delete query
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':order_no' => $order_no]);

        // Commit the transaction
        $pdo->commit();

        return true; // Return true if the transaction is successful
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();

        return false; // Return false if the transaction fails
    }
}
function Process_to_Cancel($pdo)
{
    try {
        $order_no = $_POST['order_no'];
        // Begin a transaction
        $pdo->beginTransaction();

        // SQL query to insert data into customer_process
        $insertQuery = "INSERT INTO customer_canceled (order_no, table_no, customer_name, created_at)
            SELECT order_no, table_no, customer_name, created_at
            FROM customer_process
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the insert query
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([':order_no' => $order_no]);

        // SQL query to delete data from customer_order
        $deleteQuery = "DELETE FROM customer_process
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the delete query
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':order_no' => $order_no]);

        // Commit the transaction
        $pdo->commit();

        return true; // Return true if the transaction is successful
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();

        return false; // Return false if the transaction fails
    }
}
function Serve_to_Complete($pdo)
{
    try {
        $order_no = $_POST['order_no'];
        // Begin a transaction
        $pdo->beginTransaction();

        // SQL query to insert data into customer_serve
        $insertQuery = "INSERT INTO customer_complete (order_no, table_no, customer_name, created_at)
            SELECT order_no, table_no, customer_name, created_at
            FROM customer_serve
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the insert query
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([':order_no' => $order_no]);

        // SQL query to delete data from customer_order
        $deleteQuery = "DELETE FROM customer_serve
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the delete query
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':order_no' => $order_no]);

        // Commit the transaction
        $pdo->commit();

        return true; // Return true if the transaction is successful
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();

        return false; // Return false if the transaction fails
    }
}
function Cancel_to_Order($pdo)
{
    try {
        $order_no = $_POST['order_no'];
        // Begin a transaction
        $pdo->beginTransaction();

        // SQL query to insert data into customer_process
        $insertQuery = "INSERT INTO customer_process (order_no, table_no, customer_name, created_at)
            SELECT order_no, table_no, customer_name, created_at
            FROM customer_canceled
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the insert query
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([':order_no' => $order_no]);

        // SQL query to delete data from customer_process
        $deleteQuery = "DELETE FROM customer_canceled
            WHERE order_no = :order_no;
        ";
        // Prepare and execute the delete query
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([':order_no' => $order_no]);

        // Commit the transaction
        $pdo->commit();

        return true; // Return true if the transaction is successful
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();

        return false; // Return false if the transaction fails
    }
}
function OrderListbyID($pdo, $orderNo) {
    try {
        // Query to fetch order details
        $stmt = $pdo->prepare("
            SELECT
                a.order_no,
                b.menu_name,
                c.variation_name,
                a.qty,
                a.price
            FROM ordered_menu a
            INNER JOIN menu b ON b.id = a.menu_id
            INNER JOIN variations c ON c.id = a.variation_id
            WHERE a.order_no = :order_no
        ");
        $stmt->bindParam(':order_no', $orderNo, PDO::PARAM_INT);
        $stmt->execute();
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $orderDetails;
    } catch (PDOException $e) {
        return false; // Return false if an error occurs
    }
}