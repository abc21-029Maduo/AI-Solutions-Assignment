<?php
// dbConnect.php
// PHP code to connect to the ai_solutions database on server 127.0.0.1, port 3307 using PDO

function getDbConnection() {
    $server = "127.0.0.1";
    $port = 3307;
    $database = "ai_solutions";
    $username = "root";
    $password = "";

    try {
        $dsn = "mysql:host={$server};port={$port};dbname={$database};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Handle connection error
        die("Database connection failed: " . $e->getMessage());
    }
}

/**
 * Fetch data for the admin dashboard
 * Returns an associative array with keys:
 * - totalDemoRequests (int)
 * - totalEventSignups (int)
 * - mostRequestedSolution (array with keys INTERESTAREA and count)
 */
function fetchDashboardData() {
    $pdo = getDbConnection();

    // Query total demo requests
    $stmt1 = $pdo->query("SELECT COUNT(*) AS total FROM demorequest");
    $totalDemoRequests = $stmt1->fetchColumn();

    // Query total event signups
    $stmt2 = $pdo->query("SELECT COUNT(*) AS total FROM eventtparticipation");
    $totalEventSignups = $stmt2->fetchColumn();

    // Query most requested AI solution
    $stmt3 = $pdo->query("
        SELECT INTERESTAREA, COUNT(*) AS count 
        FROM demorequest
        GROUP BY INTERESTAREA
        ORDER BY count DESC 
        LIMIT 1
    ");
    $mostRequestedSolution = $stmt3->fetch(PDO::FETCH_ASSOC);

    return [
        'totalDemoRequests' => (int)$totalDemoRequests,
        'totalEventSignups' => (int)$totalEventSignups,
        'mostRequestedSolution' => $mostRequestedSolution ?: null,
    ];
}
/**
 * Insert a new demo request into the demorequest table
 * 
 * @param string $customerid
 * @param string $phone
 * @param string $interestarea
 * @param string $demodate (YYYY-MM-DD)
 * @param string $submissionDate (YYYY-MM-DD)
 * @return bool True on success, False on failure
 */
function insertDemoRequest($customerid, $phone, $interestarea, $demodate, $submissionDate) {
    try {
        $pdo = getDbConnection();
        $sql = "INSERT INTO demorequest (customerid, phonenumber, interestarea, requesteddate, requestsubmissiondate) 
                VALUES (:customerid, :phone, :interestarea, :demodate, :submissionDate)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customerid', $customerid);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':interestarea', $interestarea);
        $stmt->bindParam(':demodate', $demodate);
        $stmt->bindParam(':submissionDate', $submissionDate);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Print the actual error for debugging (you can later log this instead of printing)
        echo "Insert error: " . $e->getMessage();
        return false;
    }
}

/**
 * Insert a new feedback entry into the feedback table
 * 
 * @param string $customerid
 * @param string $interestarea
 * @param int $rating
 * @param string $comments
 * @param string $submissionDate (YYYY-MM-DD)
 * @return bool True on success, False on failure
 */
function insertFeedback($customerid, $interestarea, $rating, $comments, $submissionDate) {
    try {
        $pdo = getDbConnection();
        $sql = "INSERT INTO feedback (customerid, interestarea, rating, comments, submissiondate) 
                VALUES (:customerid, :interestarea, :rating, :comments, :submissionDate)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customerid', $customerid);
        $stmt->bindParam(':interestarea', $interestarea);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':submissionDate', $submissionDate);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Print the actual error for debugging (you can later log this instead of printing)
        echo "Insert error: " . $e->getMessage();
        return false;
    }
}

/**
 * Update follow-up status and notes for a feedback entry
 * 
 * @param int $id
 * @param string $followup_status
 * @param string $followup_notes
 * @return bool True on success, False on failure
 */
function updateFeedbackFollowup($id, $followup_status, $followup_notes) {
    try {
        $pdo = getDbConnection();
        $sql = "UPDATE feedback SET followup_status = :followup_status, followup_notes = :followup_notes WHERE feedbackID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':followup_status', $followup_status);
        $stmt->bindParam(':followup_notes', $followup_notes);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Update error: " . $e->getMessage();
        return false;
    }
}

?>
