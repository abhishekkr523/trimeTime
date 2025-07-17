<?php
require '../config/database.php';

if (isset($_POST['update_profile'])) {
    $id             = $_POST['barber_id'];
    $shop_name      = trim($_POST['shop_name']);
    $address        = trim($_POST['address']);
    $contact_number = trim($_POST['contact_number']);
    $opening_hours  = trim($_POST['opening_hours']);
    $price_range    = trim($_POST['price_range']);

    // Handle profile image upload
    $profile_image = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../uploads/";
        $profile_image = time() . '_' . basename($_FILES['profile_image']['name']);
        $target_file = $target_dir . $profile_image;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);
    }

    $sql = "UPDATE users SET 
                shop_name = ?, 
                address = ?, 
                contact_number = ?, 
                opening_hours = ?, 
                price_range = ?";

    if ($profile_image) {
        $sql .= ", profile_image = ?";
    }

    $sql .= " WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    $params = [$shop_name, $address, $contact_number, $opening_hours, $price_range];
    if ($profile_image) $params[] = $profile_image;
    $params[] = $id;

    $stmt->execute($params);

    header("Location: ../barber/profile.php");
    exit;
}
?>
