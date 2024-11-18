<?php
require("cntdb.php");
$page_title = "Admin Panel";
include('includes/header.php');
include('includes/navbar.php');
include('includes/footer.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<div class="container">
    <h2 style="text-align:center; margin:20px auto;">Admin Panel</h2>
    </div>

<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "manoranjan_db");

if (!$conn) {
    die("Cannot connect to database: " . mysqli_connect_error());
}

// Count records in each table for debugging
$reports_count = mysqli_query($conn, "SELECT COUNT(*) FROM reports");
$comments_count = mysqli_query($conn, "SELECT COUNT(*) FROM comments");
$posts_count = mysqli_query($conn, "SELECT COUNT(*) FROM posts");

echo "Reports: " . mysqli_fetch_row($reports_count)[0] . "<br>";
echo "Comments: " . mysqli_fetch_row($comments_count)[0] . "<br>";
echo "Posts: " . mysqli_fetch_row($posts_count)[0] . "<br>";

// Fetch data from reports, comments, and posts
$query = "
    SELECT reports.id, 
           reports.user_email AS report_user_email, 
           comments.user_email AS comment_user_email, 
           posts.email AS post_user_email, 
           reports.reason, 
           comments.comment 
    FROM reports
    INNER JOIN comments ON reports.post_id = comments.post_id
    INNER JOIN posts ON comments.post_id = posts.id
";

// Debug: Show the query
// echo $query; // Uncomment this line to check the query

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if there are results
if (mysqli_num_rows($result) === 0) {
    echo "<p>No reports found.</p>";
} else {
    // Display the reported comments with "Send Warning" and "Delete" buttons
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='padding: 10px; margin-bottom: 20px; background-color: #f8f8f8;'>";

        // Display emails
        echo "<p><strong>Reported User Email (Reports):</strong> " . htmlspecialchars($row['report_user_email'], ENT_QUOTES) . "</p>";
        echo "<p><strong>Comment User Email (Comments):</strong> " . htmlspecialchars($row['comment_user_email'], ENT_QUOTES) . "</p>";
        echo "<p><strong>Post User Email:</strong> " . htmlspecialchars($row['post_user_email'], ENT_QUOTES) . "</p>";
        
        echo "<p><strong>Reported Reason:</strong> " . htmlspecialchars($row['reason'], ENT_QUOTES) . "</p>";
        echo "<p><strong>Comment:</strong> <span style='color:red;'>" . htmlspecialchars($row['comment'], ENT_QUOTES) . "</span></p>";

        // Send Warning button (Send email to comment_user_email)
        echo "<form action='send_warning.php' method='POST' style='display: inline;'>";
        echo "<input type='hidden' name='user_email' value='" . htmlspecialchars($row['comment_user_email'], ENT_QUOTES) . "'>"; // Use comment_user_email here
        echo "<button 
            onclick=\"if(confirm('Are you sure you want to send a warning?')) { this.form.submit(); }\" 
            type='button' 
            style='background-color: yellow; padding: 5px;'>
            Send Warning
        </button>";
        echo "</form>";

        // Delete button (deletes the specific comment)
        echo "<form action='delete_user.php' method='POST' style='display: inline; margin-left: 10px;'>";
        echo "<input type='hidden' name='user_email' value='" . htmlspecialchars($row['comment_user_email'], ENT_QUOTES) . "'>"; // Use comment_user_email here
        echo "<input type='hidden' name='comment_id' value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'>"; // Assuming 'id' is the unique identifier for comments
        echo "<button type='submit' style='background-color: red; color: white; padding: 5px;'>Delete</button>";
        echo "</form>";

        echo "</div>"; // Close the comment container
    }
}

mysqli_close($conn);
?>
