<?php

function get_all_users($conn, $role = null)
{
    $sql = "SELECT * FROM users";
    if ($role) {
        $sql .= " WHERE role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$role]);
    } else {
        $sql .= " WHERE role IN (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["admin", "employee", "client"]);
    }

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return 0;
    }
}

function insert_user($conn, $data)
{
    $sql = "INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// 🔁 Used when editing user WITHOUT changing password
function update_user($conn, $id, $full_name, $username)
{
    $sql = "UPDATE users SET full_name = ?, username = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$full_name, $username, $id]);
}

// 🔐 Used when editing user WITH password change
function update_user_with_password($conn, $id, $full_name, $username, $password)
{
    $sql = "UPDATE users SET full_name = ?, username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$full_name, $username, $password, $id]);
}

function delete_user($conn, $data)
{
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function get_user_by_id($conn, $id)
{
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    } else {
        return 0;
    }
}

function update_profile($conn, $data)
{
    $sql = "UPDATE users SET full_name = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function count_users($conn)
{
    $sql = "SELECT id FROM users WHERE role = 'employee'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}
