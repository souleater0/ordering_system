<?php 
function loginProcess($pdo){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username= ?");
    $stmt ->execute([$username]);
    $user = $stmt ->fetch();

    if($user && password_verify($password, $user["password"])){
        //login success
        // session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION['logged_in'] = true;
        $_SESSION['user_role'] = $user["role_id"];
        return true;
    }else{
        return false;
    }
}
function getRole($pdo){
    try {
        $query = "SELECT * FROM roles";
        $stmt = $pdo->prepare($query);

        $stmt ->execute();
        $roles = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return $roles;
    }catch(PDOException $e){
                // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function addUser($pdo){
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

        $stmt = $pdo ->prepare("INSERT INTO users (username, password, display_name, role_id, isEnabled) VALUES (:username, :password, :display_name, :role_id , :isEnabled)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':display_name', $user_display);
        $stmt->bindParam(':role_id', $user_role, PDO::PARAM_INT);
        $stmt->bindParam(':isEnabled', $loginEnabled, PDO::PARAM_INT);
        if ($stmt->execute()){
            // Users added successfully
            return true;
        } else {
            // Error occurred
            return false;
        }
    }catch(PDOException $e){
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function updateUser($pdo){
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
        }else{
            return false;
        }
    }catch(PDOException $e){
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function updateUserPassword($pdo){
    try {
        $update_ID = $_POST['update_id'];
        $password = password_hash($_POST['c_password'], PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        //bind parameters
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $update_ID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }else{
            return false;
        }
    }catch(PDOException $e){
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}

?>