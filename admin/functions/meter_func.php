<?php

function getMeters($db) {

    $stmt = $db->prepare("SELECT * FROM meters order by id desc");
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    return $data;
}