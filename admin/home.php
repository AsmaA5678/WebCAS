<?php 
include('../functions.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: ../login.php");
}

// Vérifie si l'utilisateur est un administrateur
if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

// Si le formulaire d'ajout d'événement est soumis
if (isset($_POST['add_event_btn'])) {
    // Assurez-vous que le formulaire a été soumis
    $event_title = e($_POST['event_title']);
    $event_description = e($_POST['event_description']);
    $event_date_start = e($_POST['event_date_start']);
    $event_date_end = e($_POST['event_date_end']);

    // Ajoutez votre logique d'insertion dans la base de données ici...
    // Vérifie si tous les champs sont remplis
    if (empty($event_title) || empty($event_description) || empty($event_date_start) || empty($event_date_end)) {
        array_push($errors, "All fields are required");
    }

    // Si pas d'erreur, insère l'événement dans la base de données
    if (count($errors) == 0) {
        $query = "INSERT INTO events (title, description, date_start, date_end) VALUES ('$event_title', '$event_description', '$event_date_start', '$event_date_end')";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['success'] = "Event successfully created";
        } else {
            array_push($errors, "Error: " . mysqli_error($db));
        }
    }

    // Après l'insertion, redirigez l'utilisateur pour éviter la soumission répétée
    header('location: home.php');
    exit();
}

// Récupère la liste des événements depuis la base de données
$query_events = "SELECT * FROM events";
$result_events = mysqli_query($db, $query_events);
?>

<!DOCTYPE html>
<html>
<head>
        <title>CASInpt_HomePage</title>
        <link rel="stylesheet" type="text/css" href="home_admin.css">
        <style>
        .header {
                background: #003366;
        }
        button[name=register_btn] {
                background: #003366;
        }
        </style>
</head>
<body>
<header>
    <div class="navbar">
        <div class="CASINPT">
            <img src="../images/icon1.png" alt="Logo" width="50" height="50" style="display: inline-block; vertical-align: middle;">
            <a href="Home.html" class="logo" style="display: inline-block; vertical-align: middle; margin-top: -5px;">CASInpt</a>
        </div>
    </div>
</header>
        <div class="space">
                <h2>...........................Admin - Home Page...........................</h2>
        </div>
        <div class="content">
                <!-- notification message au cas de creation reussite-->
                <?php if (isset($_SESSION['success'])) : ?>
                        <div class="error success" >
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
                        <img src="../images/admin_profile.png"  >

                        <div>
                                <?php  if (isset($_SESSION['user'])) : ?>
                                        <strong><?php echo $_SESSION['user']['username']; ?></strong>

                                        <small>
                                                <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
                                                <br>
                                                <a href="home.php?logout='1'" style="color: red;">logout</a>
                       &nbsp; <a href="create_user.php"> + add user</a>
                                        </small>

                                <?php endif ?>
                        </div>
                </div>
        </div>


<!-- Affichage des événements existants -->
<div>
    <h2>...........................Existing Events...........................</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Date Start</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_events)) : ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['date_start']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<!-- Formulaire d'ajout d'événement -->
<h2>...........................Add New Event...........................</h2>
<div class="container">
        <?php echo display_error(); ?>
        <form method="post" action="home.php">
            <!-- Vos champs de formulaire ici... -->
            <div class="input-group">
                <label>Title:</label>
                <input type="text" name="event_title">
            </div>

            <div class="input-group">
                <label>Description:</label>
                <textarea name="event_description"></textarea>
            </div>

            <div class="input-group">
                <label>Date Start:</label>
                <input type="datetime-local" name="event_date_start">
            </div>

            <div class="input-group">
                <label>Date End:</label>
                <input type="datetime-local" name="event_date_end">
            </div>

            <div class="input-group">
                <button type="submit" class="btn" name="add_event_btn">Add Event</button>
            </div>
        </form>
    </div>
<!-- Affichage des utilisateurs qui ont accepté les événements -->
<div>
    <h2>...........................Users who accepted events...........................</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Accepted Event</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query_accepted_users = "SELECT u.username, e.title
                                    FROM users u
                                    JOIN user_events ue ON u.id = ue.user_id
                                    JOIN events e ON ue.event_id = e.id
                                    WHERE ue.status = 'accepted'";
            $result_accepted_users = mysqli_query($db, $query_accepted_users);

            while ($row = mysqli_fetch_assoc($result_accepted_users)) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>