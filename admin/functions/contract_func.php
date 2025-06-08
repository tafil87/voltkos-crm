<?php
function getNextContractId(mysqli $db) {
    $query = "SHOW TABLE STATUS LIKE 'customers'";
    $result = mysqli_query($db, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return (int) $row['Auto_increment'];
    }

    return null; // or throw an exception / return error code
}

function getContract($db) {

    $stmt = $db->prepare("SELECT * FROM contracts a, customers b where a.customer_id = b.id order by a.id desc; ");
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    return $data;
}