<?php 
        include('functions.php');
        if (!isLoggedIn()) {
            $_SESSION['msg'] = "You must log in first";
            header('location: login.php');
        }
        // Vérifie si l'utilisateur est connecté
if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    
    // Si le formulaire de participation est soumis
    if (isset($_POST['participate_btn'])) {
        $event_id = e($_POST['event_id']);
        $status = e($_POST['status']);
    
        // Mise à jour de la participation de l'utilisateur dans la table user_events
        $user_id = $_SESSION['user']['id'];
        $query_participation = "INSERT INTO user_events (user_id, event_id, status) VALUES ('$user_id', '$event_id', '$status') ON DUPLICATE KEY UPDATE status='$status'";
        mysqli_query($db, $query_participation);
    }
    
    // Récupère la liste des événements depuis la base de données
    $query_events = "SELECT * FROM events";
    $result_events = mysqli_query($db, $query_events);
    
    // Récupère la participation de l'utilisateur actuel dans chaque événement
    $user_id = $_SESSION['user']['id'];
    $query_user_participation = "SELECT event_id, status FROM user_events WHERE user_id = $user_id";
    $result_user_participation = mysqli_query($db, $query_user_participation);
    $participation_data = array();
    while ($row = mysqli_fetch_assoc($result_user_participation)) {
        $participation_data[$row['event_id']] = $row['status'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CASInpt_Home</title>
    <link rel="stylesheet" type="text/css" href="index1.css">
</head>
<body>

<header>
    <div class="navbar">
        <div class="CASINPT">
            <img src="images/icon1.png" alt="Logo" width="50" height="50" style="display: inline-block; vertical-align: middle;">
            <a href="Home.html" class="logo" style="display: inline-block; vertical-align: middle; margin-top: -5px;">CASInpt</a>
        </div>
    </div>
</header>


    <section id="personnel" class="personnel">
        <div class="space">
            <h2>....................Your Space....................</h2>

            <!-- notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success">
                    <h3>
                        <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']);
                        ?>
                    </h3>
                </div>
            <?php endif ?>

            <!-- logged in user information -->
            <div class="profile_info">
                <img src="images/user_profile.png">

                <div>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <strong><?php echo $_SESSION['user']['username']; ?></strong>

                        <small>
                            <i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                            <br>
                            <a href="index1.php?logout='1'" class="logout-link">logout</a>

                        </small>

                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Affichage des événements -->
    <section id="evenements" class="evenements">
        <div class="content1">
            <table>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Decision</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result_events)) : ?>
                    <?php
                    // Vérifie si l'utilisateur a déjà pris une décision sur cet événement
                    $userDecision = isset($participation_data[$row['id']]) ? $participation_data[$row['id']] : null;

                    // Si l'utilisateur a rejeté l'événement, *****ne l'affiche pas*******
                    if ($userDecision === 'rejected') {
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['date_start']; ?></td>
                        <td><?php echo $row['date_end']; ?></td>
                        <td>
                            <!-- Formulaire de participation -->
                            <form method="post" action="index1.php">
                                <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                <?php if ($userDecision === 'accepted') : ?>
                                    <p>You have accepted this event.</p>
                                <?php elseif ($userDecision === null) : ?>
                                    <label for="accept">Accept</label>
                                    <input type="radio" id="accept" name="status" value="accepted" required>

                                    <label for="reject">Reject</label>
                                    <input type="radio" id="reject" name="status" value="rejected" required>

                                    <button type="submit" class="btn" name="participate_btn">&#10004;</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </section>

</body>
</html>
