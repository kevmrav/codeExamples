<?php
require_once('taskClass.php');

$taskClass = new TaskClass();
$postedData = $_POST;

$result = false;
$retrievedData = null;

if ($postedData['operation'] == 'retrieve') {
    $record = $taskClass->getRows($postedData['task_id']);
    if ($record) {
        $result = true;
        $retrievedData = $record[0];
    }

}elseif ($postedData['operation'] == 'add') {
    $result = $taskClass->addTask($postedData);

}elseif ($postedData['operation'] == 'edit'){
    $result = $taskClass->updateTask($postedData);

}elseif ($postedData['operation'] == 'delete'){
    $result = $taskClass->deleteTask($postedData['task_id']);

}elseif ($postedData['operation'] == 'completion'){
    $result = $taskClass->updateCompletionDate($postedData['task_id']);

}

echo json_encode([
    'success' => $result,
    'data' => $retrievedData
]);
exit;
