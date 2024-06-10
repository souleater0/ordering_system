<?php
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

function getFoodMenu($pdo)
{
    try {
        $query = "SELECT * FROM menu";
        $stmt = $pdo->prepare($query);

        $stmt->execute();
        $foodmenu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $foodmenu;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function getFoodMenubyID($pdo)
{
    try {
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;

        if ($category_id) {
            $query = "SELECT * FROM menu a
                      INNER JOIN category b ON b.category_id = a.category_id
                      WHERE a.category_id = :category_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        } else {
            $query = "SELECT * FROM menu a
                      INNER JOIN category b ON b.category_id = a.category_id";
            $stmt = $pdo->prepare($query);
        }

        $stmt->execute();
        $foodmenulist_by_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $foodmenulist_by_id;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}
function getFoodMenubyMenuID($pdo){
    try {
        $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;

        if ($menu_id) {
            $query = "SELECT * FROM menu
            where menu.id = :menu_id AND menu.isArchive = 0";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
        }
        $stmt->execute();
        $menubyid = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menubyid;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array if an error occurs
    }
}