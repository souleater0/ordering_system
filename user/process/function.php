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
            $query = "SELECT a.id, a.menu_name,
            IFNULL(MIN(b.price), 'undefined') AS menu_price,
            c.category_name,
            a.menu_img,
            a.created_at
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN category c ON a.category_id = c.category_id
            WHERE a.category_id = :category_id
            GROUP BY a.id, a.menu_name, a.category_id, c.category_name, a.created_at, a.updated_at";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        } else {
            $query = "SELECT a.id, a.menu_name,
            IFNULL(MIN(b.price), 'undefined') AS menu_price,
            c.category_name,
            a.menu_img,
            a.created_at
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN category c ON a.category_id = c.category_id
            GROUP BY a.id, a.menu_name, a.category_id, c.category_name, a.created_at, a.updated_at";
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
function getFoodDetailsbyID($pdo) {
    try {
        $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;

        if ($menu_id) {
            $query = "SELECT
                a.id,
                a.menu_img,
                a.menu_name,
                a.menu_description,
                a.category_id,
                d.category_name,
                c.id AS variation_id,
                c.variation_name,
                b.price
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN variations c ON b.variation_id = c.id
            LEFT JOIN category d ON a.category_id = d.category_id
            WHERE b.menu_id = :menu_id AND a.isArchive = 0";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                $menuItems = [];

                foreach ($results as $row) {
                    $menuID = $row['id'];
                    if (!isset($menuItems[$menuID])) {
                        $menuItems[$menuID] = [
                            'id' => $row['id'],
                            'img_path' => $row['menu_img'],
                            'menu_name' => $row['menu_name'],
                            'menu_description' => $row['menu_description'],
                            'category_name' => $row['category_name'],
                            'variations' => []
                        ];
                    }
                    $menuItems[$menuID]['variations'][] = [
                        'id' => $row['variation_id'],
                        'name' => $row['variation_name'],
                        'price' => (float) $row['price']
                    ];
                }

                // Return JSON-encoded data
                return array_values($menuItems);
            } else {
                return json_encode(['success' => false, 'message' => 'No menu items found for menu ID: ' . $menu_id]);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Menu ID is missing']);
        }
    } catch (PDOException $e) {
        // Handle database connection or query error
        return json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

function getFoodMenubyMenuID($pdo){
    try {
        $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;
        $variation_id = isset($_POST['variation_id']) ? $_POST['variation_id'] : null;

        if ($menu_id) {
            $query = "SELECT
            a.id,
            a.menu_name,
            c.id AS variation_id,
            c.variation_name,
            b.price
            FROM menu a
            LEFT JOIN menu_variations b ON a.id = b.menu_id
            LEFT JOIN variations c ON b.variation_id = c.id
            WHERE b.menu_id = :menu_id AND b.variation_id = :variation_id AND a.isArchive = 0";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':menu_id', $menu_id, PDO::PARAM_INT);
            $stmt->bindParam(':variation_id', $variation_id, PDO::PARAM_INT);
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