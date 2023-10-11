<?php
// Calculate pagination variables

$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$recordsPerPage = 11;
$totalRecords = count($dataArray);
$totalPages = ceil($totalRecords / $recordsPerPage);
$startIndex = ($currentPage - 1) * $recordsPerPage;
$endIndex = $startIndex + $recordsPerPage;

// Slice the array based on the current page
$slicedDataArray = array_slice($dataArray, $startIndex, $recordsPerPage);
