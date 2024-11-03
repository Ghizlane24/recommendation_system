<?php
include 'db/database.php';

$db = getConnection();


// Function to get user preferences
function getUserPreferences($userId, $db) {
    $query = "
        SELECT books.genre, COUNT(*) as count
        FROM reservations
        INNER JOIN books ON reservations.id_book = books.id
        WHERE reservations.id_user = :userId
        GROUP BY books.genre
        ORDER BY count DESC;
    ";
    $stmt = $db->prepare($query);
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to suggest books
function suggestBooks($userId, $db) {
    $userPreferences = getUserPreferences($userId, $db);
    $suggestedBooksByGenre = [];
    $addedBooks = [];

    // Suggest books based on user’s preferred genres
    foreach ($userPreferences as $preference) {
        $genre = $preference['genre'];
        
        $query = "
            SELECT * FROM books 
            WHERE genre = :genre
            AND id NOT IN (
                SELECT id_book FROM reservations WHERE id_user = :userId
            )
            ORDER BY popularity_score DESC
            LIMIT 5;
        ";
        $stmt = $db->prepare($query);
        $stmt->execute(['genre' => $genre, 'userId' => $userId]);
        
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Avoid duplicates by checking the addedBooks array
        foreach ($books as $book) {
            if (!isset($addedBooks[$book['id']])) {
                $suggestedBooksByGenre[$genre][] = $book;
                $addedBooks[$book['id']] = true;
            }
        }
    }

    // Get popular books that the user hasn’t reserved
    $suggestedBooksByPopularity = [];
    $popularQuery = "
        SELECT * FROM books
        WHERE id NOT IN (SELECT id_book FROM reservations WHERE id_user = :userId)
        ORDER BY popularity_score DESC;
        
    ";
    $popularStmt = $db->prepare($popularQuery);
    $popularStmt->execute(['userId' => $userId]);
    
    $popularBooks = $popularStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($popularBooks as $book) {
        if (!isset($addedBooks[$book['id']])) {
            $suggestedBooksByPopularity[] = $book;
            $addedBooks[$book['id']] = true;
        }
    }

    return [
        'by_genre' => $suggestedBooksByGenre,
        'by_popularity' => $suggestedBooksByPopularity,
    ];
}


function updatePopularityScore($bookId, $db, $interval = 30) {
    $query = "
        UPDATE books 
        SET popularity_score = (
            SELECT COUNT(*) 
            FROM reservations 
            WHERE id_book = :bookId 
            AND date_reservation >= DATE_SUB(NOW(), INTERVAL :interval DAY)
        )
        WHERE id = :bookId
    ";

    $stmt = $db->prepare($query);
    $stmt->execute(['bookId' => $bookId, 'interval' => $interval]);
}
