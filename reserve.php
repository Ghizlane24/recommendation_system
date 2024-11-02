<?php
include 'operations.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $bookId = $_POST['book_id'];

    // Get the genre of the reserved book
    $query = "SELECT genre FROM books WHERE id = :bookId";
    $stmt = $db->prepare($query);
    $stmt->execute(['bookId' => $bookId]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        $genre = $book['genre'];

        // Insert reservation record
        $reserveQuery = "INSERT INTO reservations (id_user, id_book, date_reservation) VALUES (:userId, :bookId, NOW())";
        $reserveStmt = $db->prepare($reserveQuery);
        $reserveStmt->execute(['userId' => $userId, 'bookId' => $bookId]);


        // Redirect to index or a confirmation page
        header("Location: index.php");
        exit();
    } else {
        echo "Livre introuvable.";
    }
}
?>
