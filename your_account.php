<?php
include('config/connect.php');

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$u_id = $_SESSION['user_id'];
$username = '';
$fullName = '';
$email = '';
$phone = '';
$gender = '';
$dob = '';
$updateSuccess = false;
$otpMessage = "";

// Handle profile updates
if (isset($_POST['update_profile'])) {
    // Sanitize and prepare input data
    $fullName = $db->real_escape_string($_POST['name']);
    $phone = $db->real_escape_string($_POST['phone_number']);
    $gender = $db->real_escape_string($_POST['gender']);
    $dob = $db->real_escape_string($_POST['dob']);
    $address = $db->real_escape_string($_POST['address']);

    // Prepare the UPDATE statement
    $stmt = $db->prepare("UPDATE users SET fullName=?, phone=?, gender=?, dob=?, address=? WHERE u_id=?");
    $stmt->bind_param("sssssi", $fullName, $phone, $gender, $dob, $address, $u_id);
    if ($stmt->execute()) {
        $updateSuccess = true;
    }
    $stmt->close();
}

// Handle Telegram binding
if (isset($_POST['bindTelegram'])) {
    $otp = bin2hex(random_bytes(4));
    $expiration = new DateTime('+15 minutes');
    $userId = $_SESSION['user_id'];

    $query = "INSERT INTO tg_verification (userId, code, expiration) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iss", $userId, $otp, $expiration->format('Y-m-d H:i:s'));
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $otpMessage = "<div class='otp-message'>Please send the following code to our Telegram bot <a href='https://t.me/lfsc_buyer_bot' target='_blank'>@lfsc_buyer_bot</a>: <strong>$otp</strong></div>";
        } else {
            $otpMessage = "<div class='otp-message'>An error occurred. Please try again or contact support.</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        $otpMessage = "An error occurred preparing the database. Please try again or contact support.";
    }
}

// Fetch current user data
$stmt = $db->prepare("SELECT username, fullName, email, phone, gender, dob, address FROM users WHERE u_id = ?");
$stmt->bind_param("i", $u_id);
$stmt->execute();
$stmt->bind_result($username, $fullName, $email, $phone, $gender, $dob, $address);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Account</title>
    <link rel="stylesheet" href="landing/style.css" />
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="profile-management-container">
        <h1>My Profile</h1>
        <p>Manage and protect your account</p>
        <div class="telegram-bind-container" style="margin-top: 10px;">
            <form method="POST">
                <button type="submit" name="bindTelegram" class="order-button">Bind Telegram</button>
            </form>
            <?php if (!empty($otpMessage)): ?>
                <p><?php echo $otpMessage; ?></p>
            <?php endif; ?>
        </div>

        <div class="profile-management-layout">
            <div class="form-fields-container">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Existing form fields -->
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" disabled />

                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($fullName); ?>" />

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled />
                    <a href="change_email.php">Change</a>

                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone); ?>" />

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" />

                    <div class="gender-row">
                        <label>Gender</label>
                        <input type="radio" id="male" name="gender" value="male" <?php echo ($gender == 'male') ? 'checked' : ''; ?> />
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female" <?php echo ($gender == 'female') ? 'checked' : ''; ?> />
                        <label for="female">Female</label>
                        <input type="radio" id="other" name="gender" value="other" <?php echo ($gender == 'other') ? 'checked' : ''; ?> />
                        <label for="other">Other</label>
                    </div>

                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" />

                    <button type="submit" name="update_profile" style="margin-top: 20px;">Save</button>
                </form>
            </div>
        </div>
    </div>

    <?php if ($updateSuccess): ?>
        <script>        alert('Profile Updated');</script>
    <?php endif; ?>
</body>
</html>
